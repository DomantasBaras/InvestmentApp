<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    public function up()
    {
        // First, check if the user_id column exists before trying to add it
        if (!Schema::hasColumn('investments', 'user_id')) {
            // Create a default user for existing investments
            $user = User::firstOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Admin',
                    'password' => bcrypt('password'),
                ]
            );

            // Add nullable user_id first
            Schema::table('investments', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable();
            });

            // Assign existing investments to the default user
            DB::table('investments')->update(['user_id' => $user->id]);

            // Make the column required and add the foreign key constraint
            Schema::table('investments', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable(false)->change();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        // Drop the foreign key and the column
        Schema::table('investments', function (Blueprint $table) {
            if (Schema::hasColumn('investments', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
