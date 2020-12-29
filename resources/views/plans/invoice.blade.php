@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('transaction',['download'=>'pdf']) }}">Download PDF</a>
</div>
<h1>Thank you, for your payment.</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5 class="text-center"><strong>Payment Summary</strong></h5>
                        @foreach ($transactions as $item)
                        <strong class="text-center">{{ $item->date_period }}</strong><br>
                        <strong class="float-right">{{ 'Invoice Number:  '. $item->invoice_number }}</strong>

                        @endforeach
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td class="text-center"><strong>Description</strong></td>
                                        <td class="text-center"><strong>Unit Price</strong></td>
                                        <td class="text-center"><strong>Amount</strong></td>

                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach ($transactions as $item)
                                   @if($item->description1 ==='')
                                    {{ " " }}
                                    @else
                                    <tr>
                                        <td>{{ $item->description1 }}</td>
                                        <td class="emptyrow"></td>
                                        <td class="text-center">{{ number_format($item->amount1,2) }}</td>
                                     </tr>
                                  @endif
                                 <tr>
                                    <td>{{ $item->description }}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center">{{ number_format($item->amount,2) }}</td>
                                 </tr>


                                 @if (number_format($item->discount==0))
                                  {{ "" }}
                                @else
                                <tr>
                                    <td class="emptyrow"></td>
                                    <td class="highrow text-center"><strong>Subtotal</strong></td>
                                    <td class="highrow text-center">{{ number_format($item->subtotal,2) }}</td>


                                </tr>
                                @endif
                                @if (number_format($item->discount==0))
                                {{ "" }}
                                @else
                                <tr>
                                    <td class="highrow"></td>
                                    <td class="highrow text-center"><strong>Discount</strong></td>
                                    <td class="highrow text-center">{{ number_format(-$item->discount,2) }}</td>

                                </tr>
                                @endif
                                    <tr>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow text-center"><strong>Total</strong></td>
                                        <td class="emptyrow text-center">{{ number_format($item->total,2) }}</td>

                                    </tr>
                                    <tr>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow text-center"><strong>Amount Due</strong></td>
                                        <td class="emptyrow text-center">{{ number_format($item->amount_due,2) }}</td>

                                    </tr>

                                    @endforeach
                                </tbody>

                            </table>
                            <p>Please check your email for payment confirmation</p>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
