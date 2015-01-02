<?php

class PaymentLibrary
{
	private $provider;

	public function validate($data)
	{
		$validator = Validator::make($data, $this->rules);
		if($validator->fails())
		{
			throw new ValidateException($validator->messages()->all()[0]);
		}
	}

	public function __call($name, $value )
	{
		$this->$name = $value;
	}

	/**
	* Return credit card type if number is valid
	* http://wephp.co/detect-credit-card-type-php/
	*
	* @return string
	* @param $number string
	**/
	function getCardType($number)
	{
		$number=preg_replace('/[^\d]/','',$number);
		if (preg_match('/^3[47][0-9]{13}$/',$number))
		{
			return 'amex';
		}
		elseif (preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',$number))
		{
			return 'diners';
		}
		elseif (preg_match('/^6(?:011|5[0-9][0-9])[0-9]{12}$/',$number))
		{
			return 'discover';
		}
		elseif (preg_match('/^(?:2131|1800|35\d{3})\d{11}$/',$number))
		{
			return 'jcb';
		}
		elseif (preg_match('/^5[1-5][0-9]{14}$/',$number))
		{
			return 'mastercard';
		}
		elseif (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/',$number))
		{
			return 'visa';
		}
		else
		{
			return 'Unknown';
		}
	}
}
