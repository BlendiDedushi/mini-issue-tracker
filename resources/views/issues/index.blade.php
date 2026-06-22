<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Issues') }}
            </h2>

            @can('create', App\Models\Issue::class)
                <a href="{{ route('issues.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('New Issue') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('issues.partials.filters')

            @if ($issues->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-600">
                        {{ __('No issues found.') }}
                    </div>
                </div>
            @else
                <div class="space-y-6 md:grid md:grid-cols-2 md:gap-6 md:space-y-0 lg:grid-cols-3">
                    @foreach ($issues as $issue)
                        @include('issues.partials.card', ['issue' => $issue])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $issues->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
