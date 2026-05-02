<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('suggestions', function (Blueprint $table): void {
            $table->string('table_number')->nullable()->after('guest_name');
        });
    }

    public function down(): void
    {
        Schema::table('suggestions', function (Blueprint $table): void {
            $table->dropColumn('table_number');
        });
    }
};
