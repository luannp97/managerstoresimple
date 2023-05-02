<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('status', 10);
            $table->text('description');
            $table->text('image')->nullable();
            $table->unsignedBigInteger('store_id');
            $table->integer('import_price');
            $table->integer('price');
            $table->string('product_code', 30);
            $table->string('product_type', 30);
            $table->integer('sold')->default(0);
            $table->integer('total')->default(0);
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('store_id')->references('id')->on('stores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_store_id_foreign');
        });
        Schema::dropIfExists('products');
    }
};
