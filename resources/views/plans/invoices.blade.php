@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Plans</div>
                <div class="card-body">
                    @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                        <td>{{ $invoice->total() }}</td>
                        <td><a href="/invoice/{{ $invoice->id }}">Download</a></td>
                        <td><a href="{{ $invoice->hosted_invoice_url }}">Download</a></td>
                    </tr>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
