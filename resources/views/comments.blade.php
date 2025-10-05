<div class="flex flex-col h-full space-y-4 ">
    @if (auth()->user()->can('create', \Parallax\FilamentComments\Models\FilamentComment::class))
        <div class="space-y-4">
            {{ $this->form }}

            <x-filament::button
                wire:click="create"
                color="primary"
            >
                {{ __('filament-comments::filament-comments.comments.add') }}
            </x-filament::button>
        </div>
    @endif

    @if (count($comments))
        <div class="flex flex-col gap-4 fi-in-repeatable fi-contained">
            @foreach ($comments as $comment)
                <div class="fi-in-repeatable-item block rounded-xl  p-4">
                    <div class="flex gap-x-3">
                        @if (config('filament-comments.display_avatars'))
                            <x-filament-panels::avatar.user size="md" :user="$comment->user" />
                        @endif
                        <div class="flex-grow space-y-2 pt-1.5">
                            <div class="flex items-center justify-between gap-x-2">
                                <div class="flex items-center gap-x-2">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $comment->user[config('filament-comments.user_name_attribute')] }}
                                    </div>

                                    <div class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </div>
                                </div>

                                @if (auth()->user()->can('delete', $comment))
                                    <div class="flex-shrink-0">
                                        <x-filament::icon-button
                                            wire:click="delete({{ $comment->id }})"
                                            icon="{{ config('filament-comments.icons.delete') }}"
                                            color="danger"
                                            tooltip="{{ __('filament-comments::filament-comments.comments.delete.tooltip') }}"
                                        />
                                    </div>
                                @endif
                            </div>

                            <div class="prose dark:prose-invert prose-sm text-sm text-gray-900 dark:text-gray-100 leading-6 [&>*]:mb-2 [&>*]:mt-0 [&>*:last-child]:mb-0">
                                @if(config('filament-comments.editor') === 'markdown')
                                    {!! Str::of($comment->comment)->markdown()->toHtmlString() !!}
                                @else
                                    {!! Str::of($comment->comment)->toHtmlString() !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex h-full flex-col items-center justify-center space-y-4">
            <x-filament::icon
                icon="{{ config('filament-comments.icons.empty') }}"
                class="h-12 w-12 text-gray-400 dark:text-gray-500"
            />

            <div class="text-sm text-gray-400 dark:text-gray-500">
                {{ __('filament-comments::filament-comments.comments.empty') }}
            </div>
        </div>
    @endif
</div>
