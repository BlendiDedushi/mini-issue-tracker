<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    {{ __('Name') }}
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    {{ __('Email') }}
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    {{ __('Role') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">
                                        @can('updateRole', $user)
                                            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="inline">
                                                @csrf
                                                @method('PATCH')

                                                <select
                                                    name="role"
                                                    onchange="this.form.submit()"
                                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                                                >
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->value }}" @selected($user->hasRole($role->value))>
                                                            {{ ucfirst(str_replace('_', ' ', $role->value)) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        @else
                                            <span>{{ ucfirst(str_replace('_', ' ', $user->roles->first()?->name ?? '')) }}</span>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
