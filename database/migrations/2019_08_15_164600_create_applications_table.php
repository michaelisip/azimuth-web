<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('admin_id');
            $table->string('name')->default('Azimuth');
            $table->string('logo')->default('default.jpg');
            $table->timestamps();

            $table->foreign('admin_id')
                    ->references('id')
                    ->on('admins')
                    ->onDelete('cascade');
        });

        // Seed Admin Account
        Artisan::call('db:seed --class=AdminSeeder');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
