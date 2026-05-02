<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('admin.questions.index', [
            'questions' => Question::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question_text' => ['required', 'string', 'max:255'],
            'placeholder' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'question_text.required' => 'Pertanyaan wajib diisi.',
            'sort_order.required' => 'Urutan tampil wajib diisi.',
        ]);

        Question::create([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('questions.index')
            ->with('status', 'Pertanyaan kuesioner berhasil ditambahkan.');
    }

    public function update(Request $request, Question $question): RedirectResponse
    {
        $validated = $request->validate([
            'question_text' => ['required', 'string', 'max:255'],
            'placeholder' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'question_text.required' => 'Pertanyaan wajib diisi.',
            'sort_order.required' => 'Urutan tampil wajib diisi.',
        ]);

        $question->update([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('questions.index')
            ->with('status', 'Pertanyaan kuesioner berhasil diperbarui.');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()
            ->route('questions.index')
            ->with('status', 'Pertanyaan kuesioner berhasil dihapus.');
    }
}
