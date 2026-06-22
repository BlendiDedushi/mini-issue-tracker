@use('App\Enums\UserRole')

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if (Auth::user()->hasRole(UserRole::ProjectOwner->value))
                    {{ __('Your Projects') }}
                @else
                    {{ __('Projects') }}
                @endif
            </h2>

            @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('New Project') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($projects->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-600">
                        @can('create', App\Models\Project::class)
                            {{ __('You have no projects yet. Create one to get started.') }}
                        @else
                            {{ __('No projects are available yet.') }}
                        @endcan
                    </div>
                </div>
            @else
                <div class="space-y-6 md:grid md:grid-cols-2 md:gap-6 md:space-y-0 lg:grid-cols-3">
                    @foreach ($projects as $project)
                        @include('projects.partials.card', [
                            'project' => $project,
                            'showOwner' => ! Auth::user()->hasRole(UserRole::ProjectOwner->value),
                        ])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
