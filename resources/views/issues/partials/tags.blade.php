<div
    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
    x-data="{
        tags: @js($issue->tags->map(fn ($tag) => [
            'id' => $tag->id,
            'name' => $tag->name,
            'color' => $tag->color ?? '#6b7280',
        ])->values()),
        allTags: @js($allTags->map(fn ($tag) => [
            'id' => $tag->id,
            'name' => $tag->name,
            'color' => $tag->color ?? '#6b7280',
        ])->values()),
        error: '',
        issueId: @js($issue->id),
        canManageTags: @js(auth()->user()->can('manageTags', $issue)),
        csrfToken: document.querySelector('meta[name=csrf-token]').content,
        get unattachedTags() {
            const attachedIds = new Set(this.tags.map(tag => tag.id));
            return this.allTags.filter(tag => ! attachedIds.has(tag.id));
        },
        async attach(tagId) {
            this.error = '';
            const response = await fetch(`/issues/${this.issueId}/tags/${tagId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json',
                },
            });
            const data = await response.json();
            if (! response.ok) {
                this.error = data.message ?? '{{ __('Could not attach tag.') }}';
                return;
            }
            this.tags = data.tags;
            $dispatch('close-modal', 'attach-tag');
        },
        async detach(tagId) {
            this.error = '';
            const response = await fetch(`/issues/${this.issueId}/tags/${tagId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json',
                },
            });
            const data = await response.json();
            if (! response.ok) {
                this.error = data.message ?? '{{ __('Could not detach tag.') }}';
                return;
            }
            this.tags = data.tags;
        },
    }"
>
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">{{ __('Tags') }}</h3>
            @can('manageTags', $issue)
                <button
                    type="button"
                    class="text-sm text-indigo-600 hover:text-indigo-800"
                    x-on:click="$dispatch('open-modal', 'attach-tag')"
                    x-show="unattachedTags.length > 0"
                >
                    {{ __('+ Attach tag') }}
                </button>
            @endcan
        </div>

        <p x-show="error" x-text="error" class="mb-3 text-sm text-red-600" x-cloak></p>

        <template x-if="tags.length === 0">
            <p class="text-sm text-gray-600">{{ __('No tags attached yet.') }}</p>
        </template>

        <div class="flex flex-wrap gap-2" x-show="tags.length > 0">
            <template x-for="tag in tags" :key="tag.id">
                <span
                    class="inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-sm font-medium text-white"
                    :style="`background-color: ${tag.color}`"
                >
                    <span x-text="tag.name"></span>
                    <button
                        type="button"
                        class="text-xl leading-none hover:text-gray-200"
                        x-show="canManageTags"
                        x-on:click="detach(tag.id)"
                        :aria-label="`{{ __('Remove') }} ${tag.name}`"
                    >&times;</button>
                </span>
            </template>
        </div>
    </div>

    @can('manageTags', $issue)
    <x-modal name="attach-tag" focusable>
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Attach a tag') }}</h3>

            <template x-if="unattachedTags.length === 0">
                <p class="text-sm text-gray-600">{{ __('All tags are already attached.') }}</p>
            </template>

            <ul class="flex max-h-64 flex-col gap-3 overflow-y-auto pr-1">
                <template x-for="tag in unattachedTags" :key="tag.id">
                    <li>
                        <button
                            type="button"
                            class="w-full text-left inline-flex items-center rounded-full px-4 py-2 text-sm font-medium text-white hover:opacity-90"
                            :style="`background-color: ${tag.color}`"
                            x-on:click="attach(tag.id)"
                            x-text="tag.name"
                        ></button>
                    </li>
                </template>
            </ul>

            <div class="mt-6 flex justify-end">
                <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'attach-tag')">
                    {{ __('Cancel') }}
                </x-secondary-button>
            </div>
        </div>
    </x-modal>
    @endcan
</div>
