<?php

class Currency extends \Eloquent {

	protected $fillable = [];

    public function orders()
    {
        return $this->hasMany('Order');
    }
}
