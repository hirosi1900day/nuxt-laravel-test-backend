<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporary_registers', function (Blueprint $table) {
            $table->id();
            $table->string('email', 255)->comment('メールアドレス')->default('');
            $table->string('token', 250)->comment('確認トークン')->default('');
            $table->tinyInteger('status')->comment('ステータス')->default(false);
            $table->dateTime('expiration_datetime')->comment('有効期限')->nullable();
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
        Schema::dropIfExists('temporary_registers');
    }
}
