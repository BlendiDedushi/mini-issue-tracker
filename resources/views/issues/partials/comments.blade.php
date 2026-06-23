<div
    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
    x-data="{
        comments: [],
        page: 1,
        lastPage: 1,
        loading: true,
        loadingMore: false,
        submitting: false,
        errors: {},
        formError: '',
        authorName: @js(auth()->user()->name),
        body: '',
        issueId: @js($issue->id),
        csrfToken: document.querySelector('meta[name=csrf-token]').content,
        get hasMore() {
            return this.page < this.lastPage;
        },
        async init() {
            await this.fetchComments();
        },
        async fetchComments() {
            const isFirstPage = this.page === 1;
            if (isFirstPage) {
                this.loading = true;
            } else {
                this.loadingMore = true;
            }

            const response = await fetch(`/issues/${this.issueId}/comments?page=${this.page}`, {
                headers: { 'Accept': 'application/json' },
            });
            const data = await response.json();

            if (! response.ok) {
                this.formError = data.message ?? '{{ __('Could not load comments.') }}';
                this.loading = false;
                this.loadingMore = false;
                return;
            }

            if (isFirstPage) {
                this.comments = data.comments;
            } else {
                this.comments = [...this.comments, ...data.comments];
            }

            this.lastPage = data.meta.last_page;
            this.loading = false;
            this.loadingMore = false;
        },
        async loadMore() {
            if (! this.hasMore || this.loadingMore) {
                return;
            }

            this.page++;
            await this.fetchComments();
        },
        async submitComment() {
            this.errors = {};
            this.formError = '';
            this.submitting = true;

            const response = await fetch(`/issues/${this.issueId}/comments`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    author_name: this.authorName,
                    body: this.body,
                }),
            });
            const data = await response.json();

            if (response.status === 422) {
                this.errors = data.errors ?? {};
                this.submitting = false;
                return;
            }

            if (! response.ok) {
                this.formError = data.message ?? '{{ __('Could not add comment.') }}';
                this.submitting = false;
                return;
            }

            this.comments = [data.comment, ...this.comments];
            this.body = '';
            this.submitting = false;
        },
    }"
>
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Comments') }}</h3>

        <form x-on:submit.prevent="submitComment()" class="mb-6 space-y-4 border-b border-gray-200 pb-6">
            <p x-show="formError" x-text="formError" class="text-sm text-red-600" x-cloak></p>

            <div>
                <x-input-label for="author_name" :value="__('Author name')" />
                <x-text-input
                    id="author_name"
                    type="text"
                    class="mt-1 block w-full bg-gray-50"
                    x-model="authorName"
                    readonly
                />
                <template x-if="errors.author_name">
                    <p class="mt-2 text-sm text-red-600" x-text="errors.author_name[0]"></p>
                </template>
            </div>

            <div>
                <x-input-label for="body" :value="__('Comment')" />
                <textarea
                    id="body"
                    rows="3"
                    required
                    x-model="body"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                ></textarea>
                <template x-if="errors.body">
                    <p class="mt-2 text-sm text-red-600" x-text="errors.body[0]"></p>
                </template>
            </div>

            <div class="mt-4 flex justify-end">
                <x-primary-button type="submit" x-bind:disabled="submitting">
                    <span x-show="! submitting">{{ __('Add Comment') }}</span>
                    <span x-show="submitting" x-cloak>{{ __('Adding...') }}</span>
                </x-primary-button>
            </div>
        </form>

        <div x-show="loading" class="text-sm text-gray-600">{{ __('Loading comments...') }}</div>

        <template x-if="! loading && comments.length === 0">
            <p class="text-sm text-gray-600">{{ __('No comments yet.') }}</p>
        </template>

        <ul x-show="! loading && comments.length > 0" class="divide-y divide-gray-200">
            <template x-for="comment in comments" :key="comment.id">
                <li class="py-4">
                    <div class="flex items-center justify-between gap-4">
                        <p class="font-medium text-gray-900" x-text="comment.author_name"></p>
                        <p class="text-sm text-gray-500" x-text="comment.created_at"></p>
                    </div>
                    <p class="mt-2 text-sm text-gray-600 whitespace-pre-wrap" x-text="comment.body"></p>
                </li>
            </template>
        </ul>

        <div x-show="hasMore && ! loading" class="mt-4 text-center">
            <button
                type="button"
                class="text-sm text-indigo-600 hover:text-indigo-800"
                x-on:click="loadMore()"
                x-bind:disabled="loadingMore"
            >
                <span x-show="! loadingMore">{{ __('Load more comments') }}</span>
                <span x-show="loadingMore" x-cloak>{{ __('Loading...') }}</span>
            </button>
        </div>
    </div>
</div>
