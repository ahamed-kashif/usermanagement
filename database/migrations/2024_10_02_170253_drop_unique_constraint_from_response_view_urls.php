<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('response_view_urls', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropUnique('response_view_urls_user_id_unique');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('response_view_urls', function (Blueprint $table) {

            $table->unique('user_id', 'response_view_urls_user_id_unique');
        });
    }
};
