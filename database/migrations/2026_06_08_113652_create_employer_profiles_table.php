<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('employer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('company_name')->nullable();
            $table->string('location_employer')->nullable();
            $table->string('company_type')->nullable(); // Misal: IT, Finance, Manufacture
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->text('reviews')->nullable();
            $table->string('document_npwp')->nullable();
            $table->string('document_nib')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('employer_profiles');
    }
};