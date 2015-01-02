<?php

interface PaymentLibraryInterface
{
	public function connect();

	public function create();

	public function setCardNumber($number);

	public function setExpireMonth($month);

	public function setExpireYear($year);

	public function setCvv($cvv);

	public function setAmount($amount);

}
