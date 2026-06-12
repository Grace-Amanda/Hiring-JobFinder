<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard - Filter Candidate</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { margin: 0; background: #f4f4f9; color: #333; font-family: sans-serif; display: flex; flex-direction: column; height: 100vh; }
        .navbar { background: #3b5998; padding: 15px; display: flex; justify-content: space-between; align-items: center; color: white;}
        
        .filter-section { padding: 20px; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .filter-section input { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; outline: none; font-size: 16px; box-sizing: border-box; }
        
        .content-area { flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; align-items: center; }
        
        /* List Kandidat */
        .candidate-card { background: white; width: 100%; max-width: 400px; border-radius: 12px; padding: 15px; margin-bottom: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: flex; gap: 15px; align-items: center; border-left: 5px solid #3b5998;}
        .avatar { width: 60px; height: 60px; background: #ddd; border-radius: 50%; object-fit: cover; }
        .candidate-info h3 { margin: 0 0 5px 0; font-size: 18px; color: #333;}
        .candidate-info p { margin: 0; font-size: 14px; color: #666; }
        .candidate-info .badge { display: inline-block; background: #e0f7fa; color: #00796b; padding: 3px 8px; border-radius: 12px; font-size: 12px; margin-top: 5px;}
        
        .btn-action { margin-left: auto; background: #ff7b00; color: white; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="logo">Hiring - Employer Portal</div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="background:none; border:none; color:white; font-size:16px; cursor:pointer;">Logout</button>
        </form>
    </header>

    <div class="filter-section">
        <input type="text" id="filterInput" placeholder="Filter skill, nama, atau universitas kandidat...">
    </div>

    <main class="content-area" id="candidateList">
        </main>

    <script>
        // Cek dan set Token Sanctum ke LocalStorage
        @if(session('api_token'))
            localStorage.setItem('api_token', '{{ session('api_token') }}');
        @endif

        const filterInput = document.getElementById('filterInput');
        const candidateList = document.getElementById('candidateList');

        // Muat semua kandidat saat pertama kali halaman dibuka
        fetchCandidates('');

        // Event listener saat employer mengetik (Fitur Filter Asinkronus)
        filterInput.addEventListener('keyup', function() {
            fetchCandidates(this.value);
        });

        async function fetchCandidates(keyword) {
            try {
                let response = await fetch(`/api/applicants/search?keyword=${keyword}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('api_token') 
                    }
                });

                if (response.ok) {
                    let result = await response.json();
                    renderCandidates(result.data); 
                }
            } catch (error) {
                console.error("Gagal melakukan fetch: ", error);
            }
        }

        // Render data JSON menjadi HTML List
        function renderCandidates(applicants) {
            candidateList.innerHTML = ''; 

            if (applicants.length === 0) {
                candidateList.innerHTML = '<p style="color:#666;">Kandidat tidak ditemukan dengan kata kunci tersebut.</p>';
                return;
            }

            applicants.forEach(applicant => {
                let name = applicant.full_name || applicant.user.name;
                let education = applicant.education || 'Pendidikan belum diisi';
                let avatarSrc = applicant.document_ktp ? `/storage/${applicant.document_ktp}` : 'https://via.placeholder.com/60';

                let cardHTML = `
                    <div class="candidate-card">
                        <img src="${avatarSrc}" alt="Avatar" class="avatar">
                        <div class="candidate-info">
                            <h3>${name}</h3>
                            <p><i class="fas fa-graduation-cap"></i> ${education}</p>
                            <span class="badge">Rating: ${applicant.rating} / 5.0</span>
                        </div>
                        <button class="btn-action" onclick="alert('Buka Chat dengan ${name}')">
                            <i class="fas fa-comment-dots"></i>
                        </button>
                    </div>
                `;
                candidateList.insertAdjacentHTML('beforeend', cardHTML);
            });
        }
    </script>
</body>
</html>