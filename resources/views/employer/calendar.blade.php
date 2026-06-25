<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Manage Schedule</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

    <style>
        :root {
            --bg-dark: #13131a; --card-dark: #1c1c24; --border-dark: #2d2d3a;
            --primary-orange: #ff512f; --gradient-orange: linear-gradient(135deg, #ff512f 0%, #f09819 100%);
            --text-light: #ffffff; --text-muted: #a1a1aa;
        }
        
        body, html { margin: 0; padding: 0; background: var(--bg-dark); color: var(--text-light); font-family: 'Plus Jakarta Sans', sans-serif; height: 100vh; display: flex; flex-direction: column; overflow: hidden; }

        body { background: linear-gradient(135deg, #0f0f13 0%, #1a1a24 100%); }

        .top-nav { padding: 20px 5%; display: flex; justify-content: space-between; align-items: center; z-index: 10; border-bottom: 1px solid var(--border-dark); background: rgba(19, 19, 26, 0.9); backdrop-filter: blur(10px);}
        .logo { font-size: 24px; font-weight: 800; color: var(--primary-orange); letter-spacing: -1px; display:flex; align-items: baseline; gap: 8px;}
        .logo span { font-size: 12px; font-weight: 500; color: var(--text-muted); text-transform: uppercase;}
        .desktop-menu { display: none; gap: 40px; }
        .desktop-menu a { color: var(--text-muted); text-decoration: none; font-size: 16px; font-weight: 500; transition: color 0.3s; }
        .desktop-menu a.active, .desktop-menu a:hover { color: var(--text-light); }

        .main-content { flex: 1; overflow-y: auto; padding: 20px 5%; padding-bottom: 100px; display: flex; flex-direction: column; align-items: center; }
        
        .calendar-wrapper { width: 100%; max-width: 500px; background: rgba(28,28,36,0.8); backdrop-filter: blur(10px); border: 1px solid var(--border-dark); border-radius: 24px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); margin-bottom: 25px; }
        .cal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .cal-header h2 { margin: 0; font-size: 20px; font-weight: 800; letter-spacing: -0.5px;}
        .cal-header button { background: rgba(255,255,255,0.05); border: 1px solid var(--border-dark); color: var(--text-light); font-size: 14px; cursor: pointer; padding: 8px 12px; border-radius: 10px; transition: 0.2s; }
        .cal-header button:hover { background: rgba(255,255,255,0.1); color: var(--primary-orange); }

        .cal-weekdays { display: grid; grid-template-columns: repeat(7, 1fr); text-align: center; font-weight: 800; color: var(--text-muted); font-size: 12px; margin-bottom: 15px; text-transform: uppercase;}
        .cal-days { display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; }
        .day { padding: 12px 0; text-align: center; border-radius: 12px; cursor: pointer; font-size: 15px; font-weight: 600; transition: 0.2s; position: relative; }
        .day:hover { background: rgba(255,255,255,0.05); }
        .day.prev-date, .day.next-date { color: #444; }
        .day.active { background: var(--gradient-orange); color: white; font-weight: 800; box-shadow: 0 5px 15px rgba(255,81,47,0.3); }
        .day.has-event::after { content: ''; position: absolute; bottom: 5px; left: 50%; transform: translateX(-50%); width: 5px; height: 5px; background: var(--primary-orange); border-radius: 50%; }
        .day.active.has-event::after { background: white; }

        .schedule-container { width: 100%; max-width: 500px; }
        .schedule-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border-dark); padding-bottom: 15px;}
        .schedule-header h3 { margin: 0; font-size: 18px; font-weight: 800; }
        .btn-add { background: rgba(255,81,47,0.1); color: var(--primary-orange); border: 1px solid rgba(255,81,47,0.3); padding: 8px 15px; border-radius: 20px; font-size: 13px; font-weight: 700; cursor: pointer; transition: 0.2s; }
        .btn-add:hover { background: var(--primary-orange); color: white; }

        .schedule-card { background: rgba(28,28,36,0.6); border: 1px solid var(--border-dark); border-radius: 16px; padding: 15px; margin-bottom: 12px; display: flex; align-items: center; gap: 15px; transition: transform 0.2s;}
        .schedule-card:hover { transform: translateY(-2px); border-color: rgba(255,81,47,0.3); }
        .schedule-time { background: rgba(255,255,255,0.05); padding: 12px; border-radius: 12px; font-weight: 800; color: var(--primary-orange); text-align: center; min-width: 55px; font-size: 15px;}
        .schedule-info { flex: 1; }
        .schedule-info h4 { margin: 0 0 5px 0; font-size: 16px; font-weight: 800;}
        .schedule-info p { margin: 0; font-size: 13px; color: var(--text-muted); display: flex; align-items: center; gap: 8px; margin-bottom: 3px;}
        .schedule-actions button { background: rgba(248, 113, 113, 0.1); border: 1px solid rgba(248, 113, 113, 0.2); color: #f87171; font-size: 14px; cursor: pointer; transition: 0.2s; padding: 10px 12px; border-radius: 10px;}
        .schedule-actions button:hover { background: #f87171; color: white; }

        .empty-state { text-align: center; color: var(--text-muted); padding: 40px 20px; font-size: 14px; background: rgba(28,28,36,0.5); border-radius: 20px; border: 1px dashed var(--border-dark);}

        /* MODAL TAMBAH JADWAL */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 100; display: none; justify-content: center; align-items: center; }
        .modal-content { background: var(--bg-dark); border: 1px solid var(--border-dark); border-radius: 24px; width: 90%; max-width: 400px; padding: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.8); }
        .modal-content h3 { margin: 0 0 20px 0; font-size: 22px; font-weight: 800;}
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 8px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;}
        .form-group input, .form-group select { width: 100%; background: var(--card-dark); border: 1px solid var(--border-dark); color: white; padding: 14px 15px; border-radius: 12px; font-family: inherit; font-size: 15px; box-sizing: border-box; outline: none; transition: 0.3s;}
        .form-group input:focus, .form-group select:focus { border-color: var(--primary-orange); }
        .form-group select option { background: var(--bg-dark); color: white; }
        
        /* Modifikasi untuk Input Waktu */
        .time-input-wrapper { position: relative; }
        .time-input-wrapper i { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;}
        
        .modal-actions { display: flex; gap: 10px; margin-top: 25px; }
        .btn-cancel { flex: 1; padding: 14px; background: transparent; border: 1px solid var(--border-dark); color: white; border-radius: 12px; cursor: pointer; font-weight: 700; font-family: inherit; transition: 0.2s;}
        .btn-cancel:hover { background: rgba(255,255,255,0.05); }
        .btn-save { flex: 1; padding: 14px; background: var(--gradient-orange); border: none; color: white; border-radius: 12px; cursor: pointer; font-weight: 800; font-family: inherit; box-shadow: 0 10px 20px rgba(255,81,47,0.3);}

        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: rgba(19, 19, 26, 0.95); backdrop-filter: blur(10px); border-top: 1px solid var(--border-dark); display: flex; justify-content: space-around; padding: 20px 0 calc(20px + env(safe-area-inset-bottom)); z-index: 50; }
        .bottom-nav a { color: var(--text-muted); font-size: 22px; transition: 0.3s; }
        .bottom-nav a.active { color: var(--primary-orange); }
        @media (min-width: 768px) { .bottom-nav { display: none; } .desktop-menu { display: flex; } }
    </style>
