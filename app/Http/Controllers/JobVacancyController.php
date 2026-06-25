<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\Swipe;
use Illuminate\Support\Facades\Auth;

class JobVacancyController extends Controller
{
    /**
     * Tampilkan halaman kelola lowongan milik employer yang sedang login.
     */
    public function index()
    {
        $jobs = JobVacancy::where('employer_id', Auth::id())
            ->latest()
            ->get();

        // Hitung statistik
        $totalJobs   = $jobs->count();
        $activeJobs  = $jobs->where('is_active', true)->count();
        $totalMatch  = Swipe::whereIn('job_vacancy_id', $jobs->pluck('id'))
            ->where('status', 'matched')
            ->count();

        return view('employer.jobs', compact('jobs', 'totalJobs', 'activeJobs', 'totalMatch'));
    }

    /**
     * Simpan lowongan baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'qualifications' => 'required|string',
            'is_active'      => 'nullable|boolean',
        ]);

        JobVacancy::create([
            'employer_id'    => Auth::id(),
            'title'          => $validated['title'],
            'description'    => $validated['description'],
            'qualifications' => $validated['qualifications'],
            'is_active'      => $request->boolean('is_active', true),
        ]);

        return redirect()->route('jobs.index')
            ->with('success', 'Lowongan baru berhasil dibuat!');
    }

    /**
     * Perbarui lowongan yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $job = JobVacancy::findOrFail($id);

        if ($job->employer_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Ini bukan lowongan Anda.');
        }

        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'qualifications' => 'required|string',
            'is_active'      => 'nullable|boolean',
        ]);

        $job->update([
            'title'          => $validated['title'],
            'description'    => $validated['description'],
            'qualifications' => $validated['qualifications'],
            'is_active'      => $request->boolean('is_active', true),
        ]);

        return redirect()->route('jobs.index')
            ->with('success', 'Lowongan berhasil diperbarui!');
    }

    /**
     * Toggle status aktif / nonaktif sebuah lowongan (dipanggil via form POST).
     */
    public function toggle($id)
    {
        $job = JobVacancy::findOrFail($id);

        if ($job->employer_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Ini bukan lowongan Anda.');
        }

        $job->update(['is_active' => !$job->is_active]);

        $status = $job->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('jobs.index')
            ->with('success', "Lowongan berhasil {$status}!");
    }

    /**
     * Hapus lowongan dari database.
     */
    public function destroy($id)
    {
        $job = JobVacancy::findOrFail($id);

        if ($job->employer_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Ini bukan lowongan Anda.');
        }

        $job->delete();

        return redirect()->route('jobs.index')
            ->with('success', 'Lowongan berhasil dihapus!');
    }
}