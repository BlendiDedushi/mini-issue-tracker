<form
    x-ref="filterForm"
    method="GET"
    action="{{ route('issues.index') }}"
    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-4"
>
    <div>
        <x-input-label for="search" :value="__('Search')" />
        <x-text-input
            id="search"
            name="search"
            type="search"
            class="mt-1 block w-full"
            placeholder="{{ __('Search by title or description...') }}"
            x-model="search"
            x-on:input="onSearchInput()"
        />
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div>
            <x-input-label for="status" :value="__('Status')" />
            <select id="status" name="status"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">{{ __('All statuses') }}</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @selected(($filters['status'] ?? '') === $status->value)>
                        {{ ucfirst(str_replace('_', ' ', $status->value)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <x-input-label for="priority" :value="__('Priority')" />
            <select id="priority" name="priority"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">{{ __('All priorities') }}</option>
                @foreach ($priorities as $priority)
                    <option value="{{ $priority->value }}" @selected(($filters['priority'] ?? '') === $priority->value)>
                        {{ ucfirst($priority->value) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <x-input-label for="tag" :value="__('Tag')" />
            <select id="tag" name="tag"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">{{ __('All tags') }}</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" @selected(($filters['tag'] ?? '') == $tag->id)>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="flex items-center justify-center gap-4">
        <x-primary-button>{{ __('Filter') }}</x-primary-button>
        <a href="{{ route('issues.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
            {{ __('Clear') }}
        </a>
    </div>
</form>
