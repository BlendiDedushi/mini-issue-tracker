@php($issue = $issue ?? null)

<x-form-section :title="__('Issue details')" :description="__('Link the issue to a project and describe the work.')">
    <div>
        <x-input-label for="project_id" :value="__('Project')" />
        @if ($projects->count() === 1)
            <input type="hidden" name="project_id" value="{{ $projects->first()->id }}">
        @endif
        <select id="project_id" @if ($projects->count() !== 1) name="project_id" @endif required @disabled($projects->count() === 1)
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm disabled:bg-gray-50 disabled:text-gray-500">
            <option value="">{{ __('Select a project') }}</option>
            @foreach ($projects as $project)
                <option value="{{ $project->id }}" @selected(old('project_id', $selectedProjectId ?? $issue?->project_id) == $project->id)>
                    {{ $project->name }}
                </option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('project_id')" />
    </div>

    <div>
        <x-input-label for="title" :value="__('Title')" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
            :value="old('title', $issue?->title)" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('title')" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" name="description" rows="5" required
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $issue?->description) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('description')" />
    </div>
</x-form-section>

<x-form-section :title="__('Classification')" :description="__('Set priority, status, and optional due date.')">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <x-input-label for="status" :value="__('Status')" />
            <select id="status" name="status" required
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @selected(old('status', $issue?->status?->value ?? 'open') === $status->value)>
                        {{ ucfirst(str_replace('_', ' ', $status->value)) }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
        </div>

        <div>
            <x-input-label for="priority" :value="__('Priority')" />
            <select id="priority" name="priority" required
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                @foreach ($priorities as $priority)
                    <option value="{{ $priority->value }}" @selected(old('priority', $issue?->priority?->value ?? 'medium') === $priority->value)>
                        {{ ucfirst($priority->value) }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('priority')" />
        </div>
    </div>

    <div class="sm:max-w-xs">
        <x-input-label for="due_date" :value="__('Due date')" />
        <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full"
            :value="old('due_date', $issue?->due_date?->format('Y-m-d'))" />
        <x-input-error class="mt-2" :messages="$errors->get('due_date')" />
    </div>
</x-form-section>
