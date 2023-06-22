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
        Schema::table('users', function (Blueprint $table) {

            $table->string('phone')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('hobbies')->nullable()->change();
            $table->string('profile_photo')->nullable()->change();
            $table->string('country')->nullable();
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
            $table->string('phone')->change();
            $table->string('gender')->change();
            $table->string('city')->change();
            $table->string('hobbies')->change();
            $table->string('profile_photo')->change();
            $table->dropColumn('country');
        });
    }
};
