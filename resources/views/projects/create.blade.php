<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-form-card>
                <form method="POST" action="{{ route('projects.store') }}" class="divide-y divide-gray-200">
                    @csrf

                    <div class="space-y-8 p-6">
                        @include('projects.partials.form')
                    </div>

                    <div class="flex items-center justify-between gap-3 bg-gray-50 px-6 py-4">
                        <a href="{{ route('projects.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            {{ __('Cancel') }}
                        </a>
                        <x-primary-button>{{ __('Create Project') }}</x-primary-button>
                    </div>
                </form>
            </x-form-card>
        </div>
    </div>
</x-app-layout>
