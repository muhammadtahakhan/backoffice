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
        // This method defines the changes to be applied when migrating
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing primary key 'id'
            $table->string('name'); // Defines a column named 'name' of type varchar
            $table->string('phone'); // Defines a column named 'phone' of type varchar
            $table->string('address'); // Defines a column named 'address' of type varchar

            $table->timestamps(); // Creates 'created_at' and 'updated_at' columns for timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This method defines the actions to be taken when rolling back the migration
        Schema::dropIfExists('customers'); // Drops the 'customers' table if it exists
    }
};
