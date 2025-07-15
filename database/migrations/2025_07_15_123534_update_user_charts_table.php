<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_chats', function (Blueprint $table) {
            $table->string('interaction_type')->nullable()->after('content');
            $table->json('context_data ')->nullable()->after('interaction_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_chats', function (Blueprint $table) {
            $table->dropColumn('interaction_type');
            $table->dropColumn('context_data');
        });
    }
}
