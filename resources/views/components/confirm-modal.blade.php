@props([
    'name',
    'title',
    'message',
    'action',
    'method' => 'POST',
    'confirmLabel' => __('Delete'),
    'cancelLabel' => __('Cancel'),
    'show' => false,
])

<x-modal :name="$name" :show="$show" focusable>
    <form method="post" action="{{ $action }}" class="p-6">
        @csrf
        @method($method)

        <h2 class="text-lg font-medium text-gray-900">
            {{ $title }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ $message }}
        </p>

        {{ $slot }}

        <div class="mt-6 flex justify-end gap-3">
            <x-secondary-button type="button" x-on:click="$dispatch('close-modal', '{{ $name }}')">
                {{ $cancelLabel }}
            </x-secondary-button>

            <x-danger-button>
                {{ $confirmLabel }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
