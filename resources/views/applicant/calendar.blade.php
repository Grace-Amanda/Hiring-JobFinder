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
            --bg-dark: #13131a; --card-dark: #1c1c24; --border-dark: #2d2d3a;
            --primary-orange: #ff512f; --gradient-orange: linear-gradient(135deg, #ff512f 0%, #f09819 100%);
            --text-light: #ffffff; --text-muted: #a1a1aa;
        }
        
        body, html { margin: 0; padding: 0; background: var(--bg-dark); color: var(--text-light); font-family: 'Plus Jakarta Sans', sans-serif; height: 100vh; display: flex; flex-direction: column; overflow: hidden; }

        .top-nav { padding: 20px 5%; display: flex; justify-content: space-between; align-items: center; z-index: 10; border-bottom: 1px solid var(--border-dark); background: rgba(19, 19, 26, 0.9); backdrop-filter: blur(10px);}
        .logo { font-size: 24px; font-weight: 800; color: var(--primary-orange); letter-spacing: -1px; }
        .desktop-menu { display: none; gap: 40px; }
        .desktop-menu a { color: var(--text-muted); text-decoration: none; font-size: 16px; font-weight: 500; transition: color 0.3s; }
        .desktop-menu a.active, .desktop-menu a:hover { color: var(--text-light); }

        .main-content { flex: 1; overflow-y: auto; padding: 20px 5%; padding-bottom: 100px; display: flex; flex-direction: column; align-items: center; }
        .calendar-wrapper { width: 100%; max-width: 500px; background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 20px; padding: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); margin-bottom: 20px; }
        
        .cal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .cal-header h2 { margin: 0; font-size: 20px; font-weight: 800; }
        .cal-header button { background: transparent; border: none; color: var(--text-light); font-size: 18px; cursor: pointer; padding: 5px 10px; border-radius: 8px; transition: 0.2s; }
        .cal-header button:hover { background: rgba(255,255,255,0.1); color: var(--primary-orange); }

        .cal-weekdays { display: grid; grid-template-columns: repeat(7, 1fr); text-align: center; font-weight: 700; color: var(--text-muted); font-size: 12px; margin-bottom: 10px; }
        .cal-days { display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; }
        .day { padding: 10px 0; text-align: center; border-radius: 12px; cursor: pointer; font-size: 14px; font-weight: 500; transition: 0.2s; position: relative; }
        .day:hover { background: rgba(255,255,255,0.05); }
        .day.prev-date, .day.next-date { color: #444; }
        .day.active { background: var(--gradient-orange); color: white; font-weight: 800; box-shadow: 0 5px 15px rgba(255,81,47,0.3); }
        .day.has-event::after { content: ''; position: absolute; bottom: 4px; left: 50%; transform: translateX(-50%); width: 4px; height: 4px; background: #4ade80; border-radius: 50%; }
        .day.active.has-event::after { background: white; }

        /* Slots Available */
        .schedule-container { width: 100%; max-width: 500px; }
        .schedule-header { margin-bottom: 15px; border-bottom: 1px solid var(--border-dark); padding-bottom: 10px;}
        .schedule-header h3 { margin: 0; font-size: 18px; font-weight: 700; }
        .schedule-header p { margin: 5px 0 0 0; font-size: 13px; color: var(--text-muted); }

        .schedule-card { background: var(--card-dark); border: 1px solid var(--border-dark); border-radius: 16px; padding: 15px; margin-bottom: 10px; display: flex; align-items: center; gap: 15px; }
        .schedule-time { background: rgba(255,255,255,0.05); padding: 10px; border-radius: 10px; font-weight: 800; color: var(--primary-orange); text-align: center; min-width: 50px; }
        .schedule-info { flex: 1; }
        .schedule-info h4 { margin: 0 0 5px 0; font-size: 16px; }
        .schedule-info p { margin: 0; font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 5px;}
        
        .btn-book { background: rgba(74, 222, 128, 0.1); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.3); padding: 8px 15px; border-radius: 20px; font-size: 13px; font-weight: 700; cursor: pointer; transition: 0.2s; white-space: nowrap;}
        .btn-book:hover { background: #4ade80; color: var(--bg-dark); }
        .btn-booked { background: transparent; color: var(--text-muted); border: 1px dashed var(--border-dark); padding: 8px 15px; border-radius: 20px; font-size: 13px; font-weight: 700; cursor: not-allowed; }

        .empty-state { text-align: center; color: var(--text-muted); padding: 30px; font-size: 14px; background: var(--card-dark); border-radius: 16px; border: 1px dashed var(--border-dark);}

        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: rgba(19, 19, 26, 0.95); backdrop-filter: blur(10px); border-top: 1px solid var(--border-dark); display: flex; justify-content: space-around; padding: 20px 0 calc(20px + env(safe-area-inset-bottom)); z-index: 50; }
        .bottom-nav a { color: var(--text-muted); font-size: 22px; transition: 0.3s; }
        .bottom-nav a.active { color: var(--primary-orange); }
        @media (min-width: 768px) { .bottom-nav { display: none; } .desktop-menu { display: flex; } }
    </style>
</head>
<body>

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
                <button onclick="changeMonth(-1)"><i class="fas fa-chevron-left"></i></button>
                <h2 id="monthYearDisplay">September 2026</h2>
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
                <h3 id="selectedDateDisplay">Available Slots</h3>
                <p>Pilih jam wawancara yang ditawarkan oleh perusahaan.</p>
            </div>
            <div id="scheduleList">
                </div>
        </div>
    </div>

    <nav class="bottom-nav">
        <a href="{{ url('/applicant/home') }}"><i class="fas fa-layer-group"></i></a>
        <a href="{{ url('/applicant/calendar') }}" class="active"><i class="fas fa-calendar-alt"></i></a>
        <a href="{{ route('messages.index') }}"><i class="fas fa-comment-dots"></i></a>
        <a href="{{ url('/applicant/profile') }}"><i class="fas fa-user"></i></a>
    </nav>

    <script>
        // Simulasi slot yang disediakan Employer
        let slots = {
            "2026-06-25": [
                { id: 101, time: "10:00", company: "PT Teknologi Jaya", type: "Online (Google Meet)", is_booked: false },
                { id: 102, time: "14:00", company: "PT Teknologi Jaya", type: "On-site (Office)", is_booked: true }
            ]
        };

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
                let hasEventClass = slots[checkDateStr] && slots[checkDateStr].length > 0 ? 'has-event' : '';
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
                listDiv.innerHTML = `<div class="empty-state">Pilih tanggal untuk melihat ketersediaan jadwal.</div>`;
                return;
            }

            let dailySlots = slots[selectedDateStr] || [];

            if (dailySlots.length === 0) {
                listDiv.innerHTML = `<div class="empty-state"><i class="fas fa-inbox" style="font-size:30px; margin-bottom:10px; opacity:0.5"></i><br>Tidak ada tawaran wawancara di tanggal ini.</div>`;
                return;
            }

            dailySlots.sort((a, b) => a.time.localeCompare(b.time));

            let html = "";
            dailySlots.forEach(slot => {
                let btnHTML = slot.is_booked 
                    ? `<button class="btn-booked" disabled><i class="fas fa-check"></i> Booked</button>`
                    : `<button class="btn-book" onclick="bookSlot(${slot.id})">Book Slot</button>`;

                html += `
                    <div class="schedule-card">
                        <div class="schedule-time">${slot.time}</div>
                        <div class="schedule-info">
                            <h4>${slot.company}</h4>
                            <p><i class="fas fa-video"></i> ${slot.type}</p>
                        </div>
                        <div>
                            ${btnHTML}
                        </div>
                    </div>
                `;
            });
            listDiv.innerHTML = html;
        }

        function bookSlot(id) {
            if(confirm('Konfirmasi booking jadwal ini?')) {
                // Cari dan ubah status
                let slot = slots[selectedDateStr].find(s => s.id === id);
                if(slot) slot.is_booked = true;
                renderSchedules();
                alert('Jadwal berhasil dibooking!');
            }
        }

        let todayStr = `${currentDate.getFullYear()}-${String(currentDate.getMonth()+1).padStart(2,'0')}-${String(currentDate.getDate()).padStart(2,'0')}`;
        selectDate(todayStr);

    </script>
</body>
</html>