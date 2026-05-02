@extends('layouts.admin', [
    'heading' => 'Data Kuesioner',
    'subheading' => 'Daftar isian pengunjung dari form frontend, lengkap dengan jawaban pertanyaan dan saran.',
])

@push('styles')
    <style>
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .toolbar-group {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .status-banner {
            margin-bottom: 16px;
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(60, 111, 72, 0.12);
            color: var(--success);
            font-weight: 700;
        }

        .field-inline {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
        }

        .field-inline select,
        .field-inline input {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 11px 13px;
            font: inherit;
            color: var(--text);
            background: #fffefb;
        }

        .field-inline input {
            min-width: 260px;
        }

        .soft-note {
            color: var(--muted);
            line-height: 1.6;
        }

        .action-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-light,
        .btn-danger {
            border: 0;
            border-radius: 14px;
            padding: 10px 14px;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-light {
            background: #f6efe4;
            color: var(--text);
        }

        .btn-danger {
            background: #f6dede;
            color: #8d3131;
        }

        .summary-text {
            max-width: 360px;
            color: var(--muted);
            line-height: 1.65;
        }

        .summary-meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .meta-chip {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 999px;
            background: #f6efe4;
            color: var(--text);
            font-size: 0.85rem;
            font-weight: 600;
        }

        .datatable-meta {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            margin-top: 16px;
            flex-wrap: wrap;
            color: var(--muted);
        }

        .pagination {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .pagination button {
            border: 1px solid var(--border);
            background: #fffefb;
            color: var(--text);
            border-radius: 12px;
            padding: 8px 12px;
            cursor: pointer;
        }

        .pagination button[disabled] {
            opacity: 0.45;
            cursor: not-allowed;
        }

        .modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(38, 28, 20, 0.45);
            z-index: 1000;
        }

        .modal.open {
            display: flex;
        }

        .modal-card {
            width: min(100%, 920px);
            max-height: min(88vh, 920px);
            overflow: auto;
            background: #fffdf9;
            border-radius: 28px;
            padding: 30px;
            border: 1px solid rgba(79, 52, 34, 0.08);
            box-shadow: 0 32px 70px rgba(38, 28, 20, 0.22);
        }

        .modal-head {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: flex-start;
            margin-bottom: 22px;
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(79, 52, 34, 0.08);
        }

        .modal-head h3 {
            margin: 0 0 6px;
            font-size: 1.45rem;
        }

        .close-modal {
            border: 0;
            background: #f6efe4;
            width: 38px;
            height: 38px;
            border-radius: 999px;
            font-size: 1.25rem;
            cursor: pointer;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(280px, 0.9fr);
            gap: 20px;
        }

        .detail-card {
            padding: 18px;
            border-radius: 18px;
            background: #fcf8f2;
            border: 1px solid rgba(79, 52, 34, 0.08);
        }

        .detail-card h4 {
            margin: 0 0 10px;
        }

        .detail-answer-list {
            display: grid;
            gap: 14px;
        }

        .detail-answer-item {
            padding: 16px;
            border-radius: 16px;
            background: #fffefb;
            border: 1px solid rgba(79, 52, 34, 0.08);
        }

        .detail-answer-item strong {
            display: block;
            margin-bottom: 6px;
        }

        .detail-answer-item div,
        .detail-card p {
            color: var(--muted);
            line-height: 1.65;
            margin: 0;
        }

        .hidden {
            display: none !important;
        }

        @media (max-width: 840px) {
            .toolbar,
            .datatable-meta,
            .modal-head {
                flex-direction: column;
                align-items: stretch;
            }

            .field-inline {
                width: 100%;
            }

            .field-inline input {
                min-width: 0;
                width: 100%;
            }

            .action-row form,
            .action-row button {
                width: 100%;
            }

            .modal-card {
                width: 100%;
                padding: 22px;
                border-radius: 22px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <section class="panel">
        @if (session('status'))
            <div class="status-banner">{{ session('status') }}</div>
        @endif

        <div class="toolbar">
            <div>
                <h2 style="margin-top: 0;">Daftar Isian Kuesioner</h2>
                <p class="soft-note">Gunakan tombol detail untuk melihat seluruh jawaban pengunjung dalam satu tampilan yang rapi.</p>
            </div>
        </div>

        @if ($suggestions->isNotEmpty())
            <div class="toolbar">
                <div class="toolbar-group">
                    <label class="field-inline">
                        Tampilkan
                        <select id="questionnairePageSize">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                        </select>
                        data
                    </label>
                </div>

                <label class="field-inline">
                    Cari
                    <input id="questionnaireSearch" type="search" placeholder="Cari isi saran atau jawaban">
                </label>
            </div>

            <div class="table-wrap">
                <table id="questionnaireTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ringkasan</th>
                            <th>Jumlah Jawaban</th>
                            <th>Waktu</th>
                            <th style="width: 200px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suggestions as $suggestion)
                            @php
                                $answerSummary = $suggestion->answers->map(fn ($answer) => $answer->question->question_text.' '.$answer->answer_text)->implode(' ');
                                $guestSummary = collect([$suggestion->guest_name, $suggestion->table_number])->filter()->implode(' ');
                            @endphp
                            <tr
                                data-row
                                data-search="{{ strtolower(trim($suggestion->suggestion.' '.$answerSummary.' '.$guestSummary)) }}"
                            >
                                <td>#{{ $suggestion->id }}</td>
                                <td>
                                    <div class="summary-text">
                                        {{ \Illuminate\Support\Str::limit($suggestion->suggestion, 110) }}
                                    </div>
                                    @if ($suggestion->guest_name || $suggestion->table_number)
                                        <div class="summary-meta">
                                            @if ($suggestion->guest_name)
                                                <span class="meta-chip">{{ $suggestion->guest_name }}</span>
                                            @endif
                                            @if ($suggestion->table_number)
                                                <span class="meta-chip">{{ $suggestion->table_number }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge">{{ $suggestion->answers->count() }} jawaban</span>
                                </td>
                                <td>{{ $suggestion->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <div class="action-row">
                                        <button
                                            class="btn-light"
                                            type="button"
                                            data-open-detail-modal
                                            data-id="{{ $suggestion->id }}"
                                            data-created-at="{{ $suggestion->created_at->format('d M Y H:i') }}"
                                            data-suggestion="{{ e($suggestion->suggestion) }}"
                                            data-guest-name="{{ e($suggestion->guest_name ?? '') }}"
                                            data-table-number="{{ e($suggestion->table_number ?? '') }}"
                                            data-answers='@json($suggestion->answers->map(fn ($answer) => ["question" => $answer->question->question_text, "answer" => $answer->answer_text])->values())'
                                        >
                                            Detail
                                        </button>

                                        <form method="POST" action="{{ route('questionnaires.destroy', $suggestion) }}" onsubmit="return confirm('Hapus data kuesioner ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="datatable-meta">
                <div id="questionnaireTableInfo">Menampilkan data kuesioner.</div>
                <div class="pagination">
                    <button id="questionnairePrev" type="button">Sebelumnya</button>
                    <span id="questionnairePageLabel">Halaman 1</span>
                    <button id="questionnaireNext" type="button">Berikutnya</button>
                </div>
            </div>
        @else
            <div class="empty-state">
                Belum ada data kuesioner. Halaman ini akan langsung menampilkan respon begitu form frontend mulai digunakan.
            </div>
        @endif
    </section>

    <div class="modal" id="questionnaireDetailModal" aria-hidden="true">
        <div class="modal-card">
            <div class="modal-head">
                <div>
                    <h3 id="detailTitle">Detail Kuesioner</h3>
                    <p class="soft-note" id="detailMeta" style="margin: 0;">Lihat seluruh isian responden dalam satu panel.</p>
                </div>
                <button class="close-modal" type="button" data-close-detail-modal>&times;</button>
            </div>

            <div class="detail-grid">
                <div class="detail-card">
                    <h4>Info Pengunjung</h4>
                    <p id="detailGuest">Tidak diisi.</p>
                </div>

                <div class="detail-card">
                    <h4>Saran Pengunjung</h4>
                    <p id="detailSuggestion">-</p>
                </div>

                <div class="detail-card">
                    <h4>Jawaban Pertanyaan</h4>
                    <div class="detail-answer-list" id="detailAnswers"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            const rows = Array.from(document.querySelectorAll('#questionnaireTable [data-row]'));
            const searchInput = document.getElementById('questionnaireSearch');
            const pageSizeSelect = document.getElementById('questionnairePageSize');
            const info = document.getElementById('questionnaireTableInfo');
            const prevButton = document.getElementById('questionnairePrev');
            const nextButton = document.getElementById('questionnaireNext');
            const pageLabel = document.getElementById('questionnairePageLabel');
            let currentPage = 1;

            const renderTable = () => {
                if (!rows.length) {
                    return;
                }

                const keyword = (searchInput?.value || '').trim().toLowerCase();
                const pageSize = Number(pageSizeSelect?.value || 10);
                const filteredRows = rows.filter((row) => row.dataset.search.includes(keyword));
                const totalPages = Math.max(1, Math.ceil(filteredRows.length / pageSize));

                if (currentPage > totalPages) {
                    currentPage = totalPages;
                }

                const start = (currentPage - 1) * pageSize;
                const end = start + pageSize;

                rows.forEach((row) => row.classList.add('hidden'));
                filteredRows.slice(start, end).forEach((row) => row.classList.remove('hidden'));

                info.textContent = filteredRows.length
                    ? `Menampilkan ${start + 1}-${Math.min(end, filteredRows.length)} dari ${filteredRows.length} data`
                    : 'Tidak ada data yang cocok dengan pencarian.';
                pageLabel.textContent = `Halaman ${currentPage} dari ${totalPages}`;
                prevButton.disabled = currentPage === 1;
                nextButton.disabled = currentPage === totalPages || filteredRows.length === 0;
            };

            searchInput?.addEventListener('input', () => {
                currentPage = 1;
                renderTable();
            });

            pageSizeSelect?.addEventListener('change', () => {
                currentPage = 1;
                renderTable();
            });

            prevButton?.addEventListener('click', () => {
                currentPage -= 1;
                renderTable();
            });

            nextButton?.addEventListener('click', () => {
                currentPage += 1;
                renderTable();
            });

            renderTable();

            const modal = document.getElementById('questionnaireDetailModal');
            const detailTitle = document.getElementById('detailTitle');
            const detailMeta = document.getElementById('detailMeta');
            const detailGuest = document.getElementById('detailGuest');
            const detailSuggestion = document.getElementById('detailSuggestion');
            const detailAnswers = document.getElementById('detailAnswers');

            const closeModal = () => {
                modal.classList.remove('open');
                modal.setAttribute('aria-hidden', 'true');
            };

            document.querySelectorAll('[data-open-detail-modal]').forEach((button) => {
                button.addEventListener('click', () => {
                    const answers = JSON.parse(button.dataset.answers || '[]');

                    detailTitle.textContent = `Detail Kuesioner #${button.dataset.id}`;
                    detailMeta.textContent = `Dikirim pada ${button.dataset.createdAt}`;
                    detailGuest.textContent = [button.dataset.guestName, button.dataset.tableNumber].filter(Boolean).join(' | ') || 'Tidak diisi.';
                    detailSuggestion.textContent = button.dataset.suggestion || '-';
                    detailAnswers.innerHTML = '';

                    if (answers.length) {
                        answers.forEach((item) => {
                            const wrapper = document.createElement('div');
                            wrapper.className = 'detail-answer-item';
                            wrapper.innerHTML = `<strong>${item.question}</strong><div>${item.answer}</div>`;
                            detailAnswers.appendChild(wrapper);
                        });
                    } else {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'detail-answer-item';
                        wrapper.innerHTML = '<strong>Belum ada jawaban tambahan</strong><div>Respon ini hanya berisi saran utama tanpa jawaban pertanyaan tambahan.</div>';
                        detailAnswers.appendChild(wrapper);
                    }

                    modal.classList.add('open');
                    modal.setAttribute('aria-hidden', 'false');
                });
            });

            document.querySelectorAll('[data-close-detail-modal]').forEach((button) => {
                button.addEventListener('click', closeModal);
            });

            modal?.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });
        })();
    </script>
@endpush
