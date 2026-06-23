<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-form-card>
                <form method="POST" action="{{ route('projects.update', $project) }}" class="divide-y divide-gray-200">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8 p-6">
                        @include('projects.partials.form', ['project' => $project])
                    </div>

                    <div class="flex items-center justify-between gap-3 bg-gray-50 px-6 py-4">
                        <a href="{{ route('projects.show', $project) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            {{ __('Cancel') }}
                        </a>
                        <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                    </div>
                </form>
            </x-form-card>
        </div>
    </div>
</x-app-layout>
