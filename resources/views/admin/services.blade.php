@extends('layouts.admin')

@section('title', 'Services - Admin')
@section('page-title', 'Services')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Kelola Layanan</h2>
    <a href="{{ route('admin.services.create') }}"
       class="bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition inline-flex items-center shadow-lg">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Tambah Layanan
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($services as $service)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            <!-- Service Image -->
            <div class="h-48 bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center overflow-hidden">
                @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}"
                         alt="{{ $service->name }}"
                         class="w-full h-full object-cover">
                @else
                    <span class="text-white text-6xl">💇</span>
                @endif
            </div>

            <!-- Service Details -->
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $service->name }}</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $service->description }}</p>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-xs text-gray-500">Harga</p>
                        <p class="text-lg font-bold text-pink-600">{{ $service->formatted_price }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Durasi</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $service->formatted_duration }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200 flex justify-between items-center">
                    <span class="text-sm text-gray-600">
                        <strong>{{ $service->bookings_count }}</strong> bookings
                    </span>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.services.edit', $service->id) }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Yakin hapus layanan ini?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
