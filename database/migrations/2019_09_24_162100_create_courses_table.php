<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id');
            $table->string('activity_code')->nullable();
            $table->string('activity_name');
            $table->string('delivery');
            $table->float('duration');
            $table->boolean('is_safety')->default(0);
            $table->string('type');
            $table->bigInteger('work_center_id')->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::create('catalogs', function(Blueprint $table) {
            $table->integer('id');
            $table->integer('parent_id')->nullable();
            $table->integer('reference_id')->nullable();
            $table->string('activity_code')->nullable();
            $table->string('activity_name');
            $table->string('activity_type');
            $table->integer('estimated_duration')->nullable();

            $table->index(['id', 'parent_id', 'reference_id']);
        });

//        Schema::create('safety_maps', function (Blueprint $table) {
//            $table->bigIncrements('id');
//            $table->string('name');
//            $table->bigInteger('work_center_id')->index();
//            $table->timestamp('created_at')->useCurrent();
//            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
//        });

        Schema::create('documentation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('type');
            $table->bigInteger('work_center_id')->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::create('documentation_course', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('document_id')->unsigned()->index();
            $table->bigInteger('course_id')->unsigned()->index();
            $table->foreign('document_id')->references('id')->on('documentation')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });

        Schema::create('course_relationships', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('course_id')->unsigned()->index();
            $table->bigInteger('parent_id')->unsigned()->index();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('courses')->onDelete('cascade');
        });

        Schema::create('work_centers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
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
        Schema::dropIfExists('courses');
        Schema::dropIfExists('required_course');
        Schema::dropIfExists('work_centers');
        Schema::dropIfExists('catalogs');
        Schema::dropIfExists('course_relationships');
        Schema::dropIfExists('documentation');
    }
}
