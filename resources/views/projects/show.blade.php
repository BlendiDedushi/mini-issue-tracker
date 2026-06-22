<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->name }}
            </h2>

            @can('update', $project)
                <a href="{{ route('projects.edit', $project) }}"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Edit') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <p class="text-gray-600">{{ $project->description }}</p>

                    <dl class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-3">
                        <div>
                            <dt class="font-medium text-gray-700">{{ __('Owner') }}</dt>
                            <dd class="text-gray-600">{{ $project->owner->name }}</dd>
                        </div>
                        @if ($project->start_date)
                            <div>
                                <dt class="font-medium text-gray-700">{{ __('Start date') }}</dt>
                                <dd class="text-gray-600">{{ $project->start_date->format('M j, Y') }}</dd>
                            </div>
                        @endif
                        @if ($project->deadline)
                            <div>
                                <dt class="font-medium text-gray-700">{{ __('Deadline') }}</dt>
                                <dd class="text-gray-600">{{ $project->deadline->format('M j, Y') }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Issues') }}</h3>

                    @if ($project->issues->isEmpty())
                        <p class="text-sm text-gray-600">{{ __('No issues yet.') }}</p>
                    @else
                        <ul class="divide-y divide-gray-200">
                            @foreach ($project->issues as $issue)
                                <li class="py-3 flex items-center justify-between gap-4">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $issue->title }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ ucfirst(str_replace('_', ' ', $issue->status->value)) }}
                                            · {{ ucfirst($issue->priority->value) }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('projects.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    ← {{ __('Back to projects') }}
                </a>

                @can('delete', $project)
                    <x-danger-button
                        type="button"
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-project-deletion')"
                    >
                        {{ __('Delete Project') }}
                    </x-danger-button>

                    <x-confirm-modal
                        name="confirm-project-deletion"
                        :title="__('Delete this project?')"
                        :message="__('This action cannot be undone. All issues and related data will be permanently deleted.')"
                        :action="route('projects.destroy', $project)"
                        method="DELETE"
                        :confirm-label="__('Delete Project')"
                    />
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
