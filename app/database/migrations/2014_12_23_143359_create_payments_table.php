<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('order_id')->unsigned();
			$table->char('credit_card_name', 50);
			$table->smallInteger('credit_card_number');
			$table->tinyInteger('credit_card_month');
			$table->tinyInteger('credit_card_year');
			$table->tinyInteger('credit_card_cvv');
			$table->enum('status', array('accepted', 'pending', 'cancelled', 'fraud'))->default('pending');
			$table->timestamps();
		});
		Schema::table('payments', function($table) {
		   $table->foreign('order_id')->references('id')->on('payments');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('payments');
	}

}
