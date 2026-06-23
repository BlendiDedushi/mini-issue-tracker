<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $issue->title }}
            </h2>

            @can('update', $issue)
                <a href="{{ route('issues.edit', $issue) }}"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Edit') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">
                    <p class="text-gray-600">{{ $issue->description }}</p>

                    <dl class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <dt class="font-medium text-gray-700">{{ __('Project') }}</dt>
                            <dd>
                                <a href="{{ route('projects.show', $issue->project) }}" class="text-indigo-600 hover:text-indigo-800">
                                    {{ $issue->project->name }}
                                </a>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-700">{{ __('Status') }}</dt>
                            <dd class="text-gray-600">{{ ucfirst(str_replace('_', ' ', $issue->status->value)) }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-700">{{ __('Priority') }}</dt>
                            <dd class="text-gray-600">{{ ucfirst($issue->priority->value) }}</dd>
                        </div>
                        @if ($issue->due_date)
                            <div>
                                <dt class="font-medium text-gray-700">{{ __('Due date') }}</dt>
                                <dd class="text-gray-600">{{ $issue->due_date->format('M j, Y') }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            @include('issues.partials.tags')

            <div class="flex items-center justify-between">
                <a href="{{ route('projects.show', $issue->project) }}" class="text-sm text-gray-600 hover:text-gray-900">
                    ← {{ __('Back to project') }}
                </a>

                @can('delete', $issue)
                    <x-danger-button
                        type="button"
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-issue-deletion')"
                    >
                        {{ __('Delete Issue') }}
                    </x-danger-button>

                    <x-confirm-modal
                        name="confirm-issue-deletion"
                        :title="__('Delete this issue?')"
                        :message="__('This action cannot be undone.')"
                        :action="route('issues.destroy', $issue)"
                        method="DELETE"
                        :confirm-label="__('Delete Issue')"
                    />
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
