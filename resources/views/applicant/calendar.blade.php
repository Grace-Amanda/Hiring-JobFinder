<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Interview Schedule</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-dark: #13131a; --border-dark: #2d2d3a; --primary-orange: #ff512f;
            --gradient-orange: linear-gradient(135deg, #ff512f, #f09819);
            --text-light: #fff; --text-muted: #a1a1aa;
        }
        * { box-sizing: border-box; }
        body, html {
            margin: 0; padding: 0; background: linear-gradient(135deg, #0f0f13, #1a1a24);
            color: var(--text-light); font-family: 'Plus Jakarta Sans', sans-serif;
            height: 100vh; overflow: hidden; display: flex; flex-direction: column;
        }
        
        /* Background & Shapes */
        .bg-shapes { position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; }
        .shape1, .shape2 { position: absolute; filter: blur(50px); }
        .shape1 { top: -10%; left: -10%; width: 50vw; height: 50vw; background: radial-gradient(circle, rgba(255,81,47,0.2) 0%, transparent 60%); }
        .shape2 { bottom: 0; right: -10%; width: 60vw; height: 60vw; filter: blur(60px); background: radial-gradient(circle, rgba(240,152,25,0.15) 0%, transparent 60%); }
        .grid-pattern { position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 40px 40px; }

        /* Navigations */
        .top-nav { padding: 20px 5%; display: flex; justify-content: space-between; align-items: center; z-index: 10; border-bottom: 1px solid var(--border-dark); background: rgba(19, 19, 26, 0.8); backdrop-filter: blur(10px); }
        .logo { font-size: 28px; font-weight: 800; color: var(--primary-orange); letter-spacing: -1px; text-shadow: 0 4px 10px rgba(255,81,47,0.3); }
        .desktop-menu { display: none; gap: 40px; }
        .desktop-menu a { color: var(--text-muted); text-decoration: none; font-weight: 500; transition: .3s; }
        .desktop-menu a.active, .desktop-menu a:hover { color: var(--text-light); }
        
        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: rgba(19, 19, 26, 0.95); backdrop-filter: blur(10px); border-top: 1px solid var(--border-dark); display: flex; justify-content: space-around; padding: 20px 0 calc(20px + env(safe-area-inset-bottom)); z-index: 50; }
        .bottom-nav a { color: var(--text-muted); font-size: 22px; transition: .3s; text-decoration: none; }
        .bottom-nav a.active { color: var(--primary-orange); }

        /* Main Content & Calendar */
        .main-content { flex: 1; overflow-y: auto; padding: 20px 5% 100px; display: flex; flex-direction: column; align-items: center; z-index: 5; }
        .calendar-wrapper, .schedule-card { background: rgba(28, 28, 36, 0.7); backdrop-filter: blur(12px); border: 1px solid var(--border-dark); border-radius: 24px; width: 100%; max-width: 500px; padding: 20px; box-shadow: 0 20px 40px -12px rgba(0,0,0,0.8); margin-bottom: 20px; }
        
        .cal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .cal-header h2 { margin: 0; font-size: 20px; font-weight: 800; }
        .cal-header button { background: none; border: none; color: var(--text-light); font-size: 18px; cursor: pointer; padding: 5px 12px; border-radius: 10px; transition: .2s; }
        .cal-header button:hover { background: rgba(255,255,255,0.08); color: var(--primary-orange); }
        
        .cal-weekdays, .cal-days { display: grid; grid-template-columns: repeat(7, 1fr); text-align: center; }
        .cal-weekdays { font-weight: 700; color: var(--text-muted); font-size: 12px; margin-bottom: 10px; }
        .cal-days { gap: 5px; }
        
        .day { padding: 10px 0; border-radius: 12px; cursor: pointer; font-size: 14px; font-weight: 500; transition: .2s; position: relative; }
        .day:hover { background: rgba(255,255,255,0.06); }
        .day.prev-date { color: #444; pointer-events: none; }
        .day.active { background: var(--gradient-orange); color: #fff; font-weight: 800; box-shadow: 0 5px 15px rgba(255,81,47,0.3); }
        .day.has-event::after { content: ''; position: absolute; bottom: 4px; left: 50%; transform: translateX(-50%); width: 5px; height: 5px; background: #4ade80; border-radius: 50%; }
        .day.active.has-event::after { background: #fff; }

        /* Schedule Details */
        .schedule-container { width: 100%; max-width: 500px; }
        .schedule-header { margin-bottom: 15px; border-bottom: 1px solid var(--border-dark); padding-bottom: 10px; }
        .schedule-header h3 { margin: 0; font-size: 18px; font-weight: 700; }
        .schedule-header p { margin: 5px 0 0; font-size: 13px; color: var(--text-muted); }
        
        .schedule-card { border-radius: 16px; padding: 15px; margin-bottom: 10px; display: flex; align-items: center; gap: 15px; transition: .2s; box-shadow: none; }
        .schedule-card:hover { border-color: rgba(255,81,47,0.3); }
        .schedule-time { background: rgba(255,255,255,0.05); padding: 10px 12px; border-radius: 10px; font-weight: 800; color: var(--primary-orange); text-align: center; min-width: 55px; }
        .schedule-info { flex: 1; }
        .schedule-info h4 { margin: 0 0 5px; font-size: 16px; }
        .schedule-info p { margin: 0; font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 5px; }
        
        .btn-book, .btn-booked { padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; white-space: nowrap; }
        .btn-book { background: rgba(74, 222, 128, 0.12); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.3); cursor: pointer; transition: .2s; }
        .btn-book:hover { background: #4ade80; color: var(--bg-dark); }
        .btn-booked { background: transparent; color: var(--text-muted); border: 1px dashed var(--border-dark); cursor: not-allowed; }
        
        .empty-state { text-align: center; color: var(--text-muted); padding: 30px 20px; font-size: 14px; background: rgba(28, 28, 36, 0.5); border-radius: 16px; border: 1px dashed var(--border-dark); }

        @media (min-width: 768px) {
            .bottom-nav { display: none; }
            .desktop-menu { display: flex; }
            .main-content { padding-bottom: 40px; }
        }
    </style>
</head>
<body>
    <div class="bg-shapes">
        <div class="grid-pattern"></div>
        <div class="shape1"></div><div class="shape2"></div>
    </div>

    <header class="top-nav">
        <div class="logo">Hiring</div>
        <div class="desktop-menu">
            <a href="{{ url('/applicant/home') }}">Discover</a>
            <a href="{{ url('/applicant/calendar') }}" class="active">Calendar</a>
            <a href="{{ route('messages.index') }}">Messages</a>
            <a href="{{ url('/applicant/profile') }}">Profile</a>
        </div>
    </header>

    <div class="main-content">
        <div class="calendar-wrapper">
            <div class="cal-header">
                <button onclick="chgMo(-1)"><i class="fas fa-chevron-left"></i></button>
                <h2 id="monthYearDisplay"></h2>
                <button onclick="chgMo(1)"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="cal-weekdays">
                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
            </div>
            <div class="cal-days" id="calendarDays"></div>
        </div>

        <div class="schedule-container">
            <div class="schedule-header">
                <h3 id="selectedDateDisplay">Available Slots</h3>
                <p>Pilih jam wawancara yang ditawarkan oleh perusahaan.</p>
            </div>
            <div id="scheduleList"></div>
        </div>
    </div>

    <nav class="bottom-nav">
        <a href="{{ url('/applicant/home') }}"><i class="fas fa-layer-group"></i></a>
        <a href="{{ url('/applicant/calendar') }}" class="active"><i class="fas fa-calendar-alt"></i></a>
        <a href="{{ route('messages.index') }}"><i class="fas fa-comment-dots"></i></a>
        <a href="{{ url('/applicant/profile') }}"><i class="fas fa-user"></i></a>
    </nav>

    <script>
        // ── Token Sanctum dari session Laravel ──────────────────────────
        const API_TOKEN = '{{ session('api_token') }}';

        const $ = id => document.getElementById(id);
        const mos = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        const fmt = (y, m, d) => `${y}-${String(m).padStart(2,'0')}-${String(d).padStart(2,'0')}`;

        let slots = {};   // ← kosong dulu, diisi dari API
        let cur = new Date(), selDate = "";

        // ── FETCH jadwal dari database ───────────────────────────────────
        async function loadInterviews() {
            try {
                const res = await fetch('/api/interviews', {
                    headers: {
                        'Authorization': 'Bearer ' + API_TOKEN,
                        'Accept': 'application/json'
                    }
                });

                if (!res.ok) {
                    console.error('Gagal fetch interviews, status:', res.status);
                    return;
                }

                const json = await res.json();
                slots = {};

                (json.data || []).forEach(iv => {
                    if (iv.status === 'cancelled') return; // skip yang dibatalkan

                    const dateKey = iv.schedule_date; // "YYYY-MM-DD"
                    if (!slots[dateKey]) slots[dateKey] = [];

                    // Ambil nama perusahaan dari relasi employer.employerProfile
                    const companyName = iv.employer?.employer_profile?.company_name
                                    ?? iv.employer?.employerProfile?.company_name
                                    ?? 'Perusahaan';

                    slots[dateKey].push({
                        id:        iv.id,
                        time:      iv.schedule_time.substring(0, 5), // "HH:MM"
                        company:   companyName,
                        type:      iv.interview_type === 'online' ? 'Online (Video Call)' : 'On-site (Office)',
                        location:  iv.location_or_link,
                        status:    iv.status,
                        // scheduled = sudah dipilih/dikonfirmasi employer, confirmed = applicant sudah konfirmasi
                        is_booked: iv.status === 'confirmed'
                    });
                });

                renderCal();
                sel(fmt(cur.getFullYear(), cur.getMonth() + 1, cur.getDate()));

            } catch (e) {
                console.error('Error load interviews:', e);
            }
        }

        // ── Render kalender ──────────────────────────────────────────────
        const renderCal = () => {
            let y = cur.getFullYear(), m = cur.getMonth();
            $('monthYearDisplay').innerText = `${mos[m]} ${y}`;
            let fd = new Date(y, m, 1).getDay(), ld = new Date(y, m+1, 0).getDate(), pd = new Date(y, m, 0).getDate();
            let h = "";
            for (let x = fd; x > 0; x--) h += `<div class="day prev-date">${pd - x + 1}</div>`;
            for (let i = 1; i <= ld; i++) {
                let d = fmt(y, m+1, i), c = `${d === selDate ? 'active' : ''} ${slots[d]?.length ? 'has-event' : ''}`;
                h += `<div class="day ${c}" onclick="sel('${d}')">${i}</div>`;
            }
            $('calendarDays').innerHTML = h;
        };

        const chgMo = dir => { cur.setMonth(cur.getMonth() + dir); renderCal(); };

        // ── Tampilkan daftar jadwal per tanggal ──────────────────────────
        const sel = d => {
            selDate = d; renderCal();
            let dt = new Date(d + 'T00:00:00'); // fix timezone shift
            $('selectedDateDisplay').innerText = `${dt.getDate()} ${mos[dt.getMonth()]} ${dt.getFullYear()}`;

            let s = slots[d] || [];
            if (!s.length) {
                $('scheduleList').innerHTML = `<div class="empty-state">
                    <i class="fas fa-inbox" style="font-size:30px; margin-bottom:10px; opacity:0.5"></i><br>
                    Tidak ada jadwal wawancara di tanggal ini.
                </div>`;
                return;
            }

            $('scheduleList').innerHTML = s.sort((a, b) => a.time.localeCompare(b.time)).map(x => `
                <div class="schedule-card">
                    <div class="schedule-time">${x.time}</div>
                    <div class="schedule-info">
                        <h4>${x.company}</h4>
                        <p><i class="fas ${x.type.includes('Online') ? 'fa-video' : 'fa-building'}"></i> ${x.type}</p>
                        <p style="margin-top:4px; color:#6b7280; font-size:11px;">
                            <i class="fas fa-map-marker-alt"></i> ${x.location}
                        </p>
                    </div>
                    <div>
                        ${x.is_booked
                            ? `<button class="btn-booked" disabled><i class="fas fa-check"></i> Confirmed</button>`
                            : x.status === 'scheduled'
                                ? `<button class="btn-book" onclick="book(${x.id})">Konfirmasi</button>`
                                : `<span style="color:#a1a1aa; font-size:12px;">${x.status}</span>`
                        }
                    </div>
                </div>
            `).join('');
        };

        // ── Konfirmasi kehadiran → POST /api/interviews/{id}/confirm ─────
        const book = async (id) => {
            if (!confirm('Konfirmasi kehadiran untuk jadwal interview ini?')) return;

            try {
                const res = await fetch(`/api/interviews/${id}/confirm`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + API_TOKEN,
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? ''
                    }
                });

                const json = await res.json();

                if (res.ok && json.status === 'success') {
                    alert('✅ Interview berhasil dikonfirmasi!');
                    await loadInterviews(); // reload dari DB supaya status terupdate
                } else {
                    alert('Gagal konfirmasi: ' + (json.message ?? 'Unknown error'));
                }
            } catch (e) {
                alert('Terjadi error: ' + e.message);
            }
        };

        // ── Mulai load saat halaman siap ────────────────────────────────
        loadInterviews();
    </script>
</body>
</html>