</head>
<body>

    <header class="top-nav">
        <div class="logo">Hiring <span>Employer</span></div>
        <div class="desktop-menu">
            <a href="{{ url('/employer/dashboard') }}">Candidates</a>
            <a href="{{ url('/employer/jobs') }}">Jobs</a> <a href="{{ url('/employer/calendar') }}" class="active">Calendar</a>
            <a href="{{ route('messages.index') }}">Messages</a>
            <a href="{{ url('/employer/profile') }}">Profile</a>
        </div>
    </header>

    <div class="main-content">
        <div class="calendar-wrapper">
            <div class="cal-header">
                <button onclick="changeMonth(-1)"><i class="fas fa-chevron-left"></i></button>
                <h2 id="monthYearDisplay">Month 2026</h2>
                <button onclick="changeMonth(1)"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="cal-weekdays">
                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
            </div>
            <div class="cal-days" id="calendarDays">
            </div>
        </div>

        <div class="schedule-container">
            <div class="schedule-header">
                <h3 id="selectedDateDisplay">Schedules</h3>
                <button class="btn-add" onclick="openModal()"><i class="fas fa-plus"></i> Buat Jadwal</button>
            </div>
            <div id="scheduleList">
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="scheduleModal">
        <div class="modal-content">
            <h3>Buat Jadwal Baru</h3>
            <div class="form-group">
                <label>Jam Wawancara</label>
                <div class="time-input-wrapper">
                    <input type="text" id="inputTime" placeholder="Pilih jam..." required autocomplete="off">
                    <i class="far fa-clock"></i>
                </div>
            </div>
            <div class="form-group">
                <label>Nama Kandidat</label>
                <select id="inputCandidate" required>
                <option value="" disabled selected>-- Pilih Kandidat Matched --</option>
                @foreach($matches as $match)
                    @if($match->applicant)
                        @php
                            $candidateName = $match->applicant->applicantProfile->full_name ?? $match->applicant->name;
                        @endphp
                        <option value="{{ $match->applicant_id }}">{{ $candidateName }}</option>
                    @endif
                @endforeach
            </select>
            </div>
            <div class="form-group">
                <label>Metode Wawancara</label>
                <select id="inputType">
                    <option value="Online (Google Meet)">💻 Online (Google Meet)</option>
                    <option value="On-site (Office)">🏢 On-site (Office)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Lokasi / Tautan Panggilan</label>
                <input type="text" id="inputLocation" placeholder="Link Meet / Alamat Lengkap Kantor">
            </div>
            <div class="modal-actions">
                <button class="btn-cancel" onclick="closeModal()">Batal</button>
                <button class="btn-save" onclick="saveSchedule()">Simpan</button>
            </div>
        </div>
    </div>

    <nav class="bottom-nav">
        <a href="{{ url('/employer/dashboard') }}"><i class="fas fa-users"></i></a>
        <a href="{{ url('/employer/jobs') }}"><i class="fas fa-briefcase"></i></a> <a href="{{ url('/employer/calendar') }}" class="active"><i class="fas fa-calendar-alt"></i></a>
        <a href="{{ route('messages.index') }}"><i class="fas fa-comment-dots"></i></a>
        <a href="{{ url('/employer/profile') }}"><i class="fas fa-building"></i></a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Inisialisasi Time Picker Modern
        flatpickr("#inputTime", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            disableMobile: "true" 
        });

        // 1. Ambil token API penjelajah yang tersimpan saat login
        const apiToken = localStorage.getItem('api_token');

        // 2. Inisialisasi schedules menjadi objek kosong (Data asli akan ditarik dari database)
        let schedules = {};

        // 3. Fungsi Baru: Memuat semua jadwal interview resmi dari database server MySQL
        async function loadSchedulesFromServer() {
            try {
                let response = await fetch('/api/interviews', {
                    headers: { 'Authorization': 'Bearer ' + apiToken }
                });
                if (response.ok) {
                    let result = await response.json();
                    // Sinkronkan data terformat dari database server ke kalender browser
                    schedules = result.data || {};
                    renderCalendar();
                    renderSchedules();
                }
            } catch (error) {
                console.error("Gagal menarik data jadwal dari server:", error);
            }
        }

        let currentDate = new Date(); 
        let selectedDateStr = "";
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            document.getElementById('monthYearDisplay').innerText = `${monthNames[month]} ${year}`;
            
            const firstDayIndex = new Date(year, month, 1).getDay();
            const lastDay = new Date(year, month + 1, 0).getDate();
            const prevLastDay = new Date(year, month, 0).getDate();
            
            let daysHTML = "";

            for (let x = firstDayIndex; x > 0; x--) {
                daysHTML += `<div class="day prev-date">${prevLastDay - x + 1}</div>`;
            }

            for (let i = 1; i <= lastDay; i++) {
                let checkDateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                let hasEventClass = schedules[checkDateStr] && schedules[checkDateStr].length > 0 ? 'has-event' : '';
                let activeClass = checkDateStr === selectedDateStr ? 'active' : '';

                daysHTML += `<div class="day ${activeClass} ${hasEventClass}" onclick="selectDate('${checkDateStr}')">${i}</div>`;
            }

            document.getElementById('calendarDays').innerHTML = daysHTML;
        }

        function changeMonth(direction) {
            currentDate.setMonth(currentDate.getMonth() + direction);
            renderCalendar();
        }

        function selectDate(dateStr) {
            selectedDateStr = dateStr;
            renderCalendar(); 
            
            const d = new Date(dateStr);
            document.getElementById('selectedDateDisplay').innerText = `${d.getDate()} ${monthNames[d.getMonth()]} ${d.getFullYear()}`;
            
            renderSchedules();
        }

        function renderSchedules() {
            const listDiv = document.getElementById('scheduleList');
            if(!selectedDateStr) {
                listDiv.innerHTML = `<div class="empty-state">Pilih tanggal pada kalender untuk melihat jadwal.</div>`;
                return;
            }

            let dailySchedules = schedules[selectedDateStr] || [];

            if (dailySchedules.length === 0) {
                listDiv.innerHTML = `<div class="empty-state"><i class="fas fa-folder-open" style="font-size:40px; margin-bottom:15px; opacity:0.3"></i><br>Belum ada jadwal di tanggal ini.</div>`;
                return;
            }

            dailySchedules.sort((a, b) => a.time.localeCompare(b.time));

            let html = "";
            dailySchedules.forEach(sch => {
                html += `
                    <div class="schedule-card">
                        <div class="schedule-time">${sch.time}</div>
                        <div class="schedule-info">
                            <h4>${sch.candidate}</h4>
                            <p><i class="fas fa-video"></i> ${sch.type}</p>
                            <p><i class="fas fa-map-marker-alt"></i> ${sch.location}</p>
                        </div>
                        <div class="schedule-actions">
                            <button onclick="deleteSchedule(${sch.id})" title="Hapus Jadwal"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                `;
            });
            listDiv.innerHTML = html;
        }

        function openModal() {
            if(!selectedDateStr) { alert("Pilih tanggal di kalender terlebih dahulu!"); return; }
            document.getElementById('scheduleModal').style.display = 'flex';
        }
        function closeModal() { document.getElementById('scheduleModal').style.display = 'none'; }

        // 4. PERBAIKAN FUNGSI SIMPAN: Menyimpan permanen ke Database via API
        async function saveSchedule() {
            let time = document.getElementById('inputTime').value;
            let selectEl = document.getElementById('inputCandidate');
            let applicantId = selectEl.value;
            let candidateName = selectEl.options[selectEl.selectedIndex].text;
            let type = document.getElementById('inputType').value;
            let loc = document.getElementById('inputLocation').value;

            if(!time || !applicantId) { alert("Wajib mengisi Jam dan Nama Kandidat!"); return; }

            try {
                let response = await fetch('/api/interviews', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + apiToken
                    },
                    body: JSON.stringify({
                        schedule_date: selectedDateStr,
                        schedule_time: time,
                        applicant_id: applicantId,
                        candidate_name: candidateName,
                        interview_type: type,
                        location_or_link: loc
                    })
                });

                if (response.ok) {
                    closeModal();
                    await loadSchedulesFromServer(); // Muat ulang data terbaru dari database
                    
                    // Bersihkan form input
                    document.getElementById('inputTime').value = '';
                    document.getElementById('inputCandidate').value = '';
                    document.getElementById('inputLocation').value = '';
                } else {
                    alert("Gagal menyimpan jadwal ke server database.");
                }
            } catch (error) {
                console.error("Error saving schedule:", error);
            }
        }

        // 5. PERBAIKAN FUNGSI HAPUS: Menghapus record fisik di Server Database
        async function deleteSchedule(id) {
            if(confirm('Apakah Anda yakin ingin membatalkan dan menghapus jadwal ini?')) {
                try {
                    let response = await fetch(`/api/interviews/${id}`, {
                        method: 'DELETE',
                        headers: { 'Authorization': 'Bearer ' + apiToken }
                    });
                    if (response.ok) {
                        await loadSchedulesFromServer(); // Muat ulang visual kalender resmi
                    } else {
                        alert("Gagal menghapus jadwal di server.");
                    }
                } catch (error) {
                    console.error("Error deleting schedule:", error);
                }
            }
        }

        // Ambil penanggalan hari ini secara otomatis saat pertama buka halaman
        let todayStr = `${currentDate.getFullYear()}-${String(currentDate.getMonth()+1).padStart(2,'0')}-${String(currentDate.getDate()).padStart(2,'0')}`;
        selectDate(todayStr);

        // Jalankan sinkronisasi data server saat halaman terbuka
        loadSchedulesFromServer();
    </script>
</body>
</html>