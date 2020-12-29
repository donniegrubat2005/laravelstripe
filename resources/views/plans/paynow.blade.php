@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Checkout page') }}</div>

                <div class="card-body">
                    <form id="payment-form" action="{{ route('payments.subscribe') }}" method="POST">

                        @csrf
                        <input type="hidden" name="plan" value="{{ $plan->id }}" />
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" id="card-holder-name" class="form-control" value="" placeholder="Name on the card">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="email" id="email" class="form-control" value="" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="">Card details</label>
                            <div id="card-element"></div>
                            <div id="card-errors" role="alert"></div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="card-button" data-secret="{{ $intent->client_secret }}">Pay</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');

    const elements = stripe.elements()

    var style = {
        base: {
            color: '#32325d',
            lineHeight: '18px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    const cardElement = elements.create('card', { style: style, hidePostalCode: true }); // Create an instance of the card Element.
    const cardHolderName = document.getElementById('card-holder-name');
    const emailName = document.getElementById('email');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardElement.mount('#card-element'); // Add an instance of the card Element into the `card-element` <div>.

    // Handle real-time validation errors from the card Element.
    cardElement.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission.
    var form = document.getElementById('payment-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe
            .handleCardSetup(clientSecret, cardElement, {
                payment_method_data: {
                    billing_details:
                    {
                        name: cardHolderName.value,
                        email: emailName.value
                    }
                }
            })
            .then(function(result) {
                console.log(result);
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    console.log(result);
                    // Send the token to your server.
                    stripeTokenHandler(result.setupIntent.payment_method);
                }
            });


    // Submit the form with the token ID.
    function stripeTokenHandler(paymentMethod) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'paymentMethod');
        hiddenInput.setAttribute('value', paymentMethod);
        form.appendChild(hiddenInput);


        // Submit the form
        form.submit();
        //createPayment();
    }


});

</script>
@endsection
