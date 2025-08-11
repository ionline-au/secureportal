<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToHistoryTable extends Migration
{
    public function up()
    {
        Schema::table('history', function (Blueprint $table) {
            $table->string('type')->nullable(); // login, logout, upload, message
            $table->string('notes')->nullable(); // note of what happened
            $table->string('user_id')->nullable(); // note of what happened
        });
    }

    public function down()
    {
        Schema::table('history', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('notes');
            $table->dropColumn('user_id');
        });
    }
}