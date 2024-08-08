<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCourseIdFromAssistancesTable extends Migration
{
    public function up()
    {
        Schema::table('assistances', function (Blueprint $table) {
            if (Schema::hasColumn('assistances', 'course_id')) {
                $table->dropForeign(['course_id']);
                $table->dropColumn('course_id');
            }
        });
    }

    public function down()
    {
        Schema::table('assistances', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }
};
