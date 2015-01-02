<?php

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payment;
use PayPal\Api\CreditCard;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\Payment as PayPalPayment;

class Paypal extends PaymentLibrary implements PaymentLibraryInterface
{
	private $config;
	private $result;
	private $card;
	private $funding_instrument;
	private $payer;
	private $amount;
	public $rules = array(
		// Paypal only allow these credit cards
		'card_type' => 'in:visa, mastercard,discover,amex'
	);

	public function __construct()
	{
		$this->card = new CreditCard();
		$this->amount = new Amount();
	}

	public function connect()
	{
		$this->config = new ApiContext(new OAuthTokenCredential(
				getenv('PAYPAL_ID'), getenv('PAYPAL_TOKEN')));
	}

	public function setCardNumber($number)
	{
		$this->card->setNumber($number);
	}

	public function setCardType($type)
	{
		$this->card->setType($type);
	}

	public function setExpireMonth($month)
	{
		$this->card->setExpire_month($month);
	}

	public function setExpireYear($year)
	{
		$this->card->setExpire_year($year);
	}

	public function setCvv($cvv)
	{
		$this->card->setCvv2($cvv);
	}

	public function setName($name)
	{
		$split_name = explode(' ', $name);
		$this->card->setFirst_name($split_name[0]);
		$this->card->setLast_name($split_name[1]);
	}

	public function setCurrency($currency)
	{
		$this->amount->setCurrency($currency);
	}

	public function setAmount($amount)
	{
		$this->amount->setTotal($amount);
	}

	public function create()
	{
		$funding_instrument = new FundingInstrument();
		$funding_instrument->setCredit_card($this->card);

		$payer = new Payer();
		$payer->setPayment_method('credit_card');
		$payer->setFunding_instruments(array($funding_instrument));

		$transaction = new Transaction();
		$transaction->setAmount($this->amount);

		$payment = new PayPalPayment();
		$payment->setIntent('sale');
		$payment->setPayer($payer);
		$payment->setTransactions(array($transaction));

		try
		{
			$this->result = $payment->create($this->config);
		}
		catch(Exception $e)
		{
			throw new ValidateException('An unknown error occurred');
		}

		return true;
	}

	public function result()
	{
		return $this->result;
	}
}
