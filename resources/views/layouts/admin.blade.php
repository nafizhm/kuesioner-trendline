<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @stack('styles')
    <style>
        :root {
            --paper: #f7f1e8;
            --sidebar: #2f1d12;
            --sidebar-soft: #4f3422;
            --card: #fffdf9;
            --accent: #cf9d72;
            --accent-soft: rgba(207, 157, 114, 0.2);
            --text: #2d2219;
            --muted: #6f6257;
            --border: rgba(79, 52, 34, 0.1);
            --success: #3c6f48;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background:
                radial-gradient(circle at top right, rgba(207, 157, 114, 0.16), transparent 25%),
                linear-gradient(180deg, #fbf7f1, var(--paper));
            color: var(--text);
        }

        .app-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 280px 1fr;
        }

        .sidebar {
            padding: 28px 20px;
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.05), transparent 28%),
                linear-gradient(180deg, var(--sidebar), #23140b);
            color: #f9f4ee;
        }

        .brand {
            padding: 18px 18px 22px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.06);
            margin-bottom: 22px;
        }

        .brand small {
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-size: 0.72rem;
            color: rgba(249, 244, 238, 0.72);
            margin-bottom: 10px;
        }

        .brand strong {
            font-size: 1.35rem;
            line-height: 1.3;
        }

        .nav-link {
            display: block;
            padding: 14px 16px;
            margin-bottom: 10px;
            border-radius: 16px;
            text-decoration: none;
            color: inherit;
            background: transparent;
            transition: 0.2s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-footer {
            margin-top: 28px;
            padding: 18px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.06);
            color: rgba(249, 244, 238, 0.84);
            line-height: 1.6;
        }

        .sidebar-note {
            margin: 0;
        }

        .logout-button {
            margin-top: 14px;
            width: 100%;
            border: 0;
            border-radius: 14px;
            padding: 12px 14px;
            font: inherit;
            font-weight: 700;
            background: #f4e1d1;
            color: #3d2719;
            cursor: pointer;
        }

        .content {
            padding: 28px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 24px;
        }

        .topbar h1 {
            margin: 0 0 8px;
            font-size: 2rem;
        }

        .topbar p {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .user-badge {
            padding: 14px 18px;
            border-radius: 18px;
            background: var(--card);
            border: 1px solid var(--border);
            box-shadow: 0 16px 40px rgba(47, 29, 18, 0.08);
            font-weight: 600;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .card,
        .panel {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 22px;
            box-shadow: 0 18px 46px rgba(47, 29, 18, 0.07);
        }

        .panel h2 {
            margin-bottom: 14px;
        }

        .card span {
            display: block;
            color: var(--muted);
            margin-bottom: 12px;
        }

        .card strong {
            font-size: 2rem;
        }

        .accent {
            background: linear-gradient(135deg, #f7ebdf, #fffaf4);
            border-color: rgba(207, 157, 114, 0.28);
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px 0;
            text-align: left;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
        }

        th {
            color: var(--muted);
            font-size: 0.9rem;
            font-weight: 700;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 999px;
            background: var(--accent-soft);
            color: #7a4f2b;
            font-size: 0.88rem;
            font-weight: 700;
        }

        .empty-state {
            padding: 22px;
            border-radius: 18px;
            background: #fcf8f2;
            border: 1px dashed rgba(79, 52, 34, 0.2);
            color: var(--muted);
            line-height: 1.6;
        }

        .placeholder-list {
            display: grid;
            gap: 14px;
        }

        .placeholder-item {
            padding: 18px;
            border-radius: 18px;
            background: #fcf8f2;
            border: 1px solid rgba(79, 52, 34, 0.08);
        }

        @media (max-width: 960px) {
            .app-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                padding: 20px;
            }

            .topbar {
                flex-direction: column;
                align-items: stretch;
            }

            .user-badge {
                width: fit-content;
            }

            .card-grid {
                grid-template-columns: 1fr;
            }

            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <div class="brand">
                <small>Admin Panel</small>
                <strong>{{ config('app.name') }}</strong>
            </div>

            <nav>
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link {{ request()->routeIs('questionnaires.*') ? 'active' : '' }}" href="{{ route('questionnaires.index') }}">Data Kuesioner</a>
                <a class="nav-link {{ request()->routeIs('questions.*') ? 'active' : '' }}" href="{{ route('questions.index') }}">Pertanyaan Kuesioner</a>
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">Pengaturan Pengguna</a>
            </nav>

            <div class="sidebar-footer">
                <p class="sidebar-note">
                    Login sebagai <strong>{{ auth()->user()->username }}</strong>.
                    Area admin siap dipakai untuk kelola data inti kuesioner.
                </p>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">Logout</button>
                </form>
            </div>
        </aside>

        <main class="content">
            <div class="topbar">
                <div>
                    <h1>{{ $heading ?? 'Dashboard' }}</h1>
                    <p>{{ $subheading ?? 'Kelola aplikasi kuesioner untuk meja coffee dari satu tempat.' }}</p>
                </div>
                <div class="user-badge">{{ auth()->user()->name }}</div>
            </div>

            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
