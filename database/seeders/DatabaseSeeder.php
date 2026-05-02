<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'username' => 'admin',
        ], [
            'name' => 'Administrator',
            'password' => 'admin12345',
        ]);

        Question::query()->updateOrCreate([
            'question_text' => 'Apa yang paling Anda sukai dari pengalaman di Trendline Coffee hari ini?',
        ], [
            'placeholder' => 'Contoh: suasana, rasa kopi, pelayanan, atau kenyamanan tempat.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Question::query()->updateOrCreate([
            'question_text' => 'Apa yang perlu kami tingkatkan agar kunjungan Anda berikutnya lebih baik?',
        ], [
            'placeholder' => 'Contoh: menu, kecepatan layanan, kebersihan, atau fasilitas tambahan.',
            'sort_order' => 2,
            'is_active' => true,
        ]);
    }
}
