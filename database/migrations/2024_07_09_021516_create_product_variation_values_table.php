<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariationValuesTable extends Migration
{
    public function up()
    {
        Schema::create('product_variation_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('option_id')->constrained('product_variation_options')->onDelete('cascade');
            $table->string('value'); // e.g., 'male', 'red', 'L'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_variation_values');
    }
}
