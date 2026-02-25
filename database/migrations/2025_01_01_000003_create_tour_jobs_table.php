<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->enum('type', ['inbound', 'outbound']);
            $table->string('location')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('fee', 10, 2)->default(0);
            $table->enum('status', ['pending', 'active', 'closed'])->default('pending');
            $table->timestamp('admin_approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_jobs');
    }
};
