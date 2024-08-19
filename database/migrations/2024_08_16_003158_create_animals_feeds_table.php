<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsFeedsTable extends Migration
{
    public function up()
    {
        Schema::create('animals_feeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animals');
            $table->foreignId('feed_id')->constrained('feeds');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('animals_feeds');
    }
}
