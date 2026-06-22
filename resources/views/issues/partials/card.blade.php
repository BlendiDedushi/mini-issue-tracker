<a href="{{ route('issues.show', $issue) }}" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
    <div class="p-6">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0 flex-1">
                <h3 class="text-lg font-semibold text-gray-900 truncate">
                    {{ $issue->title }}
                </h3>
                <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                    {{ $issue->description }}
                </p>
            </div>
            @if ($issue->due_date)
                <span class="shrink-0 text-sm text-gray-500">
                    {{ $issue->due_date->format('M j, Y') }}
                </span>
            @endif
        </div>

        <p class="mt-4 text-sm text-gray-500">
            {{ $issue->project->name }}
            · {{ ucfirst(str_replace('_', ' ', $issue->status->value)) }}
            · {{ ucfirst($issue->priority->value) }}
        </p>
    </div>
</a>
