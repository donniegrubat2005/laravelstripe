@extends('layouts.main')


@section('headerlabel','Payment')

@section('headerSubLabel','Pay')

@section('title','Payment')

@section('topbarbutton')

@endsection

@section('css')
<link href="/assets/css/pages/wizard/wizard-4.css?v=7.0.6" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/payment.css') }}" rel="stylesheet">
@endsection


@section('scripts')
<script src="/assets/js/pages/custom/user/edit-user.js?v=7.0.6"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="{{asset('js/plugins.js')}}"></script>
<script src="{{asset('js/billing.js')}}"></script>


<script>
    $(document).ready(function(){

// Create a Stripe client.
var stripe = Stripe('{{ env("STRIPE_KEY") }}');

// Create an instance of Elements.
var elements = stripe.elements();

var style = {
base: {
color: '#32325d',
lineHeight: '18px',
fontFamily: '"Roboto", Helvetica Neue", Helvetica, sans-serif',
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

// Create an instance of the card Element
var card = elements.create('card', {
style: style,
hidePostalCode: true
});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');
// Handle real-time validation errors from the card Element.
card.on('change', function(event) {
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

// Disable the submit button to prevent repeated clicks
document.getElementById('payment-submit').disabled = true;

var options = {
name: document.getElementById('name_on_card').value
}

stripe.createToken(card, options).then(function(result) {
if (result.error) {
// Inform the user if there was an error.
var errorElement = document.getElementById('card-errors');
errorElement.textContent = result.error.message;

// Enable the submit button
document.getElementById('payment-submit').disabled = false;

} else {
// Send the token to your server.
stripeTokenHandler(result.token);
console.log(result.token);
}
});
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
// Insert the token ID into the form so it gets submitted to the server
var form = document.getElementById('payment-form');
var hiddenInput = document.createElement('input');
hiddenInput.setAttribute('type', 'hidden');
hiddenInput.setAttribute('name', 'stripeToken');
hiddenInput.setAttribute('value', token.id);
form.appendChild(hiddenInput);

// Submit the form
//form.submit();
createPayment();


}

});

</script>
@endsection

@section('content')
<!--begin::Card-->
<div class="card card-custom">
    <!--begin::Card header-->
    <div class="card-header card-header-tabs-line nav-tabs-line-3x">
         <!--begin::Card body-->
    <div class="card-body px-0">
        {{-- <form action="{{ route('settings.billing.paymentstore') }}" method="POST" id="payment-form"> --}}
            <form class="form" id="payment-form">
             @csrf
              <div class="tab-content">
                <!--begin::Tab-->
                <div class="tab-pane show active px-7" id="kt_user_edit_tab_1" role="tabpanel">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-xl-2"></div>
                        <div class="col-xl-7 my-2">
                        <!--begin::Row-->
                           <div class="row">
                            <label class="col-3"></label>
                            <div class="col-9">
                                <h6 class=" text-dark font-weight-bold mb-10">Payment Details:</h6>
                            </div>
                        </div>
                        <!--end::Row-->
                            <div class="form-group row">
                                <label class="col-form-label col-3 text-lg-right text-left">Name on Card</label>
                                <div class="col-9">
                                <input type="text" class="form-control" id="name_on_card" name="name_on_card" value="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="card-element" class="col-form-label col-3 text-lg-right text-left">
                                  Credit or debit card
                                </label>
                                <div id="card-element" class="card-style">
                                  <!-- a Stripe Element will be inserted here. -->
                                </div>

                                <!-- Used to display form errors -->
                                <div id="card-errors" role="alert" class="col-9 text-center"></div>
                            </div>
                            <div class="form-group row">
                                <label for="card-element" class="col-form-label col-3 text-lg-right text-left">Total Amount</label>
                                <div class="col-9">
                                <input type="text" class="form-control" id="total" name="total">
                                </div>

                            </div>

                     <!--begin::Row-->
                     <div class="row">
                        <div class="col-xl-2"></div>
                        <div class="col-xl-7">

                            <!--begin::Group-->
                            <div class="form-group row mt-10">
                                <label class="col-3"></label>
                                <div class="col-9">
                                    <button type="submit" id="payment-submit" class="btn btn-light-success font-weight-bold btn">Pay now</button>
                                    <button type="submit" class="btn btn-light-primary font-weight-bold btn">Cancel</button>
                                </div>

                            </div>
                            <!--end::Group-->
                        </div>
                        <div class="col-xl-2"></div>
                    </div>

                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Tab-->


            </div>
        </form>
    </div>
    <!--begin::Card body-->
    </div>
</div>
    <!--end::Card header-->
</div>

</div>


@endsection



