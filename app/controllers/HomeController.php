<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	*/

	public function index()
	{
		if (Request::isMethod('post'))
		{
			$validator = Purchase::validateStandardPurchase(Input::all());

			if ($validator->fails())
			{
				return Redirect::back()->withInput()
					->withErrors($validator->messages());
			}

			try
			{
				Purchase::createStandardPurchase(Input::all());
			}
			catch(ValidateException $e)
			{
				$messages = $validator->errors();
				$messages->add(null, $e->get());
				return Redirect::back()->withInput()->withErrors($validator);
			}

			Purchase::storeStandardPurchase(Input::all());


			return Redirect::action('HomeController@success')
				->with(array('success' => true));
		}

		return View::make('index')->with(array(
			'currencies' => Currency::lists('currency_code', 'id'),
			'error' => false,
		));

	}

	public function success()
	{
		return View::make('success');
	}
}
