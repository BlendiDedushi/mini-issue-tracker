<div
    x-data="{
        name: @js(old('name', '')),
        color: @js(old('color', '#6b7280')),
    }"
>
    <x-form-section :title="__('Tag details')" :description="__('Choose a short label and color for filtering issues.')">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                x-model="name"
                required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="color" :value="__('Color')" />
            <div class="mt-2 flex flex-wrap items-center gap-4">
                <input
                    id="color"
                    name="color"
                    type="color"
                    x-model="color"
                    class="h-11 w-14 cursor-pointer rounded-md border border-gray-300 bg-white p-1"
                />
                <span class="text-sm font-mono text-gray-600" x-text="color"></span>
                <span
                    class="inline-flex items-center rounded-full px-4 py-1.5 text-sm font-medium text-white"
                    :style="`background-color: ${color}`"
                    x-text="name || '{{ __('Preview') }}'"
                ></span>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('color')" />
        </div>
    </x-form-section>
</div>
