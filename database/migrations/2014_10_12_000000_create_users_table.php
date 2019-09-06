<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('employee_id', 7);
            $table->string('account')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('title')->nullable();
            $table->string('department')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('manager_email')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cost_center')->nullable();
            $table->string('shift', 10)->nullable();
            $table->dateTime('last_seen')->nullable();
            $table->boolean('is_synced')->default(0);
            $table->date('sync_date')->nullable();
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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
