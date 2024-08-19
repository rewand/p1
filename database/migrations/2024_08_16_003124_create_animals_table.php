<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained("categories");
            $table->foreignId('caregiver_id')->constrained("caregivers");
            $table->string('photo_1')->nullable();
            $table->string('photo_2')->nullable();
            $table->date('regist_date');
            $table->char('regist_status')->default("A");
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('animals');
    }
}
