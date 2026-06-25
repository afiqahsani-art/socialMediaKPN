<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->default(null)->after('id')->unique();
        });

        Post::whereNull('uuid')->each(function ($post) {
            $post->uuid = (string) Str::uuid();
            $post->save();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
