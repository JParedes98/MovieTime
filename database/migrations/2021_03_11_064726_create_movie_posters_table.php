<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviePostersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_posters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
            $table->string('name', 100);
            $table->string('extension', 20);
            $table->binary('object');
            $table->timestamps();

            $table->foreign('movie_id')->references('id')->on('movies');
        });

        DB::statement("ALTER TABLE movie_posters MODIFY COLUMN object longblob");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movie_posters', function (Blueprint $table) {
            $table->dropForeign(['movie_id']);
        });

        Schema::dropIfExists('movie_posters');
    }
}
