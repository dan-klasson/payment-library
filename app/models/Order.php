<?php

class Order extends \Eloquent {

	protected $fillable = [];


    public function currency()
    {
        return $this->belongsTo('Currency');
    }

    public function payments()
    {
        return $this->hasMany('Payment');
    }
}
