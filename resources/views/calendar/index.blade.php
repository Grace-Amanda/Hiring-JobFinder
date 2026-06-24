<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Kalender Interview</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-dark: #121212; --card-dark: #1e1e1e; --primary-orange: #ff512f;
            --text-light: #ffffff; --text-muted: #aaaaaa; --border-dark: #333333;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--bg-dark); color: var(--text-light); font-family: 'Segoe UI', sans-serif; min-height: 100vh; padding-bottom: 90px; }

        /* ── HEADER ── */
        .header { padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-dark); background: var(--bg-dark); position: sticky; top: 0; z-index: 50; }
        .logo { font-size: 22px; font-weight: bold; color: var(--primary-orange); }
        .desktop-nav { display: none; gap: 28px; align-items: center; }
        .desktop-nav a { color: var(--text-muted); font-size: 20px; text-decoration: none; transition: 0.2s; }
        .desktop-nav a:hover, .desktop-nav a.active { color: var(--primary-orange); }
        @media(min-width:768px) { .desktop-nav { display: flex; } .bottom-nav { display: none !important; } }

        /* ── LAYOUT ── */
        .container { max-width: 860px; margin: 0 auto; padding: 20px 16px; }
        .page-title { font-size: 18px; font-weight: bold; margin-bottom: 20px; color: var(--primary-orange); display: flex; align-items: center; gap: 8px; }

        /* ── CALENDAR ── */
        .cal-nav { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
        .cal-nav h2 { font-size: 16px; font-weight: 700; }
        .cal-btn { background: var(--card-dark); border: 1px solid var(--border-dark); color: var(--text-light); width: 36px; height: 36px; border-radius: 8px; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center; transition: 0.2s; }
        .cal-btn:hover { border-color: var(--primary-orange); color: var(--primary-orange); }
        .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; margin-bottom: 8px; }
        .cal-day-name { text-align: center; font-size: 11px; color: var(--text-muted); padding: 4px 0; font-weight: 700; }
        .cal-cell { min-height: 48px; background: var(--card-dark); border-radius: 8px; border: 1px solid var(--border-dark); padding: 4px; cursor: pointer; transition: border-color 0.15s; position: relative; }
        .cal-cell:hover { border-color: var(--primary-orange); }
        .cal-cell.today { border-color: var(--primary-orange); }
        .cal-cell.selected { border-color: var(--primary-orange); box-shadow: 0 0 0 2px var(--primary-orange); background: rgba(255,81,47,.12); }
        .cal-cell.other-month { opacity: 0.28; pointer-events: none; }
        .day-num { font-size: 12px; text-align: center; padding: 2px; line-height: 1; }
        .cal-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--primary-orange); margin: 3px auto 0; }

        /* ── SCHEDULE LIST ── */
        .section-label { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin: 20px 0 10px; font-weight: 700; }
        .sc-card { background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 12px; padding: 14px 16px; margin-bottom: 10px; }
        .sc-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; margin-bottom: 8px; }
        .sc-name { font-weight: 700; font-size: 15px; }
        .sc-job { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
        .badge { font-size: 11px; padding: 3px 9px; border-radius: 20px; font-weight: 700; white-space: nowrap; flex-shrink: 0; }
        .badge-scheduled { background: rgba(255,179,0,.2); color: #ffb300; }
        .badge-confirmed  { background: rgba(76,175,80,.2);  color: #4caf50; }
        .badge-completed  { background: rgba(33,150,243,.2); color: #2196f3; }
        .badge-cancelled  { background: rgba(244,67,54,.2);  color: #f44336; }
        .sc-meta { display: flex; flex-wrap: wrap; gap: 10px; font-size: 12px; color: var(--text-muted); margin-bottom: 10px; }
        .sc-meta span { display: flex; align-items: center; gap: 4px; }
        .sc-note { font-size: 12px; color: var(--text-muted); background: rgba(255,255,255,.04); border-radius: 6px; padding: 6px 10px; margin-bottom: 10px; line-height: 1.5; }
        .sc-actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn-act { padding: 6px 13px; border-radius: 7px; border: 1px solid; font-size: 12px; font-weight: 700; cursor: pointer; transition: opacity 0.15s; background: transparent; }
        .btn-act:hover { opacity: 0.75; }
        .btn-green  { color: #4caf50; border-color: #4caf50; }
        .btn-red    { color: #f44336; border-color: #f44336; }
        .btn-orange { color: var(--primary-orange); border-color: var(--primary-orange); }
        .btn-blue   { color: #2196f3; border-color: #2196f3; }

        /* ── FAB ── */
        .fab { position: fixed; bottom: 76px; right: 18px; width: 54px; height: 54px; background: var(--primary-orange); border: none; border-radius: 50%; color: white; font-size: 22px; cursor: pointer; box-shadow: 0 4px 16px rgba(255,81,47,.45); z-index: 45; display: flex; align-items: center; justify-content: center; }
        .fab:hover { opacity: 0.88; }

        /* ── MODAL ── */
        .modal-bg { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.72); z-index: 100; align-items: center; justify-content: center; padding: 16px; }
        .modal-bg.open { display: flex; }
        .modal { background: var(--card-dark); border-radius: 16px; padding: 22px; width: 100%; max-width: 460px; border: 1px solid var(--border-dark); max-height: 90vh; overflow-y: auto; }
        .modal h3 { font-size: 16px; color: var(--primary-orange); margin-bottom: 18px; }
        .fg { margin-bottom: 14px; }
        .fg label { display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 5px; }
        .fg select, .fg input, .fg textarea {
            width: 100%; padding: 9px 12px; background: #252525;
            border: 1px solid var(--border-dark); border-radius: 7px;
            color: var(--text-light); font-size: 13px; outline: none; font-family: inherit;
        }
        .fg select:focus, .fg input:focus, .fg textarea:focus { border-color: var(--primary-orange); }
        .fg textarea { resize: vertical; min-height: 70px; }
        .modal-foot { display: flex; gap: 10px; justify-content: flex-end; margin-top: 18px; }

        /* ── EMPTY ── */
        .empty { text-align: center; color: var(--text-muted); padding: 36px 16px; }
        .empty i { font-size: 42px; margin-bottom: 10px; color: var(--border-dark); display: block; }

        /* ── TOAST ── */
        .toast { position: fixed; top: 16px; left: 50%; transform: translateX(-50%); background: #4caf50; color: white; padding: 9px 22px; border-radius: 22px; font-size: 13px; font-weight: 700; z-index: 200; opacity: 0; transition: opacity .3s; pointer-events: none; white-space: nowrap; }
        .toast.err { background: #f44336; }
        .toast.show { opacity: 1; }

        /* ── BOTTOM NAV ── */
        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: var(--card-dark); display: flex; justify-content: space-around; padding: 13px 0; border-top: 1px solid var(--border-dark); z-index: 40; }
        .nav-item { color: var(--text-muted); font-size: 22px; text-decoration: none; transition: 0.2s; }
        .nav-item.active, .nav-item:hover { color: var(--primary-orange); }
    </style>
</head>
<body>

<div class="toast" id="toast"></div>

<!-- HEADER -->
<header class="header">
    <div class="logo">Hiring</div>
    <nav class="desktop-nav">
        @if(Auth::user()->role === 'applicant')
            <a href="/applicant/home"><i class="fas fa-layer-group"></i></a>
        @else
            <a href="/employer/dashboard"><i class="fas fa-users"></i></a>
        @endif
        <a href="{{ route('messages.index') }}"><i class="fas fa-comment-dots"></i></a>
        <a href="{{ route('calendar.index') }}" class="active"><i class="fas fa-calendar-alt"></i></a>
        @if(Auth::user()->role === 'applicant')
            <a href="/applicant/profile"><i class="fas fa-user"></i></a>
        @else
            <a href="/employer/profile"><i class="fas fa-building"></i></a>
        @endif
    </nav>
</header>

<div class="container">
    <div class="page-title">
        <i class="fas fa-calendar-alt"></i>
        Kalender Interview
        <span style="font-size:12px;color:var(--text-muted);font-weight:normal;">
            — {{ Auth::user()->role === 'employer' ? 'Employer View' : 'Applicant View' }}
        </span>
    </div>

    <!-- CALENDAR GRID -->
    <div class="cal-nav">
        <button class="cal-btn" onclick="prevMonth()"><i class="fas fa-chevron-left"></i></button>
        <h2 id="calTitle"></h2>
        <button class="cal-btn" onclick="nextMonth()"><i class="fas fa-chevron-right"></i></button>
    </div>
    <div class="cal-grid" id="calGrid"></div>

    <!-- SCHEDULE LIST -->
    <div class="section-label" id="listLabel">Semua Jadwal</div>
    <div id="scheduleList"></div>
</div>

<!-- FAB: hanya employer -->
@if(Auth::user()->role === 'employer')
<button class="fab" onclick="openCreate()" title="Buat Jadwal Baru">
    <i class="fas fa-plus"></i>
</button>
@endif

<!-- MODAL BUAT INTERVIEW -->
@if(Auth::user()->role === 'employer')
<div class="modal-bg" id="modalCreate">
    <div class="modal">
        <h3><i class="fas fa-calendar-plus"></i> Buat Jadwal Interview</h3>

        <div class="fg">
            <label>Pilih Kandidat (sudah matched) *</label>
            <select id="fCandidate">
                <option value="">-- Memuat kandidat --</option>
            </select>
        </div>

        <div class="fg" id="fJobWrap" style="display:none">
            <label>Posisi yang dilamar</label>
            <input type="text" id="fJobDisplay" readonly style="opacity:.6">
            <input type="hidden" id="fJobId">
            <input type="hidden" id="fAppId">
        </div>

        <div class="fg">
            <label>Tanggal Interview *</label>
            <input type="date" id="fDate" min="{{ date('Y-m-d') }}">
        </div>

        <div class="fg">
            <label>Jam Interview *</label>
            <input type="time" id="fTime">
        </div>

        <div class="fg">
            <label>Tipe Interview *</label>
            <select id="fType">
                <option value="online">Online (Zoom / Google Meet)</option>
                <option value="offline">Offline (Tatap Muka)</option>
            </select>
        </div>

        <div class="fg">
            <label>Link Meeting / Alamat Lokasi *</label>
            <input type="text" id="fLink" placeholder="https://meet.google.com/... atau Jl. Sudirman No.1">
        </div>

        <div class="fg">
            <label>Catatan (opsional)</label>
            <textarea id="fNotes" placeholder="Siapkan portfolio, bawa CV, dll."></textarea>
        </div>

        <div class="modal-foot">
            <button class="btn-act btn-red" onclick="closeCreate()">Batal</button>
            <button class="btn-act btn-orange" onclick="submitCreate()">Buat Jadwal</button>
        </div>
    </div>
</div>

<!-- MODAL EDIT INTERVIEW -->
<div class="modal-bg" id="modalEdit">
    <div class="modal">
        <h3><i class="fas fa-edit"></i> Edit Jadwal Interview</h3>
        <input type="hidden" id="eId">
        <div class="fg">
            <label>Tanggal Interview *</label>
            <input type="date" id="eDate" min="{{ date('Y-m-d') }}">
        </div>
        <div class="fg">
            <label>Jam Interview *</label>
            <input type="time" id="eTime">
        </div>
        <div class="fg">
            <label>Tipe Interview *</label>
            <select id="eType">
                <option value="online">Online</option>
                <option value="offline">Offline</option>
            </select>
        </div>
        <div class="fg">
            <label>Link / Alamat *</label>
            <input type="text" id="eLink">
        </div>
        <div class="fg">
            <label>Catatan</label>
            <textarea id="eNotes"></textarea>
        </div>
        <div class="modal-foot">
            <button class="btn-act btn-red" onclick="closeEdit()">Batal</button>
            <button class="btn-act btn-blue" onclick="submitEdit()">Simpan</button>
        </div>
    </div>
</div>
@endif

<!-- BOTTOM NAV -->
<nav class="bottom-nav">
    @if(Auth::user()->role === 'applicant')
        <a href="/applicant/home" class="nav-item"><i class="fas fa-layer-group"></i></a>
    @else
        <a href="/employer/dashboard" class="nav-item"><i class="fas fa-users"></i></a>
    @endif
    <a href="{{ route('messages.index') }}" class="nav-item"><i class="fas fa-comment-dots"></i></a>
    <a href="{{ route('calendar.index') }}" class="nav-item active"><i class="fas fa-calendar-alt"></i></a>
    @if(Auth::user()->role === 'applicant')
        <a href="/applicant/profile" class="nav-item"><i class="fas fa-user"></i></a>
    @else
        <a href="/employer/profile" class="nav-item"><i class="fas fa-building"></i></a>
    @endif
</nav>

<script>
@if(session('api_token')) localStorage.setItem('api_token', '{{ session('api_token') }}'); @endif

const IS_EMPLOYER = {{ Auth::user()->role === 'employer' ? 'true' : 'false' }};
const TOKEN = localStorage.getItem('api_token');
const H = { 'Authorization': 'Bearer ' + TOKEN, 'Content-Type': 'application/json' };

const MONTHS = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
const DAYS   = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];

let allInterviews = [];
let curDate = new Date();
let selDate = null;
let matchedList = [];

// ─── INIT ───────────────────────────────────────────
window.onload = async function() {
    await loadInterviews();
    buildCalendar();
    if (IS_EMPLOYER) loadMatched();
};

// ─── LOAD INTERVIEWS ────────────────────────────────
async function loadInterviews() {
    try {
        const r = await fetch('/api/interviews', { headers: H });
        const j = await r.json();
        allInterviews = j.data || [];
    } catch(e) {
        console.error('Gagal memuat interview:', e);
        allInterviews = [];
    }
    renderList(selDate ? allInterviews.filter(iv => iv.schedule_date === selDate) : allInterviews);
    buildCalendar();
}

// ─── LOAD MATCHED CANDIDATES (employer) ─────────────
async function loadMatched() {
    try {
        const r = await fetch('/api/interviews/matched-candidates', { headers: H });
        const j = await r.json();
        matchedList = j.data || [];

        const sel = document.getElementById('fCandidate');
        sel.innerHTML = '<option value="">-- Pilih Kandidat --</option>';
        matchedList.forEach((sw, i) => {
            const name = sw.applicant?.applicant_profile?.full_name || sw.applicant?.name || 'Kandidat';
            const job  = sw.job_vacancy?.title || '-';
            const opt  = document.createElement('option');
            opt.value = i;
            opt.textContent = name + ' — ' + job;
            sel.appendChild(opt);
        });

        sel.onchange = function() {
            const wrap = document.getElementById('fJobWrap');
            if (this.value === '') { wrap.style.display = 'none'; return; }
            const sw = matchedList[+this.value];
            document.getElementById('fJobDisplay').value = sw?.job_vacancy?.title || '-';
            document.getElementById('fJobId').value      = sw?.job_vacancy_id || sw?.job_vacancy?.id || '';
            document.getElementById('fAppId').value      = sw?.applicant_id || '';
            wrap.style.display = 'block';
        };
    } catch(e) { console.error(e); }
}

// ─── CALENDAR BUILD ──────────────────────────────────
function buildCalendar() {
    const grid  = document.getElementById('calGrid');
    document.getElementById('calTitle').textContent = MONTHS[curDate.getMonth()] + ' ' + curDate.getFullYear();
    grid.innerHTML = '';

    DAYS.forEach(d => {
        const el = document.createElement('div');
        el.className = 'cal-day-name';
        el.textContent = d;
        grid.appendChild(el);
    });

    const y = curDate.getFullYear(), m = curDate.getMonth();
    const firstDay  = new Date(y, m, 1).getDay();
    const totalDays = new Date(y, m+1, 0).getDate();
    const prevTotal = new Date(y, m, 0).getDate();
    const today     = new Date();

    // prev month filler
    for (let i = firstDay - 1; i >= 0; i--) {
        const c = document.createElement('div');
        c.className = 'cal-cell other-month';
        c.innerHTML = '<div class="day-num">' + (prevTotal - i) + '</div>';
        grid.appendChild(c);
    }

    // this month
    for (let d = 1; d <= totalDays; d++) {
        const ds    = y + '-' + String(m+1).padStart(2,'0') + '-' + String(d).padStart(2,'0');
        const hasEv = allInterviews.some(iv => iv.schedule_date === ds && iv.status !== 'cancelled');
        const isTod = d === today.getDate() && m === today.getMonth() && y === today.getFullYear();
        const isSel = selDate === ds;

        const c = document.createElement('div');
        c.className = 'cal-cell' + (isTod ? ' today' : '') + (isSel ? ' selected' : '');
        c.innerHTML = '<div class="day-num">' + d + '</div>' + (hasEv ? '<div class="cal-dot"></div>' : '');
        c.onclick = () => onDateClick(ds, c);
        grid.appendChild(c);
    }

    // next month filler
    const used = firstDay + totalDays;
    const rem  = used % 7 === 0 ? 0 : 7 - (used % 7);
    for (let i = 1; i <= rem; i++) {
        const c = document.createElement('div');
        c.className = 'cal-cell other-month';
        c.innerHTML = '<div class="day-num">' + i + '</div>';
        grid.appendChild(c);
    }
}

function prevMonth() { curDate.setMonth(curDate.getMonth() - 1); selDate = null; buildCalendar(); renderList(allInterviews); document.getElementById('listLabel').textContent = 'Semua Jadwal'; }
function nextMonth() { curDate.setMonth(curDate.getMonth() + 1); selDate = null; buildCalendar(); renderList(allInterviews); document.getElementById('listLabel').textContent = 'Semua Jadwal'; }

function onDateClick(ds) {
    if (selDate === ds) { selDate = null; renderList(allInterviews); document.getElementById('listLabel').textContent = 'Semua Jadwal'; }
    else {
        selDate = ds;
        renderList(allInterviews.filter(iv => iv.schedule_date === ds));
        const d = new Date(ds + 'T00:00:00');
        document.getElementById('listLabel').textContent = 'Jadwal ' + d.getDate() + ' ' + MONTHS[d.getMonth()] + ' ' + d.getFullYear();
    }
    buildCalendar();
}

// ─── RENDER LIST ─────────────────────────────────────
const BADGE_CLASS = { scheduled:'badge-scheduled', confirmed:'badge-confirmed', completed:'badge-completed', cancelled:'badge-cancelled' };
const BADGE_LABEL = { scheduled:'Terjadwal', confirmed:'Dikonfirmasi', completed:'Selesai', cancelled:'Dibatalkan' };

function renderList(list) {
    const el = document.getElementById('scheduleList');
    if (!list || !list.length) {
        el.innerHTML = '<div class="empty"><i class="fas fa-calendar-times"></i><p>Tidak ada jadwal interview.</p></div>';
        return;
    }

    el.innerHTML = list.map(iv => {
        const d   = new Date(iv.schedule_date + 'T00:00:00');
        const ds  = d.getDate() + ' ' + MONTHS[d.getMonth()] + ' ' + d.getFullYear();
        const ts  = (iv.schedule_time || '').slice(0,5);
        const job = iv.job_vacancy?.title || '-';
        const ico = iv.interview_type === 'online'
            ? '<i class="fas fa-video" style="color:#2196f3"></i> Online'
            : '<i class="fas fa-map-marker-alt" style="color:#4caf50"></i> Offline';

        let opp = '';
        if (IS_EMPLOYER) {
            opp = iv.applicant?.applicant_profile?.full_name || iv.applicant?.name || '-';
        } else {
            opp = iv.employer?.employer_profile?.company_name || iv.employer?.name || '-';
        }

        let acts = '';
        if (IS_EMPLOYER) {
            if (iv.status === 'scheduled' || iv.status === 'confirmed') {
                const loc  = (iv.location_or_link||'').replace(/\\/g,'\\\\').replace(/'/g,"\\'");
                const note = (iv.notes||'').replace(/\\/g,'\\\\').replace(/'/g,"\\'");
                acts += `<button class="btn-act btn-orange" onclick="openEdit(${iv.id},'${iv.schedule_date}','${ts}','${iv.interview_type}','${loc}','${note}')"><i class="fas fa-edit"></i> Edit</button>`;
                acts += `<button class="btn-act btn-red" onclick="doCancel(${iv.id})"><i class="fas fa-times"></i> Batalkan</button>`;
            }
            if (iv.status === 'confirmed') {
                acts += `<button class="btn-act btn-blue" onclick="doComplete(${iv.id})"><i class="fas fa-check-double"></i> Selesai</button>`;
            }
        } else {
            if (iv.status === 'scheduled') {
                acts += `<button class="btn-act btn-green" onclick="doConfirm(${iv.id})"><i class="fas fa-check"></i> Konfirmasi Hadir</button>`;
                acts += `<button class="btn-act btn-red" onclick="doCancel(${iv.id})"><i class="fas fa-times"></i> Tolak</button>`;
            }
        }

        return `<div class="sc-card">
            <div class="sc-top">
                <div>
                    <div class="sc-name">${opp}</div>
                    <div class="sc-job"><i class="fas fa-briefcase"></i> ${job}</div>
                </div>
                <span class="badge ${BADGE_CLASS[iv.status]||'badge-scheduled'}">${BADGE_LABEL[iv.status]||iv.status}</span>
            </div>
            <div class="sc-meta">
                <span><i class="fas fa-calendar"></i> ${ds}</span>
                <span><i class="fas fa-clock"></i> ${ts} WIB</span>
                <span>${ico}</span>
            </div>
            <div class="sc-meta">
                <span><i class="fas fa-link"></i> ${iv.location_or_link || '-'}</span>
            </div>
            ${iv.notes ? `<div class="sc-note"><i class="fas fa-sticky-note"></i> ${iv.notes}</div>` : ''}
            ${acts ? `<div class="sc-actions">${acts}</div>` : ''}
        </div>`;
    }).join('');
}

// ─── ACTIONS ──────────────────────────────────────────
async function doConfirm(id) {
    if (!confirm('Konfirmasi kehadiran interview ini?')) return;
    const r = await fetch('/api/interviews/'+id+'/confirm', { method:'POST', headers:H });
    const j = await r.json();
    toast(j.message, !r.ok);
    if (r.ok) loadInterviews();
}
async function doCancel(id) {
    if (!confirm('Batalkan jadwal ini?')) return;
    const r = await fetch('/api/interviews/'+id+'/cancel', { method:'POST', headers:H });
    const j = await r.json();
    toast(j.message, !r.ok);
    if (r.ok) loadInterviews();
}
async function doComplete(id) {
    if (!confirm('Tandai interview ini sebagai selesai?')) return;
    const r = await fetch('/api/interviews/'+id+'/complete', { method:'POST', headers:H });
    const j = await r.json();
    toast(j.message, !r.ok);
    if (r.ok) loadInterviews();
}

// ─── CREATE MODAL ────────────────────────────────────
function openCreate()  { document.getElementById('modalCreate').classList.add('open'); loadMatched(); }
function closeCreate() { document.getElementById('modalCreate').classList.remove('open'); }

async function submitCreate() {
    const idx  = document.getElementById('fCandidate').value;
    const date = document.getElementById('fDate').value;
    const time = document.getElementById('fTime').value;
    const type = document.getElementById('fType').value;
    const link = document.getElementById('fLink').value.trim();
    const note = document.getElementById('fNotes').value.trim();
    const jobId = document.getElementById('fJobId').value;
    const appId = document.getElementById('fAppId').value;

    if (!idx || !date || !time || !link || !jobId) {
        toast('Lengkapi semua field bertanda *', true); return;
    }

    const r = await fetch('/api/interviews', {
        method: 'POST', headers: H,
        body: JSON.stringify({
            applicant_id: +appId,
            job_vacancy_id: +jobId,
            schedule_date: date,
            schedule_time: time + ':00',
            interview_type: type,
            location_or_link: link,
            notes: note
        })
    });
    const j = await r.json();
    toast(j.message, !r.ok);
    if (r.ok) {
        closeCreate();
        // reset form
        document.getElementById('fCandidate').value = '';
        document.getElementById('fDate').value = '';
        document.getElementById('fTime').value = '';
        document.getElementById('fLink').value = '';
        document.getElementById('fNotes').value = '';
        document.getElementById('fJobWrap').style.display = 'none';
        loadInterviews();
    }
}

// ─── EDIT MODAL ──────────────────────────────────────
function openEdit(id, date, time, type, link, notes) {
    document.getElementById('eId').value   = id;
    document.getElementById('eDate').value = date;
    document.getElementById('eTime').value = time;
    document.getElementById('eType').value = type;
    document.getElementById('eLink').value = link;
    document.getElementById('eNotes').value = notes;
    document.getElementById('modalEdit').classList.add('open');
}
function closeEdit() { document.getElementById('modalEdit').classList.remove('open'); }

async function submitEdit() {
    const id   = document.getElementById('eId').value;
    const date = document.getElementById('eDate').value;
    const time = document.getElementById('eTime').value;
    const type = document.getElementById('eType').value;
    const link = document.getElementById('eLink').value.trim();
    const note = document.getElementById('eNotes').value.trim();

    if (!date || !time || !link) { toast('Lengkapi semua field bertanda *', true); return; }

    const r = await fetch('/api/interviews/'+id, {
        method: 'PUT', headers: H,
        body: JSON.stringify({ schedule_date:date, schedule_time:time+':00', interview_type:type, location_or_link:link, notes:note })
    });
    const j = await r.json();
    toast(j.message, !r.ok);
    if (r.ok) { closeEdit(); loadInterviews(); }
}

// ─── TOAST ───────────────────────────────────────────
function toast(msg, isErr) {
    const el = document.getElementById('toast');
    el.textContent = msg;
    el.className = 'toast' + (isErr ? ' err' : '') + ' show';
    setTimeout(() => { el.className = 'toast' + (isErr ? ' err' : ''); }, 3000);
}
</script>
</body>
</html>