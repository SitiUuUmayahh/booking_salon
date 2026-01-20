@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Kelola Notifikasi Pelanggan</h1>
        <a href="{{ route('admin.notifications.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            + Buat Notifikasi Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Judul</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tipe</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Dipublikasikan</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notification)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <a href="{{ route('admin.notifications.show', $notification) }}" class="text-blue-600 hover:underline">
                                {{ $notification->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($notification->type === 'info') bg-blue-100 text-blue-800
                                @elseif($notification->type === 'warning') bg-yellow-100 text-yellow-800
                                @elseif($notification->type === 'success') bg-green-100 text-green-800
                                @elseif($notification->type === 'urgent') bg-red-100 text-red-800
                                @endif
                            ">
                                {{ ucfirst($notification->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($notification->is_active)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $notification->published_at ? $notification->published_at->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.notifications.edit', $notification) }}" class="text-blue-600 hover:underline">
                                    Edit
                                </a>
                                <form action="{{ route('admin.notifications.toggle-active', $notification) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-purple-600 hover:underline">
                                        {{ $notification->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            Tidak ada notifikasi. <a href="{{ route('admin.notifications.create') }}" class="text-blue-600 hover:underline">Buat yang baru</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
