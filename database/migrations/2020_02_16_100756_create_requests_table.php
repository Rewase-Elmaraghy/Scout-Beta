<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demands', function (Blueprint $table) {
            //
            Schema::create('demands', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('category_id');
                $table->integer('demand');
                $table->boolean('Accepted')->default('2');
                $table->boolean('seen_by_user')->default('0')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            //
            Schema::dropIfExists('requests');
        });
    }
}
