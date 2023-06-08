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
        Schema::table('beers', function (Blueprint $table) {
            $table->decimal('price', 10, 5)->after ('description')->default (0);
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
        Schema::table('beers', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
