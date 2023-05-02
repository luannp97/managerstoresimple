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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('address');
            $table->string('store_code', 30);
            $table->string('type_of', 30);
            $table->boolean('is_active')->default(true);
            $table->string('status',10)->default('new');
            $table->unsignedBigInteger('author_id');
            $table->text('image')->nullable();
            $table->double('total_monthly_cost')->default(0);
            $table->double('total_cost_per_year')->default(0);
            $table->double('total_monthly_revenue')->default(0);
            $table->double('total_annual_revenue')->default(0);
            $table->timestamps();
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropForeign('stores_author_id_foreign');
        });
        Schema::dropIfExists('stores');
    }
};
