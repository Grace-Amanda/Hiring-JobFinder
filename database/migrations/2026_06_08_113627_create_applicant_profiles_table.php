<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('applicant_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['active_searching', 'unactive'])->default('active_searching');
            $table->string('full_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('location')->nullable();
            $table->string('education')->nullable();
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->text('job_history')->nullable();
            $table->string('document_ktp')->nullable(); 
            $table->string('document_ijazah')->nullable();
            $table->string('document_cv')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('applicant_profiles');
    }
};