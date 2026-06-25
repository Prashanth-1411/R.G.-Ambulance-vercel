<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funeral_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('service_type')->nullable();
            $table->string('deceased_name')->nullable();
            $table->date('service_date')->nullable();
            $table->text('special_requests')->nullable();
            $table->string('status', 20)->default('pending')->check("status IN ('pending', 'confirmed', 'in_progress', 'completed', 'cancelled')");
            $table->text('admin_notes')->nullable();
            $table->string('ip_address')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funeral_bookings');
    }
};
