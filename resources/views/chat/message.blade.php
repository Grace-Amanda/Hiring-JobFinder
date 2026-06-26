<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Messages</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{--bg-dark:#13131a;--card-dark:#1c1c24;--border-dark:#2d2d3a;--primary-orange:#ff512f;--gradient-orange:linear-gradient(135deg,#ff512f 0%,#f09819 100%);--text-light:#ffffff;--text-muted:#a1a1aa}
        body,html{margin:0;padding:0;background:linear-gradient(135deg,#0f0f13 0%,#1a1a24 100%);color:var(--text-light);font-family:'Plus Jakarta Sans',sans-serif;height:100vh;overflow:hidden;display:flex;flex-direction:column}
        .bg-shapes{position:fixed;inset:0;z-index:0;pointer-events:none;overflow:hidden}
        .shape1,.shape2{position:absolute;filter:blur(50px)}
        .shape1{top:-10%;left:-10%;width:50vw;height:50vw;background:radial-gradient(circle,rgba(255,81,47,.15) 0%,transparent 60%)}
        .shape2{bottom:0;right:-10%;width:60vw;height:60vw;background:radial-gradient(circle,rgba(240,152,25,.1) 0%,transparent 60%)}
        .grid-pattern{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);background-size:40px 40px}
        .top-nav{padding:20px 5%;display:flex;justify-content:space-between;align-items:center;z-index:10;position:relative}
        .logo{font-size:28px;font-weight:800;color:var(--primary-orange);letter-spacing:-1px;text-shadow:0 4px 10px rgba(255,81,47,.3);display:flex;align-items:baseline;gap:8px}
        .logo span{font-size:14px;font-weight:500;color:var(--text-muted);letter-spacing:1px;text-transform:uppercase}
        .desktop-menu{display:none;gap:40px}
        .desktop-menu a{color:var(--text-muted);text-decoration:none;font-size:16px;font-weight:500;transition:.3s}
        .desktop-menu a.active,.desktop-menu a:hover{color:var(--text-light);font-weight:700}
        .messenger-container{flex:1;display:flex;overflow:hidden;position:relative;z-index:5;margin:20px 5%;border-radius:20px;background:rgba(28,28,36,.4);backdrop-filter:blur(20px);border:1px solid var(--border-dark);box-shadow:0 25px 50px -12px rgba(0,0,0,.5)}
        .contact-list-panel{width:100%;display:flex;flex-direction:column;border-right:1px solid var(--border-dark);transition:transform .3s ease}
        .contact-header{padding:20px;border-bottom:1px solid var(--border-dark);font-weight:800;font-size:18px;letter-spacing:.5px}
        .contact-list{overflow-y:auto;flex:1;padding-bottom:80px}
        .section-label{padding:12px 20px;font-size:11px;font-weight:700;color:var(--primary-orange);text-transform:uppercase;letter-spacing:1.5px;background:rgba(0,0,0,.2)}
        .contact-item{display:flex;align-items:center;padding:15px 20px;border-bottom:1px solid rgba(255,255,255,.03);cursor:pointer;transition:.3s}
        .contact-item:hover{background:rgba(255,255,255,.05);padding-left:25px}
        .contact-avatar{width:45px;height:45px;border-radius:50%;object-fit:cover;border:2px solid var(--primary-orange);box-shadow:0 0 15px rgba(255,81,47,.3)}
        .contact-info{flex:1;margin-left:15px}
        .contact-name{font-weight:700;color:var(--text-light);font-size:15px;margin-bottom:4px}
        .contact-desc{font-size:12px;color:var(--text-muted);display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden}
        .btn-message-bubble{color:var(--primary-orange);font-size:20px;border:none;background:0 0;cursor:pointer;transition:.2s}
        .message-panel{width:100%;display:none;flex-direction:column;position:absolute;inset:0;z-index:5;background:rgba(20,20,26,.95)}
        .message-header{padding:15px 20px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--border-dark);background:rgba(0,0,0,.2)}
        .message-header-info{display:flex;align-items:center;gap:15px}
        .btn-back{color:var(--primary-orange);font-size:20px;cursor:pointer;background:0 0;border:none;display:flex;align-items:center}
        .message-header-name{font-weight:800;color:var(--text-light);font-size:16px}
        .message-header-sub{font-size:12px;color:var(--primary-orange)}
        .header-actions{display:flex;gap:10px;align-items:center}
        .btn-schedule{background:var(--gradient-orange);color:#fff;border:none;padding:8px 15px;border-radius:12px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:8px;font-size:13px;box-shadow:0 4px 15px rgba(255,81,47,.3);transition:.2s}
        .btn-schedule:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(255,81,47,.5)}
        .btn-send-slot{background:rgba(255,81,47,.15);color:var(--primary-orange);border:1px solid rgba(255,81,47,.3);padding:8px 15px;border-radius:12px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:8px;font-size:13px;transition:.2s}
        .btn-send-slot:hover{background:rgba(255,81,47,.25)}
        .messages-history{flex:1;padding:20px;overflow-y:auto;display:flex;flex-direction:column;gap:15px}
        .message-bubble{max-width:75%;padding:12px 18px;border-radius:18px;font-size:14px;line-height:1.5;position:relative;font-weight:500;word-break:break-word}
        .time-stamp{font-size:10px;opacity:.6;margin-top:6px;display:block;font-weight:400}
        .message-incoming{align-self:flex-start;background:var(--card-dark);border:1px solid var(--border-dark);color:var(--text-light);border-bottom-left-radius:4px}
        .message-outgoing{align-self:flex-end;background:var(--gradient-orange);color:#fff;border-bottom-right-radius:4px;box-shadow:0 4px 15px rgba(255,81,47,.3)}
        .message-outgoing .time-stamp{text-align:right;color:rgba(255,255,255,.8)}

        /* Bubble khusus slot interview */
        .slot-bubble{align-self:flex-start;max-width:85%;background:rgba(28,28,36,.9);border:1px solid rgba(255,81,47,.3);border-radius:18px;border-bottom-left-radius:4px;padding:16px 20px}
        .slot-bubble.outgoing{align-self:flex-end;border-bottom-left-radius:18px;border-bottom-right-radius:4px;border-color:rgba(255,81,47,.5)}
        .slot-bubble-title{font-weight:800;font-size:15px;color:var(--primary-orange);margin-bottom:6px;display:flex;align-items:center;gap:8px}
        .slot-bubble-desc{font-size:13px;color:var(--text-muted);margin-bottom:12px}
        .btn-view-slots{background:var(--gradient-orange);color:#fff;border:none;padding:10px 20px;border-radius:12px;font-weight:700;cursor:pointer;font-size:13px;width:100%;transition:.2s;display:flex;align-items:center;justify-content:center;gap:8px}
        .btn-view-slots:hover{transform:translateY(-1px);box-shadow:0 4px 15px rgba(255,81,47,.4)}
        .slot-selected-badge{background:rgba(74,222,128,.15);border:1px solid rgba(74,222,128,.3);color:#4ade80;padding:8px 14px;border-radius:10px;font-size:13px;font-weight:700;display:flex;align-items:center;gap:6px}

        /* Bubble konfirmasi slot dipilih (employer) */
        .confirmed-bubble{align-self:flex-start;max-width:85%;background:rgba(74,222,128,.08);border:1px solid rgba(74,222,128,.3);border-radius:18px;border-bottom-left-radius:4px;padding:16px 20px}
        .confirmed-bubble-title{font-weight:800;font-size:15px;color:#4ade80;margin-bottom:8px;display:flex;align-items:center;gap:8px}
        .confirmed-detail{font-size:13px;color:var(--text-muted);margin:3px 0}
        .confirmed-detail strong{color:var(--text-light)}

        .empty-chat{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--text-muted);text-align:center;padding:20px}
        .message-input-area{padding:15px 20px;border-top:1px solid var(--border-dark);display:flex;gap:12px;align-items:center;background:rgba(0,0,0,.2)}
        .message-input{flex:1;background:rgba(28,28,36,.8);border:1px solid var(--border-dark);padding:14px 20px;border-radius:25px;color:var(--text-light);outline:0;font-family:inherit;font-size:14px;transition:.3s}
        .message-input:focus{border-color:var(--primary-orange)}
        .btn-send{background:var(--gradient-orange);color:#fff;border:none;width:48px;height:48px;border-radius:50%;font-size:18px;cursor:pointer;display:flex;justify-content:center;align-items:center;box-shadow:0 4px 15px rgba(255,81,47,.4);transition:.2s;flex-shrink:0}
        .btn-send:hover{transform:scale(1.05)}
        .btn-send:disabled{opacity:.5;cursor:not-allowed;transform:none}
        .bottom-nav{position:fixed;bottom:0;width:100%;background:rgba(19,19,26,.95);backdrop-filter:blur(10px);border-top:1px solid var(--border-dark);display:flex;justify-content:space-around;padding:20px 0 calc(20px + env(safe-area-inset-bottom));z-index:50}
        .bottom-nav a{color:var(--text-muted);font-size:22px;transition:.3s}
        .bottom-nav a.active{color:var(--primary-orange)}
        .status-msg{text-align:center;padding:8px;font-size:12px;color:var(--text-muted);font-style:italic}

        /* Modal */
        .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.7);backdrop-filter:blur(5px);z-index:1000;display:none;justify-content:center;align-items:center;padding:20px}
        .modal-overlay.active{display:flex}
        .modal-box{background:#1c1c24;border:1px solid var(--border-dark);border-radius:24px;padding:30px;width:100%;max-width:540px;max-height:85vh;overflow-y:auto;box-shadow:0 25px 50px rgba(0,0,0,.5)}
        .modal-title{font-size:20px;font-weight:800;color:var(--text-light);margin:0 0 6px;letter-spacing:-.5px}
        .modal-sub{font-size:13px;color:var(--text-muted);margin:0 0 24px}
        .slot-item{background:rgba(255,255,255,.04);border:1px solid var(--border-dark);border-radius:14px;padding:14px 16px;margin-bottom:10px;cursor:pointer;transition:.2s;display:flex;align-items:center;gap:14px}
        .slot-item:hover{border-color:var(--primary-orange);background:rgba(255,81,47,.08)}
        .slot-item.selected{border-color:var(--primary-orange);background:rgba(255,81,47,.12)}
        .slot-icon{width:44px;height:44px;border-radius:12px;background:rgba(255,81,47,.15);display:flex;align-items:center;justify-content:center;color:var(--primary-orange);font-size:20px;flex-shrink:0}
        .slot-info{flex:1}
        .slot-date{font-weight:700;font-size:14px;color:var(--text-light);margin-bottom:3px}
        .slot-meta{font-size:12px;color:var(--text-muted);display:flex;gap:10px;flex-wrap:wrap}
        .slot-meta span{display:flex;align-items:center;gap:4px}
        .slot-check{width:22px;height:22px;border-radius:50%;border:2px solid var(--border-dark);display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:.2s}
        .slot-item.selected .slot-check{background:var(--primary-orange);border-color:var(--primary-orange);color:#fff}
        .add-slot-btn{background:rgba(255,255,255,.04);border:1px dashed var(--border-dark);border-radius:14px;padding:12px;width:100%;color:var(--text-muted);cursor:pointer;font-family:inherit;font-size:13px;display:flex;align-items:center;justify-content:center;gap:8px;transition:.2s;margin-top:4px}
        .add-slot-btn:hover{border-color:var(--primary-orange);color:var(--primary-orange)}
        .slot-form{background:rgba(255,255,255,.04);border:1px solid var(--border-dark);border-radius:14px;padding:16px;margin-bottom:10px}
        .slot-form label{display:block;font-size:12px;font-weight:700;color:var(--text-muted);margin-bottom:6px}
        .slot-form input,.slot-form select,.slot-form textarea{width:100%;background:rgba(0,0,0,.3);border:1px solid var(--border-dark);border-radius:10px;color:var(--text-light);padding:10px 14px;font-size:13px;outline:0;font-family:inherit;box-sizing:border-box;transition:.2s;margin-bottom:10px}
        .slot-form input:focus,.slot-form select:focus{border-color:var(--primary-orange)}
        .slot-form textarea{resize:vertical;min-height:60px}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:10px}
        .modal-actions{display:flex;gap:10px;margin-top:20px}
        .btn-modal-cancel{flex:1;padding:13px;background:transparent;border:1px solid var(--border-dark);border-radius:14px;color:var(--text-muted);cursor:pointer;font-family:inherit;font-weight:700;font-size:14px;transition:.2s}
        .btn-modal-cancel:hover{border-color:var(--text-muted)}
        .btn-modal-confirm{flex:2;padding:13px;background:var(--gradient-orange);border:none;border-radius:14px;color:#fff;cursor:pointer;font-family:inherit;font-weight:800;font-size:14px;box-shadow:0 4px 15px rgba(255,81,47,.3);transition:.2s}
        .btn-modal-confirm:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(255,81,47,.5)}
        .btn-modal-confirm:disabled{opacity:.5;cursor:not-allowed;transform:none}
        .remove-slot-btn{background:none;border:none;color:#f87171;cursor:pointer;font-size:12px;display:flex;align-items:center;gap:4px;padding:0;font-family:inherit}

        /* Pop up konfirmasi employer */
        .popup-confirm{position:fixed;bottom:30px;right:30px;background:#1c1c24;border:1px solid rgba(74,222,128,.4);border-radius:20px;padding:20px 24px;z-index:2000;max-width:340px;box-shadow:0 10px 40px rgba(0,0,0,.5);animation:slideUp .3s ease;display:none}
        .popup-confirm.active{display:block}
        @keyframes slideUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        .popup-confirm-title{font-weight:800;font-size:15px;color:#4ade80;margin-bottom:8px;display:flex;align-items:center;gap:8px}
        .popup-confirm-body{font-size:13px;color:var(--text-muted);line-height:1.5}
        .popup-confirm-body strong{color:var(--text-light)}
        .popup-close{position:absolute;top:14px;right:14px;background:none;border:none;color:var(--text-muted);cursor:pointer;font-size:16px}

        @media(min-width:768px){
            .bottom-nav{display:none}.desktop-menu{display:flex}
            .contact-list-panel{width:35%;max-width:380px;position:relative}
            .message-panel{width:65%;display:flex;position:relative;background:0 0}
            .btn-back{display:none}
        }
        @media(max-width:768px){
            .messenger-container{margin:0;border-radius:0;border:none;border-top:1px solid var(--border-dark)}
        }
    </style>
</head>
<body>
<div class="bg-shapes"><div class="grid-pattern"></div><div class="shape1"></div><div class="shape2"></div></div>

@if(auth()->user()->role === 'applicant')
<header class="top-nav">
    <div class="logo">Hiring</div>
    <div class="desktop-menu">
        <a href="{{ url('/applicant/home') }}">Discover</a>
        <a href="{{ url('/applicant/calendar') }}">Calendar</a>
        <a href="{{ route('messages.index') }}" class="active">Messages</a>
        <a href="{{ url('/applicant/profile') }}">Profile</a>
    </div>
</header>
@else
<header class="top-nav">
    <div class="logo">Hiring <span>Employer</span></div>
    <div class="desktop-menu">
        <a href="{{ url('/employer/dashboard') }}">Candidates</a>
        <a href="{{ url('/employer/calendar') }}">Calendar</a>
        <a href="{{ route('messages.index') }}" class="active">Messages</a>
        <a href="{{ url('/employer/profile') }}">Profile</a>
    </div>
</header>
@endif

<main class="messenger-container">
    <div class="contact-list-panel" id="contactListPanel">
        <div class="contact-header">Messages</div>
        <div class="contact-list" id="contactList">
            <div class="status-msg" id="contactStatus">Memuat kontak...</div>
        </div>
    </div>

    <div class="message-panel" id="messagePanel">
        <div class="empty-chat" id="emptyState">
            <span style="font-size:50px;opacity:.3">💬</span>
            <h3 style="margin:0 0 8px;color:var(--text-muted)">Pilih percakapan</h3>
            <p style="margin:0;font-size:14px">Klik nama kontak di sebelah kiri untuk memulai chat.</p>
        </div>

        <div id="activeChatArea" style="display:none;flex-direction:column;flex:1;min-height:0">
            <div class="message-header">
                <div class="message-header-info">
                    <button class="btn-back" onclick="backToList()">
                        <i class="fas fa-arrow-left" style="margin-right:8px"></i>
                    </button>
                    <img src="" alt="" class="contact-avatar" id="chatAvatar" style="width:40px;height:40px">
                    <div>
                        <div class="message-header-name" id="chatName">—</div>
                        <div class="message-header-sub" id="chatSub">—</div>
                    </div>
                </div>
                <div class="header-actions">
                    @if(auth()->user()->role === 'employer')
                    {{-- Tombol Kirim Slot Interview --}}
                    <button class="btn-send-slot" onclick="openSendSlotModal()">
                        <i class="fas fa-calendar-plus"></i> Kirim Slot
                    </button>
                    {{-- Tombol ke Kalender --}}
                    <a href="{{ url('/employer/calendar') }}" class="btn-schedule">
                        <i class="far fa-calendar-check"></i> Kalender
                    </a>
                    @endif
                </div>
            </div>

            <div class="messages-history" id="messagesBox"></div>

            <div class="message-input-area">
                <input type="text" class="message-input" id="msgInput" placeholder="Tulis pesan Anda di sini..." autocomplete="off">
                <button class="btn-send" id="btnSend">
                    <i class="fas fa-paper-plane" style="margin-left:-2px"></i>
                </button>
            </div>
        </div>
    </div>
</main>

@if(auth()->user()->role === 'applicant')
<nav class="bottom-nav">
    <a href="{{ url('/applicant/home') }}"><i class="fas fa-layer-group"></i></a>
    <a href="{{ url('/applicant/calendar') }}"><i class="fas fa-calendar-alt"></i></a>
    <a href="{{ route('messages.index') }}" class="active"><i class="fas fa-comment-dots"></i></a>
    <a href="{{ url('/applicant/profile') }}"><i class="fas fa-user"></i></a>
</nav>
@else
<nav class="bottom-nav">
    <a href="{{ url('/employer/dashboard') }}"><i class="fas fa-users"></i></a>
    <a href="{{ url('/employer/calendar') }}"><i class="fas fa-calendar-alt"></i></a>
    <a href="{{ route('messages.index') }}" class="active"><i class="fas fa-comment-dots"></i></a>
    <a href="{{ url('/employer/profile') }}"><i class="fas fa-building"></i></a>
</nav>
@endif

{{-- ═══════════════════════════════════════════════════════
     MODAL: Employer Kirim Slot Interview
═══════════════════════════════════════════════════════ --}}
@if(auth()->user()->role === 'employer')
<div class="modal-overlay" id="sendSlotModal">
    <div class="modal-box">
        <h3 class="modal-title"><i class="fas fa-calendar-plus" style="color:var(--primary-orange)"></i> Kirim Slot Interview</h3>
        <p class="modal-sub">Tambahkan satu atau beberapa pilihan jadwal untuk kandidat.</p>

        <div id="slotFormContainer"></div>

        <button class="add-slot-btn" onclick="addSlotForm()" id="addSlotBtn">
            <i class="fas fa-plus"></i> Tambah Slot Lainnya
        </button>

        <div class="modal-actions">
            <button class="btn-modal-cancel" onclick="closeSendSlotModal()">Batal</button>
            <button class="btn-modal-confirm" id="btnSendSlots" onclick="submitSlots()">
                <i class="fas fa-paper-plane"></i> Kirim Slot
            </button>
        </div>
    </div>
</div>
@endif

{{-- ═══════════════════════════════════════════════════════
     MODAL: Applicant Pilih Slot Interview
═══════════════════════════════════════════════════════ --}}
@if(auth()->user()->role === 'applicant')
<div class="modal-overlay" id="viewSlotModal">
    <div class="modal-box">
        <h3 class="modal-title"><i class="fas fa-calendar-check" style="color:var(--primary-orange)"></i> Pilih Jadwal Interview</h3>
        <p class="modal-sub">Pilih satu slot waktu yang paling sesuai dengan jadwal kamu.</p>

        <div id="slotListContainer">
            <div style="text-align:center;padding:30px;color:var(--text-muted)">
                <i class="fas fa-spinner fa-spin" style="font-size:24px;margin-bottom:10px;display:block"></i>
                Memuat slot interview...
            </div>
        </div>

        <div class="modal-actions">
            <button class="btn-modal-cancel" onclick="closeViewSlotModal()">Tutup</button>
            <button class="btn-modal-confirm" id="btnSelectSlot" onclick="confirmSelectSlot()" disabled>
                <i class="fas fa-check"></i> Konfirmasi Pilihan
            </button>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Pilihan Slot --}}
<div class="modal-overlay" id="confirmSlotModal">
    <div class="modal-box" style="max-width:420px">
        <h3 class="modal-title" style="color:#4ade80"><i class="fas fa-check-circle"></i> Konfirmasi Jadwal</h3>
        <p class="modal-sub">Apakah kamu yakin dengan pilihan jadwal berikut?</p>
        <div id="confirmSlotDetail" style="background:rgba(74,222,128,.08);border:1px solid rgba(74,222,128,.2);border-radius:14px;padding:16px;margin-bottom:16px"></div>
        <div class="modal-actions">
            <button class="btn-modal-cancel" onclick="closeConfirmSlotModal()">Kembali</button>
            <button class="btn-modal-confirm" style="background:linear-gradient(135deg,#4ade80,#22c55e)" onclick="finalSelectSlot()">
                <i class="fas fa-check"></i> Ya, Pilih Ini!
            </button>
        </div>
    </div>
</div>
@endif

{{-- Pop up Notifikasi Employer (slot dipilih applicant) --}}
@if(auth()->user()->role === 'employer')
<div class="popup-confirm" id="popupConfirm">
    <button class="popup-close" onclick="closePopup()"><i class="fas fa-times"></i></button>
    <div class="popup-confirm-title"><i class="fas fa-check-circle"></i> Slot Dipilih!</div>
    <div class="popup-confirm-body" id="popupBody">—</div>
</div>
@endif

<script>
    @if(session('api_token')) localStorage.setItem('api_token', '{{ session('api_token') }}'); @endif

    const TOKEN     = localStorage.getItem('api_token');
    const USER_ROLE = '{{ auth()->user()->role ?? "applicant" }}';
    const MY_ID     = {{ auth()->id() ?? 0 }};

    const $contactList    = document.getElementById('contactList');
    const $contactStatus  = document.getElementById('contactStatus');
    const $contactPanel   = document.getElementById('contactListPanel');
    const $messagePanel   = document.getElementById('messagePanel');
    const $emptyState     = document.getElementById('emptyState');
    const $activeChatArea = document.getElementById('activeChatArea');
    const $messagesBox    = document.getElementById('messagesBox');
    const $chatName       = document.getElementById('chatName');
    const $chatSub        = document.getElementById('chatSub');
    const $chatAvatar     = document.getElementById('chatAvatar');
    const $msgInput       = document.getElementById('msgInput');
    const $btnSend        = document.getElementById('btnSend');

    let curSwipeId       = null;
    let curApplicantId   = null; // untuk employer kirim slot
    let curJobVacancyId  = null;
    let pollTimer        = null;
    let loadedMsgIds     = new Set();
    let slotCount        = 1;
    let selectedSlotId   = null;
    let selectedSlotData = null;

    // ── Layout ──────────────────────────────────────────────────────────
    function applyLayout() {
        const isDesktop = window.innerWidth >= 768;
        if (isDesktop) {
            $contactPanel.style.display   = 'flex';
            $messagePanel.style.display   = 'flex';
            $emptyState.style.display     = curSwipeId ? 'none' : 'flex';
            $activeChatArea.style.display = curSwipeId ? 'flex' : 'none';
        } else {
            $contactPanel.style.display   = curSwipeId ? 'none' : 'flex';
            $messagePanel.style.display   = curSwipeId ? 'flex'  : 'none';
            $emptyState.style.display     = 'none';
            $activeChatArea.style.display = curSwipeId ? 'flex' : 'none';
        }
    }
    window.addEventListener('resize', applyLayout);
    applyLayout();

    function backToList() {
        curSwipeId = null;
        if (pollTimer) clearInterval(pollTimer);
        applyLayout();
    }

    // ── Kontak ──────────────────────────────────────────────────────────
    async function loadContacts() {
        try {
            const res  = await fetch('/api/connections', { headers: { 'Authorization': 'Bearer ' + TOKEN } });
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const data    = await res.json();
            renderContacts(data.matched || [], data.pending || []);
        } catch (e) {
            $contactStatus.textContent = 'Gagal memuat kontak. Coba refresh halaman.';
        }
    }

    function renderContacts(matched, pending) {
        $contactList.innerHTML = '';
        if (!matched.length && !pending.length) {
            $contactList.innerHTML = `<div style="text-align:center;padding:40px 20px;color:var(--text-muted)"><span style="font-size:50px;display:block;margin-bottom:15px;opacity:.3">💬</span><p>Belum ada koneksi.<br>Mulai swipe untuk bertemu!</p></div>`;
            return;
        }
        if (matched.length) {
            $contactList.innerHTML += `<div class="section-label">Terhubung (${matched.length})</div>`;
            matched.forEach(s => {
                const otherName    = USER_ROLE === 'applicant' ? s.employer?.name : s.applicant?.name;
                const profile      = USER_ROLE === 'applicant' ? s.employer?.employer_profile : s.applicant?.applicant_profile;
                const loc          = USER_ROLE === 'applicant' ? (profile?.location_employer || 'Lokasi Perusahaan') : (profile?.location_applicant || 'Lokasi Pelamar');
                const jobTitle     = s.job?.title || 'Lowongan';
                const applicantId  = s.applicant_id;
                const jobVacId     = s.job_vacancy_id || s.job?.id;
                const enc          = encodeURIComponent(otherName || '?');
                const safeName     = (otherName || '').replace(/'/g, "\\'");
                $contactList.innerHTML += `
                    <div class="contact-item" onclick="openChat(${s.id},'${safeName}','${loc.replace(/'/g,"\\'")}','${jobTitle.replace(/</g,'&lt;')}',${applicantId},${jobVacId})">
                        <img src="https://ui-avatars.com/api/?name=${enc}&background=1c1c24&color=ff512f&bold=true" class="contact-avatar" alt="${safeName}">
                        <div class="contact-info">
                            <div class="contact-name">${otherName || '—'}</div>
                            <div class="contact-desc">Posisi: ${jobTitle}</div>
                        </div>
                        <button class="btn-message-bubble" onclick="openChat(${s.id},'${safeName}','${loc.replace(/'/g,"\\'")}','${jobTitle.replace(/</g,'&lt;')}',${applicantId},${jobVacId});event.stopPropagation()">
                            <i class="fas fa-comment-dots"></i>
                        </button>
                    </div>`;
            });
        }
        if (pending.length) {
            $contactList.innerHTML += `<div class="section-label" style="margin-top:10px">Menunggu (${pending.length})</div>`;
            pending.forEach(s => {
                const otherName = USER_ROLE === 'applicant' ? s.employer?.name : s.applicant?.name;
                const enc = encodeURIComponent(otherName || '?');
                $contactList.innerHTML += `
                    <div class="contact-item" style="opacity:.5;cursor:default">
                        <img src="https://ui-avatars.com/api/?name=${enc}&background=2d2d3a&color=a1a1aa" class="contact-avatar" style="border-color:var(--border-dark);box-shadow:none">
                        <div class="contact-info">
                            <div class="contact-name" style="color:var(--text-muted)">${otherName || '—'}</div>
                            <div class="contact-desc">Menunggu respon</div>
                        </div>
                        <i class="fas fa-lock" style="color:var(--border-dark);font-size:16px"></i>
                    </div>`;
            });
        }
    }

    // ── Buka Chat ────────────────────────────────────────────────────────
    async function openChat(swipeId, name, loc, jobTitle, applicantId, jobVacId) {
        curSwipeId      = swipeId;
        curApplicantId  = applicantId;
        curJobVacancyId = jobVacId;
        loadedMsgIds.clear();
        $messagesBox.innerHTML = '';
        $chatName.textContent  = name;
        $chatSub.textContent   = jobTitle ? `Posisi: ${jobTitle}` : loc;
        $chatAvatar.src        = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=1c1c24&color=ff512f&bold=true`;
        applyLayout();
        if (pollTimer) clearInterval(pollTimer);
        await fetchMessages();
        pollTimer = setInterval(fetchMessages, 3000);
    }

    // ── Fetch & Render Pesan ─────────────────────────────────────────────
    async function fetchMessages() {
        if (!curSwipeId) return;
        try {
            const res = await fetch(`/api/messages/${curSwipeId}`, { headers: { 'Authorization': 'Bearer ' + TOKEN } });
            if (!res.ok) return;
            let payload = await res.json();
            const msgs = Array.isArray(payload) ? payload : (payload.data || []);
            renderMessages(msgs);
        } catch (e) {}
    }

    function renderMessages(msgs) {
        if (!Array.isArray(msgs)) return;
        let hasNew = false;
        msgs.forEach(m => {
            if (loadedMsgIds.has(m.id)) return;
            loadedMsgIds.add(m.id);
            hasNew = true;

            const isMine = m.sender_id == MY_ID;
            const time   = new Date(m.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

            // Cek apakah pesan adalah tipe khusus (JSON)
            let parsed = null;
            try { parsed = JSON.parse(m.message); } catch(e) {}

            if (parsed && parsed.type === 'interview_slots') {
                // Bubble slot interview
                renderSlotBubble(parsed, isMine, time, m.id);
            } else if (parsed && parsed.type === 'slot_selected') {
                // Bubble konfirmasi slot dipilih
                renderSlotSelectedBubble(parsed, isMine, time);
                // Jika employer, tampilkan popup notifikasi
                if (USER_ROLE === 'employer' && !isMine) {
                    showEmployerPopup(parsed);
                }
            } else {
                // Pesan biasa
                const cls  = isMine ? 'message-outgoing' : 'message-incoming';
                const safe = m.message.replace(/</g, '&lt;').replace(/>/g, '&gt;');
                $messagesBox.insertAdjacentHTML('beforeend',
                    `<div class="message-bubble ${cls}">${safe}<span class="time-stamp">${time}</span></div>`
                );
            }
        });
        if (hasNew) $messagesBox.scrollTop = $messagesBox.scrollHeight;
    }

    function renderSlotBubble(parsed, isMine, time, msgId) {
        const count = parsed.slot_count || parsed.interview_ids?.length || 0;
        if (isMine) {
            // Employer: tampilkan bubble outgoing (sudah kirim)
            $messagesBox.insertAdjacentHTML('beforeend', `
                <div class="slot-bubble outgoing">
                    <div class="slot-bubble-title"><i class="fas fa-calendar-plus"></i> Slot Interview Dikirim</div>
                    <div class="slot-bubble-desc">Kamu telah mengirim <strong>${count} pilihan jadwal</strong> interview. Menunggu kandidat memilih...</div>
                    <span class="time-stamp" style="text-align:right;display:block;opacity:.5;font-size:10px">${time}</span>
                </div>`);
        } else {
            // Applicant: tampilkan bubble incoming dengan tombol
            const ids = JSON.stringify(parsed.interview_ids);
            $messagesBox.insertAdjacentHTML('beforeend', `
                <div class="slot-bubble" id="slotBubble_${msgId}">
                    <div class="slot-bubble-title"><i class="fas fa-calendar-alt"></i> Undangan Interview!</div>
                    <div class="slot-bubble-desc">HRD telah mengirimkan <strong>${count} pilihan jadwal</strong> interview. Silakan pilih waktu yang paling sesuai.</div>
                    <button class="btn-view-slots" onclick="openViewSlotModal(${curSwipeId})">
                        <i class="fas fa-calendar-check"></i> Lihat & Pilih Jadwal
                    </button>
                    <span class="time-stamp" style="opacity:.5;font-size:10px;margin-top:8px">${time}</span>
                </div>`);
        }
    }

    function renderSlotSelectedBubble(parsed, isMine, time) {
        const dateStr = new Date(parsed.schedule_date + 'T00:00:00').toLocaleDateString('id-ID', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
        const typeIcon = parsed.interview_type === 'online' ? '🖥️' : '🏢';
        if (isMine) {
            $messagesBox.insertAdjacentHTML('beforeend', `
                <div class="slot-bubble outgoing">
                    <div class="slot-bubble-title" style="color:#4ade80"><i class="fas fa-check-circle"></i> Jadwal Dipilih!</div>
                    <div class="slot-bubble-desc">Kamu telah memilih jadwal interview berikut:</div>
                    <div style="background:rgba(74,222,128,.08);border:1px solid rgba(74,222,128,.2);border-radius:10px;padding:10px 12px;font-size:13px;color:var(--text-light)">
                        📅 <strong>${dateStr}</strong><br>
                        🕐 Pukul <strong>${parsed.schedule_time}</strong><br>
                        ${typeIcon} ${parsed.interview_type === 'online' ? 'Online' : 'Offline'} · ${parsed.location_or_link}
                    </div>
                    <span class="time-stamp" style="text-align:right;display:block;opacity:.5;font-size:10px;margin-top:6px">${time}</span>
                </div>`);
        } else {
            $messagesBox.insertAdjacentHTML('beforeend', `
                <div class="confirmed-bubble">
                    <div class="confirmed-bubble-title"><i class="fas fa-check-circle"></i> Kandidat Memilih Jadwal</div>
                    <div class="confirmed-detail">📅 <strong>${dateStr}</strong></div>
                    <div class="confirmed-detail">🕐 Pukul <strong>${parsed.schedule_time}</strong></div>
                    <div class="confirmed-detail">${typeIcon} ${parsed.interview_type === 'online' ? 'Online' : 'Offline'} · <strong>${parsed.location_or_link}</strong></div>
                    <span class="time-stamp" style="opacity:.5;font-size:10px;margin-top:6px">${time}</span>
                </div>`);
        }
    }

    // ── Pop up Notifikasi Employer ───────────────────────────────────────
    function showEmployerPopup(parsed) {
        const popup = document.getElementById('popupConfirm');
        if (!popup) return;
        const dateStr = new Date(parsed.schedule_date + 'T00:00:00').toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long' });
        document.getElementById('popupBody').innerHTML = `
            Kandidat telah memilih jadwal:<br>
            📅 <strong>${dateStr}</strong> pukul <strong>${parsed.schedule_time}</strong><br>
            ${parsed.interview_type === 'online' ? '🖥️ Online' : '🏢 Offline'}: ${parsed.location_or_link}`;
        popup.classList.add('active');
        setTimeout(() => popup.classList.remove('active'), 8000);
    }
    function closePopup() {
        document.getElementById('popupConfirm')?.classList.remove('active');
    }

    // ── Kirim Pesan Biasa ────────────────────────────────────────────────
    async function sendMessage() {
        const txt = $msgInput.value.trim();
        if (!txt || !curSwipeId) return;
        $btnSend.disabled  = true;
        $msgInput.disabled = true;
        const orig = $msgInput.value;
        $msgInput.value = '';
        try {
            const res = await fetch('/api/messages', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'Authorization': 'Bearer ' + TOKEN },
                body: JSON.stringify({ swipe_id: curSwipeId, message: txt }),
            });
            const data = await res.json();
            if (res.ok && data.status === 'success') {
                renderMessages([data.data]);
            } else {
                $msgInput.value = orig;
                alert('⚠️ ' + (data.message || 'Gagal mengirim.'));
            }
        } catch (e) {
            $msgInput.value = orig;
            alert('⚠️ Koneksi bermasalah.');
        } finally {
            $btnSend.disabled  = false;
            $msgInput.disabled = false;
            $msgInput.focus();
        }
    }
    $btnSend.addEventListener('click', sendMessage);
    $msgInput.addEventListener('keypress', e => { if (e.key === 'Enter' && !e.shiftKey) sendMessage(); });

    // ═══════════════════════════════════════════════════════════════
    // EMPLOYER: Modal Kirim Slot
    // ═══════════════════════════════════════════════════════════════
    function openSendSlotModal() {
        if (!curSwipeId) { alert('Pilih percakapan dulu!'); return; }
        slotCount = 0;
        document.getElementById('slotFormContainer').innerHTML = '';
        addSlotForm();
        document.getElementById('sendSlotModal').classList.add('active');
    }
    function closeSendSlotModal() {
        document.getElementById('sendSlotModal').classList.remove('active');
    }

    function addSlotForm() {
        if (slotCount >= 5) { alert('Maksimal 5 slot!'); return; }
        slotCount++;
        const idx = slotCount;
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('slotFormContainer').insertAdjacentHTML('beforeend', `
            <div class="slot-form" id="slotForm_${idx}">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                    <strong style="font-size:13px;color:var(--primary-orange)"><i class="fas fa-calendar"></i> Slot ${idx}</strong>
                    ${idx > 1 ? `<button class="remove-slot-btn" onclick="removeSlot(${idx})"><i class="fas fa-trash"></i> Hapus</button>` : ''}
                </div>
                <div class="form-row">
                    <div>
                        <label>Tanggal *</label>
                        <input type="date" id="slot_date_${idx}" min="${today}" required>
                    </div>
                    <div>
                        <label>Waktu *</label>
                        <input type="time" id="slot_time_${idx}" required>
                    </div>
                </div>
                <label>Tipe Interview *</label>
                <select id="slot_type_${idx}">
                    <option value="online">🖥️ Online</option>
                    <option value="offline">🏢 Offline</option>
                </select>
                <label>Link / Lokasi *</label>
                <input type="text" id="slot_loc_${idx}" placeholder="Contoh: https://meet.google.com/xxx atau Jl. Sudirman No.1" required>
                <label>Catatan (opsional)</label>
                <textarea id="slot_notes_${idx}" placeholder="Contoh: Bawa CV fisik, pakaian formal..."></textarea>
            </div>`);
        // Sembunyikan tombol tambah jika sudah 5
        document.getElementById('addSlotBtn').style.display = slotCount >= 5 ? 'none' : 'flex';
    }

    function removeSlot(idx) {
        document.getElementById(`slotForm_${idx}`)?.remove();
        slotCount--;
        document.getElementById('addSlotBtn').style.display = slotCount >= 5 ? 'none' : 'flex';
    }

    async function submitSlots() {
        const btn = document.getElementById('btnSendSlots');
        const slots = [];

        // Kumpulkan semua slot yang ada
        const forms = document.querySelectorAll('[id^="slotForm_"]');
        for (const form of forms) {
            const idx = form.id.split('_')[1];
            const date = document.getElementById(`slot_date_${idx}`)?.value;
            const time = document.getElementById(`slot_time_${idx}`)?.value;
            const type = document.getElementById(`slot_type_${idx}`)?.value;
            const loc  = document.getElementById(`slot_loc_${idx}`)?.value?.trim();
            const notes= document.getElementById(`slot_notes_${idx}`)?.value?.trim();
            if (!date || !time || !loc) { alert(`Slot ${idx}: Tanggal, waktu, dan lokasi wajib diisi!`); return; }
            slots.push({ schedule_date: date, schedule_time: time, interview_type: type, location_or_link: loc, notes: notes || null });
        }

        if (!slots.length) { alert('Tambahkan minimal 1 slot!'); return; }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

        try {
            const res = await fetch('/api/interviews/send-slots', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + TOKEN },
                body: JSON.stringify({
                    swipe_id: curSwipeId,
                    applicant_id: curApplicantId,
                    job_vacancy_id: curJobVacancyId,
                    slots: slots,
                }),
            });
            const data = await res.json();
            if (res.ok && data.status === 'success') {
                closeSendSlotModal();
                await fetchMessages();
            } else {
                alert('⚠️ ' + (data.message || 'Gagal mengirim slot.'));
            }
        } catch (e) {
            alert('⚠️ Koneksi bermasalah.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Slot';
        }
    }

    // ═══════════════════════════════════════════════════════════════
    // APPLICANT: Modal Lihat & Pilih Slot
    // ═══════════════════════════════════════════════════════════════
    async function openViewSlotModal(swipeId) {
        selectedSlotId   = null;
        selectedSlotData = null;
        document.getElementById('btnSelectSlot').disabled = true;
        document.getElementById('viewSlotModal').classList.add('active');
        document.getElementById('slotListContainer').innerHTML = `
            <div style="text-align:center;padding:30px;color:var(--text-muted)">
                <i class="fas fa-spinner fa-spin" style="font-size:24px;margin-bottom:10px;display:block"></i>
                Memuat slot interview...
            </div>`;
        try {
            const res = await fetch(`/api/interviews/slots/${swipeId}`, {
                headers: { 'Authorization': 'Bearer ' + TOKEN }
            });
            const data = await res.json();
            renderSlotList(data.data || []);
        } catch (e) {
            document.getElementById('slotListContainer').innerHTML = `<p style="color:#f87171;text-align:center">Gagal memuat slot. Coba lagi.</p>`;
        }
    }

    function renderSlotList(slots) {
        if (!slots.length) {
            document.getElementById('slotListContainer').innerHTML = `
                <div style="text-align:center;padding:30px;color:var(--text-muted)">
                    <span style="font-size:40px;display:block;margin-bottom:10px">📭</span>
                    Tidak ada slot yang tersedia saat ini.
                </div>`;
            return;
        }
        let html = '';
        slots.forEach(slot => {
            const dateStr = new Date(slot.schedule_date + 'T00:00:00').toLocaleDateString('id-ID', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
            const typeIcon = slot.interview_type === 'online' ? '🖥️' : '🏢';
            html += `
                <div class="slot-item" id="slotItem_${slot.id}" onclick="selectSlotItem(${slot.id}, '${slot.schedule_date}', '${slot.schedule_time}', '${slot.location_or_link}', '${slot.interview_type}')">
                    <div class="slot-icon">${typeIcon}</div>
                    <div class="slot-info">
                        <div class="slot-date">${dateStr}</div>
                        <div class="slot-meta">
                            <span><i class="fas fa-clock"></i> ${slot.schedule_time}</span>
                            <span><i class="fas fa-map-marker-alt"></i> ${slot.interview_type === 'online' ? 'Online' : 'Offline'}</span>
                            ${slot.notes ? `<span><i class="fas fa-sticky-note"></i> ${slot.notes}</span>` : ''}
                        </div>
                        <div style="font-size:12px;color:var(--text-muted);margin-top:4px">${slot.location_or_link}</div>
                    </div>
                    <div class="slot-check" id="slotCheck_${slot.id}"><i class="fas fa-check" style="font-size:10px"></i></div>
                </div>`;
        });
        document.getElementById('slotListContainer').innerHTML = html;
    }

    function selectSlotItem(id, date, time, loc, type) {
        // Reset semua
        document.querySelectorAll('.slot-item').forEach(el => el.classList.remove('selected'));
        selectedSlotId   = id;
        selectedSlotData = { id, schedule_date: date, schedule_time: time, location_or_link: loc, interview_type: type };
        document.getElementById(`slotItem_${id}`)?.classList.add('selected');
        document.getElementById('btnSelectSlot').disabled = false;
    }

    function closeViewSlotModal() {
        document.getElementById('viewSlotModal').classList.remove('active');
    }

    function confirmSelectSlot() {
        if (!selectedSlotData) return;
        const dateStr = new Date(selectedSlotData.schedule_date + 'T00:00:00').toLocaleDateString('id-ID', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
        const typeIcon = selectedSlotData.interview_type === 'online' ? '🖥️' : '🏢';
        document.getElementById('confirmSlotDetail').innerHTML = `
            <div style="font-size:14px;line-height:1.8">
                📅 <strong>${dateStr}</strong><br>
                🕐 Pukul <strong>${selectedSlotData.schedule_time}</strong><br>
                ${typeIcon} ${selectedSlotData.interview_type === 'online' ? 'Online' : 'Offline'}<br>
                📍 ${selectedSlotData.location_or_link}
            </div>`;
        closeViewSlotModal();
        document.getElementById('confirmSlotModal').classList.add('active');
    }

    function closeConfirmSlotModal() {
        document.getElementById('confirmSlotModal').classList.remove('active');
        document.getElementById('viewSlotModal').classList.add('active');
    }

    async function finalSelectSlot() {
        if (!selectedSlotId) return;
        try {
            const res = await fetch(`/api/interviews/${selectedSlotId}/select`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + TOKEN },
            });
            const data = await res.json();
            if (res.ok && data.status === 'success') {
                document.getElementById('confirmSlotModal').classList.remove('active');
                await fetchMessages();
            } else {
                alert('⚠️ ' + (data.message || 'Gagal memilih slot.'));
            }
        } catch (e) {
            alert('⚠️ Koneksi bermasalah.');
        }
    }

    // ── Start ────────────────────────────────────────────────────────────
    if (!TOKEN) {
        $contactStatus.textContent = '⚠️ Sesi tidak valid. Silakan logout dan login ulang.';
    } else {
        loadContacts();
    }
</script>
</body>
</html>