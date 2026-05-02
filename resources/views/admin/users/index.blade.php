@extends('layouts.admin', [
    'heading' => 'Pengaturan Pengguna',
    'subheading' => 'Kelola akun admin berbasis username untuk mengakses dashboard.',
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

        .status-banner {
            margin-bottom: 16px;
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(60, 111, 72, 0.12);
            color: var(--success);
            font-weight: 700;
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

        .soft-note {
            color: var(--muted);
            line-height: 1.6;
        }

        .action-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
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
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px 20px;
            align-items: start;
        }

        .form-group {
            display: grid;
            gap: 8px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group input {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 12px 13px;
            font: inherit;
            color: var(--text);
            background: #fffefb;
        }

        .field-note {
            color: var(--muted);
            font-size: 0.92rem;
            line-height: 1.5;
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
            .modal-head,
            .modal-actions {
                flex-direction: column;
                align-items: stretch;
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
                <h2 style="margin-top: 0;">Daftar Pengguna</h2>
                <p class="soft-note">Tambah, ubah, dan hapus akun admin yang dapat masuk ke dashboard.</p>
            </div>

            <button class="btn" type="button" data-open-user-modal="create">Tambah Pengguna</button>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Dibuat</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td><span class="badge">{{ $user->username }}</span></td>
                            <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <div class="action-row">
                                    <button
                                        class="btn-light"
                                        type="button"
                                        data-open-user-modal="edit"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-username="{{ $user->username }}"
                                    >
                                        Edit
                                    </button>

                                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini?')" >
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-danger" type="submit" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <div class="modal" id="userModal" aria-hidden="true">
        <div class="modal-card">
            <div class="modal-head">
                <div>
                    <h3 id="userModalTitle">Tambah Pengguna</h3>
                    <p class="soft-note" style="margin: 0;">Gunakan username unik dan password yang mudah dikelola oleh tim admin.</p>
                </div>
                <button class="close-modal" type="button" data-close-user-modal>&times;</button>
            </div>

            <form method="POST" id="userForm" action="{{ route('users.store') }}">
                @csrf
                <div id="userMethod"></div>

                <div class="modal-grid">
                    <div class="form-group full">
                        <label for="name">Nama Pengguna</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Contoh: Admin Shift Pagi">
                        <div class="field-note">Nama ini akan tampil di area admin untuk memudahkan identifikasi akun.</div>
                        @error('name')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" name="username" type="text" value="{{ old('username') }}" placeholder="Contoh: admintrendline">
                        <div class="field-note">Gunakan huruf, angka, dash, atau underscore.</div>
                        @error('username')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" placeholder="Minimal 6 karakter">
                        <div class="field-note" id="passwordHelp">Isi password untuk akun baru.</div>
                        @error('password')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Ulangi password">
                        <div class="field-note">Pastikan sama dengan password di atas.</div>
                    </div>
                </div>

                <div class="modal-actions">
                    <button class="btn-light" type="button" data-close-user-modal>Batal</button>
                    <button class="btn" type="submit" data-submit-with-spinner>
                        <span data-button-text>Simpan Pengguna</span>
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
            const modal = document.getElementById('userModal');
            const form = document.getElementById('userForm');
            const modalTitle = document.getElementById('userModalTitle');
            const methodContainer = document.getElementById('userMethod');
            const nameInput = document.getElementById('name');
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const passwordHelp = document.getElementById('passwordHelp');
            const updateBaseUrl = @json(url('/pengaturan-pengguna'));

            const openModal = (mode, payload = {}) => {
                modal.classList.add('open');
                modal.setAttribute('aria-hidden', 'false');

                if (mode === 'edit') {
                    modalTitle.textContent = 'Edit Pengguna';
                    form.action = `${updateBaseUrl}/${payload.id}`;
                    methodContainer.innerHTML = '@method("PUT")';
                    nameInput.value = payload.name || '';
                    usernameInput.value = payload.username || '';
                    passwordInput.value = '';
                    passwordConfirmationInput.value = '';
                    passwordHelp.textContent = 'Kosongkan jika password tidak ingin diubah.';
                } else {
                    modalTitle.textContent = 'Tambah Pengguna';
                    form.action = @json(route('users.store'));
                    methodContainer.innerHTML = '';
                    form.reset();
                    passwordHelp.textContent = 'Isi password untuk akun baru.';
                }
            };

            const closeModal = () => {
                modal.classList.remove('open');
                modal.setAttribute('aria-hidden', 'true');
            };

            document.querySelectorAll('[data-open-user-modal]').forEach((button) => {
                button.addEventListener('click', () => {
                    const mode = button.dataset.openUserModal;

                    openModal(mode, {
                        id: button.dataset.id,
                        name: button.dataset.name,
                        username: button.dataset.username,
                    });
                });
            });

            document.querySelectorAll('[data-close-user-modal]').forEach((button) => {
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

            @if ($errors->any())
                openModal('create');
            @endif
        })();
    </script>
@endpush
