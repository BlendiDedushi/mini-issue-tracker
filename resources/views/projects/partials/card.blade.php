<a href="{{ route('projects.show', $project) }}" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
    <div class="p-6">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0 flex-1">
                <h3 class="text-lg font-semibold text-gray-900 truncate">
                    {{ $project->name }}
                </h3>
                <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                    {{ $project->description }}
                </p>
            </div>
            <span class="shrink-0 inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                {{ $project->issues_count }} {{ Str::plural('issue', $project->issues_count) }}
            </span>
        </div>

        <dl class="mt-4 grid grid-cols-1 gap-2 text-sm text-gray-500 sm:grid-cols-2">
            @if ($project->start_date)
                <div>
                    <dt class="font-medium text-gray-700">Start</dt>
                    <dd>{{ $project->start_date->format('M j, Y') }}</dd>
                </div>
            @endif
            @if ($project->deadline)
                <div>
                    <dt class="font-medium text-gray-700">Deadline</dt>
                    <dd>{{ $project->deadline->format('M j, Y') }}</dd>
                </div>
            @endif
            @if ($showOwner ?? false)
                <div class="sm:col-span-2">
                    <dt class="font-medium text-gray-700">Owner</dt>
                    <dd>{{ $project->owner->name }}</dd>
                </div>
            @endif
        </dl>
    </div>
</a>
