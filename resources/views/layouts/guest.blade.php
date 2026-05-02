<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    <style>
        :root {
            --ivory: #f6f4ee;
            --mist: #eef0e5;
            --sage: #909b70;
            --olive: #7d8960;
            --forest: #5e6849;
            --deep: #3f4934;
            --white: #fffefb;
            --danger: #9c2f2f;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.92), transparent 34%),
                radial-gradient(circle at bottom right, rgba(144, 155, 112, 0.18), transparent 28%),
                linear-gradient(135deg, #fcfbf7, var(--ivory) 42%, var(--mist) 100%);
            color: var(--deep);
        }

        a {
            color: inherit;
        }

        .page-shell {
            width: min(1100px, calc(100% - 32px));
            margin: 0 auto;
            padding: 32px 0 48px;
        }

        .topbar {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
        }

        .brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            text-align: center;
        }

        .brand img {
            width: min(420px, 80vw);
            height: auto;
            display: block;
            filter: drop-shadow(0 18px 28px rgba(63, 73, 52, 0.14));
        }

        .brand span {
            font-size: 0.92rem;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--forest);
        }

        .hero {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 24px;
            align-items: stretch;
        }

        .panel {
            background: rgba(255, 253, 249, 0.84);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(125, 137, 96, 0.16);
            border-radius: 28px;
            box-shadow: 0 22px 60px rgba(94, 104, 73, 0.12);
        }

        .hero-copy {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .eyebrow {
            display: inline-flex;
            width: fit-content;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(144, 155, 112, 0.16);
            color: var(--forest);
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.04em;
        }

        h1 {
            margin: 18px 0 16px;
            font-size: clamp(2.2rem, 4vw, 4.2rem);
            line-height: 1.02;
        }

        .lead {
            font-size: 1.08rem;
            line-height: 1.7;
            color: rgba(63, 73, 52, 0.82);
            max-width: 52ch;
        }

        .info-card {
            margin-top: 24px;
            padding: 18px 20px;
            border-radius: 22px;
            background: linear-gradient(135deg, var(--sage), var(--forest));
            color: var(--white);
        }

        .info-card strong {
            display: block;
            margin-bottom: 6px;
        }

        .form-card {
            padding: 28px;
        }

        .question-block {
            padding: 16px 18px;
            margin-top: 16px;
            border-radius: 20px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.88), rgba(238, 240, 229, 0.55));
            border: 1px solid rgba(125, 137, 96, 0.14);
        }

        .form-card h2 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .muted {
            color: rgba(63, 73, 52, 0.74);
            line-height: 1.6;
        }

        .field {
            margin-top: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        input,
        textarea {
            width: 100%;
            border: 1px solid rgba(125, 137, 96, 0.24);
            border-radius: 18px;
            padding: 14px 16px;
            font: inherit;
            background: rgba(255, 255, 255, 0.85);
            color: var(--deep);
        }

        input:focus,
        textarea:focus {
            outline: 3px solid rgba(144, 155, 112, 0.18);
            border-color: var(--sage);
        }

        textarea {
            min-height: 180px;
            resize: vertical;
        }

        .error-text {
            margin-top: 8px;
            color: var(--danger);
            font-size: 0.92rem;
        }

        .status {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(144, 155, 112, 0.16);
            color: var(--forest);
            font-weight: 600;
        }

        .button {
            margin-top: 22px;
            width: 100%;
            border: 0;
            border-radius: 18px;
            padding: 15px 18px;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            background: linear-gradient(135deg, var(--sage), var(--forest));
            color: var(--white);
            box-shadow: 0 18px 32px rgba(94, 104, 73, 0.24);
        }

        .button:hover {
            filter: brightness(1.04);
        }

        @media (max-width: 900px) {
            .hero {
                grid-template-columns: 1fr;
            }

            .hero-copy,
            .form-card {
                padding: 24px;
            }
        }

        @media (max-width: 640px) {
            .page-shell {
                width: min(100% - 20px, 1100px);
                padding: 18px 0 28px;
            }

            .brand img {
                width: min(320px, 78vw);
            }

            .brand span {
                letter-spacing: 0.16em;
                font-size: 0.82rem;
            }

            h1 {
                font-size: 1.9rem;
                line-height: 1.14;
            }

            .lead,
            .muted {
                font-size: 0.96rem;
            }

            .field {
                margin-top: 14px;
            }

            input,
            textarea,
            .button {
                border-radius: 16px;
                padding: 13px 14px;
            }

            .question-block {
                padding: 14px;
                border-radius: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <div class="topbar">
            <div class="brand">
                <img src="{{ asset('images/trendline-logo.png') }}" alt="Logo Trendline Coffee">
                <span>Trendline Coffee</span>
            </div>
        </div>

        @yield('content')
    </div>
</body>
</html>
