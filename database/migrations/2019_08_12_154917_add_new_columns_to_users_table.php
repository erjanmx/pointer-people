<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('job_title')->after('remember_token')->nullable();
            $table->string('team_name')->after('job_title')->nullable();
            $table->string('country', '3')->after('team_name')->nullable();
            $table->text('bio')->after('country')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('job_title');
            $table->dropColumn('team_name');
            $table->dropColumn('country');
            $table->dropColumn('bio');
        });
    }
}
