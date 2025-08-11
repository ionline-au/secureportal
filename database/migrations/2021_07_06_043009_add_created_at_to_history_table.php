<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedAtToHistoryTable extends Migration
{
    public function up()
    {
        Schema::table('history', function (Blueprint $table) {
            $table->dateTime('created_at')->nullable();;
        });
    }

    public function down()
    {
        Schema::table('history', function (Blueprint $table) {
            $table->dropColumn('created_at');
        });
    }
}