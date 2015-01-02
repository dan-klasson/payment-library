<?php

class ExampleTest extends TestCase {


	public function setUp()
	{
		parent::setUp();

		$this->prepareForTests();
	}

	// Create the application
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

	// Migrate the database
	private function prepareForTests()
	{
		Artisan::call('migrate');
	}

	public function testIndexControllerIsResponsive()
	{
		$crawler = $this->client->request('GET', '/');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testGetCardType()
	{
		$library = new PaymentLibrary();
		$this->assertEquals($library->getCardType('378282246310005'), 'amex');
		$this->assertEquals($library->getCardType('5555555555554444'), 'mastercard');
		$this->assertEquals($library->getCardType('4111111111111111'), 'visa');
	}

	public function testPaypalProviderCall()
	{
		$provider = new Paypal();
		$provider->setCardNumber('4417119669820331');
		$provider->setCardType('visa');
		$provider->setExpireMonth(1);
		$provider->setExpireYear(date('Y') + 5);
		$provider->setAmount(rand(10, 300));
		$provider->setCvv('123');
		$provider->setName('John Doe');
		$provider->setCurrency('EUR');
		$provider->setAmount(11.43);

		$provider->connect();
		$this->assertTrue($provider->create());
	}

	public function testBraintreeProviderCall()
	{
		$provider = new BraintreeProvider();
		$provider->setCardNumber('4111111111111111'); 
		$provider->setExpireMonth(1);
		$provider->setExpireYear(date('Y') + 5);
		$provider->setAmount(rand(10, 300));
		$provider->connect();
		$this->assertTrue($provider->create());
	}

	public function testDatabase()
	{

		$values = array(
			'credit_card_name' => 'John Doe',
			'credit_card_number' => '12345',
			'credit_card_month' => 11,
			'credit_card_year' => 2015,
			'credit_card_cvv' => 123,
			'price' => 222,
			'currency' => 1,
			'customer_name' => 'John Doe',
		);

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

		$first_order = Order::first();
		$this->assertEquals($first_order->price, 222);
		$this->assertEquals($first_order->currency_id, 1);
		$this->assertEquals($first_order->customer_name, 'John Doe');

		$first_payment = Payment::first();
		$this->assertEquals($first_payment->credit_card_number, 12345);
		$this->assertEquals($first_payment->credit_card_cvv, 123);
	}

}
