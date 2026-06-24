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
        :root{--bg-dark:#13131a;--card-dark:#1c1c24;--border-dark:#2d2d3a;--primary-orange:#ff512f;--gradient-orange:linear-gradient(135deg,#ff512f,#f09819);--text-light:#fff;--text-muted:#a1a1aa}
        *{box-sizing:border-box}
        body,html{margin:0;padding:0;background:linear-gradient(135deg,#0f0f13,#1a1a24);color:var(--text-light);font-family:'Plus Jakarta Sans',sans-serif;height:100vh;overflow:hidden;display:flex;flex-direction:column}
        .bg-shapes{position:fixed;inset:0;z-index:0;pointer-events:none;overflow:hidden}
        .shape1,.shape2{position:absolute;filter:blur(50px)}
        .shape1{top:-10%;left:-10%;width:50vw;height:50vw;background:radial-gradient(circle,rgba(255,81,47,.2) 0%,transparent 60%)}
        .shape2{bottom:0;right:-10%;width:60vw;height:60vw;filter:blur(60px);background:radial-gradient(circle,rgba(240,152,25,.15) 0%,transparent 60%)}
        .grid-pattern{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);background-size:40px 40px}
        
        /* STANDAR LOGO & NAV */
        .top-nav{padding:20px 5%;display:flex;justify-content:space-between;align-items:center;z-index:10;border-bottom:1px solid var(--border-dark);background:rgba(19,19,26,.8);backdrop-filter:blur(10px)}
        .logo{font-size:28px;font-weight:800;color:var(--primary-orange);letter-spacing:-1px;text-shadow:0 4px 10px rgba(255,81,47,.3);display:flex;align-items:baseline;gap:8px}
        .logo span{font-size:14px;font-weight:500;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px}
        .desktop-menu{display:none;gap:40px}
        .desktop-menu a{color:var(--text-muted);text-decoration:none;font-size:16px;font-weight:500;transition:.3s}
        .desktop-menu a.active,.desktop-menu a:hover{color:var(--text-light)}
        
        .main-content{flex:1;overflow-y:auto;padding:20px 5% 100px;display:flex;flex-direction:column;align-items:center;position:relative;z-index:5}
        
        .calendar-wrapper{width:100%;max-width:500px;background:rgba(28,28,36,.7);backdrop-filter:blur(12px);border:1px solid var(--border-dark);border-radius:24px;padding:25px;box-shadow:0 20px 40px -12px rgba(0,0,0,.8);margin-bottom:25px}
        .cal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
        .cal-header h2{margin:0;font-size:20px;font-weight:800;letter-spacing:-.5px}
        .cal-header button{background:rgba(255,255,255,.05);border:1px solid var(--border-dark);color:var(--text-light);font-size:14px;cursor:pointer;padding:8px 14px;border-radius:10px;transition:.2s}
        .cal-header button:hover{background:rgba(255,255,255,.1);color:var(--primary-orange)}
        .cal-weekdays,.cal-days{display:grid;grid-template-columns:repeat(7,1fr);text-align:center}
        .cal-weekdays{font-weight:800;color:var(--text-muted);font-size:12px;margin-bottom:15px;text-transform:uppercase;letter-spacing:.5px}
        .cal-days{gap:8px}
        .day{padding:12px 0;border-radius:12px;cursor:pointer;font-size:15px;font-weight:600;transition:.2s;position:relative;color:var(--text-light)}
        .day:hover{background:rgba(255,255,255,.06)}
        .day.prev-date{color:#444;pointer-events:none}
        .day.active{background:var(--gradient-orange);color:#fff;font-weight:800;box-shadow:0 5px 15px rgba(255,81,47,.3)}
        .day.has-event::after{content:'';position:absolute;bottom:5px;left:50%;transform:translateX(-50%);width:5px;height:5px;background:var(--primary-orange);border-radius:50%}
        .day.active.has-event::after{background:#fff}
        
        .schedule-container{width:100%;max-width:500px}
        .schedule-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;border-bottom:1px solid var(--border-dark);padding-bottom:15px}
        .schedule-header h3{margin:0;font-size:18px;font-weight:800}
        .btn-add{background:rgba(255,81,47,.12);color:var(--primary-orange);border:1px solid rgba(255,81,47,.3);padding:8px 16px;border-radius:20px;font-size:13px;font-weight:700;cursor:pointer;transition:.2s;display:flex;align-items:center;gap:6px}
        .btn-add:hover{background:var(--primary-orange);color:#fff;border-color:var(--primary-orange)}
        
        .schedule-card{background:rgba(28,28,36,.6);backdrop-filter:blur(8px);border:1px solid var(--border-dark);border-radius:16px;padding:15px;margin-bottom:12px;display:flex;align-items:center;gap:15px;transition:transform .2s,border-color .2s}
        .schedule-card:hover{transform:translateY(-2px);border-color:rgba(255,81,47,.3)}
        .schedule-time{background:rgba(255,255,255,.05);padding:10px;border-radius:12px;font-weight:800;color:var(--primary-orange);text-align:center;min-width:70px;font-size:14px;line-height:1.4}
        .schedule-info{flex:1}
        .schedule-info h4{margin:0 0 5px;font-size:15px;font-weight:800}
        .schedule-info p{margin:0 0 3px;font-size:13px;color:var(--text-muted);display:flex;align-items:center;gap:8px}
        .schedule-info p i{width:16px;text-align:center}
        
        .schedule-actions{display:flex;gap:8px;}
        .schedule-actions button{font-size:13px;cursor:pointer;transition:.2s;padding:8px 10px;border-radius:10px;}
        .btn-edit{background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.2);color:#3b82f6;}
        .btn-edit:hover{background:#3b82f6;color:#fff;border-color:#3b82f6;}
        .btn-delete{background:rgba(248,113,113,.1);border:1px solid rgba(248,113,113,.2);color:#f87171;}
        .btn-delete:hover{background:#f87171;color:#fff;border-color:#f87171;}
        
        .empty-state{text-align:center;color:var(--text-muted);padding:40px 20px;font-size:14px;background:rgba(28,28,36,.5);backdrop-filter:blur(4px);border-radius:20px;border:1px dashed var(--border-dark)}
        
        .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.8);backdrop-filter:blur(5px);z-index:100;display:none;justify-content:center;align-items:center}
        .modal-content{background:var(--bg-dark);border:1px solid var(--border-dark);border-radius:24px;width:90%;max-width:400px;padding:30px;box-shadow:0 20px 40px rgba(0,0,0,.8)}
        .modal-content h3{margin:0 0 20px;font-size:22px;font-weight:800}
        .form-row{display:flex;gap:15px;}
        .form-group{margin-bottom:15px;flex:1;}
        .form-group label{display:block;font-size:11px;color:var(--text-muted);margin-bottom:8px;font-weight:800;text-transform:uppercase;letter-spacing:1px}
        .form-group input,.form-group select{width:100%;background:var(--card-dark);border:1px solid var(--border-dark);color:#fff;padding:12px 15px;border-radius:12px;font-family:inherit;font-size:14px;outline:0;transition:.3s}
        .form-group input:focus,.form-group select:focus{border-color:var(--primary-orange);box-shadow:0 0 0 3px rgba(255,81,47,.2)}
        .form-group select option{background:var(--bg-dark);color:#fff}
        .time-input-wrapper{position:relative}
        .time-input-wrapper i{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none}
        .modal-actions{display:flex;gap:10px;margin-top:25px}
        .btn-cancel,.btn-save{flex:1;padding:12px;border-radius:12px;cursor:pointer;font-weight:800;font-family:inherit;transition:.2s;font-size:14px;}
        .btn-cancel{background:0 0;border:1px solid var(--border-dark);color:#fff}
        .btn-cancel:hover{background:rgba(255,255,255,.05)}
        .btn-save{background:var(--gradient-orange);border:0;color:#fff;box-shadow:0 10px 20px rgba(255,81,47,.3)}
        .btn-save:hover{transform:scale(1.02);box-shadow:0 15px 30px rgba(255,81,47,.4)}
        
        .bottom-nav{position:fixed;bottom:0;width:100%;background:rgba(19,19,26,.95);backdrop-filter:blur(10px);border-top:1px solid var(--border-dark);display:flex;justify-content:space-around;padding:20px 0 calc(20px + env(safe-area-inset-bottom));z-index:50}
        .bottom-nav a{color:var(--text-muted);font-size:22px;transition:.3s;text-decoration:none}
        .bottom-nav a.active{color:var(--primary-orange)}
        @media (min-width:768px){.bottom-nav{display:none}.desktop-menu{display:flex}.main-content{padding-bottom:40px}}
    </style>
</head>
<body>
    <div class="bg-shapes"><div class="grid-pattern"></div><div class="shape1"></div><div class="shape2"></div></div>

    <header class="top-nav">
        <div class="logo">Hiring <span>Employer</span></div>
        <div class="desktop-menu">
            <a href="{{ url('/employer/dashboard') }}">Candidates</a>
            <a href="{{ url('/employer/calendar') }}" class="active">Calendar</a>
            <a href="{{ route('messages.index') }}">Messages</a>
            <a href="{{ url('/employer/profile') }}">Profile</a>
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
                <h3 id="selectedDateDisplay">Schedules</h3>
                <button class="btn-add" onclick="openModal()"><i class="fas fa-plus"></i> Buat Jadwal</button>
            </div>
            <div id="scheduleList"></div>
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal-overlay" id="scheduleModal">
        <div class="modal-content">
            <h3 id="modalTitle">Buat Jadwal Baru</h3>
            <input type="hidden" id="inputId">
            
            <div class="form-group">
                <label>Tanggal</label>
                <div class="time-input-wrapper">
                    <input type="text" id="inputDate" placeholder="Pilih tanggal..." required autocomplete="off">
                    <i class="far fa-calendar"></i>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Jam Mulai</label>
                    <div class="time-input-wrapper">
                        <input type="text" id="inputStartTime" placeholder="12:00" required autocomplete="off">
                        <i class="far fa-clock"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label>Jam Akhir</label>
                    <div class="time-input-wrapper">
                        <input type="text" id="inputEndTime" placeholder="13:00" required autocomplete="off">
                        <i class="far fa-clock"></i>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Status / Metode</label>
                <select id="inputType">
                    <option value="Online (Google Meet)">💻 Online (Google Meet)</option>
                    <option value="Online (Zoom)">💻 Online (Zoom)</option>
                    <option value="On-site (Offline)">🏢 On-site (Offline)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Keterangan / Tautan / Lokasi</label>
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
        <a href="{{ url('/employer/calendar') }}" class="active"><i class="fas fa-calendar-alt"></i></a>
        <a href="{{ route('messages.index') }}"><i class="fas fa-comment-dots"></i></a>
        <a href="{{ url('/employer/profile') }}"><i class="fas fa-building"></i></a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const $ = id => document.getElementById(id);
        const fmt = (y,m,d) => `${y}-${String(m).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        const mos = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        
        // Inisialisasi Flatpickr
        let fpDate = flatpickr("#inputDate", { dateFormat: "Y-m-d", disableMobile: "true" });
        flatpickr("#inputStartTime, #inputEndTime", { enableTime: true, noCalendar: true, dateFormat: "H:i", time_24hr: true, disableMobile: "true" });

        // Format data: Ditambahkan startTime dan endTime, candidate dihapus (diubah menjadi slot jadwal)
        let schedules = { 
            "2026-06-25": [
                { id: 1, startTime: "10:00", endTime: "11:00", type: "Online (Google Meet)", location: "meet.google.com/abc" }
            ] 
        };
        let cur = new Date(), selDate = "";

        const renderCal = () => {
            let y = cur.getFullYear(), m = cur.getMonth(); $('monthYearDisplay').innerText = `${mos[m]} ${y}`;
            let fd = new Date(y, m, 1).getDay(), ld = new Date(y, m + 1, 0).getDate(), pd = new Date(y, m, 0).getDate(), h = "";
            for (let x = fd; x > 0; x--) h += `<div class="day prev-date">${pd - x + 1}</div>`;
            for (let i = 1; i <= ld; i++) {
                let d = fmt(y, m + 1, i), c = `${d === selDate ? 'active' : ''} ${schedules[d]?.length ? 'has-event' : ''}`;
                h += `<div class="day ${c}" onclick="sel('${d}')">${i}</div>`;
            }
            $('calendarDays').innerHTML = h;
        };

        const chgMo = dir => { cur.setMonth(cur.getMonth() + dir); renderCal(); };

        const sel = d => {
            selDate = d; renderCal();
            let dt = new Date(d); $('selectedDateDisplay').innerText = `${dt.getDate()} ${mos[dt.getMonth()]} ${dt.getFullYear()}`;
            let s = schedules[d] || [];
            
            if (!s.length) return $('scheduleList').innerHTML = `<div class="empty-state"><i class="fas fa-folder-open" style="font-size:40px;margin-bottom:15px;opacity:0.3"></i><br>Belum ada slot jadwal di tanggal ini.</div>`;
            
            $('scheduleList').innerHTML = s.sort((a,b)=>a.startTime.localeCompare(b.startTime)).map(x=>`
                <div class="schedule-card">
                    <div class="schedule-time">${x.startTime} <br> <span style="font-size:11px;opacity:0.7">${x.endTime}</span></div>
                    <div class="schedule-info">
                        <h4>Slot Tersedia</h4>
                        <p><i class="fas fa-video"></i> ${x.type}</p>
                        <p><i class="fas fa-map-marker-alt"></i> ${x.location || '-'}</p>
                    </div>
                    <div class="schedule-actions">
                        <button class="btn-edit" onclick="editSchedule(${x.id}, '${d}')" title="Edit Jadwal"><i class="fas fa-edit"></i></button>
                        <button class="btn-delete" onclick="del(${x.id})" title="Hapus Jadwal"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
            `).join('');
        };

        const checkOverlap = (date, start, end, excludeId = null) => {
            if (!schedules[date]) return false;
            return schedules[date].some(s => {
                if (s.id == excludeId) return false;
                // Logika overlap: Mulai lebih awal dari akhir acara B, dan Berakhir setelah mulai acara B
                return (start < s.endTime && end > s.startTime);
            });
        };

        const openModal = () => {
            if (!selDate) return alert("Pilih tanggal di kalender terlebih dahulu!");
            $('modalTitle').innerText = "Buat Jadwal Baru";
            $('inputId').value = "";
            fpDate.setDate(selDate);
            $('inputStartTime').value = "";
            $('inputEndTime').value = "";
            $('inputType').value = "Online (Google Meet)";
            $('inputLocation').value = "";
            $('scheduleModal').style.display = 'flex';
        };

        const editSchedule = (id, date) => {
            let schedule = schedules[date].find(s => s.id === id);
            if(!schedule) return;
            
            $('modalTitle').innerText = "Edit Jadwal";
            $('inputId').value = schedule.id;
            fpDate.setDate(date);
            
            $('inputStartTime').value = schedule.startTime;
            $('inputEndTime').value = schedule.endTime;
            $('inputType').value = schedule.type;
            $('inputLocation').value = schedule.location;
            
            // Menyimpan asal tanggal (jika tanggal diubah saat edit)
            $('scheduleModal').dataset.oldDate = date; 
            $('scheduleModal').style.display = 'flex';
        };

        const closeModal = () => $('scheduleModal').style.display = 'none';

        const saveSchedule = () => {
            let id = $('inputId').value;
            let d = $('inputDate').value;
            let st = $('inputStartTime').value;
            let et = $('inputEndTime').value;
            let ty = $('inputType').value;
            let loc = $('inputLocation').value;
            
            if(!d || !st || !et) return alert("Wajib mengisi Tanggal, Jam Mulai, dan Jam Akhir!");
            if(st >= et) return alert("Jam Akhir harus lebih besar dari Jam Mulai!");

            // Validasi slot waktu bertabrakan
            if (checkOverlap(d, st, et, id || null)) {
                return alert("Gagal menyimpan! Terdapat jadwal lain pada rentang waktu tersebut (Jam tidak tersedia).");
            }

            if (id) {
                // Proses Edit
                let oldD = $('scheduleModal').dataset.oldDate;
                
                // Hapus dari array tanggal lama jika tanggal diubah
                if (oldD !== d) {
                    schedules[oldD] = schedules[oldD].filter(s => s.id != id);
                } else {
                    // Jika tanggal sama, cukup filter yang sedang diedit agar di push ulang nanti
                    schedules[d] = schedules[d].filter(s => s.id != id);
                }
                
                (schedules[d] ||= []).push({ id: Number(id), startTime: st, endTime: et, type: ty, location: loc });
            } else {
                // Proses Tambah Baru
                (schedules[d] ||= []).push({ id: Date.now(), startTime: st, endTime: et, type: ty, location: loc });
            }

            closeModal();
            selDate = d; // Pindah otomatis ke tanggal yang baru diedit/dibuat
            renderCal(); 
            sel(selDate);
        };

        const del = id => { 
            if(confirm('Hapus jadwal ini?')) { 
                schedules[selDate] = schedules[selDate].filter(s => s.id !== id); 
                renderCal(); 
                sel(selDate); 
            } 
        };

        // Initialize First Render
        sel(fmt(cur.getFullYear(), cur.getMonth() + 1, cur.getDate()));
    </script>
</body>
</html>