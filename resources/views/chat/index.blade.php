<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Messages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-dark: #121212; --card-dark: #1e1e1e; --primary-orange: #ff512f;
            --text-light: #ffffff; --text-muted: #aaaaaa; --border-dark: #333333;
        }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--bg-dark); color: var(--text-light); font-family: 'Segoe UI', sans-serif; display: flex; flex-direction: column; height: 100vh; overflow: hidden; }

        .header { padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-dark); background: var(--bg-dark); flex-shrink: 0; }
        .logo { font-size: 20px; font-weight: bold; color: var(--primary-orange); }
        .desktop-nav { display: none; gap: 24px; }
        .desktop-nav a { color: var(--text-muted); font-size: 20px; text-decoration: none; }
        .desktop-nav a.active, .desktop-nav a:hover { color: var(--primary-orange); }
        @media(min-width:768px) { .desktop-nav { display: flex; } .bottom-nav { display: none !important; } }

        .main { display: flex; flex: 1; overflow: hidden; }

        /* SIDEBAR */
        .sidebar { width: 280px; background: var(--card-dark); border-right: 1px solid var(--border-dark); display: flex; flex-direction: column; flex-shrink: 0; }
        .section-title { padding: 12px 16px; background: var(--primary-orange); color: white; font-weight: bold; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; }
        .connections-scroll { flex: 1; overflow-y: auto; }
        .connection-item { padding: 14px 16px; border-bottom: 1px solid var(--border-dark); cursor: pointer; transition: background 0.2s; }
        .connection-item:hover { background: #2a2a2a; }
        .connection-item.active { background: #2a2a2a; border-left: 3px solid var(--primary-orange); }
        .connection-item.pending { opacity: 0.55; cursor: default; }
        .ci-name { font-weight: 600; font-size: 14px; margin-bottom: 2px; }
        .ci-sub { font-size: 12px; color: var(--text-muted); }
        .ci-badge { display: inline-block; font-size: 10px; padding: 2px 7px; border-radius: 10px; background: rgba(255,179,0,.25); color: #ffb300; font-weight: 600; margin-top: 4px; }

        /* CHAT AREA */
        .chat-area { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .chat-header { padding: 14px 18px; background: var(--card-dark); border-bottom: 1px solid var(--border-dark); display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }
        .chat-header-name { font-weight: bold; font-size: 16px; }
        .chat-header-sub { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
        .btn-schedule { padding: 7px 14px; background: rgba(255,81,47,.15); color: var(--primary-orange); border: 1px solid var(--primary-orange); border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; }
        .btn-schedule:hover { background: rgba(255,81,47,.3); }

        .chat-history { flex: 1; padding: 16px; overflow-y: auto; display: flex; flex-direction: column; gap: 10px; }
        .chat-empty { text-align: center; color: var(--text-muted); margin-top: 80px; }
        .chat-empty i { font-size: 48px; margin-bottom: 12px; color: var(--border-dark); }
        .message-bubble { max-width: 65%; padding: 10px 14px; border-radius: 16px; font-size: 14px; line-height: 1.5; word-break: break-word; }
        .message-mine { background: var(--primary-orange); color: white; align-self: flex-end; border-bottom-right-radius: 4px; }
        .message-theirs { background: var(--card-dark); border: 1px solid var(--border-dark); color: var(--text-light); align-self: flex-start; border-bottom-left-radius: 4px; }
        .msg-time { font-size: 10px; opacity: 0.7; margin-top: 4px; }

        .chat-input { padding: 12px 16px; background: var(--card-dark); border-top: 1px solid var(--border-dark); display: none; gap: 10px; flex-shrink: 0; }
        .chat-input.visible { display: flex; }
        .chat-input input { flex: 1; padding: 10px 16px; border-radius: 24px; border: 1px solid var(--border-dark); outline: none; background: #2a2a2a; color: var(--text-light); font-size: 14px; }
        .chat-input input:focus { border-color: var(--primary-orange); }
        .chat-input button { padding: 10px 18px; background: var(--primary-orange); color: white; border: none; border-radius: 24px; cursor: pointer; font-weight: 600; }

        /* MOBILE: tampilkan sidebar saja kalau belum pilih chat */
        @media(max-width:600px) {
            .sidebar { width: 100%; display: block; }
            .chat-area { display: none; }
            .main.chat-open .sidebar { display: none; }
            .main.chat-open .chat-area { display: flex; width: 100%; }
        }

        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: var(--card-dark); display: flex; justify-content: space-around; padding: 12px 0; border-top: 1px solid var(--border-dark); z-index: 30; }
        .nav-item { color: var(--text-muted); font-size: 22px; text-decoration: none; }
        .nav-item.active, .nav-item:hover { color: var(--primary-orange); }
    </style>
</head>
<body>

<header class="header">
    <div class="logo">Hiring</div>
    <nav class="desktop-nav">
        @if(Auth::user()->role === 'applicant')
            <a href="/applicant/home"><i class="fas fa-layer-group"></i></a>
        @else
            <a href="/employer/dashboard"><i class="fas fa-users"></i></a>
        @endif
        <a href="/messages" class="active"><i class="fas fa-comment-dots"></i></a>
        <a href="/calendar"><i class="fas fa-calendar-alt"></i></a>
        @if(Auth::user()->role === 'applicant')
            <a href="/applicant/profile"><i class="fas fa-user"></i></a>
        @else
            <a href="/employer/profile"><i class="fas fa-building"></i></a>
        @endif
    </nav>
</header>

<div class="main" id="mainLayout">
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="section-title"><i class="fas fa-heart"></i> Your Matches</div>
        <div class="connections-scroll" id="matchesList">
            <div style="padding:20px; text-align:center; color:var(--text-muted);">Memuat...</div>
        </div>
        <div class="section-title" style="background:#333;"><i class="fas fa-clock"></i> Pending</div>
        <div class="connections-scroll" id="pendingList" style="max-height:200px;"></div>
    </div>

    <!-- CHAT AREA -->
    <div class="chat-area">
        <div class="chat-header">
            <div>
                <button onclick="backToList()" style="background:none;border:none;color:var(--text-muted);cursor:pointer;margin-right:8px;display:none;" id="backBtn">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <span class="chat-header-name" id="chatHeaderName">Pilih obrolan...</span>
                <div class="chat-header-sub" id="chatHeaderSub"></div>
            </div>
            @if(Auth::user()->role === 'employer')
            <button class="btn-schedule" id="btnSchedule" style="display:none;" onclick="goToCalendar()">
                <i class="fas fa-calendar-plus"></i> Jadwalkan Interview
            </button>
            @endif
        </div>
        <div class="chat-history" id="chatHistory">
            <div class="chat-empty">
                <i class="fas fa-comment-slash"></i>
                <p>Pilih kontak untuk mulai chat</p>
            </div>
        </div>
        <div class="chat-input" id="chatInputArea">
            <input type="text" id="messageText" placeholder="Ketik pesan..." onkeypress="if(event.key==='Enter') sendReply()">
            <button onclick="sendReply()"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>
</div>

<nav class="bottom-nav">
    @if(Auth::user()->role === 'applicant')
        <a href="/applicant/home" class="nav-item"><i class="fas fa-layer-group"></i></a>
    @else
        <a href="/employer/dashboard" class="nav-item"><i class="fas fa-users"></i></a>
    @endif
    <a href="/messages" class="nav-item active"><i class="fas fa-comment-dots"></i></a>
    <a href="/calendar" class="nav-item"><i class="fas fa-calendar-alt"></i></a>
    @if(Auth::user()->role === 'applicant')
        <a href="/applicant/profile" class="nav-item"><i class="fas fa-user"></i></a>
    @else
        <a href="/employer/profile" class="nav-item"><i class="fas fa-building"></i></a>
    @endif
</nav>

<script>
    @if(session('api_token')) localStorage.setItem('api_token', '{{ session('api_token') }}'); @endif

    const MY_ID      = {{ Auth::id() }};
    const IS_EMPLOYER = {{ Auth::user()->role === 'employer' ? 'true' : 'false' }};
    const API_TOKEN  = localStorage.getItem('api_token');
    const HEADERS    = { 'Authorization': 'Bearer ' + API_TOKEN, 'Content-Type': 'application/json' };
    let currentSwipeId = null;
    let pollInterval   = null;

    window.onload = loadConnections;

    async function loadConnections() {
        try {
            const res    = await fetch('/api/connections', { headers: HEADERS });
            const result = await res.json();
            renderList('matchesList',  result.matches  || [], false);
            renderList('pendingList',  result.pending  || [], true);
        } catch (e) { console.error('Gagal memuat kontak.', e); }
    }

    function renderList(elId, items, isPending) {
        const container = document.getElementById(elId);
        if (items.length === 0) {
            container.innerHTML = `<div style="padding:14px 16px; font-size:13px; color:var(--text-muted);">${isPending ? 'Belum ada pending.' : 'Belum ada match.'}</div>`;
            return;
        }
        container.innerHTML = '';
        items.forEach(item => {
            const opponentName = item.applicant_id === MY_ID
                ? (item.employer?.employer_profile?.company_name || item.employer?.name || 'Employer')
                : (item.applicant?.applicant_profile?.full_name  || item.applicant?.name || 'Applicant');
            const jobTitle = item.job_vacancy?.title || '-';

            const div = document.createElement('div');
            div.className = `connection-item${isPending ? ' pending' : ''}`;
            div.innerHTML = `
                <div class="ci-name">${opponentName}</div>
                <div class="ci-sub">${jobTitle}</div>
                ${isPending ? '<span class="ci-badge">Menunggu</span>' : ''}
            `;
            if (!isPending) div.onclick = () => openChat(item.id, opponentName, jobTitle, div);
            container.appendChild(div);
        });
    }

    async function openChat(swipeId, name, jobTitle, clickedEl) {
        // Highlight aktif
        document.querySelectorAll('.connection-item').forEach(el => el.classList.remove('active'));
        if (clickedEl) clickedEl.classList.add('active');

        currentSwipeId = swipeId;
        document.getElementById('chatHeaderName').textContent = name;
        document.getElementById('chatHeaderSub').textContent  = jobTitle;
        document.getElementById('chatInputArea').classList.add('visible');

        const btnSched = document.getElementById('btnSchedule');
        if (btnSched) btnSched.style.display = 'inline-flex';

        // Mobile: show chat area
        document.getElementById('mainLayout').classList.add('chat-open');
        document.getElementById('backBtn').style.display = 'inline';

        await fetchMessages();

        // Auto-poll setiap 5 detik
        clearInterval(pollInterval);
        pollInterval = setInterval(fetchMessages, 5000);
    }

    async function fetchMessages() {
        if (!currentSwipeId) return;
        try {
            const res    = await fetch(`/api/messages/${currentSwipeId}`, { headers: HEADERS });
            const result = await res.json();
            const history = document.getElementById('chatHistory');
            history.innerHTML = '';
            if (!result.data || result.data.length === 0) {
                history.innerHTML = '<div class="chat-empty"><i class="fas fa-comment"></i><p>Belum ada pesan. Mulai percakapan!</p></div>';
                return;
            }
            result.data.forEach(msg => {
                const isMine = msg.sender_id === MY_ID;
                const time   = new Date(msg.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                history.innerHTML += `
                    <div class="message-bubble ${isMine ? 'message-mine' : 'message-theirs'}">
                        ${msg.message}
                        <div class="msg-time">${time}</div>
                    </div>`;
            });
            history.scrollTop = history.scrollHeight;
        } catch (e) { console.error(e); }
    }

    async function sendReply() {
        const input = document.getElementById('messageText');
        if (!input.value.trim() || !currentSwipeId) return;
        try {
            const res = await fetch('/api/messages', {
                method: 'POST',
                headers: HEADERS,
                body: JSON.stringify({ swipe_id: currentSwipeId, message: input.value.trim() })
            });
            if (res.ok) { input.value = ''; await fetchMessages(); }
        } catch (e) { console.error(e); }
    }

    function goToCalendar() {
        window.location.href = '/calendar';
    }

    function backToList() {
        clearInterval(pollInterval);
        document.getElementById('mainLayout').classList.remove('chat-open');
        document.getElementById('backBtn').style.display = 'none';
        currentSwipeId = null;
    }
</script>
</body>
</html>