<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Messages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-dark: #121212; --card-dark: #1e1e1e; --primary-orange: #ff512f; --secondary-orange: #f68e1e;
            --text-light: #ffffff; --text-muted: #aaaaaa; --border-dark: #333333;
        }
        body { margin: 0; background: var(--bg-dark); color: var(--text-light); font-family: 'Segoe UI', sans-serif; display: flex; flex-direction: column; height: 100vh; overflow: hidden; }

        /* HEADER & NAV LAYOUT */
        .header { padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-dark); background: var(--bg-dark); z-index: 10; flex-shrink: 0;}
        .header .logo { font-size: 24px; font-weight: bold; color: var(--primary-orange); letter-spacing: 1px; }
        
        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: var(--card-dark); display: flex; justify-content: space-around; padding: 15px 0; border-top: 1px solid var(--border-dark); z-index: 20; padding-bottom: calc(15px + env(safe-area-inset-bottom)); flex-shrink: 0;}
        .nav-item { color: var(--text-muted); font-size: 24px; text-decoration: none; transition: 0.3s;}
        .nav-item.active, .nav-item:hover { color: var(--primary-orange); }
        .desktop-nav { display: none; }

        @media (min-width: 768px) {
            .bottom-nav { display: none; }
            .desktop-nav { display: flex; gap: 30px; align-items: center; }
            .desktop-nav a { color: var(--text-muted); font-size: 20px; text-decoration: none; transition: 0.3s;}
            .desktop-nav a.active, .desktop-nav a:hover { color: var(--primary-orange); }
        }

        /* LAYOUT MESSENGER UTAMA */
        .messenger-container { flex: 1; display: flex; overflow: hidden; position: relative; }
        
        /* PANEL KIRI: DAFTAR KONTAK */
        .contact-list-panel { width: 100%; display: flex; flex-direction: column; background: var(--bg-dark); border-right: 1px solid var(--border-dark); transition: transform 0.3s ease; }
        .contact-header { padding: 20px; border-bottom: 1px solid var(--border-dark); font-weight: bold; font-size: 18px; }
        .contact-list { overflow-y: auto; flex: 1; padding-bottom: 80px; }
        
        .section-label { padding: 10px 20px; font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; background: #181818; }
        
        .contact-item { display: flex; align-items: center; padding: 15px 20px; border-bottom: 1px solid var(--border-dark); cursor: pointer; transition: background 0.2s; }
        .contact-item:hover { background: var(--card-dark); }
        .contact-avatar { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary-orange); }
        .contact-info { flex: 1; margin-left: 15px; }
        .contact-name { font-weight: bold; color: var(--primary-orange); font-size: 16px; margin-bottom: 3px; display: flex; align-items: center; gap: 8px;}
        .contact-desc { font-size: 13px; color: var(--text-light); opacity: 0.8;}
        .btn-message-bubble { color: var(--primary-orange); font-size: 24px; border: none; background: transparent; cursor: pointer; }

        /* PANEL KANAN: RUANG PESAN */
        .message-panel { width: 100%; display: none; flex-direction: column; background: var(--card-dark); position: absolute; top: 0; left: 0; height: 100%; z-index: 5;}
        
        .message-header { padding: 15px 20px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-dark); background: var(--bg-dark); }
        .message-header-info { display: flex; align-items: center; gap: 15px; }
        .btn-back { color: var(--primary-orange); font-size: 20px; cursor: pointer; background: transparent; border: none; display: flex; align-items: center; }
        .message-header-name { font-weight: bold; color: var(--primary-orange); font-size: 18px; }
        .message-header-location { font-size: 12px; color: var(--text-muted); }
        
        .btn-schedule { background: linear-gradient(90deg, var(--primary-orange), var(--secondary-orange)); color: white; border: none; padding: 8px 15px; border-radius: 8px; font-weight: bold; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 14px;}
        
        .messages-history { flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 15px; padding-bottom: 80px;}
        .message-bubble { max-width: 75%; padding: 12px 16px; border-radius: 15px; font-size: 14px; line-height: 1.4; position: relative; }
        .time-stamp { font-size: 10px; opacity: 0.7; margin-top: 5px; display: block; }
        
        .message-incoming { align-self: flex-start; background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange)); color: white; border-bottom-left-radius: 2px; }
        .message-incoming .time-stamp { text-align: left; }
        .message-outgoing { align-self: flex-end; background: transparent; border: 1px solid var(--primary-orange); color: var(--primary-orange); border-bottom-right-radius: 2px; }
        .message-outgoing .time-stamp { text-align: right; }

        .message-input-area { padding: 15px 20px; background: var(--bg-dark); border-top: 1px solid var(--border-dark); display: flex; gap: 10px; align-items: center; }
        .message-input { flex: 1; background: var(--card-dark); border: 1px solid var(--border-dark); padding: 12px 20px; border-radius: 25px; color: white; outline: none; }
        .message-input:focus { border-color: var(--primary-orange); }
        .btn-send { background: linear-gradient(90deg, var(--primary-orange), var(--secondary-orange)); color: white; border: none; width: 45px; height: 45px; border-radius: 50%; font-size: 18px; cursor: pointer; display: flex; justify-content: center; align-items: center; }

        @media (min-width: 768px) {
            .contact-list-panel { width: 35%; max-width: 400px; position: relative; }
            .message-panel { width: 65%; display: flex; position: relative; }
            .btn-back { display: none; } 
            .messages-history { padding-bottom: 20px; }
            .contact-list { padding-bottom: 20px; }
            .empty-message-state { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--text-muted); }
            .empty-message-state i { font-size: 60px; margin-bottom: 15px; opacity: 0.2; }
        }
    </style>
