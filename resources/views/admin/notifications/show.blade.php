@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detail Notifikasi</h1>
        <a href="{{ route('admin.notifications.index') }}" class="text-gray-600 hover:text-gray-800">
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 space-y-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $notification->title }}</h2>
            <div class="flex gap-4">
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    @if($notification->type === 'info') bg-blue-100 text-blue-800
                    @elseif($notification->type === 'warning') bg-yellow-100 text-yellow-800
                    @elseif($notification->type === 'success') bg-green-100 text-green-800
                    @elseif($notification->type === 'urgent') bg-red-100 text-red-800
                    @endif
                ">
                    {{ ucfirst($notification->type) }}
                </span>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $notification->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}
                ">
                    {{ $notification->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
        </div>

        <div class="border-t pt-6">
            <h3 class="text-sm font-semibold text-gray-600 mb-2">Pesan:</h3>
            <div class="text-gray-800 whitespace-pre-wrap">{{ $notification->message }}</div>
        </div>

        <div class="grid grid-cols-2 gap-6 border-t pt-6">
            <div>
                <p class="text-sm text-gray-600 mb-1">Dibuat pada:</p>
                <p class="text-gray-800">{{ $notification->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Diperbarui pada:</p>
                <p class="text-gray-800">{{ $notification->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Dipublikasikan:</p>
                <p class="text-gray-800">{{ $notification->published_at ? $notification->published_at->format('d/m/Y H:i') : 'Segera' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Kadaluarsa:</p>
                <p class="text-gray-800">{{ $notification->expired_at ? $notification->expired_at->format('d/m/Y H:i') : 'Tidak ada batas' }}</p>
            </div>
        </div>

        <div class="flex gap-4 border-t pt-6">
            <a href="{{ route('admin.notifications.edit', $notification) }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Edit
            </a>
            <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
                    Hapus
                </button>
            </form>
            <a href="{{ route('admin.notifications.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
