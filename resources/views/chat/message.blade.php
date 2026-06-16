<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Messages</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-dark: #13131a; --card-dark: #1c1c24; --border-dark: #2d2d3a;
            --primary-orange: #ff512f; --gradient-orange: linear-gradient(135deg, #ff512f 0%, #f09819 100%);
            --text-light: #ffffff; --text-muted: #a1a1aa;
        }
        
        body, html { margin: 0; padding: 0; background: var(--bg-dark); color: var(--text-light); font-family: 'Plus Jakarta Sans', sans-serif; height: 100vh; overflow: hidden; display: flex; flex-direction: column; }

        body { background: linear-gradient(135deg, #0f0f13 0%, #1a1a24 100%); }
        
        /* BACKGROUND SHAPES DARI HOME PAGE */
        .bg-shapes { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; overflow: hidden; pointer-events: none; }
        .shape1 { position: absolute; top: -10%; left: -10%; width: 50vw; height: 50vw; background: radial-gradient(circle, rgba(255,81,47,0.15) 0%, transparent 60%); filter: blur(50px); }
        .shape2 { position: absolute; bottom: 0%; right: -10%; width: 60vw; height: 60vw; background: radial-gradient(circle, rgba(240,152,25,0.1) 0%, transparent 60%); filter: blur(60px); }
        .grid-pattern { position: absolute; width: 100%; height: 100%; background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 40px 40px; }

        /* HEADER NAVIGASI BARU */
        .top-nav { padding: 20px 5%; display: flex; justify-content: space-between; align-items: center; z-index: 10; position: relative;}
        .logo { font-size: 28px; font-weight: 800; color: var(--primary-orange); letter-spacing: -1px; text-shadow: 0 4px 10px rgba(255,81,47,0.3);}
        .desktop-menu { display: none; gap: 40px; }
        .desktop-menu a { color: var(--text-muted); text-decoration: none; font-size: 16px; font-weight: 500; transition: color 0.3s; }
        .desktop-menu a.active, .desktop-menu a:hover { color: var(--text-light); font-weight: 700; text-shadow: 0 0 10px rgba(255,255,255,0.3); }

        /* LAYOUT MESSENGER GLASSMORPHISM */
        .messenger-container { flex: 1; display: flex; overflow: hidden; position: relative; z-index: 5; margin: 20px 5%; border-radius: 20px; background: rgba(28, 28, 36, 0.4); backdrop-filter: blur(20px); border: 1px solid var(--border-dark); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); }
        
        /* PANEL KIRI: DAFTAR KONTAK */
        .contact-list-panel { width: 100%; display: flex; flex-direction: column; border-right: 1px solid var(--border-dark); transition: transform 0.3s ease; }
        .contact-header { padding: 20px; border-bottom: 1px solid var(--border-dark); font-weight: 800; font-size: 18px; letter-spacing: 0.5px;}
        .contact-list { overflow-y: auto; flex: 1; padding-bottom: 80px; }
        
        .section-label { padding: 12px 20px; font-size: 11px; font-weight: 700; color: var(--primary-orange); text-transform: uppercase; letter-spacing: 1.5px; background: rgba(0,0,0,0.2); }
        
        .contact-item { display: flex; align-items: center; padding: 15px 20px; border-bottom: 1px solid rgba(255,255,255,0.03); cursor: pointer; transition: 0.3s; }
        .contact-item:hover { background: rgba(255,255,255,0.05); padding-left: 25px;}
        .contact-avatar { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary-orange); box-shadow: 0 0 15px rgba(255,81,47,0.3);}
        .contact-info { flex: 1; margin-left: 15px; }
        .contact-name { font-weight: 700; color: var(--text-light); font-size: 15px; margin-bottom: 4px; }
        .contact-desc { font-size: 12px; color: var(--text-muted); display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;}
        .btn-message-bubble { color: var(--primary-orange); font-size: 20px; border: none; background: transparent; cursor: pointer; transition: 0.2s;}
        .contact-item:hover .btn-message-bubble { transform: scale(1.1); }

        /* PANEL KANAN: RUANG PESAN */
        .message-panel { width: 100%; display: none; flex-direction: column; position: absolute; top: 0; left: 0; height: 100%; z-index: 5; background: rgba(20, 20, 26, 0.95); }
        
        .message-header { padding: 15px 20px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-dark); background: rgba(0,0,0,0.2); }
        .message-header-info { display: flex; align-items: center; gap: 15px; }
        .btn-back { color: var(--primary-orange); font-size: 20px; cursor: pointer; background: transparent; border: none; display: flex; align-items: center; }
        .message-header-name { font-weight: 800; color: var(--text-light); font-size: 16px; }
        .message-header-location { font-size: 12px; color: var(--primary-orange); }
        
        .btn-schedule { background: var(--gradient-orange); color: white; border: none; padding: 8px 15px; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 13px; box-shadow: 0 4px 15px rgba(255,81,47,0.3); transition: 0.2s;}
        .btn-schedule:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255,81,47,0.5);}
        
        .messages-history { flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 15px; }
        .message-bubble { max-width: 75%; padding: 12px 18px; border-radius: 18px; font-size: 14px; line-height: 1.5; position: relative; font-weight: 500;}
        .time-stamp { font-size: 10px; opacity: 0.6; margin-top: 6px; display: block; font-weight: 400;}
        
        /* Incoming Message (Dari Lawan Bicara) */
        .message-incoming { align-self: flex-start; background: var(--card-dark); border: 1px solid var(--border-dark); color: var(--text-light); border-bottom-left-radius: 4px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);}
        .message-incoming .time-stamp { text-align: left; }
        
        /* Outgoing Message (Dari Kita) */
        .message-outgoing { align-self: flex-end; background: var(--gradient-orange); color: white; border-bottom-right-radius: 4px; box-shadow: 0 4px 15px rgba(255,81,47,0.3);}
        .message-outgoing .time-stamp { text-align: right; color: rgba(255,255,255,0.8);}

        /* Area Input Pesan bergaya Glassmorphism */
        .message-input-area { padding: 15px 20px; border-top: 1px solid var(--border-dark); display: flex; gap: 12px; align-items: center; background: rgba(0,0,0,0.2); }
        .message-input { flex: 1; background: rgba(28, 28, 36, 0.8); backdrop-filter: blur(10px); border: 1px solid var(--border-dark); padding: 14px 20px; border-radius: 25px; color: var(--text-light); outline: none; font-family: inherit; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.2);}
        .message-input:focus { border-color: var(--primary-orange); }
        .btn-send { background: var(--gradient-orange); color: white; border: none; width: 48px; height: 48px; border-radius: 50%; font-size: 18px; cursor: pointer; display: flex; justify-content: center; align-items: center; box-shadow: 0 4px 15px rgba(255,81,47,0.4); transition: 0.2s;}
        .btn-send:hover { transform: scale(1.05); }

        /* BOTTOM NAV BARU */
        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: rgba(19, 19, 26, 0.95); backdrop-filter: blur(10px); border-top: 1px solid var(--border-dark); display: flex; justify-content: space-around; padding: 20px 0 calc(20px + env(safe-area-inset-bottom)); z-index: 50; }
        .bottom-nav a { color: var(--text-muted); font-size: 22px; transition: 0.3s; }
        .bottom-nav a.active { color: var(--primary-orange); text-shadow: 0 0 15px rgba(255,81,47,0.5);}

        @media (min-width: 768px) {
            .bottom-nav { display: none; }
            .desktop-menu { display: flex; }
            .contact-list-panel { width: 35%; max-width: 400px; position: relative; }
            .message-panel { width: 65%; display: flex; position: relative; background: transparent;}
            .btn-back { display: none; } 
            .empty-message-state { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--text-muted); }
            .empty-message-state span { font-size: 60px; margin-bottom: 15px; display: block; filter: grayscale(1) opacity(0.2); }
            .empty-message-state h2 { font-weight: 800; color: var(--text-muted); margin: 0;}
        }
        
        @media (max-width: 768px) {
            .messenger-container { margin: 0; border-radius: 0; border: none; border-top: 1px solid var(--border-dark); }
            .messages-history { padding-bottom: 100px; } /* Space for mobile nav */
        }
    </style>
