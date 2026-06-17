@extends('layouts.admin')
@section('title', 'Notifikasi')
@section('content')
<style>
    .notif-list { display:flex; flex-direction:column; gap:12px; animation:fadeUp 0.4s ease; }
    .notif-item { background:#fff; border-radius:14px; padding:18px 22px; box-shadow:0 2px 10px rgba(0,0,0,0.05); display:flex; justify-content:space-between; align-items:center; border-left:4px solid #e8e8e8; transition:all 0.2s; }
    .notif-item.unread { border-left-color:#A8C8E8; background:#f8fbff; }
    .notif-item:hover { box-shadow:0 6px 20px rgba(0,0,0,0.1); }
    .notif-title { font-weight:600; font-size:15px; margin-bottom:4px; }
    .notif-pesan { font-size:13px; color:#888; }
    .notif-time { font-size:12px; color:#aaa; white-space:nowrap; }
    .btn-readall { padding:10px 22px; background:#A8C8E8; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
    .btn-readall:hover { background:#8BB5D9; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
</style>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <div class="page-header" style="margin-bottom:0;">
        <h1>Notifikasi</h1>
        <p>Semua aktivitas terbaru</p>
    </div>
    <button class="btn-readall" onclick="markAllRead()">✓ Tandai Semua Dibaca</button>
</div>

<div class="notif-list">
    @forelse($notifications as $notif)
    <div class="notif-item {{ !$notif->is_read ? 'unread' : '' }}" id="notif-{{ $notif->id }}">
        <div>
            <div class="notif-title">
                {{ $notif->tipe == 'pesanan' ? '🛒' : '⭐' }} {{ $notif->judul }}
                @if(!$notif->is_read)<span style="background:#A8C8E8;color:#fff;font-size:10px;padding:2px 8px;border-radius:10px;margin-left:8px;">Baru</span>@endif
            </div>
            <div class="notif-pesan">{{ $notif->pesan }}</div>
        </div>
        <div style="text-align:right;">
            <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
            @if($notif->url)
            <a href="{{ $notif->url }}" style="font-size:12px;color:#A8C8E8;text-decoration:none;">Lihat →</a>
            @endif
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:60px;color:#888;">
        <div style="font-size:48px;margin-bottom:12px;">🔔</div>
        <p>Belum ada notifikasi.</p>
    </div>
    @endforelse
</div>

<div style="margin-top:16px;">{{ $notifications->links() }}</div>

<script>
async function markAllRead() {
    await fetch('{{ route('admin.notifications.readAll') }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
    });
    document.querySelectorAll('.notif-item.unread').forEach(el => {
        el.classList.remove('unread');
        el.querySelector('span[style*="background:#A8C8E8"]')?.remove();
    });
    document.getElementById('notif-badge')?.remove();
}
</script>
@endsection