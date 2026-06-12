<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use Illuminate\Support\Facades\Auth;

class JobVacancyController extends Controller {
    
    // Menyimpan lowongan baru ke database
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'qualifications' => 'required|string',
            'is_active' => 'boolean'
        ]);

        JobVacancy::create([
            'employer_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'qualifications' => $request->qualifications,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->back()->with('success', 'Lowongan baru berhasil dibuat!');
    }

    // Memperbarui lowongan
    public function update(Request $request, $id) {
        $job = JobVacancy::findOrFail($id);

        // Validasi Keamanan Lapis 2: Cek apakah ini benar lowongan miliknya
        if ($job->employer_id !== Auth::id()) {
            abort(403, 'Akses ilegal. Ini bukan lowongan perusahaan Anda.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'qualifications' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $job->update($request->all());
        return redirect()->back()->with('success', 'Lowongan berhasil diperbarui!');
    }

    // Menghapus lowongan
    public function destroy($id) {
        $job = JobVacancy::findOrFail($id);

        if ($job->employer_id !== Auth::id()) {
            abort(403, 'Akses ilegal.');
        }

        $job->delete();
        return redirect()->back()->with('success', 'Lowongan berhasil dihapus!');
    }
}
