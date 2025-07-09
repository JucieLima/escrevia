<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIaFeedbackDetailsToEssaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('essays', function (Blueprint $table) {
            // Adiciona a coluna para o texto completo do feedback da IA
            $table->text('ia_feedback')->nullable()->after('content'); // Coloque depois de 'content'

            // Adiciona a coluna para registrar quando a análise foi feita
            $table->timestamp('analyzed_at')->nullable()->after('overall_score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('essays', function (Blueprint $table) {
            $table->dropColumn('ia_feedback');
            $table->dropColumn('analyzed_at');
        });
    }
}
