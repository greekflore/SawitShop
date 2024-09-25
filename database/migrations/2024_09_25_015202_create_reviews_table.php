<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();  // Automatically creates an unsigned bigint `id`
            $table->unsignedBigInteger('order_detail_id');
            $table->integer('rating');
            $table->text('comment')->nullable();  // Make comment nullable
            $table->timestamps();  // Automatically creates `created_at` and `updated_at`

            $table->foreign('order_detail_id')->references('id')->on('order_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}