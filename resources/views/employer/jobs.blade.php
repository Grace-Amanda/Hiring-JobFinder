<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Kelola Lowongan</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== DESIGN TOKENS (sama persis dengan halaman employer lain) ===== */
        :root {
            --bg-dark: #13131a;
            --card-dark: #1c1c24;
            --border-dark: #2d2d3a;
            --primary-orange: #ff512f;
            --gradient-orange: linear-gradient(135deg, #ff512f 0%, #f09819 100%);
            --text-light: #ffffff;
            --text-muted: #a1a1aa;
        }
        *, *::before, *::after { box-sizing: border-box; }

        body, html {
            margin: 0; padding: 0;
            background: linear-gradient(135deg, #0f0f13 0%, #1a1a24 100%);
            color: var(--text-light);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- BACKGROUND --- */
        .bg-shapes { position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; }
        .shape1, .shape2 { position: absolute; filter: blur(50px); }
        .shape1 { top: -10%; left: -10%; width: 50vw; height: 50vw; background: radial-gradient(circle, rgba(255,81,47,.15) 0%, transparent 60%); }
        .shape2 { bottom: 0; right: -10%; width: 60vw; height: 60vw; background: radial-gradient(circle, rgba(240,152,25,.1) 0%, transparent 60%); }
        .grid-pattern { position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px); background-size: 40px 40px; }

        /* --- NAV --- */
        .top-nav { padding: 20px 5%; display: flex; justify-content: space-between; align-items: center; z-index: 10; position: relative; }
        .logo { font-size: 28px; font-weight: 800; color: var(--primary-orange); letter-spacing: -1px; text-shadow: 0 4px 10px rgba(255,81,47,.3); display: flex; align-items: baseline; gap: 8px; }
        .logo span { font-size: 14px; font-weight: 500; color: var(--text-muted); letter-spacing: 1px; text-transform: uppercase; }
        .desktop-menu { display: none; gap: 40px; }
        .desktop-menu a { color: var(--text-muted); text-decoration: none; font-size: 16px; font-weight: 500; transition: .3s; }
        .desktop-menu a.active, .desktop-menu a:hover { color: var(--text-light); }

        /* --- MAIN --- */
        .main-content { flex: 1; padding: 20px 5% 120px; max-width: 750px; margin: 0 auto; width: 100%; z-index: 5; position: relative; }

        /* --- PAGE HEADER --- */
        .page-header { margin-bottom: 28px; }
        .page-header h1 { font-size: 26px; font-weight: 800; margin: 0 0 6px; letter-spacing: -1px; }
        .page-header p { color: var(--text-muted); margin: 0; font-size: 14px; }

        /* --- ALERT --- */
        .alert { padding: 14px 18px; border-radius: 14px; margin-bottom: 20px; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: rgba(74,222,128,.1); color: #4ade80; border: 1px solid rgba(74,222,128,.25); }
        .alert-danger  { background: rgba(248,113,113,.1); color: #f87171; border: 1px solid rgba(248,113,113,.25); }

        /* --- STATS --- */
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 24px; }
        .stat-card { background: rgba(28,28,36,.6); backdrop-filter: blur(20px); border: 1px solid var(--border-dark); border-radius: 18px; padding: 18px 12px; text-align: center; }
        .stat-num { font-size: 30px; font-weight: 800; background: var(--gradient-orange); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .stat-lbl { font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: .5px; margin-top: 4px; }

        /* --- BTN TAMBAH --- */
        .btn-tambah {
            display: flex; align-items: center; justify-content: center; gap: 10px;
            width: 100%; padding: 15px;
            background: var(--gradient-orange); border: none; color: #fff;
            border-radius: 16px; font-size: 15px; font-weight: 800;
            cursor: pointer; text-decoration: none;
            box-shadow: 0 10px 25px rgba(255,81,47,.3);
            transition: .3s; margin-bottom: 24px;
        }
        .btn-tambah:hover { transform: translateY(-2px); box-shadow: 0 15px 30px rgba(255,81,47,.4); }

        /* --- JOB CARD --- */
        .job-card {
            background: rgba(28,28,36,.6); backdrop-filter: blur(20px);
            border: 1px solid var(--border-dark); border-radius: 20px;
            padding: 22px 22px 22px 26px; margin-bottom: 16px;
            position: relative; overflow: hidden; transition: border-color .3s;
        }
        .job-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: var(--gradient-orange); border-radius: 4px 0 0 4px; }
        .job-card.inactive::before { background: linear-gradient(135deg, #52525b, #3f3f46); }
        .job-card:hover { border-color: rgba(255,81,47,.3); }

        .job-title { font-size: 17px; font-weight: 800; margin: 0 0 8px; letter-spacing: -.3px; }
        .job-meta { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px; }

        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .badge-active   { background: rgba(74,222,128,.15); color: #4ade80; border: 1px solid rgba(74,222,128,.3); }
        .badge-inactive { background: rgba(82,82,91,.2); color: #a1a1aa; border: 1px solid rgba(82,82,91,.4); }
        .badge-match    { background: rgba(99,102,241,.15); color: #818cf8; border: 1px solid rgba(99,102,241,.3); }
        .badge-date     { background: rgba(255,255,255,.05); color: var(--text-muted); border: 1px solid var(--border-dark); }

        .job-desc { font-size: 13px; color: var(--text-muted); line-height: 1.6; margin: 0 0 16px;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

        .job-actions { display: flex; flex-wrap: wrap; gap: 8px; }
        .btn-sm { padding: 8px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 6px; transition: .2s; text-decoration: none; font-family: inherit; }
        .btn-edit     { background: rgba(255,81,47,.12); color: var(--primary-orange); border: 1px solid rgba(255,81,47,.25); }
        .btn-edit:hover { background: rgba(255,81,47,.22); }
        .btn-toggle-on  { background: rgba(161,161,170,.1); color: #a1a1aa; border: 1px solid rgba(161,161,170,.2); }
        .btn-toggle-on:hover  { background: rgba(161,161,170,.2); }
        .btn-toggle-off { background: rgba(74,222,128,.1); color: #4ade80; border: 1px solid rgba(74,222,128,.2); }
        .btn-toggle-off:hover { background: rgba(74,222,128,.2); }
        .btn-delete   { background: rgba(248,113,113,.1); color: #f87171; border: 1px solid rgba(248,113,113,.2); }
        .btn-delete:hover { background: rgba(248,113,113,.2); }

        /* --- EMPTY STATE --- */
        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state .icon { font-size: 60px; margin-bottom: 16px; display: block; }
        .empty-state h3 { font-size: 20px; font-weight: 800; color: var(--text-light); margin: 0 0 8px; }
        .empty-state p  { font-size: 14px; color: var(--text-muted); margin: 0; }

        /* ===== MODAL OVERLAY (Tambah / Edit) ===== */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.85); backdrop-filter: blur(8px);
            z-index: 200; justify-content: center; align-items: flex-end;
        }
        .modal-overlay.active { display: flex; }

        .modal-box {
            background: var(--bg-dark);
            width: 100%; max-width: 560px;
            border-radius: 24px 24px 0 0;
            border-top: 1px solid var(--border-dark);
            padding: 28px 24px 40px;
            max-height: 92vh; overflow-y: auto;
            animation: slideUp .3s ease;
        }
        @keyframes slideUp { from { transform: translateY(60px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .modal-header h2 { margin: 0; font-size: 20px; font-weight: 800; }
        .btn-modal-close { background: rgba(255,255,255,.08); border: none; color: var(--text-light); width: 36px; height: 36px; border-radius: 50%; font-size: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: .2s; }
        .btn-modal-close:hover { background: rgba(255,255,255,.15); }

        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 8px; }
        .form-group input,
        .form-group textarea {
            width: 100%;
            background: rgba(28,28,36,.9);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            color: var(--text-light);
            padding: 13px 16px;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            transition: border-color .3s;
            resize: vertical;
        }
        .form-group input:focus,
        .form-group textarea:focus { border-color: var(--primary-orange); }
        .form-group textarea { min-height: 90px; }

        /* Toggle Switch */
        .toggle-row { display: flex; align-items: center; justify-content: space-between; background: rgba(28,28,36,.9); border: 1px solid var(--border-dark); border-radius: 14px; padding: 13px 16px; }
        .toggle-row span { font-size: 14px; color: var(--text-light); }
        .toggle-switch { position: relative; width: 46px; height: 25px; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { position: absolute; inset: 0; background: #3f3f46; border-radius: 25px; cursor: pointer; transition: .3s; }
        .toggle-slider::before { content: ''; position: absolute; width: 19px; height: 19px; left: 3px; bottom: 3px; background: #71717a; border-radius: 50%; transition: .3s; }
        .toggle-switch input:checked + .toggle-slider { background: rgba(74,222,128,.3); }
        .toggle-switch input:checked + .toggle-slider::before { transform: translateX(21px); background: #4ade80; }

        .modal-footer { display: flex; gap: 12px; margin-top: 24px; }
        .btn-cancel { flex: 1; padding: 14px; background: transparent; border: 1px solid var(--border-dark); color: var(--text-light); border-radius: 14px; font-weight: 700; cursor: pointer; font-family: inherit; font-size: 14px; }
        .btn-save   { flex: 2; padding: 14px; background: var(--gradient-orange); border: none; color: #fff; border-radius: 14px; font-weight: 800; cursor: pointer; font-family: inherit; font-size: 14px; box-shadow: 0 8px 20px rgba(255,81,47,.25); }
        .btn-save:hover { transform: translateY(-1px); box-shadow: 0 12px 25px rgba(255,81,47,.4); }

        /* ===== MODAL KONFIRMASI HAPUS ===== */
        .confirm-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.85); backdrop-filter: blur(8px);
            z-index: 300; justify-content: center; align-items: center; padding: 20px;
        }
        .confirm-overlay.active { display: flex; }
        .confirm-box { background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 22px; padding: 32px 28px; max-width: 380px; width: 100%; text-align: center; animation: fadeIn .2s; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(.95); } to { opacity: 1; transform: scale(1); } }
        .confirm-icon { font-size: 44px; margin-bottom: 14px; }
        .confirm-box h3 { font-size: 19px; font-weight: 800; margin: 0 0 10px; }
        .confirm-box p  { color: var(--text-muted); font-size: 14px; margin: 0 0 24px; line-height: 1.5; }
        .confirm-actions { display: flex; gap: 12px; }
        .btn-conf-cancel { flex: 1; padding: 13px; background: transparent; border: 1px solid var(--border-dark); color: var(--text-light); border-radius: 14px; font-weight: 700; cursor: pointer; font-family: inherit; }
        .btn-conf-delete { flex: 1; padding: 13px; background: #f87171; border: none; color: #fff; border-radius: 14px; font-weight: 800; cursor: pointer; font-family: inherit; }

        /* --- BOTTOM NAV --- */
        .bottom-nav { position: fixed; bottom: 0; left: 0; width: 100%; background: rgba(19,19,26,.95); backdrop-filter: blur(10px); border-top: 1px solid var(--border-dark); display: flex; justify-content: space-around; padding: 20px 0 calc(20px + env(safe-area-inset-bottom)); z-index: 50; }
        .bottom-nav a { color: var(--text-muted); font-size: 22px; transition: .3s; text-decoration: none; }
        .bottom-nav a.active { color: var(--primary-orange); }

        @media (min-width: 768px) {
            .bottom-nav { display: none; }
            .desktop-menu { display: flex; }
            .modal-overlay { align-items: center; }
            .modal-box { border-radius: 24px; border: 1px solid var(--border-dark); }
        }
    </style>
</head>
<body>

<div class="bg-shapes">
    <div class="grid-pattern"></div>
    <div class="shape1"></div>
    <div class="shape2"></div>
</div>

{{-- ===== TOP NAV ===== --}}
<header class="top-nav">
    <div class="logo">Hiring <span>Employer</span></div>
    <div class="desktop-menu">
        <a href="{{ url('/employer/dashboard') }}">Candidates</a>
        <a href="{{ url('/employer/jobs') }}" class="active">Lowongan</a>
        <a href="{{ url('/employer/calendar') }}">Calendar</a>
        <a href="{{ route('messages.index') }}">Messages</a>
        <a href="{{ url('/employer/profile') }}">Profile</a>
    </div>
</header>

{{-- ===== MAIN CONTENT ===== --}}
<main class="main-content">

    <div class="page-header">
        <h1>Kelola Lowongan</h1>
        <p>Buat dan kelola posisi yang sedang dibuka perusahaan Anda</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-num">{{ $totalJobs }}</div>
            <div class="stat-lbl">Total Lowongan</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">{{ $activeJobs }}</div>
            <div class="stat-lbl">Aktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">{{ $totalMatch }}</div>
            <div class="stat-lbl">Total Match</div>
        </div>
    </div>

    {{-- Tombol Tambah --}}
    <button class="btn-tambah" onclick="openCreateModal()">
        <i class="fas fa-plus"></i> Tambah Lowongan Baru
    </button>

    {{-- Daftar Lowongan --}}
    @if($jobs->isEmpty())
        <div class="empty-state">
            <span class="icon">📋</span>
            <h3>Belum ada lowongan</h3>
            <p>Buat lowongan pertama Anda agar kandidat bisa menemukannya.</p>
        </div>
    @else
        @foreach($jobs as $job)
            @php
                $matchCount   = \App\Models\Swipe::where('job_vacancy_id', $job->id)->where('status', 'matched')->count();
                $pendingCount = \App\Models\Swipe::where('job_vacancy_id', $job->id)->where('status', 'pending')->count();
            @endphp
            <div class="job-card {{ $job->is_active ? '' : 'inactive' }}">
                <div class="job-title">{{ $job->title }}</div>

                <div class="job-meta">
                    <span class="badge {{ $job->is_active ? 'badge-active' : 'badge-inactive' }}">
                        <i class="fas fa-circle" style="font-size: 7px;"></i>
                        {{ $job->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    <span class="badge badge-date">
                        <i class="fas fa-clock"></i> {{ $job->created_at->diffForHumans() }}
                    </span>
                    @if($matchCount > 0)
                        <span class="badge badge-match">
                            <i class="fas fa-handshake"></i> {{ $matchCount }} Match
                        </span>
                    @endif
                    @if($pendingCount > 0)
                        <span class="badge" style="background:rgba(240,152,25,.12);color:#f09819;border:1px solid rgba(240,152,25,.25);">
                            <i class="fas fa-hourglass-half"></i> {{ $pendingCount }} Pending
                        </span>
                    @endif
                </div>

                <p class="job-desc">{{ $job->description }}</p>

                <div class="job-actions">
                    {{-- Edit --}}
                    <button class="btn-sm btn-edit"
                        onclick="openEditModal(
                            {{ $job->id }},
                            {{ json_encode($job->title) }},
                            {{ json_encode($job->description) }},
                            {{ json_encode($job->qualifications) }},
                            {{ $job->is_active ? 'true' : 'false' }}
                        )">
                        <i class="fas fa-edit"></i> Edit
                    </button>

                    {{-- Toggle Aktif / Nonaktif --}}
                    <form action="{{ url('/employer/jobs/' . $job->id . '/toggle') }}" method="POST" style="margin:0;">
                        @csrf
                        @if($job->is_active)
                            <button type="submit" class="btn-sm btn-toggle-on">
                                <i class="fas fa-pause"></i> Nonaktifkan
                            </button>
                        @else
                            <button type="submit" class="btn-sm btn-toggle-off">
                                <i class="fas fa-play"></i> Aktifkan
                            </button>
                        @endif
                    </form>

                    {{-- Hapus --}}
                    <button class="btn-sm btn-delete"
                        onclick="openConfirmDelete({{ $job->id }}, {{ json_encode($job->title) }})">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
        @endforeach
    @endif

</main>

{{-- ===== BOTTOM NAV ===== --}}
<nav class="bottom-nav">
    <a href="{{ url('/employer/dashboard') }}"><i class="fas fa-users"></i></a>
    <a href="{{ url('/employer/jobs') }}" class="active"><i class="fas fa-briefcase"></i></a>
    <a href="{{ url('/employer/calendar') }}"><i class="fas fa-calendar-alt"></i></a>
    <a href="{{ route('messages.index') }}"><i class="fas fa-comment-dots"></i></a>
    <a href="{{ url('/employer/profile') }}"><i class="fas fa-building"></i></a>
</nav>


{{-- ===== MODAL: TAMBAH / EDIT LOWONGAN ===== --}}
<div class="modal-overlay" id="jobModal">
    <div class="modal-box">
        <div class="modal-header">
            <h2 id="modalTitle">Tambah Lowongan</h2>
            <button class="btn-modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Form ini digunakan baik untuk CREATE maupun UPDATE --}}
        <form id="jobForm" method="POST" action="{{ route('jobs.store') }}">
            @csrf
            {{-- Saat edit, method di-override jadi PUT --}}
            <span id="methodField"></span>

            <div class="form-group">
                <label>Posisi / Judul Lowongan *</label>
                <input type="text" name="title" id="inputTitle"
                    placeholder="Contoh: Frontend Developer, Manajer Marketing..."
                    maxlength="255" required>
            </div>

            <div class="form-group">
                <label>Deskripsi Pekerjaan *</label>
                <textarea name="description" id="inputDescription"
                    placeholder="Jelaskan tanggung jawab, lingkungan kerja, benefit, dll..."
                    rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label>Kualifikasi yang Dibutuhkan *</label>
                <textarea name="qualifications" id="inputQualifications"
                    placeholder="Contoh: Min. S1, pengalaman 2 tahun, menguasai Laravel..."
                    rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label>Status Lowongan</label>
                <div class="toggle-row">
                    <span>Aktif &amp; tampil untuk kandidat</span>
                    <label class="toggle-switch">
                        <input type="checkbox" name="is_active" id="inputIsActive" value="1" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> <span id="btnSaveLabel">Simpan Lowongan</span>
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ===== MODAL: KONFIRMASI HAPUS ===== --}}
<div class="confirm-overlay" id="confirmModal">
    <div class="confirm-box">
        <div class="confirm-icon">🗑️</div>
        <h3>Hapus Lowongan?</h3>
        <p id="confirmText">Aksi ini tidak bisa dibatalkan.</p>

        <div class="confirm-actions">
            <button class="btn-conf-cancel" onclick="closeConfirm()">Batal</button>

            {{-- Form hapus — action di-set via JS --}}
            <form id="deleteForm" method="POST" style="flex:1;margin:0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-conf-delete" style="width:100%;">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>


<script>
    // ============================================================
    // MODAL TAMBAH / EDIT
    // ============================================================
    const jobModal   = document.getElementById('jobModal');
    const jobForm    = document.getElementById('jobForm');
    const methodField = document.getElementById('methodField');

    function openCreateModal() {
        // Reset ke mode CREATE
        document.getElementById('modalTitle').textContent    = 'Tambah Lowongan';
        document.getElementById('btnSaveLabel').textContent  = 'Simpan Lowongan';
        document.getElementById('inputTitle').value          = '';
        document.getElementById('inputDescription').value    = '';
        document.getElementById('inputQualifications').value = '';
        document.getElementById('inputIsActive').checked     = true;

        // Action & method untuk store
        jobForm.action = "{{ route('jobs.store') }}";
        methodField.innerHTML = '';         // tidak ada @method('PUT')

        jobModal.classList.add('active');
    }

    function openEditModal(id, title, description, qualifications, isActive) {
        document.getElementById('modalTitle').textContent    = 'Edit Lowongan';
        document.getElementById('btnSaveLabel').textContent  = 'Perbarui Lowongan';
        document.getElementById('inputTitle').value          = title;
        document.getElementById('inputDescription').value    = description;
        document.getElementById('inputQualifications').value = qualifications;
        document.getElementById('inputIsActive').checked     = isActive;

        // Action & method untuk update (PUT di-spoof via _method)
        jobForm.action = '/employer/jobs/' + id;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        jobModal.classList.add('active');
    }

    function closeModal() {
        jobModal.classList.remove('active');
    }

    // Klik di luar modal → tutup
    jobModal.addEventListener('click', function(e) {
        if (e.target === jobModal) closeModal();
    });


    // ============================================================
    // MODAL KONFIRMASI HAPUS
    // ============================================================
    const confirmModal = document.getElementById('confirmModal');
    const deleteForm   = document.getElementById('deleteForm');

    function openConfirmDelete(id, title) {
        document.getElementById('confirmText').textContent =
            'Yakin hapus lowongan "' + title + '"? Semua data swipe terkait juga akan terhapus.';

        deleteForm.action = '/employer/jobs/' + id;
        confirmModal.classList.add('active');
    }

    function closeConfirm() {
        confirmModal.classList.remove('active');
    }

    confirmModal.addEventListener('click', function(e) {
        if (e.target === confirmModal) closeConfirm();
    });
</script>

</body>
</html>