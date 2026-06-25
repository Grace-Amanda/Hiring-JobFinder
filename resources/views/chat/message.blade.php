<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Messages</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{--bg-dark:#13131a;--card-dark:#1c1c24;--border-dark:#2d2d3a;--primary-orange:#ff512f;--gradient-orange:linear-gradient(135deg,#ff512f 0%,#f09819 100%);--text-light:#ffffff;--text-muted:#a1a1aa}
        body,html{margin:0;padding:0;background:linear-gradient(135deg,#0f0f13 0%,#1a1a24 100%);color:var(--text-light);font-family:'Plus Jakarta Sans',sans-serif;height:100vh;overflow:hidden;display:flex;flex-direction:column}
        .bg-shapes{position:fixed;inset:0;z-index:0;pointer-events:none;overflow:hidden}
        .shape1,.shape2{position:absolute;filter:blur(50px)}
        .shape1{top:-10%;left:-10%;width:50vw;height:50vw;background:radial-gradient(circle,rgba(255,81,47,.15) 0%,transparent 60%)}
        .shape2{bottom:0;right:-10%;width:60vw;height:60vw;background:radial-gradient(circle,rgba(240,152,25,.1) 0%,transparent 60%)}
        .grid-pattern{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);background-size:40px 40px}

        .top-nav{padding:20px 5%;display:flex;justify-content:space-between;align-items:center;z-index:10;position:relative}
        .logo{font-size:28px;font-weight:800;color:var(--primary-orange);letter-spacing:-1px;text-shadow:0 4px 10px rgba(255,81,47,.3);display:flex;align-items:baseline;gap:8px}
        .logo span{font-size:14px;font-weight:500;color:var(--text-muted);letter-spacing:1px;text-transform:uppercase}
        .desktop-menu{display:none;gap:40px}
        .desktop-menu a{color:var(--text-muted);text-decoration:none;font-size:16px;font-weight:500;transition:.3s}
        .desktop-menu a.active,.desktop-menu a:hover{color:var(--text-light);font-weight:700}

        .messenger-container{flex:1;display:flex;overflow:hidden;position:relative;z-index:5;margin:20px 5%;border-radius:20px;background:rgba(28,28,36,.4);backdrop-filter:blur(20px);border:1px solid var(--border-dark);box-shadow:0 25px 50px -12px rgba(0,0,0,.5)}
        .contact-list-panel{width:100%;display:flex;flex-direction:column;border-right:1px solid var(--border-dark);transition:transform .3s ease}
        .contact-header{padding:20px;border-bottom:1px solid var(--border-dark);font-weight:800;font-size:18px;letter-spacing:.5px}
        .contact-list{overflow-y:auto;flex:1;padding-bottom:80px}
        .section-label{padding:12px 20px;font-size:11px;font-weight:700;color:var(--primary-orange);text-transform:uppercase;letter-spacing:1.5px;background:rgba(0,0,0,.2)}
        .contact-item{display:flex;align-items:center;padding:15px 20px;border-bottom:1px solid rgba(255,255,255,.03);cursor:pointer;transition:.3s}
        .contact-item:hover{background:rgba(255,255,255,.05);padding-left:25px}
        .contact-avatar{width:45px;height:45px;border-radius:50%;object-fit:cover;border:2px solid var(--primary-orange);box-shadow:0 0 15px rgba(255,81,47,.3)}
        .contact-info{flex:1;margin-left:15px}
        .contact-name{font-weight:700;color:var(--text-light);font-size:15px;margin-bottom:4px}
        .contact-desc{font-size:12px;color:var(--text-muted);display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden}
        .btn-message-bubble{color:var(--primary-orange);font-size:20px;border:none;background:0 0;cursor:pointer;transition:.2s}

        .message-panel{width:100%;display:none;flex-direction:column;position:absolute;inset:0;z-index:5;background:rgba(20,20,26,.95)}
        .message-header{padding:15px 20px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--border-dark);background:rgba(0,0,0,.2)}
        .message-header-info{display:flex;align-items:center;gap:15px}
        .btn-back{color:var(--primary-orange);font-size:20px;cursor:pointer;background:0 0;border:none;display:flex;align-items:center}
        .message-header-name{font-weight:800;color:var(--text-light);font-size:16px}
        .message-header-sub{font-size:12px;color:var(--primary-orange)}
        .btn-schedule{background:var(--gradient-orange);color:#fff;border:none;padding:8px 15px;border-radius:12px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:8px;font-size:13px;box-shadow:0 4px 15px rgba(255,81,47,.3);transition:.2s;text-decoration:none}
        .btn-schedule:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(255,81,47,.5)}

        .messages-history{flex:1;padding:20px;overflow-y:auto;display:flex;flex-direction:column;gap:15px}
        .message-bubble{max-width:75%;padding:12px 18px;border-radius:18px;font-size:14px;line-height:1.5;position:relative;font-weight:500;word-break:break-word}
        .time-stamp{font-size:10px;opacity:.6;margin-top:6px;display:block;font-weight:400}
        .message-incoming{align-self:flex-start;background:var(--card-dark);border:1px solid var(--border-dark);color:var(--text-light);border-bottom-left-radius:4px}
        .message-incoming .time-stamp{text-align:left}
        .message-outgoing{align-self:flex-end;background:var(--gradient-orange);color:#fff;border-bottom-right-radius:4px;box-shadow:0 4px 15px rgba(255,81,47,.3)}
        .message-outgoing .time-stamp{text-align:right;color:rgba(255,255,255,.8)}

        .empty-chat{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--text-muted);text-align:center;padding:20px}
        .empty-chat span{font-size:50px;margin-bottom:15px;display:block;opacity:.3}

        .message-input-area{padding:15px 20px;border-top:1px solid var(--border-dark);display:flex;gap:12px;align-items:center;background:rgba(0,0,0,.2)}
        .message-input{flex:1;background:rgba(28,28,36,.8);border:1px solid var(--border-dark);padding:14px 20px;border-radius:25px;color:var(--text-light);outline:0;font-family:inherit;font-size:14px;transition:.3s}
        .message-input:focus{border-color:var(--primary-orange)}
        .btn-send{background:var(--gradient-orange);color:#fff;border:none;width:48px;height:48px;border-radius:50%;font-size:18px;cursor:pointer;display:flex;justify-content:center;align-items:center;box-shadow:0 4px 15px rgba(255,81,47,.4);transition:.2s;flex-shrink:0}
        .btn-send:hover{transform:scale(1.05)}
        .btn-send:disabled{opacity:.5;cursor:not-allowed;transform:none}

        .bottom-nav{position:fixed;bottom:0;width:100%;background:rgba(19,19,26,.95);backdrop-filter:blur(10px);border-top:1px solid var(--border-dark);display:flex;justify-content:space-around;padding:20px 0 calc(20px + env(safe-area-inset-bottom));z-index:50}
        .bottom-nav a{color:var(--text-muted);font-size:22px;transition:.3s}
        .bottom-nav a.active{color:var(--primary-orange)}

        .status-msg{text-align:center;padding:8px;font-size:12px;color:var(--text-muted);font-style:italic}

        @media(min-width:768px){
            .bottom-nav{display:none}.desktop-menu{display:flex}
            .contact-list-panel{width:35%;max-width:380px;position:relative}
            .message-panel{width:65%;display:flex;position:relative;background:0 0}
            .btn-back{display:none}
        }
        @media(max-width:768px){
            .messenger-container{margin:0;border-radius:0;border:none;border-top:1px solid var(--border-dark)}
            .messages-history{padding-bottom:10px}
        }
    </style>
</head>
<body>
<div class="bg-shapes"><div class="grid-pattern"></div><div class="shape1"></div><div class="shape2"></div></div>

@if(auth()->user()->role === 'applicant')
<header class="top-nav">
    <div class="logo">Hiring</div>
    <div class="desktop-menu">
        <a href="{{ url('/applicant/home') }}">Discover</a>
        <a href="{{ url('/applicant/calendar') }}">Calendar</a>
        <a href="{{ route('messages.index') }}" class="active">Messages</a>
        <a href="{{ url('/applicant/profile') }}">Profile</a>
    </div>
</header>
@else
<header class="top-nav">
    <div class="logo">Hiring <span>Employer</span></div>
    <div class="desktop-menu">
        <a href="{{ url('/employer/dashboard') }}">Candidates</a>
        <a href="{{ url('/employer/calendar') }}">Calendar</a>
        <a href="{{ route('messages.index') }}" class="active">Messages</a>
        <a href="{{ url('/employer/profile') }}">Profile</a>
    </div>
</header>
@endif

<main class="messenger-container">
    {{-- ── Panel Kiri: Daftar Kontak ── --}}
    <div class="contact-list-panel" id="contactListPanel">
        <div class="contact-header">Messages</div>
        <div class="contact-list" id="contactList">
            <div class="status-msg" id="contactStatus">Memuat kontak...</div>
        </div>
    </div>

    {{-- ── Panel Kanan: Area Chat ── --}}
    <div class="message-panel" id="messagePanel">

        {{-- State kosong (desktop) --}}
        <div class="empty-chat" id="emptyState">
            <span>💬</span>
            <h3 style="margin:0 0 8px;color:var(--text-muted)">Pilih percakapan</h3>
            <p style="margin:0;font-size:14px">Klik nama kontak di sebelah kiri untuk memulai chat.</p>
        </div>

        {{-- Area chat aktif --}}
        <div id="activeChatArea" style="display:none;flex-direction:column;flex:1;min-height:0">
            <div class="message-header">
                <div class="message-header-info">
                    <button class="btn-back" onclick="backToList()">
                        <i class="fas fa-arrow-left" style="margin-right:8px"></i>
                    </button>
                    <img src="" alt="" class="contact-avatar" id="chatAvatar" style="width:40px;height:40px">
                    <div>
                        <div class="message-header-name" id="chatName">—</div>
                        <div class="message-header-sub" id="chatSub">—</div>
                    </div>
                </div>
                {{-- Tombol Schedule: hanya untuk employer, link ke halaman kalender --}}
                @if(auth()->user()->role === 'employer')
                <a href="{{ url('/employer/calendar') }}" class="btn-schedule">
                    <i class="far fa-calendar-check"></i> Schedule
                </a>
                @endif
            </div>

            <div class="messages-history" id="messagesBox"></div>

            <div class="message-input-area">
                <input type="text" class="message-input" id="msgInput" placeholder="Tulis pesan Anda di sini..." autocomplete="off">
                <button class="btn-send" id="btnSend">
                    <i class="fas fa-paper-plane" style="margin-left:-2px"></i>
                </button>
            </div>
        </div>
    </div>
</main>

@if(auth()->user()->role === 'applicant')
<nav class="bottom-nav">
    <a href="{{ url('/applicant/home') }}"><i class="fas fa-layer-group"></i></a>
    <a href="{{ url('/applicant/calendar') }}"><i class="fas fa-calendar-alt"></i></a>
    <a href="{{ route('messages.index') }}" class="active"><i class="fas fa-comment-dots"></i></a>
    <a href="{{ url('/applicant/profile') }}"><i class="fas fa-user"></i></a>
</nav>
@else
<nav class="bottom-nav">
    <a href="{{ url('/employer/dashboard') }}"><i class="fas fa-users"></i></a>
    <a href="{{ url('/employer/calendar') }}"><i class="fas fa-calendar-alt"></i></a>
    <a href="{{ route('messages.index') }}" class="active"><i class="fas fa-comment-dots"></i></a>
    <a href="{{ url('/employer/profile') }}"><i class="fas fa-building"></i></a>
</nav>
@endif

<script>
    // ─── FIX #1: Sync token dari session Blade ke localStorage SETIAP buka halaman ───
    // Sebelumnya token hanya disimpan saat login. Jika localStorage dihapus atau
    // user pakai private mode, token hilang → semua API call gagal 401.
    // Solusi: selalu sync dari session Blade ke localStorage di awal halaman.
    @if(session('api_token'))
        localStorage.setItem('api_token', '{{ session('api_token') }}');
    @endif

    // ─── Konstanta global ────────────────────────────────────────────────────────
    const TOKEN     = localStorage.getItem('api_token');
    const USER_ROLE = '{{ auth()->user()->role ?? "applicant" }}';
    const MY_ID     = {{ auth()->id() ?? 0 }};

    // ─── Elemen DOM ─────────────────────────────────────────────────────────────
    const $contactList    = document.getElementById('contactList');
    const $contactStatus  = document.getElementById('contactStatus');
    const $contactPanel   = document.getElementById('contactListPanel');
    const $messagePanel   = document.getElementById('messagePanel');
    const $emptyState     = document.getElementById('emptyState');
    const $activeChatArea = document.getElementById('activeChatArea');
    const $messagesBox    = document.getElementById('messagesBox');
    const $chatName       = document.getElementById('chatName');
    const $chatSub        = document.getElementById('chatSub');
    const $chatAvatar     = document.getElementById('chatAvatar');
    const $msgInput       = document.getElementById('msgInput');
    const $btnSend        = document.getElementById('btnSend');

    // ─── State ──────────────────────────────────────────────────────────────────
    let curSwipeId  = null;
    let pollTimer   = null;
    let loadedMsgIds = new Set();

    // ─── Layout: tampilan mobile vs desktop ─────────────────────────────────────
    function applyLayout() {
        const isDesktop = window.innerWidth >= 768;
        if (isDesktop) {
            // Desktop: kedua panel selalu tampil side-by-side
            $contactPanel.style.display  = 'flex';
            $messagePanel.style.display  = 'flex';
            $emptyState.style.display    = curSwipeId ? 'none' : 'flex';
            $activeChatArea.style.display = curSwipeId ? 'flex' : 'none';
        } else {
            // Mobile: hanya satu panel yang tampil (list ATAU chat)
            $contactPanel.style.display  = curSwipeId ? 'none' : 'flex';
            $messagePanel.style.display  = curSwipeId ? 'flex'  : 'none';
            $emptyState.style.display    = 'none';
            $activeChatArea.style.display = curSwipeId ? 'flex' : 'none';
        }
    }
    window.addEventListener('resize', applyLayout);
    applyLayout();

    // ─── Kembali ke daftar kontak (mobile) ──────────────────────────────────────
    function backToList() {
        curSwipeId = null;
        if (pollTimer) clearInterval(pollTimer);
        applyLayout();
    }

    // ─── FIX #2: Muat daftar kontak ─────────────────────────────────────────────
    // BUG LAMA: renderContacts(data.matched, data.pending) — key salah → undefined
    // FIX:      ChatController sekarang return key 'matched' (bukan 'matches')
    async function loadContacts() {
        try {
            const res  = await fetch('/api/connections', {
                headers: { 'Authorization': 'Bearer ' + TOKEN }
            });
            if (!res.ok) throw new Error('HTTP ' + res.status);

            const data    = await res.json();
            const matched = data.matched || [];  // key 'matched' sesuai ChatController yang sudah difix
            const pending = data.pending || [];

            renderContacts(matched, pending);
        } catch (e) {
            console.error('loadContacts error:', e);
            $contactStatus.textContent = 'Gagal memuat kontak. Coba refresh halaman.';
        }
    }

    function renderContacts(matched, pending) {
        $contactList.innerHTML = '';

        if (!matched.length && !pending.length) {
            $contactList.innerHTML = `
                <div style="text-align:center;padding:40px 20px;color:var(--text-muted)">
                    <span style="font-size:50px;display:block;margin-bottom:15px;opacity:.3">💬</span>
                    <p style="margin:0;font-size:14px">Belum ada koneksi.<br>Mulai swipe untuk bertemu!</p>
                </div>`;
            return;
        }

        if (matched.length) {
            $contactList.innerHTML += `<div class="section-label">Terhubung (${matched.length})</div>`;
            matched.forEach(s => {
                // Ambil nama & info sesuai role user yang sedang login
                const otherName = USER_ROLE === 'applicant' ? s.employer?.name : s.applicant?.name;
                // Akses profile dengan nama relasi snake_case sesuai JSON Laravel
                const profile   = USER_ROLE === 'applicant' ? s.employer?.employer_profile : s.applicant?.applicant_profile;
                const loc       = USER_ROLE === 'applicant'
                    ? (profile?.location_employer || 'Lokasi Perusahaan')
                    : (profile?.location_applicant || 'Lokasi Pelamar');
                const jobTitle  = s.job?.title || 'Lowongan';
                const enc       = encodeURIComponent(otherName || '?');
                const safeName  = (otherName || '').replace(/'/g, "\\'");
                const safeLoc   = loc.replace(/'/g, "\\'");
                const safeJob   = jobTitle.replace(/</g, '&lt;');

                $contactList.innerHTML += `
                    <div class="contact-item" onclick="openChat(${s.id}, '${safeName}', '${safeLoc}', '${safeJob}')">
                        <img src="https://ui-avatars.com/api/?name=${enc}&background=1c1c24&color=ff512f&bold=true"
                             class="contact-avatar" alt="${safeName}">
                        <div class="contact-info">
                            <div class="contact-name">${otherName || '—'}</div>
                            <div class="contact-desc">Posisi: ${safeJob}</div>
                        </div>
                        <button class="btn-message-bubble" onclick="openChat(${s.id},'${safeName}','${safeLoc}','${safeJob}');event.stopPropagation()">
                            <i class="fas fa-comment-dots"></i>
                        </button>
                    </div>`;
            });
        }

        if (pending.length) {
            $contactList.innerHTML += `<div class="section-label" style="margin-top:10px">Menunggu (${pending.length})</div>`;
            pending.forEach(s => {
                const otherName = USER_ROLE === 'applicant' ? s.employer?.name : s.applicant?.name;
                const jobTitle  = s.job?.title || 'Lowongan';
                const enc       = encodeURIComponent(otherName || '?');
                $contactList.innerHTML += `
                    <div class="contact-item" style="opacity:.5;cursor:default">
                        <img src="https://ui-avatars.com/api/?name=${enc}&background=2d2d3a&color=a1a1aa"
                             class="contact-avatar" style="border-color:var(--border-dark);box-shadow:none">
                        <div class="contact-info">
                            <div class="contact-name" style="color:var(--text-muted)">${otherName || '—'}</div>
                            <div class="contact-desc">Posisi: ${jobTitle} · Menunggu respon</div>
                        </div>
                        <i class="fas fa-lock" style="color:var(--border-dark);font-size:16px"></i>
                    </div>`;
            });
        }
    }

    // ─── Buka satu percakapan ────────────────────────────────────────────────────
    async function openChat(swipeId, name, loc, jobTitle) {
        curSwipeId = swipeId;
        loadedMsgIds.clear();
        $messagesBox.innerHTML = '';

        // Isi header
        $chatName.textContent   = name;
        $chatSub.textContent    = jobTitle ? `Posisi: ${jobTitle}` : loc;
        $chatAvatar.src         = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=1c1c24&color=ff512f&bold=true`;

        applyLayout();

        // Hentikan polling sebelumnya lalu muat ulang
        if (pollTimer) clearInterval(pollTimer);
        await fetchMessages();
        // Polling setiap 3 detik untuk pesan baru
        pollTimer = setInterval(fetchMessages, 3000);
    }

    // ─── FIX #3: Fetch pesan — sekarang handle array langsung (bukan {status,data}) ───
    // BUG LAMA: renderMsgs(await res.json()) → msgs adalah {status:'success', data:[...]}
    //           lalu msgs.forEach() crash karena object bukan array.
    // FIX:      ChatController.getMessages() sekarang return array JSON langsung.
    //           Di sini kita tetap tambahkan guard: jika dapat object, ambil .data
    async function fetchMessages() {
        if (!curSwipeId) return;
        try {
            const res = await fetch(`/api/messages/${curSwipeId}`, {
                headers: { 'Authorization': 'Bearer ' + TOKEN }
            });
            if (!res.ok) throw new Error('HTTP ' + res.status);

            let payload = await res.json();

            // Guard: jika server lama masih return {status, data:[...]}, ambil .data
            // Jika sudah difix (return array langsung), payload sudah array
            const msgs = Array.isArray(payload) ? payload : (payload.data || []);

            renderMessages(msgs);
        } catch (e) {
            console.error('fetchMessages error:', e);
        }
    }

    function renderMessages(msgs) {
        if (!Array.isArray(msgs)) return;
        let hasNew = false;
        msgs.forEach(m => {
            if (loadedMsgIds.has(m.id)) return;
            loadedMsgIds.add(m.id);
            hasNew = true;

            const isMine = m.sender_id == MY_ID;
            const cls    = isMine ? 'message-outgoing' : 'message-incoming';
            const time   = new Date(m.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            const safe   = m.message.replace(/</g, '&lt;').replace(/>/g, '&gt;');

            $messagesBox.insertAdjacentHTML('beforeend',
                `<div class="message-bubble ${cls}">${safe}<span class="time-stamp">${time}</span></div>`
            );
        });
        if (hasNew) $messagesBox.scrollTop = $messagesBox.scrollHeight;
    }

    // ─── FIX #4: Kirim pesan — await + disable tombol saat mengirim ─────────────
    // BUG LAMA: Tidak ada feedback visual, tidak ada error handling, tidak reload
    //           pesan setelah kirim.
    async function sendMessage() {
        const txt = $msgInput.value.trim();
        if (!txt || !curSwipeId) return;

        // Disable tombol sementara agar tidak double-send
        $btnSend.disabled = true;
        $msgInput.disabled = true;
        const originalText = $msgInput.value;
        $msgInput.value = '';

        try {
            const res = await fetch('/api/messages', {
                method: 'POST',
                headers: {
                    'Content-Type':  'application/json',
                    'Accept':        'application/json',
                    'Authorization': 'Bearer ' + TOKEN,
                },
                body: JSON.stringify({ swipe_id: curSwipeId, message: txt }),
            });

            const data = await res.json();

            if (res.ok && data.status === 'success') {
                // Langsung render pesan baru tanpa tunggu polling
                renderMessages([data.data]);
            } else {
                // Kembalikan teks ke input jika gagal
                $msgInput.value = originalText;
                const errMsg = data.message || 'Gagal mengirim. Coba lagi.';
                console.error('sendMessage error:', errMsg);
                alert('⚠️ ' + errMsg);
            }
        } catch (e) {
            $msgInput.value = originalText;
            console.error('sendMessage network error:', e);
            alert('⚠️ Koneksi bermasalah. Periksa internet Anda.');
        } finally {
            $btnSend.disabled  = false;
            $msgInput.disabled = false;
            $msgInput.focus();
        }
    }

    // Event listeners untuk kirim pesan
    $btnSend.addEventListener('click', sendMessage);
    $msgInput.addEventListener('keypress', e => { if (e.key === 'Enter' && !e.shiftKey) sendMessage(); });

    // ─── Mulai ──────────────────────────────────────────────────────────────────
    if (!TOKEN) {
        $contactStatus.textContent = '⚠️ Sesi tidak valid. Silakan logout dan login ulang.';
    } else {
        loadContacts();
    }
</script>
</body>
</html>