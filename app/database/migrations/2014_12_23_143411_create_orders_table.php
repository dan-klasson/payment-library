<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('currency_id')->unsigned();
			$table->char('customer_name', 50);
			$table->decimal('price', 6, 2);
			$table->timestamps();
		});
		Schema::table('orders', function($table) {
		   $table->foreign('currency_id')->references('id')->on('currencies');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->dropForeign('orders_currency_id_foreign');
		});
		Schema::drop('orders');
	}

}
