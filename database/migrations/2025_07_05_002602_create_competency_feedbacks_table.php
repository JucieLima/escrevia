<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetencyFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competency_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('essay_id')->constrained()->onDelete('cascade');
            $table->string('competency_name');
            $table->integer('score'); // até 200
            $table->text('feedback_text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competency_feedbacks');
    }
}
