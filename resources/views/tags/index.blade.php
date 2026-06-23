<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tags') }}
            </h2>

            @can('create', App\Models\Tag::class)
                <a href="{{ route('tags.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('New Tag') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($tags->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-600">
                        {{ __('No tags yet.') }}
                    </div>
                </div>
            @else
                <div class="space-y-6 md:grid md:grid-cols-2 md:gap-6 md:space-y-0 lg:grid-cols-3">
                    @foreach ($tags as $tag)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 flex items-center justify-between gap-4">
                                <span class="inline-flex items-center rounded-full px-4 py-1.5 text-sm font-medium text-white"
                                    style="background-color: {{ $tag->color ?? '#6b7280' }}">
                                    {{ $tag->name }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ $tag->issues_count }} {{ Str::plural('issue', $tag->issues_count) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
