<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Cari Lowongan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Desain Responsive Mobile-First sesuai spesifikasi */
        body { margin: 0; background: #1a1a1a; color: white; font-family: sans-serif; display: flex; flex-direction: column; height: 100vh; overflow: hidden;}
        .navbar { background: #ff512f; padding: 15px; display: flex; justify-content: space-between; align-items: center;}
        
        .search-container { padding: 15px; text-align: center; }
        .search-container input { width: 80%; padding: 10px; border-radius: 20px; border: none; outline: none; }
        
        /* Container Tumpukan Kartu */
        .content-area { flex: 1; display: flex; justify-content: center; align-items: center; position: relative; }
        .swipe-container { position: relative; width: 320px; height: 480px; }
        
        /* Kartu Lowongan */
        .card { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #fff; border-radius: 20px; border: 4px solid #ff7b00; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.6); transition: transform 0.3s ease; touch-action: none; user-select: none; }
        .card-img { width: 100%; height: 50%; object-fit: cover; background: #ddd; }
        .card-info { padding: 15px; background: #222; height: 50%; color: white; }
        
        .card-actions { position: absolute; bottom: 20px; width: 100%; display: flex; justify-content: center; gap: 40px; z-index: 3; }
        .card-actions button { width: 60px; height: 60px; border-radius: 50%; border: none; font-size: 28px; color: white; cursor: pointer; box-shadow: 0 5px 15px rgba(0,0,0,0.5); }
        .btn-remove { background-color: #ff5252; }
        .btn-like { background-color: #4caf50; }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="logo">Hiring</div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="background:none; border:none; color:white; font-size:16px;">Logout</button>
        </form>
    </header>

    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Cari posisi pekerjaan...">
    </div>

    <main class="content-area">
        <div class="swipe-container" id="cardContainer">
            </div>
    </main>

    <script>
        // 1. PINDAHKAN TOKEN DARI LARAVEL KE BROWSER LOCALSTORAGE
        // Ini memastikan token tidak hilang saat pindah halaman
        @if(session('api_token'))
            localStorage.setItem('api_token', '{{ session('api_token') }}');
        @endif

        // 2. LOGIKA FETCH API (Kode Anda)
        const searchInput = document.getElementById('searchInput');
        const cardContainer = document.getElementById('cardContainer');

        // Panggil API sekali saat halaman pertama kali dimuat agar kartu tidak kosong
        fetchJobs('');

        searchInput.addEventListener('keyup', function() {
            fetchJobs(this.value);
        });

        async function fetchJobs(keyword) {
            try {
                let response = await fetch(`/api/jobs/search?keyword=${keyword}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('api_token') 
                    }
                });

                if (response.ok) {
                    let result = await response.json();
                    renderCards(result.data); 
                } else {
                    console.error("Gagal mengambil data. Akses ditolak.");
                }
            } catch (error) {
                console.error("Terjadi kesalahan jaringan: ", error);
            }
        }

        // 3. LOGIKA MERENDER HTML DARI JSON
        function renderCards(jobs) {
            cardContainer.innerHTML = ''; 

            if (jobs.length === 0) {
                cardContainer.innerHTML = '<p style="color:white; text-align:center;">Tidak ada lowongan ditemukan.</p>';
                return;
            }

            // Loop untuk membuat tumpukan kartu
            jobs.forEach(job => {
                // Mencegah error jika employer_profile belum diisi
                let companyName = job.employer.employer_profile ? job.employer.employer_profile.company_name : job.employer.name;

                let cardHTML = `
                    <div class="card" data-job-id="${job.id}" data-employer-id="${job.employer_id}">
                        <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?q=80&w=400&auto=format&fit=crop" class="card-img" alt="Company Img">
                        <div class="card-info">
                            <h3>${companyName}</h3>
                            <p style="color:#ff7b00; font-weight:bold;">${job.title}</p>
                            <p style="font-size:14px; color:#ccc; margin-top:5px;">${job.qualifications}</p>
                        </div>
                        <div class="card-actions">
                            <button class="btn-remove" onclick="swipeAction(${job.employer_id}, ${job.id}, 'reject')"><i class="fas fa-times"></i></button>
                            <button class="btn-like" onclick="swipeAction(${job.employer_id}, ${job.id}, 'like')"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                `;
                cardContainer.insertAdjacentHTML('afterbegin', cardHTML); // Ditumpuk ke atas
            });
        }

        // 4. LOGIKA TOMBOL SWIPE MENGGUNAKAN API KEDUA
        async function swipeAction(employerId, jobId, action) {
            try {
                let response = await fetch(`/api/swipe`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('api_token') 
                    },
                    body: JSON.stringify({
                        employer_id: employerId,
                        job_vacancy_id: jobId,
                        action: action
                    })
                });

                if (response.ok) {
                    let result = await response.json();
                    console.log(`Berhasil: ${result.match_status}`);
                    // Re-render kartu (Menghapus kartu yang baru di-swipe)
                    // (Logika animasi swipe CSS bisa diintegrasikan di sini nantinya)
                    fetchJobs(searchInput.value); 
                }
            } catch (error) {
                console.error("Error swipe: ", error);
            }
        }
    </script>
</body>
</html>