<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Swipe;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // 1. Mengambil daftar kontak di sebelah kiri
    public function getConnections()
    {
        $user = Auth::user();
        
        $query = Swipe::with(['applicant.applicantProfile', 'employer.employerProfile', 'job']);

        if ($user->role === 'applicant') {
            $query->where('applicant_id', $user->id);
        } elseif ($user->role === 'employer') {
            $query->where('employer_id', $user->id);
        }

        $swipes = $query->get();

        return response()->json([
            'matched' => $swipes->where('status', 'matched')->values(),
            'pending' => $swipes->where('status', 'pending')->values(),
        ]);
    }

    // 2. Mengambil riwayat chat
    public function getMessages($swipeId)
    {
        $messages = Message::where('swipe_id', $swipeId)
                    ->orderBy('created_at', 'asc')
                    ->get();
                    
        return response()->json($messages);
    }

    // 3. Menyimpan pesan yang diketik
    public function sendMessage(Request $request)
    {
        $request->validate([
            'swipe_id' => 'required|exists:swipes,id',
            'message' => 'required|string'
        ]);

        $message = Message::create([
            'swipe_id' => $request->swipe_id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'is_read' => false
        ]);

        return response()->json(['status' => 'success', 'data' => $message]);
    }
}