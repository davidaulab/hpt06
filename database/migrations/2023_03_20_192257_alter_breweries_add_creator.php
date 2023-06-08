<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table ('breweries', function (Blueprint $table) {
            $table->bigInteger('creator')
                ->after ('description')
                ->default (1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table ('breweries', function (Blueprint $table) {
            $table->dropColumn('creator');
        });
    }
};
