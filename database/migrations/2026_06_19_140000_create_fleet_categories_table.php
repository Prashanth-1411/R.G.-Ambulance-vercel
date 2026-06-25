<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fleet_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('type', 20)->default('fleet')->check("type IN ('fleet', 'equipment', 'mortuary')");
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::table('fleets', function (Blueprint $table) {
            $table->foreignId('fleet_category_id')->nullable()->after('id')->constrained('fleet_categories')->nullOnDelete();
            $table->string('image')->nullable()->after('description');
        });

        Schema::table('equipment_rentals', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
        });

        Schema::table('mortuaries', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('mortuaries', fn (Blueprint $t) => $t->dropColumn('image'));
        Schema::table('equipment_rentals', fn (Blueprint $t) => $t->dropColumn('image'));
        Schema::table('fleets', function (Blueprint $t) {
            $t->dropConstrainedForeignId('fleet_category_id');
            $t->dropColumn('image');
        });
        Schema::dropIfExists('fleet_categories');
    }
};
