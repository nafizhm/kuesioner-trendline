<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_public_suggestion_form_is_accessible(): void
    {
        Question::factory()->create([
            'question_text' => 'Apa menu favorit Anda?',
            'placeholder' => 'Tulis jawaban Anda',
            'sort_order' => 1,
        ]);

        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Bagaimana Kunjungan Anda Hari Ini?')
            ->assertSee('Apa menu favorit Anda?');
    }

    public function test_the_login_page_is_accessible(): void
    {
        $response = $this->get('/login');

        $response
            ->assertOk()
            ->assertSee('Selamat datang kembali')
            ->assertSee('Username');
    }

    public function test_the_thank_you_page_is_accessible(): void
    {
        $response = $this->get('/terima-kasih');

        $response
            ->assertOk()
            ->assertSee('Terima Kasih!')
            ->assertSee('Feedback Anda Sudah Terkirim');
    }

    public function test_admin_can_login_and_open_dashboard(): void
    {
        $user = User::factory()->create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => 'admin12345',
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'admin12345',
        ]);

        $response->assertRedirect('/dashboard');

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Dashboard');
    }

    public function test_admin_can_create_question(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/pengaturan-pertanyaan', [
            'question_text' => 'Apa yang paling Anda suka?',
            'placeholder' => 'Tulis jawaban singkat',
            'sort_order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/pengaturan-pertanyaan');

        $this->assertDatabaseHas('questions', [
            'question_text' => 'Apa yang paling Anda suka?',
            'sort_order' => 1,
            'is_active' => 1,
        ]);
    }

    public function test_public_form_can_store_answers_for_dynamic_questions(): void
    {
        $question = Question::factory()->create([
            'question_text' => 'Apa yang perlu ditingkatkan?',
            'sort_order' => 1,
        ]);

        $response = $this->post('/', [
            'answers' => [
                $question->id => 'Tambahkan colokan listrik.',
            ],
            'suggestion' => 'Tempatnya nyaman dan cocok untuk kerja santai.',
        ]);

        $response->assertRedirect('/terima-kasih');

        $suggestion = Suggestion::first();

        $this->assertNotNull($suggestion);
        $this->assertDatabaseHas('suggestions', [
            'id' => $suggestion->id,
            'suggestion' => 'Tempatnya nyaman dan cocok untuk kerja santai.',
        ]);
        $this->assertDatabaseHas('question_answers', [
            'suggestion_id' => $suggestion->id,
            'question_id' => $question->id,
            'answer_text' => 'Tambahkan colokan listrik.',
        ]);
    }

    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/pengaturan-pengguna', [
            'name' => 'Kasir Sore',
            'username' => 'kasir_sore',
            'password' => 'secret12',
            'password_confirmation' => 'secret12',
        ]);

        $response->assertRedirect('/pengaturan-pengguna');

        $this->assertDatabaseHas('users', [
            'name' => 'Kasir Sore',
            'username' => 'kasir_sore',
        ]);
    }

    public function test_admin_can_update_user_without_changing_password(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create([
            'username' => 'shift_lama',
        ]);

        $response = $this->actingAs($admin)->put('/pengaturan-pengguna/'.$user->id, [
            'name' => 'Shift Baru',
            'username' => 'shift_baru',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect('/pengaturan-pengguna');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Shift Baru',
            'username' => 'shift_baru',
        ]);
    }

    public function test_admin_can_delete_other_user(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->delete('/pengaturan-pengguna/'.$user->id);

        $response->assertRedirect('/pengaturan-pengguna');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_admin_can_delete_questionnaire_data(): void
    {
        $admin = User::factory()->create();
        $suggestion = Suggestion::create([
            'suggestion' => 'Pengunjung menyukai suasana namun ingin tambahan meja panjang.',
        ]);

        $response = $this->actingAs($admin)->delete('/data-kuesioner/'.$suggestion->id);

        $response->assertRedirect('/data-kuesioner');

        $this->assertDatabaseMissing('suggestions', [
            'id' => $suggestion->id,
        ]);
    }
}
