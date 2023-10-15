<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedBigInteger('UNIQUE_KEY')->primary();
            $table->string('PRODUCT_TITLE')->index();
            $table->text('PRODUCT_DESCRIPTION')->nullable();
            $table->string('STYLE#')->nullable();
            $table->string('SANMAR_MAINFRAME_COLOR')->nullable();
            $table->string('SIZE')->index()->comment('Size range from S to 3XL');
            $table->string('COLOR_NAME')->nullable();;
            $table->decimal('PIECE_PRICE', 22, 2);
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
        Schema::dropIfExists('products');
    }
}
