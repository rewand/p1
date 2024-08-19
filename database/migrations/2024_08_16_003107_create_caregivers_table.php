<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaregiversTable extends Migration
{
    public function up()
    {
        Schema::create('caregivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docu_type_id')->constrained("document_type");
            $table->string('name');
            $table->string('surnames');
            $table->string('num_docu');
            $table->char('regist_status')->default("A");
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('caregivers');
    }
}
