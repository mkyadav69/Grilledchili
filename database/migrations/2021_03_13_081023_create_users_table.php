<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('user_name', 250)->nullable();
            $table->string('email')->nullable();
            $table->integer('email_verified_at')->nullable();
            $table->text('password')->nullable();
            $table->string('branch_id', 250)->nullable();
            $table->text('cc_email')->nullable();
            $table->text('remember_token')->nullable();
            $table->timestamp('dt_created')->nullable();
            $table->timestamp('dt_modify')->nullable();
            $table->integer('in_deleted')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
