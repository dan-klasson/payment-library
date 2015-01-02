<?php

class CurrencyTableSeeder extends Seeder {

    public function run()
    {
        DB::table('currencies')->delete();
        Currency::create(array('currency_code' => 'USD', 'currency_name' => 'U.S Dollar'));
		Currency::create(array('currency_code' => 'EUR', 'currency_name' => 'Euro'));
		Currency::create(array('currency_code' => 'THB', 'currency_name' => 'Thai Baht'));
		Currency::create(array('currency_code' => 'HKD', 'currency_name' => 'Hong Kong Dollar'));
		Currency::create(array('currency_code' => 'SGD', 'currency_name' => 'Singaporean Dollar'));
		Currency::create(array('currency_code' => 'AUD', 'currency_name' => 'Australian Dollar'));
    }

}
