@extends('layouts.master')

@section('title')
Payment page
@stop

@section('head')
<style type="text/css">
.well {
	width: 400px;
 	position: relative;
	margin: 10px;
	top: 50px;
	left: 50px;
}

</style>

<script type="text/javascript">

</script>

@stop


@section('content')


@if($errors->has())
   @foreach ($errors->all() as $error)
	  <div class="alert alert-danger" role="alert">{{ $error }}</div>
  @endforeach
@endif

<div class="well">
{{ BootForm::open() }}
    {{ BootForm::text('Price', 'price') }}
    {{ BootForm::select('Currency', 'currency', $currencies) }}
	{{ BootForm::text('Customer Name', 'customer_name') }}
    {{ BootForm::text('Credit Card Holder Name', 'credit_card_name') }}
    {{ BootForm::text('Credit Card Number', 'credit_card_number') }}
	{{ BootForm::select('Expire Month', 'credit_card_month', range(1, 12)) }}
	{{ BootForm::select('Expire Year', 'credit_card_year', range(date("Y"), date("Y") + 10)) }}
	{{ BootForm::text('Credit Card CVV', 'credit_card_cvv') }}
    {{ BootForm::submit('Submit') }}
{{ BootForm::close() }}
</div>

@stop
