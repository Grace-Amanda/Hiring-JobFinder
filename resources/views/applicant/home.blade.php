<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Jobs</title>
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
        .bg-shapes { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; overflow: hidden; pointer-events: none; }
        .shape1 { position: absolute; top: -10%; left: -10%; width: 50vw; height: 50vw; background: radial-gradient(circle, rgba(255,81,47,0.2) 0%, transparent 60%); filter: blur(50px); }
        .shape2 { position: absolute; bottom: 0%; right: -10%; width: 60vw; height: 60vw; background: radial-gradient(circle, rgba(240,152,25,0.15) 0%, transparent 60%); filter: blur(60px); }
        .grid-pattern { position: absolute; width: 100%; height: 100%; background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 40px 40px; }

        .top-nav { padding: 20px 5%; display: flex; justify-content: space-between; align-items: center; z-index: 10; position: relative; }
        .logo { font-size: 28px; font-weight: 800; color: var(--primary-orange); letter-spacing: -1px; text-shadow: 0 4px 10px rgba(255,81,47,0.3);}
        .desktop-menu { display: none; gap: 40px; }
        .desktop-menu a { color: var(--text-muted); text-decoration: none; font-size: 16px; font-weight: 500; transition: color 0.3s; }
        .desktop-menu a.active, .desktop-menu a:hover { color: var(--text-light); }

        .search-section { padding: 0 5% 30px; z-index: 10; position: relative; display: flex; justify-content: center; gap: 10px; max-width: 550px; margin: 0 auto; }
        
        .search-box { position: relative; flex: 1; }
        .search-box input { width: 100%; background: rgba(28, 28, 36, 0.8); backdrop-filter: blur(10px); border: 1px solid var(--border-dark); border-radius: 16px; color: var(--text-light); padding: 14px 40px 14px 20px; font-size: 15px; outline: none; font-family: inherit; transition: 0.3s; box-shadow: 0 10px 20px rgba(0,0,0,0.3); box-sizing: border-box;}
        .search-box input:focus { border-color: var(--primary-orange); box-shadow: 0 10px 20px rgba(255,81,47,0.2);}
        .search-box i { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 16px; }
        
        .btn-filter { background: rgba(28, 28, 36, 0.8); backdrop-filter: blur(10px); border: 1px solid var(--border-dark); color: var(--text-light); width: 50px; border-radius: 16px; display: flex; justify-content: center; align-items: center; font-size: 18px; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(0,0,0,0.3);}
        .btn-filter:hover, .btn-filter.active { border-color: var(--primary-orange); color: var(--primary-orange); background: rgba(255,81,47,0.1); }
        .filter-indicator { position: absolute; top: -5px; right: -5px; background: var(--primary-orange); width: 12px; height: 12px; border-radius: 50%; display: none; border: 2px solid var(--bg-dark); }

        .swipe-instruction { display: flex; align-items: center; justify-content: center; gap: 15px; width: 100%; z-index: 10; position: relative; margin-bottom: 35px; }
        .instruction-badge { font-size: 16px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 8px; text-shadow: 0 2px 10px rgba(0,0,0,0.5);}
        .instruction-badge.left { color: #f87171; }
        .instruction-badge.right { color: #4ade80; }
        .drag-icon { font-size: 20px; color: var(--text-light); animation: slide-hint 2s infinite; background: rgba(255,255,255,0.1); padding: 5px 15px; border-radius: 20px;}
        @keyframes slide-hint { 0% { transform: translateX(0); } 25% { transform: translateX(-10px); } 75% { transform: translateX(10px); } 100% { transform: translateX(0); } }

        .main-stage { flex: 1; display: flex; flex-direction: column; justify-content: flex-start; align-items: center; position: relative; overflow: hidden; padding-bottom: 80px; z-index: 5; }
        .card-stack { position: relative; width: 90%; max-width: 420px; height: 60vh; max-height: 550px; display: flex; justify-content: center; align-items: center;}

        .reveal-layer { position: absolute; width: 100%; height: 100%; border-radius: 30px; border: 3px dashed var(--border-dark); background: rgba(28,28,36,0.5); display: flex; justify-content: center; align-items: center; z-index: 1; }
        .reveal-content { font-size: 32px; font-weight: 800; letter-spacing: 2px; text-align: center; opacity: 0; transition: opacity 0.1s; text-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .reveal-content span { display: block; font-size: 60px; margin-bottom: 10px; }

        .card { position: absolute; width: 100%; height: 100%; background: var(--card-dark); border: 1px solid rgba(255,255,255,0.1); border-radius: 30px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8); display: flex; flex-direction: column; touch-action: none; cursor: grab; user-select: none; transition: transform 0.4s ease, opacity 0.4s ease; z-index: 2; overflow: hidden; }
        .card:active { cursor: grabbing; }

        .card-visual { height: 50%; background-color: #27272a; background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=600&auto=format&fit=crop'); background-size: cover; background-position: center; position: relative; }
        .card-visual::after { content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 60%; background: linear-gradient(to top, var(--card-dark) 0%, transparent 100%); }
        
        .card-content { padding: 0 30px; flex: 1; display: flex; flex-direction: column; position: relative; z-index: 3; margin-top: -20px; pointer-events: none;}
        .company-label { display: inline-block; padding: 6px 12px; background: rgba(255,81,47,0.15); border: 1px solid rgba(255,81,47,0.3); border-radius: 12px; font-size: 13px; font-weight: 800; color: var(--primary-orange); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; width: fit-content;}
        .job-title { font-size: 28px; font-weight: 800; line-height: 1.2; margin: 0 0 10px 0; letter-spacing: -1px; text-shadow: 0 2px 10px rgba(0,0,0,0.5); }
        .job-reqs { font-size: 15px; color: var(--text-muted); line-height: 1.5; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;}

        .card-actions { position: absolute; bottom: 20px; left: 0; width: 100%; display: flex; justify-content: center; gap: 30px; z-index: 10; }
        .btn-action { width: 65px; height: 65px; border-radius: 50%; border: none; font-size: 28px; display: flex; justify-content: center; align-items: center; cursor: pointer; background: var(--bg-dark); border: 2px solid var(--border-dark); box-shadow: 0 10px 25px rgba(0,0,0,0.5); transition: all 0.2s; pointer-events: auto;}
        .btn-action:active { transform: scale(0.9); }
        .btn-reject { color: #f87171; } .btn-reject:hover { border-color: #f87171; background: rgba(248, 113, 113, 0.1); }
        .btn-accept { color: #4ade80; } .btn-accept:hover { border-color: #4ade80; background: rgba(74, 222, 128, 0.1); }

        .swipe-out-left { transform: translateX(-150%) rotate(-20deg) !important; opacity: 0; }
        .swipe-out-right { transform: translateX(150%) rotate(20deg) !important; opacity: 0; }

        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: rgba(19, 19, 26, 0.95); backdrop-filter: blur(10px); border-top: 1px solid var(--border-dark); display: flex; justify-content: space-around; padding: 20px 0 calc(20px + env(safe-area-inset-bottom)); z-index: 50; }
        .bottom-nav a { color: var(--text-muted); font-size: 22px; transition: 0.3s; }
        .bottom-nav a.active { color: var(--primary-orange); }

        @media (min-width: 768px) {
            .bottom-nav { display: none; }
            .desktop-menu { display: flex; }
            .main-stage { padding-bottom: 0; }
        }

        .profile-alert { background: rgba(255, 81, 47, 0.1); border: 1px solid rgba(255, 81, 47, 0.3); color: var(--primary-orange); padding: 12px 5%; display: flex; justify-content: space-between; align-items: center; font-size: 14px; position: relative; z-index: 10; backdrop-filter: blur(5px);}
        .profile-alert a { background: var(--primary-orange); color: white; padding: 6px 15px; border-radius: 20px; text-decoration: none; font-weight: 700; font-size: 12px; transition: 0.3s; white-space: nowrap; margin-left: 15px;}
        .profile-alert a:hover { background: #e04425; }
        @media (max-width: 768px) { .profile-alert { flex-direction: column; text-align: center; gap: 10px; padding: 15px 5%;} }

        /* --- STYLING MODAL FILTER --- */
        .filter-modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 100; display: none; justify-content: center; align-items: flex-end; }
        .filter-modal-overlay.active { display: flex; animation: fadeIn 0.2s; }
        .filter-modal { background: var(--bg-dark); width: 100%; max-width: 500px; border-radius: 24px 24px 0 0; padding: 30px; border-top: 1px solid var(--border-dark); transform: translateY(100%); transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1); box-sizing: border-box;}
        .filter-modal-overlay.active .filter-modal { transform: translateY(0); }
        
        .filter-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .filter-header h3 { margin: 0; font-size: 20px; font-weight: 800; }
        .btn-close-filter { background: none; border: none; color: var(--text-muted); font-size: 20px; cursor: pointer; }
        
        .filter-group { margin-bottom: 20px; }
        .filter-group label { display: block; font-size: 13px; font-weight: 700; color: var(--text-muted); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;}
        .filter-group select { width: 100%; background: var(--card-dark); border: 1px solid var(--border-dark); color: var(--text-light); padding: 15px; border-radius: 12px; outline: none; font-family: inherit; font-size: 15px;}
        
        .filter-actions { display: flex; gap: 10px; margin-top: 30px; }
        .btn-reset { flex: 1; padding: 15px; background: transparent; border: 1px solid var(--border-dark); color: var(--text-light); border-radius: 12px; font-weight: 700; cursor: pointer;}
        .btn-apply { flex: 2; padding: 15px; background: var(--gradient-orange); border: none; color: white; border-radius: 12px; font-weight: 800; cursor: pointer; box-shadow: 0 10px 20px rgba(255,81,47,0.3);}
        
        @media (min-width: 768px) {
            .filter-modal-overlay { align-items: center; }
            .filter-modal { border-radius: 24px; border: 1px solid var(--border-dark); transform: scale(0.9); opacity: 0;}
            .filter-modal-overlay.active .filter-modal { transform: scale(1); opacity: 1;}
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>

    <div class="bg-shapes">
        <div class="grid-pattern"></div>
        <div class="shape1"></div>
        <div class="shape2"></div>
    </div>

    <header class="top-nav">
        <div class="logo">Hiring</div>
        <div class="desktop-menu">
            <a href="{{ url('/applicant/home') }}" class="active">Discover</a>
            <a href="{{ url('/applicant/calendar') }}">Calendar</a>
            <a href="{{ route('messages.index') }}">Messages</a>
            <a href="{{ url('/applicant/profile') }}">Profile</a>
        </div>
    </header>

    <!-- CEK KONDISI PROFIL DARI DATABASE -->
    @php
        $profile = \App\Models\ApplicantProfile::where('user_id', Auth::id())->first();
        $isProfileComplete = $profile && $profile->document_ktp && $profile->document_cv;
    @endphp

    <!-- TAMPILKAN ALERT HANYA JIKA PROFIL BELUM LENGKAP -->
    @if(!$isProfileComplete)
    <div class="profile-alert" id="profileAlert" style="display: none;">
        <div><i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i> <strong>Profil Belum Lengkap!</strong> Unggah CV dan KTP agar lamaran Anda bisa diproses.</div>
        <a href="{{ url('/applicant/profile') }}">Lengkapi Sekarang</a>
    </div>
    @endif

    <div class="search-section" style="margin-top: 20px;">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Cari posisi atau perusahaan...">
            <i class="fas fa-search"></i>
        </div>
        <!-- TOMBOL FILTER -->
        <button class="btn-filter" id="btnOpenFilter" title="Filter Pencarian">
            <i class="fas fa-sliders-h"></i>
            <div class="filter-indicator" id="filterIndicator"></div>
        </button>
    </div>

    <main class="main-stage">
        <div class="swipe-instruction">
            <div class="instruction-badge left"><i class="fas fa-times"></i> Reject</div>
            <div class="drag-icon"><i class="fas fa-arrows-alt-h"></i> Geser Kartu</div>
            <div class="instruction-badge right">Accept <i class="fas fa-check"></i></div>
        </div>

        <div class="card-stack" id="cardContainer">
            <div class="reveal-layer">
                <div class="reveal-content" id="revealContent"></div>
            </div>
            <div id="dynamicCardWrapper" style="width:100%; height:100%; position:absolute; top:0; left:0; z-index:2;"></div>
        </div>
    </main>

    <!-- MODAL FILTER -->
    <div class="filter-modal-overlay" id="filterModal">
        <div class="filter-modal">
            <div class="filter-header">
                <h3>Filter Pencarian</h3>
                <button class="btn-close-filter" id="btnCloseFilter"><i class="fas fa-times"></i></button>
            </div>
            
            <div class="filter-group">
                <label>Lokasi / Kota</label>
                <select id="filterLocation">
                    <option value="">Semua Lokasi</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Surabaya">Surabaya</option>
                    <option value="Bandung">Bandung</option>
                    <option value="Yogyakarta">Yogyakarta</option>
                    <option value="Remote">Remote / WFA</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Bidang / Industri</label>
                <select id="filterIndustry">
                    <option value="">Semua Bidang</option>
                    <option value="Teknologi">Teknologi & IT</option>
                    <option value="Kesehatan">Kesehatan</option>
                    <option value="Pendidikan">Pendidikan</option>
                    <option value="Keuangan">Keuangan & Perbankan</option>
                    <option value="Manufaktur">Manufaktur</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Tipe Pekerjaan</label>
                <select id="filterJobType">
                    <option value="">Semua Tipe</option>
                    <option value="Full-time">Full-time</option>
                    <option value="Part-time">Part-time</option>
                    <option value="Contract">Kontrak</option>
                    <option value="Internship">Magang</option>
                </select>
            </div>

            <div class="filter-actions">
                <button class="btn-reset" id="btnResetFilter">Reset</button>
                <button class="btn-apply" id="btnApplyFilter">Terapkan Filter</button>
            </div>
        </div>
    </div>

    <nav class="bottom-nav">
        <a href="{{ url('/applicant/home') }}" class="active"><i class="fas fa-layer-group"></i></a>
        <a href="{{ url('/applicant/calendar') }}"><i class="fas fa-calendar-alt"></i></a>
        <a href="{{ route('messages.index') }}"><i class="fas fa-comment-dots"></i></a>
        <a href="{{ url('/applicant/profile') }}"><i class="fas fa-user"></i></a>
    </nav>

    <script>
        @if(session('api_token')) localStorage.setItem('api_token', '{{ session('api_token') }}'); @endif
        
        // JALANKAN JAVASCRIPT ANIMASI POP-UP HANYA JIKA PROFIL BELUM LENGKAP
        @if(!$isProfileComplete)
        setTimeout(() => { 
            let alertBox = document.getElementById('profileAlert');
            if(alertBox) alertBox.style.display = 'flex'; 
        }, 1500);
        @endif

        let currentJobs = [];
        const dynamicCardWrapper = document.getElementById('dynamicCardWrapper');
        const searchInput = document.getElementById('searchInput');
        const revealContent = document.getElementById('revealContent');

        // Filter Elements
        const filterModal = document.getElementById('filterModal');
        const btnOpenFilter = document.getElementById('btnOpenFilter');
        const btnCloseFilter = document.getElementById('btnCloseFilter');
        const btnApplyFilter = document.getElementById('btnApplyFilter');
        const btnResetFilter = document.getElementById('btnResetFilter');
        const filterIndicator = document.getElementById('filterIndicator');

        // Buka/Tutup Modal Filter
        btnOpenFilter.addEventListener('click', () => filterModal.classList.add('active'));
        btnCloseFilter.addEventListener('click', () => filterModal.classList.remove('active'));
        
        // Menutup modal jika klik di luar area modal
        filterModal.addEventListener('click', (e) => {
            if(e.target === filterModal) filterModal.classList.remove('active');
        });

        // Trigger Pencarian
        searchInput.addEventListener('keyup', (e) => {
            if(e.key === 'Enter') fetchJobs(); 
        });

        // Terapkan Filter
        btnApplyFilter.addEventListener('click', () => {
            filterModal.classList.remove('active');
            fetchJobs();
        });

        // Reset Filter
        btnResetFilter.addEventListener('click', () => {
            document.getElementById('filterLocation').value = '';
            document.getElementById('filterIndustry').value = '';
            document.getElementById('filterJobType').value = '';
            searchInput.value = '';
            fetchJobs();
        });

        // Fungsi Ambil Data dengan Filter
        async function fetchJobs() {
            let keyword = searchInput.value;
            let location = document.getElementById('filterLocation').value;
            let industry = document.getElementById('filterIndustry').value;
            let jobType = document.getElementById('filterJobType').value;

            // Indikator Titik Orange jika ada filter yang aktif
            if(location || industry || jobType) {
                filterIndicator.style.display = 'block';
                btnOpenFilter.classList.add('active');
            } else {
                filterIndicator.style.display = 'none';
                btnOpenFilter.classList.remove('active');
            }

            // Membangun URL Query String
            let queryParams = new URLSearchParams();
            if (keyword) queryParams.append('keyword', keyword);
            if (location) queryParams.append('location', location);
            if (industry) queryParams.append('industry', industry);
            if (jobType) queryParams.append('job_type', jobType);

            try {
                let response = await fetch(`/api/jobs/search?${queryParams.toString()}`, {
                    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('api_token') }
                });
                
                if (response.ok) {
                    let result = await response.json();
                    currentJobs = result.data;
                    renderTopCard(); 
                }
            } catch (error) { console.error("API Error:", error); }
        }

        function renderTopCard() {
            dynamicCardWrapper.innerHTML = ''; 
            revealContent.style.opacity = 0;
            
            if (currentJobs.length === 0) {
                dynamicCardWrapper.innerHTML = `
                    <div style="text-align:center; color:var(--text-muted); margin-top:50%; font-family: inherit;">
                        <span style="font-size:60px; display:block; margin-bottom:10px;">📭</span>
                        <h2 style="font-size:28px; font-weight:800; color:var(--text-light); margin:0 0 10px 0;">Kosong!</h2>
                        <p style="font-size:15px;">Belum ada lowongan sesuai kriteria Anda.</p>
                    </div>`;
                return;
            }

            let job = currentJobs[0];
            let companyName = job.employer.employer_profile ? job.employer.employer_profile.company_name : job.employer.name;

            let cardHTML = `
                <div class="card" id="topCard">
                    <div class="card-visual"></div>
                    <div class="card-content">
                        <div class="company-label">${companyName}</div>
                        <h2 class="job-title">${job.title}</h2>
                        <div class="job-reqs">${job.qualifications}</div>
                    </div>
                    
                    <div class="card-actions">
                        <button class="btn-action btn-reject" onclick="triggerAction('reject', ${job.employer_id}, ${job.id})"><i class="fas fa-times"></i></button>
                        <button class="btn-action btn-accept" onclick="triggerAction('like', ${job.employer_id}, ${job.id})"><i class="fas fa-check"></i></button>
                    </div>
                </div>
            `;
            dynamicCardWrapper.insertAdjacentHTML('beforeend', cardHTML);
            initDrag(document.getElementById('topCard'), job.employer_id, job.id);
        }

        // ─── FIX BUG #5: triggerAction sekarang async, await fetch, handle match response ───
        // Sebelumnya: fetch tidak di-await, response tidak dibaca, tidak ada notifikasi match.
        // Sekarang: tunggu response, jika match_status === 'matched' tampilkan popup & redirect ke Messages.
        async function triggerAction(action, employerId, jobId) {
            const card = document.getElementById('topCard');
            if(!card) return;
            
            card.classList.add(action === 'like' ? 'swipe-out-right' : 'swipe-out-left');
            
            revealContent.innerHTML = action === 'like' ? '<span>💚</span> ACCEPT' : '<span>❌</span> REJECT';
            revealContent.style.color = action === 'like' ? '#4ade80' : '#f87171';
            revealContent.style.opacity = 1;

            currentJobs.shift(); 

            try {
                // FIX: await fetch agar bisa baca response-nya
                const res = await fetch(`/api/swipe`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + localStorage.getItem('api_token') },
                    body: JSON.stringify({ employer_id: employerId, job_vacancy_id: jobId, action: action })
                });
                const data = await res.json();

                // FIX: Jika match terjadi, tampilkan notifikasi lalu redirect ke Messages
                if (data.match_status === 'matched') {
                    setTimeout(() => {
                        const goMsg = confirm('🎉 IT\'S A MATCH! Perusahaan ini juga tertarik dengan profil Anda!\nMau langsung buka Messages sekarang?');
                        if (goMsg) window.location.href = '{{ route("messages.index") }}';
                        else renderTopCard();
                    }, 400);
                    return; // Jangan lanjut renderTopCard dulu, tunggu konfirmasi user
                }
            } catch(e) {
                console.error('Swipe API error:', e);
            }
            
            setTimeout(() => { renderTopCard(); }, 350);
        }

        function initDrag(card, employerId, jobId) {
            let isDragging = false;
            let startX = 0, currentX = 0;
            const threshold = 120;

            function onStart(e) {
                if(e.target.closest('.btn-action')) return; 
                isDragging = true;
                startX = e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
                currentX = startX;
                card.style.transition = 'none';
            }

            function onMove(e) {
                if (!isDragging) return;
                if(e.cancelable) e.preventDefault(); 
                
                currentX = e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
                let diffX = currentX - startX;
                let rotate = diffX * 0.05;

                card.style.transform = `translateX(${diffX}px) translateY(${Math.abs(diffX)*0.05}px) rotate(${rotate}deg)`;

                if (diffX > 0) {
                    revealContent.innerHTML = '<span>💚</span> ACCEPT';
                    revealContent.style.color = '#4ade80';
                    revealContent.style.opacity = diffX / threshold;
                } else {
                    revealContent.innerHTML = '<span>❌</span> REJECT';
                    revealContent.style.color = '#f87171';
                    revealContent.style.opacity = Math.abs(diffX) / threshold;
                }
            }

            function onEnd() {
                if (!isDragging) return;
                isDragging = false;
                let diffX = currentX - startX;
                card.style.transition = 'transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.4s ease';

                if (diffX > threshold) {
                    triggerAction('like', employerId, jobId);
                } else if (diffX < -threshold) {
                    triggerAction('reject', employerId, jobId);
                } else {
                    card.style.transform = 'translateX(0) translateY(0) rotate(0)';
                    revealContent.style.opacity = 0;
                }
            }

            card.addEventListener('mousedown', onStart);
            card.addEventListener('touchstart', onStart, {passive: false});
            window.addEventListener('mousemove', onMove);
            window.addEventListener('touchmove', onMove, {passive: false});
            window.addEventListener('mouseup', onEnd);
            window.addEventListener('touchend', onEnd);
        }

        // Jalankan fetch pertama kali
        fetchJobs();
    </script>
</body>
</html>