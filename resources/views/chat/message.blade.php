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

        /* STANDAR LOGO & NAV */
        .top-nav{padding:20px 5%;display:flex;justify-content:space-between;align-items:center;z-index:10;position:relative}
        .logo{font-size:28px;font-weight:800;color:var(--primary-orange);letter-spacing:-1px;text-shadow:0 4px 10px rgba(255,81,47,.3);display:flex;align-items:baseline;gap:8px}
        .logo span{font-size:14px;font-weight:500;color:var(--text-muted);letter-spacing:1px;text-transform:uppercase}
        .desktop-menu{display:none;gap:40px}
        .desktop-menu a{color:var(--text-muted);text-decoration:none;font-size:16px;font-weight:500;transition:.3s}
        .desktop-menu a.active,.desktop-menu a:hover{color:var(--text-light);font-weight:700;text-shadow:0 0 10px rgba(255,255,255,.3)}

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
        .contact-item:hover .btn-message-bubble{transform:scale(1.1)}

        .message-panel{width:100%;display:none;flex-direction:column;position:absolute;inset:0;z-index:5;background:rgba(20,20,26,.95)}
        .message-header{padding:15px 20px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--border-dark);background:rgba(0,0,0,.2)}
        .message-header-info{display:flex;align-items:center;gap:15px}
        .btn-back{color:var(--primary-orange);font-size:20px;cursor:pointer;background:0 0;border:none;display:flex;align-items:center}
        .message-header-name{font-weight:800;color:var(--text-light);font-size:16px}
        .message-header-location{font-size:12px;color:var(--primary-orange)}
        .btn-schedule{background:var(--gradient-orange);color:#fff;border:none;padding:8px 15px;border-radius:12px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:8px;font-size:13px;box-shadow:0 4px 15px rgba(255,81,47,.3);transition:.2s}
        .btn-schedule:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(255,81,47,.5)}

        .messages-history{flex:1;padding:20px;overflow-y:auto;display:flex;flex-direction:column;gap:15px}
        .message-bubble{max-width:75%;padding:12px 18px;border-radius:18px;font-size:14px;line-height:1.5;position:relative;font-weight:500}
        .time-stamp{font-size:10px;opacity:.6;margin-top:6px;display:block;font-weight:400}
        .message-incoming{align-self:flex-start;background:var(--card-dark);border:1px solid var(--border-dark);color:var(--text-light);border-bottom-left-radius:4px;box-shadow:0 4px 10px rgba(0,0,0,.2)}
        .message-incoming .time-stamp{text-align:left}
        .message-outgoing{align-self:flex-end;background:var(--gradient-orange);color:#fff;border-bottom-right-radius:4px;box-shadow:0 4px 15px rgba(255,81,47,.3)}
        .message-outgoing .time-stamp{text-align:right;color:rgba(255,255,255,.8)}

        .message-input-area{padding:15px 20px;border-top:1px solid var(--border-dark);display:flex;gap:12px;align-items:center;background:rgba(0,0,0,.2)}
        .message-input{flex:1;background:rgba(28,28,36,.8);backdrop-filter:blur(10px);border:1px solid var(--border-dark);padding:14px 20px;border-radius:25px;color:var(--text-light);outline:0;font-family:inherit;font-size:14px;transition:.3s;box-shadow:0 4px 15px rgba(0,0,0,.2)}
        .message-input:focus{border-color:var(--primary-orange)}
        .btn-send{background:var(--gradient-orange);color:#fff;border:none;width:48px;height:48px;border-radius:50%;font-size:18px;cursor:pointer;display:flex;justify-content:center;align-items:center;box-shadow:0 4px 15px rgba(255,81,47,.4);transition:.2s}
        .btn-send:hover{transform:scale(1.05)}

        .bottom-nav{position:fixed;bottom:0;width:100%;background:rgba(19,19,26,.95);backdrop-filter:blur(10px);border-top:1px solid var(--border-dark);display:flex;justify-content:space-around;padding:20px 0 calc(20px + env(safe-area-inset-bottom));z-index:50}
        .bottom-nav a{color:var(--text-muted);font-size:22px;transition:.3s}
        .bottom-nav a.active{color:var(--primary-orange);text-shadow:0 0 15px rgba(255,81,47,.5)}

        @media (min-width:768px){
            .bottom-nav{display:none} .desktop-menu{display:flex}
            .contact-list-panel{width:35%;max-width:400px;position:relative}
            .message-panel{width:65%;display:flex;position:relative;background:0 0}
            .btn-back{display:none}
            .empty-message-state{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--text-muted)}
            .empty-message-state span{font-size:60px;margin-bottom:15px;display:block;filter:grayscale(1) opacity(.2)}
            .empty-message-state h2{font-weight:800;color:var(--text-muted);margin:0}
        }
        @media (max-width:768px){.messenger-container{margin:0;border-radius:0;border:none;border-top:1px solid var(--border-dark)}.messages-history{padding-bottom:100px}}
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
        <div class="contact-list-panel" id="contactListPanel">
            <div class="contact-header">Messages</div>
            <div class="contact-list"></div>
        </div>

        <div class="message-panel" id="messagePanel">
            <div class="empty-message-state" id="emptyMessageState" style="display:none">
                <span>💬</span><h2>Pilih percakapan</h2><p style="font-size:14px;margin-top:5px">Mulai bertukar pesan dengan koneksi Anda.</p>
            </div>

            <div id="activeMessageArea" style="display:flex;flex-direction:column;flex:1">
                <div class="message-header">
                    <div class="message-header-info">
                        <button class="btn-back" onclick="closeMessageDetail()"><i class="fas fa-arrow-left" style="margin-right:10px"></i></button>
                        <img src="https://via.placeholder.com/50" alt="Avatar" class="contact-avatar" id="messageAvatar" style="width:40px;height:40px">
                        <div><div class="message-header-name" id="messageTitle">Nama Kontak</div><div class="message-header-location" id="messageLocation">Lokasi</div></div>
                    </div>
                    @if(auth()->user()->role === 'employer')
                    <button class="btn-schedule">Schedule <i class="far fa-calendar-check" style="margin-left:5px"></i></button>
                    @endif
                </div>
                <div class="messages-history" id="messagesBox"></div>
                <div class="message-input-area">
                    <input type="text" class="message-input" placeholder="Tulis pesan Anda di sini...">
                    <button class="btn-send"><i class="fas fa-paper-plane" style="margin-left:-2px"></i></button>
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
        @if(session('api_token')) localStorage.setItem('api_token', '{{ session('api_token') }}'); @endif
        const token = localStorage.getItem('api_token'), userRole = '{{ auth()->user()->role ?? "applicant" }}', myUserId = {{ auth()->id() ?? 0 }};
        let curSwipeId = null, pollInt = null, loadedIds = new Set();
        
        const $clp = document.getElementById('contactListPanel'), $mp = document.getElementById('messagePanel'), $ama = document.getElementById('activeMessageArea'), $ems = document.getElementById('emptyMessageState'), $msgBox = document.getElementById('messagesBox'), $inp = document.querySelector('.message-input'), $send = document.querySelector('.btn-send');

        const setInitState = () => {
            let desk = window.innerWidth >= 768;
            if(desk) { $mp.style.display = 'flex'; $ama.style.display = curSwipeId ? 'flex' : 'none'; $ems.style.display = curSwipeId ? 'none' : 'flex'; }
            else { $mp.style.display = curSwipeId ? 'flex' : 'none'; $clp.style.display = curSwipeId ? 'none' : 'flex'; }
        };
        window.addEventListener('resize', setInitState); setInitState();

        const loadContacts = async () => {
            try {
                let res = await fetch('/api/connections', { headers: { 'Authorization': 'Bearer ' + token } });
                let data = await res.json(); renderContacts(data.matched, data.pending);
            } catch(e) { console.error("Gagal", e); }
        };

        const renderContacts = (mat, pend) => {
            const list = document.querySelector('.contact-list'); list.innerHTML = '';
            if(mat.length) {
                list.innerHTML += `<div class="section-label">Terhubung</div>`;
                mat.forEach(s => {
                    let n = userRole === 'applicant' ? s.employer.name : s.applicant.name, loc = userRole === 'applicant' ? (s.employer.employer_profile?.location||'Lokasi Perusahaan') : (s.applicant.applicant_profile?.location||'Lokasi Pelamar'), j = s.job?.title||'Lowongan';
                    list.innerHTML += `<div class="contact-item" onclick="openMsg(${s.id}, '${n}', '${loc}')"><img src="https://ui-avatars.com/api/?name=${n}&background=1c1c24&color=ff512f" class="contact-avatar"><div class="contact-info"><div class="contact-name">${n}</div><div class="contact-desc">Posisi: ${j}</div></div><button class="btn-message-bubble"><i class="fas fa-comment-dots"></i></button></div>`;
                });
            }
            if(pend.length) {
                list.innerHTML += `<div class="section-label" style="margin-top:10px">Menunggu Konfirmasi</div>`;
                pend.forEach(s => {
                    let n = userRole === 'applicant' ? s.employer.name : s.applicant.name, j = s.job?.title||'Lowongan';
                    list.innerHTML += `<div class="contact-item" style="opacity:.5;cursor:default"><img src="https://ui-avatars.com/api/?name=${n}&background=1c1c24&color=a1a1aa" class="contact-avatar" style="border-color:var(--border-dark);box-shadow:none"><div class="contact-info"><div class="contact-name" style="color:var(--text-muted)">${n}</div><div class="contact-desc">Posisi: ${j}</div></div><button class="btn-message-bubble" style="color:var(--border-dark)"><i class="fas fa-lock"></i></button></div>`;
                });
            }
        };

        const openMsg = async (id, name, loc) => {
            curSwipeId = id; document.getElementById('messageTitle').innerText = name; document.getElementById('messageLocation').innerText = loc; document.getElementById('messageAvatar').src = `https://ui-avatars.com/api/?name=${name}&background=1c1c24&color=ff512f`;
            setInitState(); $msgBox.innerHTML = ''; loadedIds.clear(); if(pollInt) clearInterval(pollInt);
            await fetchMsgs(); pollInt = setInterval(fetchMsgs, 2000);
        };

        const closeMessageDetail = () => { curSwipeId = null; if(pollInt) clearInterval(pollInt); setInitState(); };

        const fetchMsgs = async () => {
            if(!curSwipeId) return;
            try {
                let res = await fetch(`/api/messages/${curSwipeId}`, { headers: { 'Authorization': 'Bearer ' + token } });
                renderMsgs(await res.json());
            } catch(e) { console.error(e); }
        };

        const renderMsgs = msgs => {
            let added = false;
            msgs.forEach(m => {
                if(!loadedIds.has(m.id)) {
                    loadedIds.add(m.id); added = true;
                    let isMine = m.sender_id == myUserId, c = isMine ? 'message-outgoing' : 'message-incoming', t = new Date(m.created_at).toLocaleTimeString([],{hour:'2-digit',minute:'2-digit'});
                    $msgBox.innerHTML += `<div class="message-bubble ${c}">${m.message}<span class="time-stamp">${t}</span></div>`;
                }
            });
            if(added) $msgBox.scrollTop = $msgBox.scrollHeight;
        };

        $send.addEventListener('click', async () => {
            let txt = $inp.value.trim(); if(!txt || !curSwipeId) return; $inp.value = '';
            try {
                let res = await fetch('/api/messages', { method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'Authorization': 'Bearer ' + token }, body: JSON.stringify({ swipe_id: curSwipeId, message: txt }) });
                if(res.ok) fetchMsgs(); else alert("Gagal: " + ((await res.json()).message || "Token Berakhir"));
            } catch(e) { console.error(e); }
        });

        $inp.addEventListener('keypress', e => { if(e.key === 'Enter') $send.click(); });
        loadContacts();
    </script>
</body>
</html>