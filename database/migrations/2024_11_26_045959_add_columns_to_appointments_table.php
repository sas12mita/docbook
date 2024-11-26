<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('doctor_id')->nullable()->constrained()->cascadeOnDelete(); // Doctor ID with foreign key
            $table->foreignId('patient_id')->nullable()->constrained('users')->cascadeOnDelete(); // Patient ID with foreign key
            $table->date('appointment_date')->nullable(); // Appointment date
            $table->time('start_time')->nullable(); // Start time
            $table->time('end_time')->nullable(); // End time
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropForeign(['doctor_id']); // Drop the foreign key for doctor_id
                $table->dropForeign(['patient_id']); // Drop the foreign key for patient_id
                $table->dropColumn(['doctor_id', 'patient_id', 'appointment_date', 'start_time', 'end_time']); // Drop the columns
            });
    
        });
    }
};
