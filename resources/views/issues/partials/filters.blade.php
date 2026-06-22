<form method="GET" action="{{ route('issues.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
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

        <div class="flex items-center justify-between">
            <x-primary-button>{{ __('Filter') }}</x-primary-button>
            <a href="{{ route('issues.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                {{ __('Clear') }}
            </a>
        </div>
    </div>
</form>
