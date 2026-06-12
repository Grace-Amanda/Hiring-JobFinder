<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Swipe;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller {

    // 1. Mengambil Daftar Kontak (Pending & Matches)
    public function getConnections() {
        $user = Auth::user();
        
        // Logika query fleksibel berdasarkan Role
        $query = Swipe::with(['applicant.applicantProfile', 'employer.employerProfile', 'job']);
        
        if ($user->role === 'applicant') {
            $query->where('applicant_id', $user->id);
        } else if ($user->role === 'employer') {
            $query->where('employer_id', $user->id);
        }

        $allConnections = $query->get();

        // Memisahkan data menggunakan Collection filter bawaan Laravel
        $matches = $allConnections->where('status', 'matched')->values();
        $pending = $allConnections->where('status', 'pending')->values();

        return response()->json([
            'status' => 'success',
            'matches' => $matches,
            'pending' => $pending
        ], 200);
    }

    // 2. Mengambil Isi Percakapan Berdasarkan ID Swipe
    public function getMessages($swipeId) {
        $messages = Message::with('sender')
            ->where('swipe_id', $swipeId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['status' => 'success', 'data' => $messages], 200);
    }

    // 3. Mengirim Pesan Baru (Asinkronus)
    public function sendMessage(Request $request) {
        $request->validate([
            'swipe_id' => 'required|exists:swipes,id',
            'message' => 'required|string'
        ]);

        $message = Message::create([
            'swipe_id' => $request->swipe_id,
            'sender_id' => Auth::id(),
            'message' => $request->message
        ]);

        return response()->json(['status' => 'success', 'data' => $message], 200);
    }
}
