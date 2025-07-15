<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Remove chats se o user for deletado
            $table->text('content');
            $table->enum('role', ['user', 'system', 'assistant']); // Padronizado com roles de APIs de IA
            $table->string('session_id')->nullable(); // Para agrupar conversas (útil se o bot for multissessão)
            $table->timestamps();

            $table->index('user_id'); // Otimiza consultas por usuário
            $table->index('session_id'); // Facilita buscar históricos específicos
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_chats');
    }
}
