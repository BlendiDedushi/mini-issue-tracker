@php($project = $project ?? null)

<x-form-section :title="__('Project details')" :description="__('Name and describe the project for your team.')">
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
            :value="old('name', $project?->name)" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" name="description" rows="4"
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            required>{{ old('description', $project?->description) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('description')" />
    </div>
</x-form-section>

<x-form-section :title="__('Timeline')" :description="__('Optional planning dates for the project.')">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <x-input-label for="start_date" :value="__('Start date')" />
            <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full"
                :value="old('start_date', $project?->start_date?->format('Y-m-d'))" />
            <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
        </div>

        <div>
            <x-input-label for="deadline" :value="__('Deadline')" />
            <x-text-input id="deadline" name="deadline" type="date" class="mt-1 block w-full"
                :value="old('deadline', $project?->deadline?->format('Y-m-d'))" />
            <x-input-error class="mt-2" :messages="$errors->get('deadline')" />
        </div>
    </div>
</x-form-section>
