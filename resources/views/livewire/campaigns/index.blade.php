<div class="flex h-full w-full flex-1 flex-col gap-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('campaigns.title') }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('campaigns.subtitle') }}</p>
        </div>
        <flux:button href="{{ route('campaigns.create') }}" icon="megaphone" variant="primary">
            {{ __('campaigns.new_campaign') }}
        </flux:button>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
        <div class="grid gap-4 md:grid-cols-3">
            {{-- Search --}}
            <div class="md:col-span-1">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    type="search"
                    placeholder="{{ __('campaigns.search_placeholder') }}"
                    icon="magnifying-glass"
                />
            </div>

            {{-- Type Filter --}}
            <div>
                <flux:select wire:model.live="filterType">
                    <option value="">{{ __('campaigns.all_types') }}</option>
                    <option value="email">{{ __('campaigns.type_email') }}</option>
                    <option value="sms">{{ __('campaigns.type_sms') }}</option>
                    <option value="phone">{{ __('campaigns.type_phone') }}</option>
                    <option value="event">{{ __('campaigns.type_event') }}</option>
                    <option value="social">{{ __('campaigns.type_social') }}</option>
                </flux:select>
            </div>

            {{-- Status Filter --}}
            <div>
                <flux:select wire:model.live="filterStatus">
                    <option value="">{{ __('campaigns.all_statuses') }}</option>
                    <option value="draft">{{ __('campaigns.status_draft') }}</option>
                    <option value="scheduled">{{ __('campaigns.status_scheduled') }}</option>
                    <option value="active">{{ __('campaigns.status_active') }}</option>
                    <option value="paused">{{ __('campaigns.status_paused') }}</option>
                    <option value="completed">{{ __('campaigns.status_completed') }}</option>
                    <option value="cancelled">{{ __('campaigns.status_cancelled') }}</option>
                </flux:select>
            </div>
        </div>

        {{-- Active Filters Display --}}
        @if($search || $filterType || $filterStatus)
            <div class="flex items-center gap-2 mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('contacts.active_filters') }}</span>
                @if($search)
                    <flux:badge color="blue">{{ __('contacts.search') }}: "{{ $search }}"</flux:badge>
                @endif
                @if($filterType)
                    <flux:badge color="green">{{ __('campaigns.type') }}: {{ ucfirst($filterType) }}</flux:badge>
                @endif
                @if($filterStatus)
                    <flux:badge color="purple">{{ __('contacts.status') }}: {{ ucfirst($filterStatus) }}</flux:badge>
                @endif
                <flux:button wire:click="resetFilters" size="sm" variant="ghost">
                    {{ __('contacts.clear_filters') }}
                </flux:button>
            </div>
        @endif
    </div>

    {{-- Campaigns Table --}}
    <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-neutral-900 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <button wire:click="sortBy('name')" class="flex items-center gap-1 text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider hover:text-gray-900 dark:hover:text-white">
                                {{ __('campaigns.name') }}
                                @if($sortField === 'name')
                                    <flux:icon.chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }} class="size-4" />
                                @endif
                            </button>
                        </th>
                        <th class="px-6 py-3 text-left">
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('campaigns.type') }}
                            </span>
                        </th>
                        <th class="px-6 py-3 text-left">
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('campaigns.status') }}
                            </span>
                        </th>
                        <th class="px-6 py-3 text-left">
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('campaigns.segment') }}
                            </span>
                        </th>
                        <th class="px-6 py-3 text-left">
                            <button wire:click="sortBy('created_at')" class="flex items-center gap-1 text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider hover:text-gray-900 dark:hover:text-white">
                                {{ __('contacts.created') }}
                                @if($sortField === 'created_at')
                                    <flux:icon.chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }} class="size-4" />
                                @endif
                            </button>
                        </th>
                        <th class="px-6 py-3 text-right">
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('contacts.actions') }}
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($campaigns as $campaign)
                        <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $campaign->name }}</p>
                                    @if($campaign->description)
                                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-1">{{ $campaign->description }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $campaign->type === 'email' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                    {{ $campaign->type === 'sms' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ $campaign->type === 'phone' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' : '' }}
                                    {{ $campaign->type === 'event' ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400' : '' }}
                                    {{ $campaign->type === 'social' ? 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400' : '' }}
                                ">
                                    {{ ucfirst($campaign->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
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
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-900 dark:text-white">
                                    {{ $campaign->segment ? $campaign->segment->name : '-' }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-900 dark:text-white">{{ $campaign->created_at->format('d/m/Y') }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <flux:button href="{{ route('campaigns.show', $campaign) }}" variant="ghost" size="sm">
                                    {{ __('contacts.view') }}
                                </flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <flux:icon.megaphone class="size-12 text-gray-400 mb-3" />
                                    <p class="text-gray-600 dark:text-gray-400 font-medium">{{ __('campaigns.no_campaigns_found') }}</p>
                                    <flux:button href="{{ route('campaigns.create') }}" variant="primary" class="mt-4">
                                        {{ __('campaigns.create_first_campaign') }}
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($campaigns->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>
</div>
