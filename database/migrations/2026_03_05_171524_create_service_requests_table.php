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
        Schema::disableForeignKeyConstraints();

        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('serviser_id')->nullable()->constrained('users');
            $table->enum('tachograph_type', ["analogni","digitalni"]);
            $table->text('description')->nullable();
            $table->dateTime('desired_date');
            $table->string('phone');
            $table->enum('status', ['zakazano', 'zavrsena_dijagnostika', 'u_popravci', 'zavrseno'])->default('zakazano');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
