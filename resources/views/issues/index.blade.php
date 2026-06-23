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
        <div
            class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"
            x-data="{
                search: @js($filters['search'] ?? ''),
                loading: false,
                debounceTimer: null,
                async fetchResults() {
                    this.loading = true;
                    const params = new URLSearchParams(new FormData(this.$refs.filterForm));
                    const response = await fetch(`{{ route('issues.index') }}?${params.toString()}`, {
                        headers: { 'Accept': 'application/json' },
                    });
                    const data = await response.json();
                    this.$refs.results.innerHTML = data.html;
                    this.loading = false;
                },
                onSearchInput() {
                    clearTimeout(this.debounceTimer);
                    this.debounceTimer = setTimeout(() => this.fetchResults(), 300);
                },
            }"
        >
            @include('issues.partials.filters')

            <p x-show="loading" x-cloak class="text-sm text-gray-500">{{ __('Searching...') }}</p>

            <div x-ref="results">
                @include('issues.partials.results')
            </div>
        </div>
    </div>
</x-app-layout>
