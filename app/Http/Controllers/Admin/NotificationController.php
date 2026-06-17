<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    // Dipanggil via polling setiap beberapa detik
    public function poll()
    {
        $notifications = Notification::where('is_read', false)
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'count' => $notifications->count(),
            'items' => $notifications,
        ]);
    }

    public function markRead($id)
    {
        Notification::findOrFail($id)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function markAllRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function index()
    {
        $notifications = Notification::latest()->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }
}