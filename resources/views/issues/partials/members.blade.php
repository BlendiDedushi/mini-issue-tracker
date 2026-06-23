<div
    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
    x-data="{
        members: @js($issue->members->map(fn ($member) => [
            'id' => $member->id,
            'name' => $member->name,
            'email' => $member->email,
        ])->values()),
        allMembers: @js($assignableMembers->map(fn ($member) => [
            'id' => $member->id,
            'name' => $member->name,
            'email' => $member->email,
        ])->values()),
        error: '',
        issueId: @js($issue->id),
        canManageMembers: @js(auth()->user()->can('manageMembers', $issue)),
        csrfToken: document.querySelector('meta[name=csrf-token]').content,
        get unassignedMembers() {
            const assignedIds = new Set(this.members.map(member => member.id));
            return this.allMembers.filter(member => ! assignedIds.has(member.id));
        },
        async attach(memberId) {
            this.error = '';
            const response = await fetch(`/issues/${this.issueId}/members/${memberId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json',
                },
            });
            const data = await response.json();
            if (! response.ok) {
                this.error = data.message ?? '{{ __('Could not assign member.') }}';
                return;
            }
            this.members = data.members;
            $dispatch('close-modal', 'attach-member');
        },
        async detach(memberId) {
            this.error = '';
            const response = await fetch(`/issues/${this.issueId}/members/${memberId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json',
                },
            });
            const data = await response.json();
            if (! response.ok) {
                this.error = data.message ?? '{{ __('Could not remove member.') }}';
                return;
            }
            this.members = data.members;
        },
    }"
>
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">{{ __('Members') }}</h3>
            @can('manageMembers', $issue)
                <button
                    type="button"
                    class="text-sm text-indigo-600 hover:text-indigo-800"
                    x-on:click="$dispatch('open-modal', 'attach-member')"
                    x-show="unassignedMembers.length > 0"
                >
                    {{ __('+ Assign member') }}
                </button>
            @endcan
        </div>

        <p x-show="error" x-text="error" class="mb-3 text-sm text-red-600" x-cloak></p>

        <template x-if="members.length === 0">
            <p class="text-sm text-gray-600">{{ __('No members assigned yet.') }}</p>
        </template>

        <div class="flex flex-wrap gap-2" x-show="members.length > 0">
            <template x-for="member in members" :key="member.id">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-200 px-4 py-1.5 text-sm font-medium text-gray-800">
                    <span x-text="member.name"></span>
                    <button
                        type="button"
                        class="text-xl leading-none text-gray-500 hover:text-gray-700"
                        x-show="canManageMembers"
                        x-on:click="detach(member.id)"
                        :aria-label="`{{ __('Remove') }} ${member.name}`"
                    >&times;</button>
                </span>
            </template>
        </div>
    </div>

    @can('manageMembers', $issue)
    <x-modal name="attach-member" focusable>
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Assign a member') }}</h3>

            <template x-if="unassignedMembers.length === 0">
                <p class="text-sm text-gray-600">{{ __('All members are already assigned.') }}</p>
            </template>

            <ul class="flex max-h-64 flex-col gap-3 overflow-y-auto pr-1">
                <template x-for="member in unassignedMembers" :key="member.id">
                    <li>
                        <button
                            type="button"
                            class="w-full rounded-lg border border-gray-200 px-4 py-3 text-left hover:bg-gray-50"
                            x-on:click="attach(member.id)"
                        >
                            <span class="block text-sm font-medium text-gray-900" x-text="member.name"></span>
                            <span class="block text-sm text-gray-500" x-text="member.email"></span>
                        </button>
                    </li>
                </template>
            </ul>

            <div class="mt-6 flex justify-end">
                <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'attach-member')">
                    {{ __('Cancel') }}
                </x-secondary-button>
            </div>
        </div>
    </x-modal>
    @endcan
</div>