</head>
<body>

    <div class="bg-shapes">
        <div class="grid-pattern"></div>
        <div class="shape1"></div>
        <div class="shape2"></div>
    </div>

    @if(auth()->user()->role === 'applicant')
        <header class="top-nav">
        <div class="logo">Hiring</div>
        <div class="desktop-menu">
            <a href="{{ url('/applicant/home') }}">Discover</a>
            <a href="{{ route('messages.index') }}" class="active">Messages</a>
            <a href="{{ url('/applicant/calendar') }}">Calendar</a>
            <a href="{{ url('/applicant/profile') }}">Profile</a>
        </div>
        </header>
    @else
    
        <header class="top-nav">
            <div class="logo">Hiring <span style="font-size:14px; font-weight:normal; color:var(--text-muted);">Employer</span></div>
            <div class="desktop-menu">
                <a href="{{ url('/employer/dashboard') }}">Dashboard</a>
                <a href="{{ route('messages.index') }}" class="active">Messages</a>
                <a href="{{ url('/employer/calendar') }}">Calendar</a>
                <a href="{{ url('/employer/profile') }}">Profile</a>
            </div>
        </header>
    @endif

    <main class="messenger-container">
        
        <div class="contact-list-panel" id="contactListPanel">
            <div class="contact-header">Messages</div>
            <div class="contact-list">
                </div>
        </div>

        <div class="message-panel" id="messagePanel">
            
            <div class="empty-message-state" id="emptyMessageState" style="display: none;">
                <span>💬</span>
                <h2>Pilih percakapan</h2>
                <p style="font-size: 14px; margin-top: 5px;">Mulai bertukar pesan dengan koneksi Anda.</p>
            </div>

            <div id="activeMessageArea" style="display: flex; flex-direction: column; flex: 1;">
                <div class="message-header">
                    <div class="message-header-info">
                        <button class="btn-back" onclick="closeMessageDetail()"><i class="fas fa-arrow-left" style="margin-right: 10px;"></i></button>
                        <img src="https://via.placeholder.com/50" alt="Avatar" class="contact-avatar" id="messageAvatar" style="width: 40px; height: 40px;">
                        <div>
                            <div class="message-header-name" id="messageTitle">Nama Kontak</div>
                            <div class="message-header-location" id="messageLocation">Lokasi</div>
                        </div>
                    </div>
                    
                    @if(auth()->user()->role === 'employer')
                    <button class="btn-schedule">
                        Schedule <i class="far fa-calendar-check" style="margin-left: 5px;"></i>
                    </button>
                    @endif
                </div>

                <div class="messages-history" id="messagesBox">
                    </div>

                <div class="message-input-area">
                    <input type="text" class="message-input" placeholder="Tulis pesan Anda di sini...">
                    <button class="btn-send"><i class="fas fa-paper-plane" style="margin-left: -2px;"></i></button>
                </div>
            </div>
            
        </div>
    </main>

    @if(auth()->user()->role === 'applicant')
        <nav class="bottom-nav">
            <a href="{{ url('/applicant/home') }}" class="nav-item"><i class="fas fa-layer-group"></i></a>
            <a href="{{ route('messages.index') }}" class="nav-item active"><i class="fas fa-comment-dots"></i></a>
            <a href="{{ url('/applicant/profile') }}" class="nav-item"><i class="fas fa-user"></i></a>
        </nav>
    @else
        <nav class="bottom-nav">
            <a href="{{ url('/employer/dashboard') }}" class="nav-item"><i class="fas fa-users"></i></a>
            <a href="{{ route('messages.index') }}" class="nav-item active"><i class="fas fa-comment-dots"></i></a>
            <a href="{{ url('/employer/profile') }}" class="nav-item"><i class="fas fa-building"></i></a>
        </nav>
    @endif

    <script>
        @if(session('api_token')) localStorage.setItem('api_token', '{{ session('api_token') }}'); @endif
        
        const token = localStorage.getItem('api_token');
        const userRole = '{{ auth()->user()->role ?? "applicant" }}';
        const myUserId = {{ auth()->id() ?? 0 }};
        
        let currentActiveSwipeId = null;
        let messagePollingInterval = null; 
        let loadedMessageIds = new Set(); 

        const contactListPanel = document.getElementById('contactListPanel');
        const messagePanel = document.getElementById('messagePanel');
        const activeMessageArea = document.getElementById('activeMessageArea');
        const emptyMessageState = document.getElementById('emptyMessageState');
        const messageTitle = document.getElementById('messageTitle');
        const messageLocation = document.getElementById('messageLocation');
        const messageAvatar = document.getElementById('messageAvatar');
        const messagesBox = document.getElementById('messagesBox');
        const messageInput = document.querySelector('.message-input');
        const sendBtn = document.querySelector('.btn-send');

        function isDesktop() { return window.innerWidth >= 768; }
        
        function setInitialState() {
            if (isDesktop()) {
                messagePanel.style.display = 'flex';
                activeMessageArea.style.display = currentActiveSwipeId ? 'flex' : 'none';
                emptyMessageState.style.display = currentActiveSwipeId ? 'none' : 'flex';
            } else {
                messagePanel.style.display = currentActiveSwipeId ? 'flex' : 'none';
                contactListPanel.style.display = currentActiveSwipeId ? 'none' : 'flex';
            }
        }
        window.addEventListener('resize', setInitialState);
        setInitialState();

        async function loadContacts() {
            try {
                let response = await fetch('/api/connections', { headers: { 'Authorization': 'Bearer ' + token } });
                let result = await response.json();
                renderContactList(result.matched, result.pending);
            } catch (error) { console.error("Gagal memuat daftar koneksi", error); }
        }

        function renderContactList(matched, pending) {
            const listContainer = document.querySelector('.contact-list');
            listContainer.innerHTML = '';

            if (matched.length > 0) {
                listContainer.innerHTML += `<div class="section-label">Terhubung</div>`;
                matched.forEach(swipe => {
                    let contactName = userRole === 'applicant' ? swipe.employer.name : swipe.applicant.name;
                    let location = userRole === 'applicant' ? (swipe.employer.employer_profile?.location || 'Lokasi Perusahaan') : (swipe.applicant.applicant_profile?.location || 'Lokasi Pelamar');
                    let jobTitle = swipe.job ? swipe.job.title : 'Lowongan';

                    listContainer.innerHTML += `
                        <div class="contact-item" onclick="openMessageDetail(${swipe.id}, '${contactName}', '${location}')">
                            <img src="https://ui-avatars.com/api/?name=${contactName}&background=1c1c24&color=ff512f" class="contact-avatar">
                            <div class="contact-info">
                                <div class="contact-name">${contactName}</div>
                                <div class="contact-desc">Posisi: ${jobTitle}</div>
                            </div>
                            <button class="btn-message-bubble"><i class="fas fa-comment-dots"></i></button>
                        </div>
                    `;
                });
            }

            if (pending.length > 0) {
                listContainer.innerHTML += `<div class="section-label" style="margin-top: 10px;">Menunggu Konfirmasi</div>`;
                pending.forEach(swipe => {
                    let contactName = userRole === 'applicant' ? swipe.employer.name : swipe.applicant.name;
                    let jobTitle = swipe.job ? swipe.job.title : 'Lowongan';

                    listContainer.innerHTML += `
                        <div class="contact-item" style="opacity: 0.5; cursor: default;">
                            <img src="https://ui-avatars.com/api/?name=${contactName}&background=1c1c24&color=a1a1aa" class="contact-avatar" style="border-color: var(--border-dark); box-shadow: none;">
                            <div class="contact-info">
                                <div class="contact-name" style="color: var(--text-muted);">${contactName}</div>
                                <div class="contact-desc">Posisi: ${jobTitle}</div>
                            </div>
                            <button class="btn-message-bubble" style="color: var(--border-dark);"><i class="fas fa-lock"></i></button>
                        </div>
                    `;
                });
            }
        }

        async function openMessageDetail(swipeId, name, location) {
            currentActiveSwipeId = swipeId;
            messageTitle.innerText = name;
            messageLocation.innerText = location;
            messageAvatar.src = `https://ui-avatars.com/api/?name=${name}&background=1c1c24&color=ff512f`;
            setInitialState();

            messagesBox.innerHTML = '';
            loadedMessageIds.clear();
            if(messagePollingInterval) clearInterval(messagePollingInterval);

            await fetchMessages();
            messagePollingInterval = setInterval(fetchMessages, 2000);
        }

        function closeMessageDetail() {
            currentActiveSwipeId = null;
            if(messagePollingInterval) clearInterval(messagePollingInterval);
            setInitialState();
        }

        async function fetchMessages() {
            if(!currentActiveSwipeId) return;
            try {
                let response = await fetch(`/api/messages/${currentActiveSwipeId}`, { headers: { 'Authorization': 'Bearer ' + token } });
                let messages = await response.json();
                renderMessages(messages);
            } catch (error) { console.error("Gagal memuat pesan", error); }
        }

        function renderMessages(messages) {
            let isNewMessageAdded = false;

            messages.forEach(msg => {
                if (!loadedMessageIds.has(msg.id)) {
                    loadedMessageIds.add(msg.id);
                    isNewMessageAdded = true;

                    let isMine = msg.sender_id == myUserId;
                    let bubbleClass = isMine ? 'message-outgoing' : 'message-incoming';
                    let time = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    
                    messagesBox.innerHTML += `
                        <div class="message-bubble ${bubbleClass}">
                            ${msg.message}
                            <span class="time-stamp">${time}</span>
                        </div>
                    `;
                }
            });

            if (isNewMessageAdded) {
                messagesBox.scrollTop = messagesBox.scrollHeight;
            }
        }

        sendBtn.addEventListener('click', async () => {
            let text = messageInput.value.trim();
            if(!text || !currentActiveSwipeId) return;

            messageInput.value = '';

            try {
                let response = await fetch('/api/messages', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token 
                    },
                    body: JSON.stringify({ swipe_id: currentActiveSwipeId, message: text })
                });
                
                if (response.ok) {
                    fetchMessages(); 
                } else {
                    let errorData = await response.json();
                    alert("Pesan gagal terkirim: " + (errorData.message || "Sesi Token Berakhir"));
                }
            } catch (error) { 
                console.error("Gagal mengirim", error); 
            }
        });

        messageInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') sendBtn.click();
        });

        loadContacts();
    </script>
</body>
</html>