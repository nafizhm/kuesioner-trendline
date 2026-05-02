<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Suggestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuggestionController extends Controller
{
    public function index(): View
    {
        return view('suggestions.index', [
            'questions' => Question::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $questions = Question::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $rules = [
            'suggestion' => ['required', 'string', 'min:10', 'max:1000'],
        ];

        foreach ($questions as $question) {
            $rules['answers.'.$question->id] = ['nullable', 'string', 'max:1000'];
        }

        $validated = $request->validate($rules, [
            'suggestion.required' => 'Saran tidak boleh kosong.',
            'suggestion.min' => 'Tulis saran minimal 10 karakter agar lebih jelas.',
        ]);

        $suggestion = Suggestion::create([
            'suggestion' => $validated['suggestion'],
        ]);

        foreach ($questions as $question) {
            $answer = trim((string) data_get($validated, 'answers.'.$question->id, ''));

            if ($answer === '') {
                continue;
            }

            $suggestion->answers()->create([
                'question_id' => $question->id,
                'answer_text' => $answer,
            ]);
        }

        return redirect()
            ->route('suggestions.index')
            ->with('status', 'Terima kasih, saran Anda sudah kami terima.');
    }
}
