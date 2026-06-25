<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Swipe;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller {

    // ─────────────────────────────────────────────────────────────────────────
    // GET /api/connections
    // Mengambil semua swipe milik user yang login, dipisah jadi matched & pending.
    // FIX: Key response diubah menjadi 'matched' (sebelumnya 'matches')
    //      agar sesuai dengan yang dibaca di message.blade.php: data.matched
    // ─────────────────────────────────────────────────────────────────────────
    public function getConnections() {
        $user  = Auth::user();
        $query = Swipe::with(['applicant.applicantProfile', 'employer.employerProfile', 'job']);

        if ($user->role === 'applicant') {
            $query->where('applicant_id', $user->id);
        } else {
            $query->where('employer_id', $user->id);
        }

        $all     = $query->get();
        $matched = $all->where('status', 'matched')->values();
        $pending = $all->where('status', 'pending')->values();

        return response()->json([
            'status'  => 'success',
            'matched' => $matched,   // KEY: 'matched' bukan 'matches'
            'pending' => $pending,
        ], 200);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // GET /api/messages/{swipeId}
    // Mengambil semua pesan dalam satu percakapan berdasarkan swipe_id.
    // FIX: Response dikembalikan sebagai ARRAY LANGSUNG (bukan object {status,data})
    //      karena message.blade.php melakukan .forEach() langsung pada result.
    //      SEBELUMNYA: return response()->json(['status'=>'success', 'data'=>$messages])
    //      SESUDAH:    return response()->json($messages)  ← array langsung
    // ─────────────────────────────────────────────────────────────────────────
    public function getMessages($swipeId) {
        // Pastikan user hanya bisa baca pesan dari swipe yang melibatkan dirinya
        $user  = Auth::user();
        $swipe = Swipe::where('id', $swipeId)
            ->where(function ($q) use ($user) {
                $q->where('applicant_id', $user->id)
                  ->orWhere('employer_id', $user->id);
            })
            ->first();

        if (!$swipe) {
            return response()->json([], 200); // Swipe tidak ditemukan / bukan miliknya → array kosong
        }

        $messages = Message::with('sender')
            ->where('swipe_id', $swipeId)
            ->orderBy('created_at', 'asc')
            ->get();

        // FIX KRITIS: Kembalikan array langsung, bukan object wrapper
        // message.blade.php: renderMsgs = msgs => { msgs.forEach(m => {...}) }
        // Jika dikembalikan {status:'success', data:[...]}, maka msgs.forEach akan crash
        // karena object tidak punya .forEach()
        return response()->json($messages, 200);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /api/messages
    // Mengirim pesan baru ke percakapan.
    // Validasi tambahan: pastikan swipe melibatkan user yang login.
    // ─────────────────────────────────────────────────────────────────────────
    public function sendMessage(Request $request) {
        $request->validate([
            'swipe_id' => 'required|exists:swipes,id',
            'message'  => 'required|string|max:5000',
        ]);

        $user    = Auth::user();
        $swipeId = $request->swipe_id;

        // Keamanan: pastikan user adalah bagian dari swipe ini
        $swipe = Swipe::where('id', $swipeId)
            ->where(function ($q) use ($user) {
                $q->where('applicant_id', $user->id)
                  ->orWhere('employer_id', $user->id);
            })
            ->first();

        if (!$swipe) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Anda tidak memiliki akses ke percakapan ini.'
            ], 403);
        }

        // Hanya matched swipe yang boleh berkirim pesan
        if ($swipe->status !== 'matched') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Pesan hanya bisa dikirim setelah keduanya match.'
            ], 403);
        }

        $message = Message::create([
            'swipe_id'  => $swipeId,
            'sender_id' => $user->id,
            'message'   => $request->message,
            'is_read'   => false,
        ]);

        // Load relasi sender agar frontend bisa baca sender_id, name, dll
        $message->load('sender');

        return response()->json([
            'status' => 'success',
            'data'   => $message,
        ], 200);
    }
}