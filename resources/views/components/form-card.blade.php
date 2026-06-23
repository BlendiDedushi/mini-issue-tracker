@props(['maxWidth' => '2xl'])

@php
    $widthClass = match ($maxWidth) {
        '3xl' => 'max-w-3xl',
        default => 'max-w-2xl',
    };
@endphp

<div {{ $attributes->merge(['class' => "$widthClass mx-auto"]) }}>
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
