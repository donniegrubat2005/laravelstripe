@component('mail::message')
# Introduction

<div class="card-body">

@foreach ($invoices as $invoice)
<a href="{{ $invoice->hosted_invoice_url }}">Download</a>
@endforeach

</div>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
