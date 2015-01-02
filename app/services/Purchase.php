<?php


class Purchase
{
	public static function validateStandardPurchase($data)
	{
		$rules = array(
			'price' => 'required|regex:/[\d]*.?[\d]*/', // decimal or integer
			'currency' => 'required',
			'customer_name' => 'required',
			'credit_card_name' => 'required',
			'credit_card_number' => 'required|integer',
			'credit_card_month' => 'required|integer',
			'credit_card_year' => 'required|integer',
			'credit_card_cvv' => 'required|integer',
		);
		return Validator::make($data, $rules);

	}
	public static function storeStandardPurchase($values)
	{
		$payment = new Payment;
		$payment->credit_card_name = $values['credit_card_name'];
		$payment->credit_card_number = $values['credit_card_number'];
		$payment->credit_card_month = $values['credit_card_month'];
		$payment->credit_card_year = $values['credit_card_year'];
		$payment->credit_card_cvv = $values['credit_card_cvv'];

		$order = new Order;
		$order->price = $values['price'];
		$order->currency_id = $values['currency'];
		$order->customer_name = $values['customer_name'];

		$order->save();
		$order->payments()->save($payment);
	}

	

	public static function createStandardPurchase($values)
	{
		$values['currency'] = Currency::find($values['currency'])->currency_code;

		if($values['currency'] === 'USD')
		{
			$provider = new BraintreeProvider();
		}
		else
		{
			$provider = new Paypal();
		}

		$values['card_type'] = $provider->getCardType($values['credit_card_number']);

		if($values['currency'] !== 'USD' && $values['card_type'] === 'amex')
		{
			throw new ValidateException('AMEX is possible to use only for USD');
		}

		$provider->setCardNumber($values['credit_card_number']);
		$provider->setCardType($values['card_type']);
		$provider->setExpireMonth($values['credit_card_month']);
		$provider->setExpireYear($values['credit_card_year']);
		$provider->setCvv($values['credit_card_cvv']);
		$provider->setName($values['credit_card_name']);
		$provider->setCurrency($values['currency']);
		$provider->setAmount($values['price']);

		$provider->validate($values);
		$provider->connect();
		$provider->create();
	}
}
