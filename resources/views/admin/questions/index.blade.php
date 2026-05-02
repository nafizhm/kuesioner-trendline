@extends('layouts.admin', [
    'heading' => 'Pertanyaan Kuesioner',
    'subheading' => 'Kelola pertanyaan yang tampil di halaman frontend. Semua jawaban disimpan sebagai teks isian.',
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
        .field-inline input,
        .modal-card input,
        .modal-card textarea {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 11px 13px;
            font: inherit;
            color: var(--text);
            background: #fffefb;
        }

        .field-inline input {
            min-width: 240px;
        }

        .btn,
        .btn-light,
        .btn-danger {
            border: 0;
            border-radius: 14px;
            padding: 11px 16px;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
        }

        .btn {
            background: linear-gradient(135deg, #73855d, #566445);
            color: #fff;
        }

        .btn-light {
            background: #f6efe4;
            color: var(--text);
        }

        .btn-danger {
            background: #f6dede;
            color: #8d3131;
        }

        .action-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .soft-note {
            color: var(--muted);
            line-height: 1.6;
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
            width: min(100%, 860px);
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

        .modal-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(240px, 0.75fr);
            gap: 18px 20px;
            align-items: start;
        }

        .modal-grid textarea {
            min-height: 180px;
            resize: vertical;
        }

        .form-group {
            display: grid;
            gap: 8px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .field-note {
            color: var(--muted);
            font-size: 0.92rem;
            line-height: 1.5;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            padding: 14px 16px;
            border-radius: 16px;
            background: #faf5ee;
            border: 1px solid rgba(79, 52, 34, 0.08);
        }

        .checkbox-row input {
            width: auto;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(79, 52, 34, 0.08);
        }

        .spinner {
            width: 15px;
            height: 15px;
            border: 2px solid rgba(255, 255, 255, 0.45);
            border-top-color: #fff;
            border-radius: 999px;
            display: inline-block;
            animation: spin 0.7s linear infinite;
        }

        .hidden {
            display: none !important;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 720px) {
            .toolbar,
            .datatable-meta,
            .modal-head,
            .modal-actions {
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

            .modal-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .modal-grid textarea {
                min-height: 140px;
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
                <h2 style="margin-top: 0;">Data Pertanyaan</h2>
                <p class="soft-note">Tambah, ubah, dan hapus pertanyaan yang akan tampil di atas kolom saran frontend.</p>
            </div>

            <button class="btn" type="button" data-open-question-modal="create">Tambah Pertanyaan</button>
        </div>

        <div class="toolbar">
            <div class="toolbar-group">
                <label class="field-inline">
                    Tampilkan
                    <select id="questionPageSize">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                    </select>
                    data
                </label>
            </div>

            <label class="field-inline">
                Cari
                <input id="questionSearch" type="search" placeholder="Cari pertanyaan atau placeholder">
            </label>
        </div>

        @if ($questions->isNotEmpty())
            <div class="table-wrap">
                <table id="questionTable">
                    <thead>
                        <tr>
                            <th>Urutan</th>
                            <th>Pertanyaan</th>
                            <th>Placeholder</th>
                            <th>Status</th>
                            <th style="width: 170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr
                                data-row
                                data-search="{{ strtolower($question->question_text.' '.$question->placeholder) }}"
                            >
                                <td>{{ $question->sort_order }}</td>
                                <td>{{ $question->question_text }}</td>
                                <td>{{ $question->placeholder ?: '-' }}</td>
                                <td>
                                    <span class="badge">{{ $question->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </td>
                                <td>
                                    <div class="action-row">
                                        <button
                                            class="btn-light"
                                            type="button"
                                            data-open-question-modal="edit"
                                            data-id="{{ $question->id }}"
                                            data-question="{{ $question->question_text }}"
                                            data-placeholder="{{ $question->placeholder }}"
                                            data-sort-order="{{ $question->sort_order }}"
                                            data-is-active="{{ $question->is_active ? '1' : '0' }}"
                                        >
                                            Edit
                                        </button>

                                        <form method="POST" action="{{ route('questions.destroy', $question) }}" onsubmit="return confirm('Hapus pertanyaan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-danger" type="submit">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="datatable-meta">
                <div id="questionTableInfo">Menampilkan data pertanyaan.</div>
                <div class="pagination">
                    <button id="questionPrev" type="button">Sebelumnya</button>
                    <span id="questionPageLabel">Halaman 1</span>
                    <button id="questionNext" type="button">Berikutnya</button>
                </div>
            </div>
        @else
            <div class="empty-state">
                Belum ada pertanyaan. Tambahkan pertanyaan pertama agar frontend bisa mulai menampilkan form kuesioner.
            </div>
        @endif
    </section>

    <div class="modal" id="questionModal" aria-hidden="true">
        <div class="modal-card">
            <div class="modal-head">
                <div>
                    <h3 id="questionModalTitle">Tambah Pertanyaan</h3>
                    <p class="soft-note" style="margin: 0;">Semua jawaban akan disimpan sebagai teks isian pada halaman frontend.</p>
                </div>
                <button class="close-modal" type="button" data-close-question-modal>&times;</button>
            </div>

            <form method="POST" id="questionForm" action="{{ route('questions.store') }}">
                @csrf
                <div id="questionMethod"></div>

                <div class="modal-grid">
                    <div class="form-group full">
                        <label for="question_text">Pertanyaan</label>
                        <textarea id="question_text" name="question_text" placeholder="Tulis pertanyaan kuesioner">{{ old('question_text') }}</textarea>
                        <div class="field-note">Gunakan kalimat yang jelas dan natural karena pertanyaan ini akan tampil langsung di halaman frontend.</div>
                        @error('question_text')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="placeholder">Placeholder Jawaban</label>
                        <input id="placeholder" name="placeholder" type="text" value="{{ old('placeholder') }}" placeholder="Contoh jawaban yang diharapkan">
                        <div class="field-note">Teks bantuan singkat untuk mengarahkan pengunjung saat mengisi jawaban.</div>
                        @error('placeholder')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="sort_order">Urutan Tampil</label>
                        <input id="sort_order" name="sort_order" type="number" min="1" value="{{ old('sort_order', 1) }}">
                        <div class="field-note">Angka lebih kecil akan tampil lebih dulu di halaman form saran.</div>
                        @error('sort_order')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group full">
                        <label class="checkbox-row">
                            <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                            Tampilkan pertanyaan ini di frontend
                        </label>
                    </div>
                </div>

                <div class="modal-actions">
                    <button class="btn-light" type="button" data-close-question-modal>Batal</button>
                    <button class="btn" type="submit" data-submit-with-spinner>
                        <span data-button-text>Simpan Pertanyaan</span>
                        <span class="spinner hidden" data-button-spinner></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            const modal = document.getElementById('questionModal');
            const form = document.getElementById('questionForm');
            const modalTitle = document.getElementById('questionModalTitle');
            const methodContainer = document.getElementById('questionMethod');
            const questionInput = document.getElementById('question_text');
            const placeholderInput = document.getElementById('placeholder');
            const sortOrderInput = document.getElementById('sort_order');
            const isActiveInput = document.getElementById('is_active');
            const updateBaseUrl = @json(url('/pengaturan-pertanyaan'));

            const openModal = (mode, payload = {}) => {
                modal.classList.add('open');
                modal.setAttribute('aria-hidden', 'false');

                if (mode === 'edit') {
                    modalTitle.textContent = 'Edit Pertanyaan';
                    form.action = `${updateBaseUrl}/${payload.id}`;
                    methodContainer.innerHTML = '@method("PUT")';
                    questionInput.value = payload.question || '';
                    placeholderInput.value = payload.placeholder || '';
                    sortOrderInput.value = payload.sortOrder || 1;
                    isActiveInput.checked = payload.isActive === '1';
                } else {
                    modalTitle.textContent = 'Tambah Pertanyaan';
                    form.action = @json(route('questions.store'));
                    methodContainer.innerHTML = '';
                    form.reset();
                    sortOrderInput.value = 1;
                    isActiveInput.checked = true;
                }
            };

            const closeModal = () => {
                modal.classList.remove('open');
                modal.setAttribute('aria-hidden', 'true');
            };

            document.querySelectorAll('[data-open-question-modal]').forEach((button) => {
                button.addEventListener('click', () => {
                    const mode = button.dataset.openQuestionModal;

                    openModal(mode, {
                        id: button.dataset.id,
                        question: button.dataset.question,
                        placeholder: button.dataset.placeholder,
                        sortOrder: button.dataset.sortOrder,
                        isActive: button.dataset.isActive,
                    });
                });
            });

            document.querySelectorAll('[data-close-question-modal]').forEach((button) => {
                button.addEventListener('click', closeModal);
            });

            modal?.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.querySelectorAll('[data-submit-with-spinner]').forEach((button) => {
                button.closest('form')?.addEventListener('submit', () => {
                    button.disabled = true;
                    button.querySelector('[data-button-text]').textContent = 'Menyimpan...';
                    button.querySelector('[data-button-spinner]').classList.remove('hidden');
                });
            });

            const rows = Array.from(document.querySelectorAll('#questionTable [data-row]'));
            const searchInput = document.getElementById('questionSearch');
            const pageSizeSelect = document.getElementById('questionPageSize');
            const info = document.getElementById('questionTableInfo');
            const prevButton = document.getElementById('questionPrev');
            const nextButton = document.getElementById('questionNext');
            const pageLabel = document.getElementById('questionPageLabel');
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

                rows.forEach((row) => {
                    row.classList.add('hidden');
                });

                filteredRows.slice(start, end).forEach((row) => {
                    row.classList.remove('hidden');
                });

                info.textContent = filteredRows.length
                    ? `Menampilkan ${start + 1}-${Math.min(end, filteredRows.length)} dari ${filteredRows.length} pertanyaan`
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

            @if ($errors->any())
                openModal('create');
            @endif
        })();
    </script>
@endpush
