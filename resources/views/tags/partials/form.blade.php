<div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
        :value="old('name')" required autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
</div>

<div>
    <x-input-label for="color" :value="__('Color')" />
    <x-text-input id="color" name="color" type="color" class="mt-1 block h-10 w-20"
        :value="old('color', '#6b7280')" />
    <x-input-error class="mt-2" :messages="$errors->get('color')" />
</div>
