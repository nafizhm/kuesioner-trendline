@extends('layouts.guest')

@section('content')
    <section class="hero">
        <div class="panel hero-copy">
            <div>
                <div class="eyebrow">Form Saran</div>
                <h1>Satu teguk kopi, satu ruang untuk masukan yang berarti.</h1>
                <p class="lead">
                    Trendline Coffee menyiapkan form singkat ini agar setiap pengunjung bisa berbagi saran,
                    pengalaman, dan ide perbaikan setelah menikmati suasana kami.
                </p>
            </div>

            <div class="info-card">
                <strong>Masukan Anda membantu kami tumbuh.</strong>
                Setiap saran akan kami gunakan untuk mengevaluasi layanan, kenyamanan tempat, dan pengalaman
                terbaik di Trendline Coffee.
            </div>
        </div>

        <div class="panel form-card">
            <h2>Tulis Saran Anda</h2>
            <p class="muted">Form ini dibuat sesingkat mungkin agar mudah diisi langsung dari meja coffee.</p>

            @if (session('status'))
                <div class="status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('suggestions.store') }}">
                @csrf

                @foreach ($questions as $question)
                    <div class="question-block">
                        <label for="answers_{{ $question->id }}">{{ $question->question_text }}</label>
                        <input
                            id="answers_{{ $question->id }}"
                            name="answers[{{ $question->id }}]"
                            type="text"
                            value="{{ old('answers.'.$question->id) }}"
                            placeholder="{{ $question->placeholder ?: 'Tulis jawaban Anda' }}"
                        >
                        @error('answers.'.$question->id)
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                <div class="field">
                    <label for="suggestion">Saran</label>
                    <textarea
                        id="suggestion"
                        name="suggestion"
                        placeholder="Contoh: tempatnya nyaman, mungkin ke depan bisa ditambah colokan listrik atau pilihan pastry."
                    >{{ old('suggestion') }}</textarea>
                    @error('suggestion')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <button class="button" type="submit">Kirim Saran</button>
            </form>
        </div>
    </section>
@endsection
