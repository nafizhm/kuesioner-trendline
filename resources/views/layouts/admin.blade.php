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

        body.sidebar-open {
            overflow: hidden;
        }

        .app-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 280px 1fr;
        }

        .sidebar {
            position: relative;
            padding: 28px 20px;
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.05), transparent 28%),
                linear-gradient(180deg, var(--sidebar), #23140b);
            color: #f9f4ee;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .sidebar-close {
            display: none;
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            color: #f9f4ee;
            font-size: 1.35rem;
            cursor: pointer;
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
            padding: 0;
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

        .topbar-main {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            flex: 1;
        }

        .page-copy {
            min-width: 0;
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

        .sidebar-toggle {
            display: none;
            width: 46px;
            height: 46px;
            border: 0;
            border-radius: 16px;
            background: linear-gradient(135deg, #6f8258, #556643);
            color: #fff;
            box-shadow: 0 14px 28px rgba(47, 29, 18, 0.12);
            cursor: pointer;
            flex-shrink: 0;
        }

        .sidebar-toggle svg {
            width: 20px;
            height: 20px;
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

        .sidebar-backdrop {
            display: none;
        }

        @media (max-width: 1024px) {
            .app-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: fixed;
                inset: 0 auto 0 0;
                width: min(320px, calc(100vw - 40px));
                min-height: 100vh;
                z-index: 40;
                overflow-y: auto;
                transform: translateX(-100%);
                transition: transform 0.24s ease;
                box-shadow: 24px 0 60px rgba(0, 0, 0, 0.18);
            }

            .app-shell.sidebar-open .sidebar {
                transform: translateX(0);
            }

            .sidebar-backdrop {
                position: fixed;
                inset: 0;
                z-index: 30;
                display: block;
                background: rgba(26, 17, 10, 0.34);
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.24s ease;
            }

            .app-shell.sidebar-open .sidebar-backdrop {
                opacity: 1;
                pointer-events: auto;
            }

            .sidebar {
                padding: 20px;
            }

            .sidebar-close,
            .sidebar-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .topbar {
                flex-direction: column;
                align-items: stretch;
                gap: 14px;
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

        @media (max-width: 640px) {
            .content {
                padding: 16px;
            }

            .card,
            .panel {
                padding: 18px;
                border-radius: 20px;
            }

            .topbar h1 {
                font-size: 1.6rem;
            }

            .topbar p {
                font-size: 0.95rem;
            }

            .user-badge {
                width: 100%;
                text-align: center;
            }

            th,
            td {
                padding: 12px 0;
            }
        }
    </style>
</head>
<body>
    <div class="app-shell" id="adminShell">
        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="brand" style="margin-bottom: 0; flex: 1;">
                    <small>Admin Panel</small>
                    <strong>{{ config('app.name') }}</strong>
                </div>
                <button class="sidebar-close" type="button" id="sidebarClose" aria-label="Tutup sidebar">&times;</button>
            </div>

            <nav style="margin-top: 22px;">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link {{ request()->routeIs('questionnaires.*') ? 'active' : '' }}" href="{{ route('questionnaires.index') }}">Data Kuesioner</a>
                <a class="nav-link {{ request()->routeIs('questions.*') ? 'active' : '' }}" href="{{ route('questions.index') }}">Pertanyaan Kuesioner</a>
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">Pengaturan Pengguna</a>
            </nav>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">Logout</button>
                </form>
            </div>
        </aside>

        <main class="content">
            <div class="topbar">
                <div class="topbar-main">
                    <button class="sidebar-toggle" type="button" id="sidebarToggle" aria-label="Buka sidebar">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <div class="page-copy">
                        <h1>{{ $heading ?? 'Dashboard' }}</h1>
                        <p>{{ $subheading ?? 'Kelola aplikasi kuesioner untuk meja coffee dari satu tempat.' }}</p>
                    </div>
                </div>
                <div class="user-badge">{{ auth()->user()->name }}</div>
            </div>

            @yield('content')
        </main>
    </div>
    <script>
        (() => {
            const shell = document.getElementById('adminShell');
            const body = document.body;
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarClose = document.getElementById('sidebarClose');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');
            const mobileBreakpoint = window.matchMedia('(max-width: 1024px)');

            const closeSidebar = () => {
                shell?.classList.remove('sidebar-open');
                body.classList.remove('sidebar-open');
            };

            const openSidebar = () => {
                shell?.classList.add('sidebar-open');
                body.classList.add('sidebar-open');
            };

            sidebarToggle?.addEventListener('click', () => {
                if (shell?.classList.contains('sidebar-open')) {
                    closeSidebar();
                    return;
                }

                openSidebar();
            });

            sidebarClose?.addEventListener('click', closeSidebar);
            sidebarBackdrop?.addEventListener('click', closeSidebar);

            document.querySelectorAll('.sidebar .nav-link').forEach((link) => {
                link.addEventListener('click', () => {
                    if (mobileBreakpoint.matches) {
                        closeSidebar();
                    }
                });
            });

            window.addEventListener('resize', () => {
                if (!mobileBreakpoint.matches) {
                    closeSidebar();
                }
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
