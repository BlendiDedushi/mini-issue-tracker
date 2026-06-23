<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Assignments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($issues->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-600">
                        {{ __('You are not assigned to any issues yet.') }}
                    </div>
                </div>
            @else
                <div class="space-y-6 md:grid md:grid-cols-2 md:gap-6 md:space-y-0 lg:grid-cols-3">
                    @foreach ($issues as $issue)
                        @include('issues.partials.card', ['issue' => $issue])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
