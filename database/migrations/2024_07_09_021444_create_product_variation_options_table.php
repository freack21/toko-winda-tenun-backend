<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariationOptionsTable extends Migration
{
    public function up()
    {
        Schema::create('product_variation_options', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., 'gender', 'color', 'size'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_variation_options');
    }
}
