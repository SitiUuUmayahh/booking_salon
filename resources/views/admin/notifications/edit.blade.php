@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Notifikasi</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.notifications.update', $notification) }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Notifikasi</label>
            <input type="text" id="title" name="title" value="{{ old('title', $notification->title) }}" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                placeholder="Contoh: Promosi Spesial Hari Ini" required>
            @error('title')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Pesan/Informasi</label>
            <textarea id="message" name="message" rows="6"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('message') border-red-500 @enderror"
                placeholder="Tulis pesan atau informasi yang ingin disampaikan ke pelanggan..." required>{{ old('message', $notification->message) }}</textarea>
            @error('message')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Tipe Notifikasi</label>
                <select id="type" name="type"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('type') border-red-500 @enderror">
                    <option value="info" {{ old('type', $notification->type) === 'info' ? 'selected' : '' }}>ℹ️ Informasi</option>
                    <option value="success" {{ old('type', $notification->type) === 'success' ? 'selected' : '' }}>✅ Sukses</option>
                    <option value="warning" {{ old('type', $notification->type) === 'warning' ? 'selected' : '' }}>⚠️ Peringatan</option>
                    <option value="urgent" {{ old('type', $notification->type) === 'urgent' ? 'selected' : '' }}>🔴 Mendesak</option>
                </select>
                @error('type')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="is_active" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                        {{ old('is_active', $notification->is_active) ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">Aktif</label>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="published_at" class="block text-sm font-semibold text-gray-700 mb-2">Waktu Publikasi</label>
                <input type="datetime-local" id="published_at" name="published_at" 
                    value="{{ old('published_at', $notification->published_at ? $notification->published_at->format('Y-m-d\TH:i') : '') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('published_at') border-red-500 @enderror"
                    placeholder="Kosongkan untuk segera dipublikasikan">
                @error('published_at')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="expired_at" class="block text-sm font-semibold text-gray-700 mb-2">Waktu Kadaluarsa</label>
                <input type="datetime-local" id="expired_at" name="expired_at" 
                    value="{{ old('expired_at', $notification->expired_at ? $notification->expired_at->format('Y-m-d\TH:i') : '') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('expired_at') border-red-500 @enderror"
                    placeholder="Kosongkan untuk tidak ada batas waktu">
                @error('expired_at')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex gap-4 pt-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.notifications.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
