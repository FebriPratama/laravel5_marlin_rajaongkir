<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblBooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_ref_books', function (Blueprint $table) {
            $table->increments('book_id');
            $table->string('book_name');
            $table->text('book_description');
            $table->text('book_keyword');
            $table->double('book_price',19,4);
            $table->string('book_penerbit');
            $table->integer('book_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_ref_books');
    }
}
