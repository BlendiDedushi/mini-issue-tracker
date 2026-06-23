@props(['member'])

@php
    $nameParts = preg_split('/\s+/', trim($member->name));
    $initials = strtoupper(
        substr($nameParts[0] ?? '', 0, 1).
        substr($nameParts[1] ?? '', 0, 1)
    ) ?: '?';
@endphp

<span
    {{ $attributes->merge(['class' => 'flex h-10 w-10 min-h-[2.5rem] min-w-[2.5rem] shrink-0 items-center justify-center rounded-full bg-gray-200 text-xs font-semibold leading-none text-gray-700']) }}
    title="{{ $member->name }}"
>
    {{ $initials }}
</span>
