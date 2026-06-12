<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <style>
        /* Layout Grid membagi layar menjadi list kontak (kiri) dan ruang obrolan (kanan) */
        body { margin: 0; font-family: sans-serif; display: flex; height: 100vh; background: #f4f4f9; }
        .sidebar { width: 30%; background: #fff; border-right: 1px solid #ccc; overflow-y: auto; }
        .chat-area { width: 70%; display: flex; flex-direction: column; background: #e5e5e5; }
        
        .section-title { padding: 15px; background: #ff512f; color: white; font-weight: bold; margin: 0; }
        .connection-item { padding: 15px; border-bottom: 1px solid #eee; cursor: pointer; display: flex; flex-direction: column;}
        .connection-item:hover { background: #f0f0f0; }
        .connection-item.pending { opacity: 0.6; }
        
        .chat-history { flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 10px; }
        .message-bubble { max-width: 60%; padding: 10px 15px; border-radius: 15px; }
        .message-mine { background: #4caf50; color: white; align-self: flex-end; }
        .message-theirs { background: white; color: black; align-self: flex-start; }
        
        .chat-input { padding: 15px; background: white; display: flex; gap: 10px; }
        .chat-input input { flex: 1; padding: 10px; border-radius: 20px; border: 1px solid #ccc; outline: none; }
        .chat-input button { padding: 10px 20px; background: #ff512f; color: white; border: none; border-radius: 20px; cursor: pointer; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3 class="section-title">Your Matches</h3>
        <div id="matchesList"></div>

        <h3 class="section-title">Pending Connections</h3>
        <div id="pendingList"></div>
    </div>

    <div class="chat-area">
        <div class="section-title" id="chatHeader">Pilih obrolan...</div>
        
        <div class="chat-history" id="chatHistory">
            </div>

        <div class="chat-input" id="chatInputArea" style="display:none;">
            <input type="text" id="messageText" placeholder="Type here...">
            <button onclick="sendReply()">Kirim</button>
        </div>
    </div>

    <script>
        let currentSwipeId = null;
        let myUserId = {{ Auth::id() }}; // Mengambil ID user dari sesi server

        // 1. Memuat daftar kontak saat halaman dibuka
        window.onload = async function() {
            try {
                let response = await fetch('/api/connections', {
                    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('api_token') }
                });
                let result = await response.json();
                
                renderList('matchesList', result.matches, false);
                renderList('pendingList', result.pending, true);
            } catch (error) {
                console.error("Gagal memuat kontak.");
            }
        };

        // 2. Merender HTML Kontak
        function renderList(elementId, items, isPending) {
            const container = document.getElementById(elementId);
            items.forEach(item => {
                // Tentukan nama lawan bicara berdasarkan role kita
                let opponentName = item.applicant_id === myUserId 
                    ? item.employer.name 
                    : item.applicant.name;

                let div = document.createElement('div');
                div.className = `connection-item ${isPending ? 'pending' : ''}`;
                div.innerHTML = `<strong>${opponentName}</strong><span>${item.job.title}</span>`;
                
                // Jika sudah match, bisa diklik untuk buka chat
                if (!isPending) {
                    div.onclick = () => openChat(item.id, opponentName);
                }
                
                container.appendChild(div);
            });
        }

        // 3. Membuka Ruang Chat (Tanpa Reload)
        async function openChat(swipeId, opponentName) {
            currentSwipeId = swipeId;
            document.getElementById('chatHeader').innerText = opponentName;
            document.getElementById('chatInputArea').style.display = 'flex';
            
            const history = document.getElementById('chatHistory');
            history.innerHTML = '<p>Memuat pesan...</p>';

            let response = await fetch(`/api/messages/${swipeId}`, {
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('api_token') }
            });
            let result = await response.json();
            
            history.innerHTML = '';
            result.data.forEach(msg => {
                let isMine = msg.sender_id === myUserId;
                history.innerHTML += `<div class="message-bubble ${isMine ? 'message-mine' : 'message-theirs'}">${msg.message}</div>`;
            });
            history.scrollTop = history.scrollHeight; // Auto-scroll ke bawah
        }

        // 4. Mengirim Pesan Baru
        async function sendReply() {
            const input = document.getElementById('messageText');
            if (!input.value || !currentSwipeId) return;

            let response = await fetch('/api/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('api_token')
                },
                body: JSON.stringify({ swipe_id: currentSwipeId, message: input.value })
            });

            if (response.ok) {
                input.value = '';
                openChat(currentSwipeId, document.getElementById('chatHeader').innerText); // Refresh obrolan
            }
        }
    </script>
</body>
</html>