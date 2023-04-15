<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'books';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function($table) {
            $table->date('published_date')->after('released_date')->nullable();
            $table->string('excerpts')->after('published_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function($table) {
            $table->dropColumn('published_date');
            $table->dropColumn('excerpts');
        });
    }
};
