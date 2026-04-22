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
        // Update borrowings table
        Schema::table('borrowings', function (Blueprint $table) {
            // Drop old status column and recreate with new values
            $table->dropColumn('status');
        });
        
        Schema::table('borrowings', function (Blueprint $table) {
            // Add new status column with approval workflow
            $table->enum('status', ['pending', 'approved', 'rejected', 'returned'])->default('pending')->after('returned_at');
            // Make borrowed_at nullable for pending requests
            $table->dateTime('borrowed_at')->nullable()->change();
            // Make due_date nullable for pending requests
            $table->dateTime('due_date')->nullable()->change();
        });

        // Update fines table - remove money-related fields, add description
        Schema::table('fines', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['amount', 'days_late', 'issued_at', 'paid_at']);
        });
        
        Schema::table('fines', function (Blueprint $table) {
            // Add description field
            $table->text('description')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert borrowings table
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dateTime('borrowed_at')->nullable(false)->change();
            $table->dateTime('due_date')->nullable(false)->change();
        });
        
        Schema::table('borrowings', function (Blueprint $table) {
            $table->enum('status', ['borrowed', 'returned'])->default('borrowed')->after('returned_at');
        });

        // Revert fines table
        Schema::table('fines', function (Blueprint $table) {
            $table->dropColumn('description');
        });
        
        Schema::table('fines', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->after('user_id');
            $table->integer('days_late')->after('amount');
            $table->dateTime('issued_at')->after('days_late');
            $table->dateTime('paid_at')->nullable()->after('status');
        });
    }
};
