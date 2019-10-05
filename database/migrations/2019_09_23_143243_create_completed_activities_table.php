<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompletedActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('completed_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('activity_name');
            $table->string('activity_code');
            $table->string('activity_label');
            $table->string('email');
            $table->date('completion_date');
            $table->bigInteger('manager_id');
            $table->string('manager_first_name');
            $table->string('manager_last_name');
            $table->string('manager_email');
            $table->string('user_primary_job');
            $table->date('expires')->nullable();
            $table->string('organization');
            $table->string('shift');
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
        Schema::dropIfExists('completed_activities');
    }
}
