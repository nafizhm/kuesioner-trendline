<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'suggestionCount' => Suggestion::count(),
            'latestSuggestion' => Suggestion::query()->with(['answers.question'])->latest()->first(),
            'questionCount' => \App\Models\Question::where('is_active', true)->count(),
            'userCount' => User::count(),
        ]);
    }
}
