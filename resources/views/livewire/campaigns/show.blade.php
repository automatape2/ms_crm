<div class="flex h-full w-full flex-1 flex-col gap-6">
    {{-- Header with Actions --}}
    <div class="flex items-start justify-between">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 size-16 rounded-full bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center text-white font-bold text-2xl">
                <flux:icon.megaphone class="size-8" />
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $campaign->name }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ ucfirst($campaign->type) }} {{ __('campaigns.campaign') }}
                </p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="px-2 py-1 text-xs font-medium rounded-full
                        {{ $campaign->status === 'draft' ? 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                        {{ $campaign->status === 'scheduled' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                        {{ $campaign->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                        {{ $campaign->status === 'paused' ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400' : '' }}
                        {{ $campaign->status === 'completed' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                        {{ $campaign->status === 'cancelled' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : '' }}
                    ">
                        {{ ucfirst($campaign->status) }}
                    </span>
                    <span class="px-2 py-1 text-xs font-medium rounded-full
                        {{ $campaign->type === 'email' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                        {{ $campaign->type === 'sms' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                        {{ $campaign->type === 'phone' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' : '' }}
                        {{ $campaign->type === 'event' ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400' : '' }}
                        {{ $campaign->type === 'social' ? 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400' : '' }}
                    ">
                        {{ ucfirst($campaign->type) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <flux:button href="{{ route('campaigns.index') }}" variant="ghost" icon="arrow-left">
                {{ __('contacts.back') }}
            </flux:button>
            <flux:button href="{{ route('campaigns.edit', $campaign) }}" variant="primary" icon="pencil">
                {{ __('contacts.edit') }}
            </flux:button>
        </div>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    {{-- Main Content Grid --}}
    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Left Column: Campaign Info --}}
        <div class="space-y-6">
            {{-- Campaign Details Card --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('contacts.contact_details') }}</h3>
                <div class="space-y-4">
                    @if($campaign->segment)
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">{{ __('campaigns.segment') }}</p>
                            <p class="text-gray-900 dark:text-white">{{ $campaign->segment->name }}</p>
                        </div>
                    @endif
                    @if($campaign->scheduled_at)
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">{{ __('campaigns.scheduled_at') }}</p>
                            <p class="text-gray-900 dark:text-white">{{ $campaign->scheduled_at->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                    @if($campaign->started_at)
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">{{ __('campaigns.started_at') }}</p>
                            <p class="text-gray-900 dark:text-white">{{ $campaign->started_at->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                    @if($campaign->completed_at)
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">{{ __('campaigns.completed_at') }}</p>
                            <p class="text-gray-900 dark:text-white">{{ $campaign->completed_at->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Stats Card --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('contacts.statistics') }}</h3>
                <div class="space-y-3">
                    @if($campaign->stats)
                        @foreach($campaign->stats as $key => $value)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $value }}</span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('campaigns.no_stats') }}</p>
                    @endif
                    <div class="flex justify-between pt-3 border-t border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('contacts.created') }}</span>
                        <span class="text-gray-900 dark:text-white">{{ $campaign->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('contacts.last_updated') }}</span>
                        <span class="text-gray-900 dark:text-white">{{ $campaign->updated_at->diffForHumans() }}</span>
                    </div>
                    @if($campaign->creator)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('contacts.created_by') }}</span>
                            <span class="text-gray-900 dark:text-white">{{ $campaign->creator->name }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column: Description & Activity --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Description Section --}}
            @if($campaign->description)
                <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('contacts.description') }}</h3>
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $campaign->description }}</p>
                </div>
            @endif

            {{-- Activities Section --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('campaigns.activity') }}</h3>
                @if($campaign->activities->count() > 0)
                    <div class="space-y-4">
                        @foreach($campaign->activities as $activity)
                            <div class="flex gap-3 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $activity->description }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('campaigns.no_activity') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
