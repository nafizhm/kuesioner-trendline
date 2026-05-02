@extends('layouts.admin', [
    'heading' => 'Dashboard',
    'subheading' => 'Ringkasan cepat aktivitas form saran dan kesiapan area admin.',
])

@section('content')
    <section class="card-grid">
        <div class="card accent">
            <span>Total saran masuk</span>
            <strong>{{ $suggestionCount }}</strong>
        </div>
        <div class="card">
            <span>Pertanyaan aktif</span>
            <strong>{{ $questionCount }}</strong>
        </div>
        <div class="card">
            <span>Total pengguna admin</span>
            <strong>{{ $userCount }}</strong>
        </div>
    </section>

    <section class="panel">
        <h2 style="margin-top: 0;">Sorotan Terbaru</h2>

        @if ($latestSuggestion)
            <div class="placeholder-item">
                <div class="badge">Saran terbaru</div>
                <p style="margin: 14px 0 8px; line-height: 1.7;">{{ $latestSuggestion->suggestion }}</p>
                <small style="color: var(--muted);">
                    {{ $latestSuggestion->created_at->format('d M Y H:i') }}
                </small>

                @if ($latestSuggestion->answers->isNotEmpty())
                    <div style="margin-top: 14px;" class="placeholder-list">
                        @foreach ($latestSuggestion->answers as $answer)
                            <div class="placeholder-item">
                                <strong>{{ $answer->question->question_text }}</strong>
                                <div style="margin-top: 6px; color: var(--muted); line-height: 1.6;">{{ $answer->answer_text }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="empty-state">
                Belum ada saran yang masuk. Saat pengunjung mulai mengisi form di halaman depan, ringkasan terbaru
                akan muncul di sini.
            </div>
        @endif
    </section>
@endsection
