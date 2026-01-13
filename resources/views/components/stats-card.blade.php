@props(['icon', 'title', 'value', 'color' => 'blue', 'trend' => null])

<div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600 mb-1">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-800">{{ $value }}</p>
            @if($trend)
                <p class="text-sm text-{{ $color }}-600 mt-2">{{ $trend }}</p>
            @endif
        </div>
        <div class="w-14 h-14 bg-{{ $color }}-100 rounded-full flex items-center justify-center">
            {!! $icon !!}
        </div>
    </div>
</div>