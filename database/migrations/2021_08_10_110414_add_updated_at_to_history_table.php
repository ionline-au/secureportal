<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdatedAtToHistoryTable extends Migration
{
    public function up()
    {
        Schema::table('history', function (Blueprint $table) {
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('history', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
    }
}
