<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('placing')->nullable();
            $table->string('place')->nullable();
            $table->dateTime('date_scanne')->nullable();
            $table->string('contact')->nullable();

            $table->string('sexe')->nullable();
            $table->unsignedBigInteger('status')->default(0);
            
            $table->unsignedBigInteger('event_id')->nullable();
            $table->timestamps();
            $table->foreign('event_id')->references('id')->on('events')
                 ->onUpdate('cascade')
                ->onDelete('cascade');
        
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