</head>
<body>

    @if(auth()->user()->role === 'applicant')
        <header class="header">
            <div class="logo">Hiring</div>
            <div class="desktop-nav">
                <a href="{{ url('/applicant/home') }}"><i class="fas fa-layer-group"></i></a>
                <a href="{{ route('messages.index') }}" class="active"><i class="fas fa-comment-dots"></i></a>
                <a href="{{ url('/applicant/profile') }}"><i class="fas fa-user"></i></a>
            </div>
        </header>
    @else
        <header class="header">
            <div class="logo">Hiring <span style="font-size:14px; font-weight:normal; color:var(--text-muted);">Employer</span></div>
            <div class="desktop-nav">
                <a href="{{ url('/employer/dashboard') }}"><i class="fas fa-users"></i></a>
                <a href="{{ route('messages.index') }}" class="active"><i class="fas fa-comment-dots"></i></a>
                <a href="{{ url('/employer/profile') }}"><i class="fas fa-building"></i></a>
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
                <i class="fas fa-comment-dots"></i>
                <h2>Pilih pesan</h2>
                <p>Mulai bertukar pesan dengan perusahaan atau pelamar.</p>
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
                        Schedule meeting <i class="far fa-calendar-alt"></i>
                    </button>
                    @endif
                </div>

                <div class="messages-history" id="messagesBox">
                    </div>

                <div class="message-input-area">
                    <input type="text" class="message-input" placeholder="Ketik pesan Anda...">
                    <button class="btn-send"><i class="fas fa-paper-plane"></i></button>
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
                listContainer.innerHTML += `<div class="section-label">Telah Terhubung</div>`;
                matched.forEach(swipe => {
                    // Logika penamaan: Ambil dari tabel users 'name'
                    let contactName = userRole === 'applicant' ? swipe.employer.name : swipe.applicant.name;
                    let location = userRole === 'applicant' ? (swipe.employer.employer_profile?.location || 'Lokasi Perusahaan') : (swipe.applicant.applicant_profile?.location || 'Lokasi Pelamar');
                    let jobTitle = swipe.job ? swipe.job.title : 'Lowongan';

                    listContainer.innerHTML += `
                        <div class="contact-item" onclick="openMessageDetail(${swipe.id}, '${contactName}', '${location}')">
                            <img src="https://ui-avatars.com/api/?name=${contactName}&background=random" class="contact-avatar">
                            <div class="contact-info">
                                <div class="contact-name">${contactName}</div>
                                <div class="contact-desc">Melamar: ${jobTitle}</div>
                            </div>
                            <button class="btn-message-bubble"><i class="fas fa-comment-dots"></i></button>
                        </div>
                    `;
                });
            }

            if (pending.length > 0) {
                listContainer.innerHTML += `<div class="section-label" style="margin-top: 10px;">Menunggu Persetujuan</div>`;
                pending.forEach(swipe => {
                    let contactName = userRole === 'applicant' ? swipe.employer.name : swipe.applicant.name;
                    let jobTitle = swipe.job ? swipe.job.title : 'Lowongan';

                    listContainer.innerHTML += `
                        <div class="contact-item" style="opacity: 0.6; cursor: default;">
                            <img src="https://ui-avatars.com/api/?name=${contactName}&background=random" class="contact-avatar">
                            <div class="contact-info">
                                <div class="contact-name">${contactName}</div>
                                <div class="contact-desc">Melamar: ${jobTitle}</div>
                            </div>
                            <button class="btn-message-bubble" style="color: var(--text-muted);"><i class="fas fa-lock"></i></button>
                        </div>
                    `;
                });
            }
        }

        async function openMessageDetail(swipeId, name, location) {
            currentActiveSwipeId = swipeId;
            messageTitle.innerText = name;
            messageLocation.innerText = location;
            messageAvatar.src = `https://ui-avatars.com/api/?name=${name}&background=random`;
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