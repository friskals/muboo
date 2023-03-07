<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'categories';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function($table) {
            $table->string('slug')->after('name')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Inactive')->after('slug');
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
            $table->dropColumn('slug');
            $table->dropColumn('status');
        });
    }
};
