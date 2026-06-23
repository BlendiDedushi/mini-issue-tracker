@props(['title', 'description' => null])

<div {{ $attributes->merge(['class' => 'space-y-4']) }}>
    <div>
        <h3 class="text-base font-semibold text-gray-900">{{ $title }}</h3>
        @if ($description)
            <p class="mt-1 text-sm text-gray-600">{{ $description }}</p>
        @endif
    </div>

    <div class="space-y-4">
        {{ $slot }}
    </div>
</div>
