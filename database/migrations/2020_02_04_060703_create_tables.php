<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('items', function (Blueprint $table){
            $table->bigIncrements('id');
            //$table->unsignedBigInteger('category_id');
            $table->string('item_name');
            $table->text('item_desc');
            $table->unsignedInteger('item_qty');
            $table->string('Istatus');
            $table->softDeletes();
            $table->timestamps();
            //$table->foreign('category_id')->references('category_id')->on('tbl_categories')->onDelete('cascade');
           // $table->softDeletes();
        });

            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
