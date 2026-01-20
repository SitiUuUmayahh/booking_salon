@php
    $notifications = \App\Models\AdminNotification::active()->get();
@endphp

@if($notifications->isNotEmpty())
    <div class="space-y-3 mb-6">
        @foreach($notifications as $notification)
            <div class="p-4 rounded-lg border-l-4 
                @if($notification->type === 'info')
                    bg-blue-50 border-blue-500 text-blue-800
                @elseif($notification->type === 'success')
                    bg-green-50 border-green-500 text-green-800
                @elseif($notification->type === 'warning')
                    bg-yellow-50 border-yellow-500 text-yellow-800
                @elseif($notification->type === 'urgent')
                    bg-red-50 border-red-500 text-red-800
                @endif
            ">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-semibold text-lg">{{ $notification->title }}</h3>
                        <p class="mt-1 text-sm opacity-90 whitespace-pre-wrap">{{ $notification->message }}</p>
                        <p class="mt-2 text-xs opacity-75">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-xl opacity-60 hover:opacity-100">
                        ×
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endif
