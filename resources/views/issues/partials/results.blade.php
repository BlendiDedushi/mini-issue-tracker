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
