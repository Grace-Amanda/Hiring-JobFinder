<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Employer Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-dark: #121212; --card-dark: #1e1e1e; --primary-orange: #ff512f;
            --text-light: #ffffff; --text-muted: #aaaaaa; --border-dark: #333333;
        }
        body { margin: 0; background: var(--bg-dark); color: var(--text-light); font-family: 'Segoe UI', sans-serif; display: flex; flex-direction: column; height: 100vh; overflow: hidden; }

        .header { padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-dark); background: var(--bg-dark); z-index: 10; }
        .header .logo { font-size: 24px; font-weight: bold; color: var(--primary-orange); letter-spacing: 1px; }
        
        .search-bar { padding: 15px; background: var(--bg-dark); z-index: 9; }
        .search-input-wrapper { position: relative; max-width: 600px; margin: 0 auto; }
        .search-input-wrapper i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
        .search-input-wrapper input { width: 100%; padding: 12px 12px 12px 40px; border: 1px solid var(--border-dark); border-radius: 25px; outline: none; font-size: 14px; box-sizing: border-box; background: var(--card-dark); color: var(--text-light); }
        .search-input-wrapper input:focus { border-color: var(--primary-orange); }

        .main-content { flex: 1; display: flex; justify-content: center; align-items: center; position: relative; padding: 20px; overflow: hidden; }
        .swipe-container { position: relative; width: 100%; max-width: 380px; height: 65vh; min-height: 400px; max-height: 550px; }

        .card { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: var(--card-dark); border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5); border: 1px solid var(--border-dark); display: flex; flex-direction: column; transition: transform 0.4s ease-out, opacity 0.4s ease-out; z-index: 2; }
        .card-header { padding: 20px; background: linear-gradient(135deg, #3a3a3a 0%, #1a1a1a 100%); text-align: center; border-bottom: 1px solid var(--border-dark);}
        .avatar { width: 80px; height: 80px; border-radius: 50%; background: var(--card-dark); margin: 0 auto 10px; display: flex; justify-content: center; align-items: center; font-size: 35px; color: var(--primary-orange); border: 2px solid var(--primary-orange); }
        .candidate-name { font-size: 20px; color: var(--text-light); margin: 0; font-weight: bold; }
        .education { font-size: 14px; color: var(--text-muted); margin-top: 5px; }

        .card-body { padding: 20px; flex: 1; overflow-y: auto;}
        .info-label { font-size: 12px; color: var(--primary-orange); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; font-weight: bold;}
        .info-text { font-size: 14px; color: var(--text-muted); margin-bottom: 15px; line-height: 1.5; }

        .card-actions { padding: 15px; display: flex; justify-content: space-evenly; border-top: 1px solid var(--border-dark); background: var(--card-dark); }
        .btn-action { width: 60px; height: 60px; border-radius: 50%; border: none; font-size: 28px; cursor: pointer; display: flex; justify-content: center; align-items: center; transition: 0.2s; }
        .btn-action:active { transform: scale(0.9); }
        .btn-reject { color: #ff5252; background: #2a2a2a; border: 1px solid #444;}
        .btn-like { color: #4caf50; background: #2a2a2a; border: 1px solid #444;}

        .swipe-left { transform: translateX(-150%) rotate(-15deg) !important; opacity: 0; }
        .swipe-right { transform: translateX(150%) rotate(15deg) !important; opacity: 0; }

        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: var(--card-dark); display: flex; justify-content: space-around; padding: 15px 0; border-top: 1px solid var(--border-dark); z-index: 20; padding-bottom: calc(15px + env(safe-area-inset-bottom)); }
        .nav-item { color: var(--text-muted); font-size: 24px; text-decoration: none; transition: 0.3s;}
        .nav-item.active, .nav-item:hover { color: var(--primary-orange); }
        .desktop-nav { display: none; }

        @media (min-width: 768px) {
            .bottom-nav { display: none; }
            .desktop-nav { display: flex; gap: 30px; align-items: center; }
            .desktop-nav a { color: var(--text-muted); font-size: 20px; text-decoration: none; transition: 0.3s;}
            .desktop-nav a.active, .desktop-nav a:hover { color: var(--primary-orange); }
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="logo">Hiring <span style="font-size:14px; font-weight:normal; color:var(--text-muted);">Employer</span></div>
        <div class="desktop-nav">
            <a href="{{ url('/employer/dashboard') }}" class="active"><i class="fas fa-users"></i></a>
            <a href="{{ route('messages.index') }}"><i class="fas fa-comment-dots"></i></a>
            <a href="{{ url('/employer/profile') }}"><i class="fas fa-building"></i></a>
        </div>
    </header>

    <div class="search-bar">
        <div class="search-input-wrapper">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Filter nama kandidat atau keahlian...">
        </div>
    </div>

    <main class="main-content">
        <div class="swipe-container" id="cardContainer">
            <!-- Tempat kartu dirender -->
        </div>
    </main>

    <nav class="bottom-nav">
        <a href="{{ url('/employer/dashboard') }}" class="nav-item active"><i class="fas fa-users"></i></a>
        <a href="{{ route('messages.index') }}" class="nav-item"><i class="fas fa-comment-dots"></i></a>
        <a href="{{ url('/employer/profile') }}" class="nav-item"><i class="fas fa-building"></i></a>
    </nav>

    <script>
        @if(session('api_token')) localStorage.setItem('api_token', '{{ session('api_token') }}'); @endif

        let currentCandidates = [];
        const cardContainer = document.getElementById('cardContainer');
        const searchInput = document.getElementById('searchInput');

        fetchCandidates();
        searchInput.addEventListener('keyup', fetchCandidates);

        async function fetchCandidates() {
            let keyword = searchInput.value;
            try {
                let response = await fetch(`/api/applicants/search?keyword=${keyword}`, {
                    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('api_token') }
                });
                if (response.ok) {
                    let result = await response.json();
                    currentCandidates = result.data;
                    renderTopCandidate(); 
                }
            } catch (error) { console.error("Error API:", error); }
        }

        function renderTopCandidate() {
            cardContainer.innerHTML = ''; 
            if (currentCandidates.length === 0) {
                cardContainer.innerHTML = `<div style="text-align:center; color:#888; margin-top:50%;"><i class="fas fa-user-slash" style="font-size:40px; margin-bottom:15px;"></i><p>Tidak ada kandidat yang sesuai.</p></div>`;
                return;
            }

            let applicant = currentCandidates[0];
            let name = applicant.full_name || applicant.user.name;
            let education = applicant.education || 'Pendidikan belum diisi';
            let history = applicant.job_history || 'Belum ada pengalaman';
            let dummyJobId = 1; // Simulasi ID Job

            let cardHTML = `
                <div class="card" id="topCard">
                    <div class="card-header">
                        <div class="avatar"><i class="fas fa-user"></i></div>
                        <h2 class="candidate-name">${name}</h2>
                        <div class="education"><i class="fas fa-graduation-cap"></i> ${education}</div>
                    </div>
                    <div class="card-body">
                        <div class="info-label">Rating</div>
                        <div class="info-text" style="color:#ffb300;"><i class="fas fa-star"></i> ${applicant.rating} / 5.0</div>
                        
                        <div class="info-label">Riwayat & Keahlian</div>
                        <div class="info-text">${history}</div>
                    </div>
                    <div class="card-actions">
                        <button class="btn-action btn-reject" onclick="triggerSwipe('reject', ${applicant.user_id}, ${dummyJobId})"><i class="fas fa-times"></i></button>
                        <button class="btn-action btn-like" onclick="triggerSwipe('like', ${applicant.user_id}, ${dummyJobId})"><i class="fas fa-check"></i></button>
                    </div>
                </div>
            `;
            cardContainer.insertAdjacentHTML('beforeend', cardHTML);
        }

        function triggerSwipe(action, applicantId, jobId) {
            const card = document.getElementById('topCard');
            if(!card) return;
            card.classList.add(action === 'like' ? 'swipe-right' : 'swipe-left');
            currentCandidates.shift(); 
            // Integrasi ke SwipeController backend jika diperlukan
            setTimeout(() => { renderTopCandidate(); }, 400);
        }
    </script>
</body>
</html>