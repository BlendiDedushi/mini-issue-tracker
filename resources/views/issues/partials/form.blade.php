@php($issue = $issue ?? null)

<div>
    <x-input-label for="project_id" :value="__('Project')" />
    <select id="project_id" name="project_id" required
        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
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
    <textarea id="description" name="description" rows="4" required
        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $issue?->description) }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('description')" />
</div>

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

<div>
    <x-input-label for="due_date" :value="__('Due date')" />
    <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full"
        :value="old('due_date', $issue?->due_date?->format('Y-m-d'))" />
    <x-input-error class="mt-2" :messages="$errors->get('due_date')" />
</div>
