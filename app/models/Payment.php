<?php

class Payment extends \Eloquent {

	protected $fillable = [];

	private $provider;

	public function order()
	{
		return $this->belongsTo('Order');
	}

}
