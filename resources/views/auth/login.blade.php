@extends('layouts.guest')

@section('content')
    <section class="hero login-hero" style="grid-template-columns: 0.95fr 0.85fr;">
        <div class="panel hero-copy">
            <div>
                <div class="eyebrow">Login Admin</div>
                <h1>Masuk untuk mengelola hasil kuesioner.</h1>
                <p class="lead">
                    Gunakan akun admin berbasis username untuk membuka dashboard, melihat data saran, serta
                    menyiapkan pengaturan pertanyaan dan pengguna.
                </p>
            </div>

            <div class="info-card">
                <strong>Akses internal.</strong>
                Halaman ini disiapkan untuk admin Trendline Coffee. Pengunjung umum tetap diarahkan ke form saran.
            </div>
        </div>

        <div class="panel form-card">
            <h2>Masuk ke Dashboard</h2>
            <p class="muted">Login menggunakan username dan password, tanpa email.</p>

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="field">
                    <label for="username">Username</label>
                    <input
                        id="username"
                        name="username"
                        type="text"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username"
                        required
                    >
                    @error('username')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Masukkan password"
                        required
                    >
                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label style="display: flex; gap: 10px; align-items: center; margin-bottom: 0;">
                        <input style="width: auto;" name="remember" type="checkbox" value="1">
                        Tetap masuk di perangkat ini
                    </label>
                </div>

                <button class="button" type="submit">Login</button>
            </form>
        </div>
    </section>
@endsection
