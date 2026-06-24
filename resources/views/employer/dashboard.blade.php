<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Candidates</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{--bg-dark:#13131a;--card-dark:#1c1c24;--border-dark:#2d2d3a;--primary-orange:#ff512f;--gradient-orange:linear-gradient(135deg,#ff512f 0%,#f09819 100%);--text-light:#ffffff;--text-muted:#a1a1aa}
        body,html{margin:0;padding:0;background:linear-gradient(135deg,#0f0f13 0%,#1a1a24 100%);color:var(--text-light);font-family:'Plus Jakarta Sans',sans-serif;height:100vh;overflow:hidden;display:flex;flex-direction:column}
        .bg-shapes{position:fixed;inset:0;z-index:0;pointer-events:none;overflow:hidden}
        .shape1,.shape2{position:absolute;filter:blur(50px)}
        .shape1{top:-10%;left:-10%;width:50vw;height:50vw;background:radial-gradient(circle,rgba(255,81,47,.2) 0%,transparent 60%)}
        .shape2{bottom:0;right:-10%;width:60vw;height:60vw;background:radial-gradient(circle,rgba(240,152,25,.15) 0%,transparent 60%)}
        .grid-pattern{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);background-size:40px 40px}
        
        /* STANDAR LOGO & NAV */
        .top-nav{padding:20px 5%;display:flex;justify-content:space-between;align-items:center;z-index:10;position:relative}
        .logo{font-size:28px;font-weight:800;color:var(--primary-orange);letter-spacing:-1px;text-shadow:0 4px 10px rgba(255,81,47,.3);display:flex;align-items:baseline;gap:8px}
        .logo span{font-size:14px;font-weight:500;color:var(--text-muted);letter-spacing:1px;text-transform:uppercase}
        .desktop-menu{display:none;gap:40px}
        .desktop-menu a{color:var(--text-muted);text-decoration:none;font-size:16px;font-weight:500;transition:.3s}
        .desktop-menu a.active,.desktop-menu a:hover{color:var(--text-light)}

        /* SEARCH & FILTER AREA */
        .search-section { padding: 0 5% 30px; z-index: 10; position: relative; display: flex; justify-content: center; gap: 10px; max-width: 550px; margin: 20px auto 0; }
        .search-box { position: relative; flex: 1; }
        .search-box input { width: 100%; background: rgba(28, 28, 36, 0.8); backdrop-filter: blur(10px); border: 1px solid var(--border-dark); border-radius: 16px; color: var(--text-light); padding: 14px 40px 14px 20px; font-size: 15px; outline: none; font-family: inherit; transition: 0.3s; box-shadow: 0 10px 20px rgba(0,0,0,0.3); box-sizing: border-box;}
        .search-box input:focus { border-color: var(--primary-orange); box-shadow: 0 10px 20px rgba(255,81,47,0.2);}
        .search-box i { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 16px; }
        
        .btn-filter { background: rgba(28, 28, 36, 0.8); backdrop-filter: blur(10px); border: 1px solid var(--border-dark); color: var(--text-light); width: 50px; border-radius: 16px; display: flex; justify-content: center; align-items: center; font-size: 18px; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(0,0,0,0.3);}
        .btn-filter:hover, .btn-filter.active { border-color: var(--primary-orange); color: var(--primary-orange); background: rgba(255,81,47,0.1); }
        .filter-indicator { position: absolute; top: -5px; right: -5px; background: var(--primary-orange); width: 12px; height: 12px; border-radius: 50%; display: none; border: 2px solid var(--bg-dark); }

        .swipe-instruction{display:flex;align-items:center;justify-content:center;gap:15px;width:100%;z-index:10;position:relative;margin-bottom:35px}
        .instruction-badge{font-size:16px;font-weight:800;text-transform:uppercase;letter-spacing:1px;display:flex;align-items:center;gap:8px;text-shadow:0 2px 10px rgba(0,0,0,.5)}
        .instruction-badge.left{color:#f87171} .instruction-badge.right{color:#4ade80}
        .drag-icon{font-size:20px;color:var(--text-light);animation:slide-hint 2s infinite;background:rgba(255,255,255,.1);padding:5px 15px;border-radius:20px}
        @keyframes slide-hint{0%,100%{transform:translateX(0)}25%{transform:translateX(-10px)}75%{transform:translateX(10px)}}
        
        .main-stage{flex:1;display:flex;flex-direction:column;align-items:center;position:relative;overflow:hidden;padding-bottom:80px;z-index:5}
        .card-stack{position:relative;width:90%;max-width:420px;height:60vh;max-height:550px;display:flex;justify-content:center;align-items:center}
        .reveal-layer{position:absolute;inset:0;border-radius:30px;border:3px dashed var(--border-dark);background:rgba(28,28,36,.5);display:flex;justify-content:center;align-items:center;z-index:1}
        .reveal-content{font-size:32px;font-weight:800;letter-spacing:2px;text-align:center;opacity:0;transition:.1s;text-shadow:0 10px 30px rgba(0,0,0,.5)}
        .reveal-content span{display:block;font-size:60px;margin-bottom:10px}
        
        .card{position:absolute;inset:0;background:var(--card-dark);border:1px solid rgba(255,255,255,.1);border-radius:30px;box-shadow:0 25px 50px -12px rgba(0,0,0,.8);display:flex;flex-direction:column;touch-action:none;cursor:grab;user-select:none;transition:transform .4s ease,opacity .4s ease;z-index:2;overflow:hidden}
        .card:active{cursor:grabbing}
        .card-visual{height:50%;background:#27272a url('https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop') center/cover;position:relative}
        .card-visual::after{content:'';position:absolute;bottom:0;left:0;width:100%;height:60%;background:linear-gradient(to top,var(--card-dark),transparent)}
        .rating-badge{position:absolute;top:20px;right:20px;background:rgba(0,0,0,.7);backdrop-filter:blur(5px);padding:8px 15px;border-radius:20px;font-weight:800;color:#f09819;border:1px solid rgba(255,255,255,.1);z-index:10}
        
        .card-content{padding:0 30px;flex:1;display:flex;flex-direction:column;position:relative;z-index:3;margin-top:-20px;pointer-events:none}
        .company-label{display:inline-block;padding:6px 12px;background:rgba(255,81,47,.15);border:1px solid rgba(255,81,47,.3);border-radius:12px;font-size:13px;font-weight:800;color:var(--primary-orange);text-transform:uppercase;letter-spacing:1px;margin-bottom:10px;width:fit-content}
        .job-title{font-size:28px;font-weight:800;line-height:1.2;margin:0 0 10px;letter-spacing:-1px;text-shadow:0 2px 10px rgba(0,0,0,.5)}
        .job-reqs{font-size:15px;color:var(--text-muted);line-height:1.5;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical}
        
        .card-actions{position:absolute;bottom:20px;width:100%;display:flex;justify-content:center;gap:30px;z-index:10}
        .btn-action{width:65px;height:65px;border-radius:50%;border:2px solid var(--border-dark);font-size:28px;cursor:pointer;background:var(--bg-dark);box-shadow:0 10px 25px rgba(0,0,0,.5);transition:.2s;pointer-events:auto;display:flex;justify-content:center;align-items:center}
        .btn-action:active{transform:scale(.9)}
        .btn-reject{color:#f87171} .btn-reject:hover{border-color:#f87171;background:rgba(248,113,113,.1)}
        .btn-accept{color:#4ade80} .btn-accept:hover{border-color:#4ade80;background:rgba(74,222,128,.1)}
        
        .swipe-out-left{transform:translateX(-150%) rotate(-20deg)!important;opacity:0}
        .swipe-out-right{transform:translateX(150%) rotate(20deg)!important;opacity:0}
        
        .profile-alert{background:rgba(255,81,47,.1);border:1px solid rgba(255,81,47,.3);color:var(--primary-orange);padding:12px 5%;display:flex;justify-content:space-between;align-items:center;font-size:14px;position:relative;z-index:10;backdrop-filter:blur(5px);display:none}
        .profile-alert a{background:var(--primary-orange);color:#fff;padding:6px 15px;border-radius:20px;text-decoration:none;font-weight:700;font-size:12px;transition:.3s;white-space:nowrap;margin-left:15px}
        .profile-alert a:hover{background:#e04425}
        
        .bottom-nav{position:fixed;bottom:0;width:100%;background:rgba(19,19,26,.95);backdrop-filter:blur(10px);border-top:1px solid var(--border-dark);display:flex;justify-content:space-around;padding:20px 0 calc(20px + env(safe-area-inset-bottom));z-index:50}
        .bottom-nav a{color:var(--text-muted);font-size:22px;transition:.3s;text-decoration:none}
        .bottom-nav a.active{color:var(--primary-orange)}

        /* MODAL FILTER CSS */
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
        
        @media (min-width:768px){
            .bottom-nav{display:none} .desktop-menu{display:flex} .main-stage{padding-bottom:0}
            .filter-modal-overlay { align-items: center; }
            .filter-modal { border-radius: 24px; border: 1px solid var(--border-dark); transform: scale(0.9); opacity: 0;}
            .filter-modal-overlay.active .filter-modal { transform: scale(1); opacity: 1;}
        }
        @media (max-width:768px){.profile-alert{flex-direction:column;text-align:center;gap:10px;padding:15px 5%}}
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>
    <div class="bg-shapes"><div class="grid-pattern"></div><div class="shape1"></div><div class="shape2"></div></div>

    <header class="top-nav">
        <div class="logo">Hiring <span>Employer</span></div>
        <div class="desktop-menu">
            <a href="{{ url('/employer/dashboard') }}" class="active">Candidates</a>
            <a href="{{ url('/employer/calendar') }}">Calendar</a>
            <a href="{{ route('messages.index') }}">Messages</a>
            <a href="{{ url('/employer/profile') }}">Profile</a>
        </div>
    </header>

    @php
        $profile = \App\Models\EmployerProfile::where('user_id', Auth::id())->first();
        // PERBAIKAN: Menggunakan document_nib sesuai penamaan di form profil Employer sebelumnya
        $isProfileComplete = $profile && $profile->document_npwp && $profile->document_nib;
    @endphp

    @if(!$isProfileComplete)
    <div class="profile-alert" id="profileAlert" style="display: none;">
        <div><i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i> <strong>Verifikasi Perusahaan!</strong> Unggah NPWP dan NIB agar Anda bisa merekrut kandidat.</div>
        <a href="{{ url('/employer/profile') }}">Lengkapi Sekarang</a>
    </div>
    @endif

    <div class="search-section">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Cari keahlian atau nama kandidat...">
            <i class="fas fa-search"></i>
        </div>
        <button class="btn-filter" id="btnOpenFilter" title="Filter Pencarian">
            <i class="fas fa-sliders-h"></i>
            <div class="filter-indicator" id="filterIndicator"></div>
        </button>
    </div>

    <main class="main-stage">
        <div class="swipe-instruction">
            <div class="instruction-badge left"><i class="fas fa-times"></i> Reject</div>
            <div class="drag-icon"><i class="fas fa-arrows-alt-h"></i> Geser Kartu</div>
            <div class="instruction-badge right">Hire <i class="fas fa-check"></i></div>
        </div>

        <div class="card-stack" id="cardContainer">
            <div class="reveal-layer"><div class="reveal-content" id="revealContent"></div></div>
            <div id="dynamicCardWrapper" style="width:100%;height:100%;position:absolute;inset:0;z-index:2"></div>
        </div>
    </main>

    <div class="filter-modal-overlay" id="filterModal">
        <div class="filter-modal">
            <div class="filter-header">
                <h3>Filter Kandidat</h3>
                <button class="btn-close-filter" id="btnCloseFilter"><i class="fas fa-times"></i></button>
            </div>
            
            <div class="filter-group">
                <label>Lokasi / Kota Domisili</label>
                <select id="filterLocation">
                    <option value="">Semua Lokasi</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Surabaya">Surabaya</option>
                    <option value="Bandung">Bandung</option>
                    <option value="Yogyakarta">Yogyakarta</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Minimal Rating (Bintang)</label>
                <select id="filterRating">
                    <option value="">Semua Rating</option>
                    <option value="4.5">⭐⭐⭐⭐ 4.5+</option>
                    <option value="4.0">⭐⭐⭐⭐ 4.0+</option>
                    <option value="3.5">⭐⭐⭐ 3.5+</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Tingkat Pendidikan</label>
                <select id="filterEducation">
                    <option value="">Semua Pendidikan</option>
                    <option value="S2">S2 / Magister</option>
                    <option value="S1">S1 / Sarjana</option>
                    <option value="D3">D3 / Diploma</option>
                    <option value="SMA">SMA / SMK / Sederajat</option>
                </select>
            </div>

            <div class="filter-actions">
                <button class="btn-reset" id="btnResetFilter">Reset</button>
                <button class="btn-apply" id="btnApplyFilter">Terapkan Filter</button>
            </div>
        </div>
    </div>

    <nav class="bottom-nav">
        <a href="{{ url('/employer/dashboard') }}" class="active"><i class="fas fa-users"></i></a>
        <a href="{{ url('/employer/calendar') }}"><i class="fas fa-calendar-alt"></i></a>
        <a href="{{ route('messages.index') }}"><i class="fas fa-comment-dots"></i></a>
        <a href="{{ url('/employer/profile') }}"><i class="fas fa-building"></i></a>
    </nav>

    <script>
        @if(session('api_token')) localStorage.setItem('api_token', '{{ session('api_token') }}'); @endif
        
        // HANYA JALANKAN JAVASCRIPT POP-UP JIKA PROFIL BELUM LENGKAP
        @if(!$isProfileComplete)
        setTimeout(() => {
            let alertBox = document.getElementById('profileAlert');
            if(alertBox) alertBox.style.display = 'flex';
        }, 1500);
        @endif

        let cands = [], dummyJobId = 1;
        const $dw = document.getElementById('dynamicCardWrapper');
        const $rc = document.getElementById('revealContent');
        const $inp = document.getElementById('searchInput');

        // Modal Filter Elements
        const filterModal = document.getElementById('filterModal');
        const btnOpenFilter = document.getElementById('btnOpenFilter');
        const btnCloseFilter = document.getElementById('btnCloseFilter');
        const btnApplyFilter = document.getElementById('btnApplyFilter');
        const btnResetFilter = document.getElementById('btnResetFilter');
        const filterIndicator = document.getElementById('filterIndicator');

        // Event Listeners untuk Modal
        btnOpenFilter.addEventListener('click', () => filterModal.classList.add('active'));
        btnCloseFilter.addEventListener('click', () => filterModal.classList.remove('active'));
        filterModal.addEventListener('click', (e) => {
            if(e.target === filterModal) filterModal.classList.remove('active');
        });

        // Event Listener Pencarian & Filter
        $inp.addEventListener('keyup', (e) => { if(e.key === 'Enter') fetchCands(); });
        
        btnApplyFilter.addEventListener('click', () => {
            filterModal.classList.remove('active');
            fetchCands();
        });

        btnResetFilter.addEventListener('click', () => {
            document.getElementById('filterLocation').value = '';
            document.getElementById('filterRating').value = '';
            document.getElementById('filterEducation').value = '';
            $inp.value = '';
            fetchCands();
        });

        // FUNGSI FETCH KANDIDAT DENGAN FILTER
        const fetchCands = async () => {
            let keyword = $inp.value;
            let location = document.getElementById('filterLocation').value;
            let rating = document.getElementById('filterRating').value;
            let education = document.getElementById('filterEducation').value;

            // Indikator aktif jika filter digunakan
            if(location || rating || education) {
                filterIndicator.style.display = 'block';
                btnOpenFilter.classList.add('active');
            } else {
                filterIndicator.style.display = 'none';
                btnOpenFilter.classList.remove('active');
            }

            // Membangun URL Query Parameters
            let queryParams = new URLSearchParams();
            if (keyword) queryParams.append('keyword', keyword);
            if (location) queryParams.append('location', location);
            if (rating) queryParams.append('rating', rating);
            if (education) queryParams.append('education', education);

            try {
                let res = await fetch(`/api/applicants/search?${queryParams.toString()}`, { 
                    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('api_token') } 
                });
                if (res.ok) { 
                    cands = (await res.json()).data; 
                    renderCard(); 
                }
            } catch (e) { console.error("API Error:", e); }
        };

        const renderCard = () => {
            $dw.innerHTML = ''; $rc.style.opacity = 0;
            if (!cands.length) return $dw.innerHTML = `<div style="text-align:center;color:var(--text-muted);margin-top:50%;font-family:inherit"><span style="font-size:60px;display:block;margin-bottom:10px">📭</span><h2 style="font-size:28px;font-weight:800;color:var(--text-light);margin:0 0 10px">Kosong!</h2><p style="font-size:15px">Tidak ada kandidat sesuai kriteria Anda.</p></div>`;
            
            let a = cands[0];
            $dw.innerHTML = `
                <div class="card" id="topCard">
                    <div class="card-visual"><div class="rating-badge">★ ${a.rating}</div></div>
                    <div class="card-content">
                        <div class="company-label">${a.education || 'Education not set'}</div>
                        <h2 class="job-title">${a.full_name || a.user.name}</h2>
                        <div class="job-reqs">${a.job_history || 'No experience detailed.'}</div>
                    </div>
                    <div class="card-actions">
                        <button class="btn-action btn-reject" onclick="act('reject',${a.user_id})"><i class="fas fa-times"></i></button>
                        <button class="btn-action btn-accept" onclick="act('like',${a.user_id})"><i class="fas fa-check"></i></button>
                    </div>
                </div>
            `;
            initDrag(document.getElementById('topCard'), a.user_id);
        };

        const act = (action, uId) => {
            let $c = document.getElementById('topCard'); if(!$c) return;
            $c.classList.add(action === 'like' ? 'swipe-out-right' : 'swipe-out-left');
            $rc.innerHTML = action === 'like' ? '<span>💚</span> HIRE' : '<span>❌</span> REJECT';
            $rc.style.color = action === 'like' ? '#4ade80' : '#f87171'; $rc.style.opacity = 1;
            cands.shift();
            fetch(`/api/swipe`, { 
                method: 'POST', 
                headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + localStorage.getItem('api_token') }, 
                body: JSON.stringify({ applicant_id: uId, job_vacancy_id: dummyJobId, action }) 
            });
            setTimeout(renderCard, 350);
        };

        const initDrag = ($c, uId) => {
            let drag = false, start = 0, cur = 0, th = 120;
            const evX = e => e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
            
            const startDrag = e => { if(e.target.closest('.btn-action')) return; drag = true; start = cur = evX(e); $c.style.transition = 'none'; };
            const moveDrag = e => {
                if(!drag) return; if(e.cancelable) e.preventDefault();
                let diff = (cur = evX(e)) - start;
                $c.style.transform = `translate(${diff}px, ${Math.abs(diff)*.05}px) rotate(${diff*.05}deg)`;
                let isLike = diff > 0;
                $rc.innerHTML = isLike ? '<span>💚</span> HIRE' : '<span>❌</span> REJECT';
                $rc.style.color = isLike ? '#4ade80' : '#f87171';
                $rc.style.opacity = Math.abs(diff) / th;
            };
            const endDrag = () => {
                if(!drag) return; drag = false; let diff = cur - start;
                $c.style.transition = 'transform .4s cubic-bezier(.175,.885,.32,1.275), opacity .4s';
                if(Math.abs(diff) > th) act(diff > 0 ? 'like' : 'reject', uId);
                else { $c.style.transform = 'none'; $rc.style.opacity = 0; }
            };

            $c.addEventListener('mousedown', startDrag); $c.addEventListener('touchstart', startDrag, {passive:false});
            window.addEventListener('mousemove', moveDrag); window.addEventListener('touchmove', moveDrag, {passive:false});
            window.addEventListener('mouseup', endDrag); window.addEventListener('touchend', endDrag);
        };

        // Initialize First Fetch
        fetchCands();
    </script>
</body>
</html>