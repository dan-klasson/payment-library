<?php

class BraintreeProvider extends PaymentLibrary implements PaymentLibraryInterface
{
	private $config;
	private $result;
	private $values;
	public $rules = array(
		// only allowed currrency is USD
		'currency' => 'in:USD',
	);

	public function __set ($name, $value )
	{
		$this->$name = $value;
	}

	public function connect()
	{
		Braintree_Configuration::environment('sandbox');
		Braintree_Configuration::merchantId(getenv('BRAINTREE_ID'));
		Braintree_Configuration::publicKey(getenv('BRAINTREE_PUBLIC_KEY'));
		Braintree_Configuration::privateKey(getenv('BRAINTREE_PRIVATE_KEY'));
	}

	public function setCardNumber($number)
	{
		$this->values['creditCard']['number'] = $number;
	}

	public function setExpireMonth($month)
	{
		$this->values['creditCard']['expirationMonth'] = $month;
	}

	public function setExpireYear($year)
	{
		$this->values['creditCard']['expirationYear'] = $year;
	}

	public function setCvv($cvv)
	{
		$this->values['creditCard']['cvv'] = $cvv;
	}

	public function setFirstName($name)
	{
		$this->values['customer']['firstName'] = $name;
	}

	public function setLastName($name)
	{
		$this->values['customer']['lastName'] = $name;
	}

	public function setAmount($amount)
	{
		$this->values['amount'] = $amount;
	}

	public function create()
	{

		$result = Braintree_Transaction::sale($this->values);

		if ($result->success)
		{
			$this->result = $result->transaction->id;
		}
		else
		{
			throw new ValidateException($result->message);
		}

		return true;
	}

	public function result()
	{
		return $this->result;
	}
}
