<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    public function index(): View
    {
        return view('admin.questionnaires.index', [
            'suggestions' => Suggestion::query()
                ->with(['answers.question'])
                ->latest()
                ->get(),
        ]);
    }

    public function destroy(Suggestion $suggestion): RedirectResponse
    {
        $suggestion->delete();

        return redirect()
            ->route('questionnaires.index')
            ->with('status', 'Data kuesioner berhasil dihapus.');
    }
}
