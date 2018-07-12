<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Feeds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('message')->nullable();
            $table->tinyInteger('type')->comment('facebook:1, twitter: 2');
            $table->integer('parent_id')->comment('retweet')->default(0);
            $table->timestamps();
            $table->index(['user_id', 'type', 'parent_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feeds');
    }
}
