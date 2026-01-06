
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('organizations.title') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('organizations.subtitle') }}</p>
            </div>
            <flux:button href="{{ route('organizations.create') }}" icon="building-office" variant="primary">
                {{ __('organizations.new_organization') }}
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
                        placeholder="{{ __('organizations.search_placeholder') }}"
                        icon="magnifying-glass"
                    />
                </div>

                {{-- Type Filter --}}
                <div>
                    <flux:select wire:model.live="filterType">
                        <option value="">{{ __('organizations.all_types') }}</option>
                        <option value="gobierno">{{ __('dashboard.gobierno') }}</option>
                        <option value="ong">{{ __('dashboard.ong') }}</option>
                        <option value="empresa">{{ __('dashboard.empresa') }}</option>
                        <option value="comunidad">{{ __('dashboard.comunidad') }}</option>
                        <option value="otro">{{ __('dashboard.otro') }}</option>
                    </flux:select>
                </div>

                {{-- Status Filter --}}
                <div>
                    <flux:select wire:model.live="filterStatus">
                        <option value="">{{ __('organizations.all_statuses') }}</option>
                        <option value="active">{{ __('organizations.active') }}</option>
                        <option value="inactive">{{ __('organizations.inactive') }}</option>
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
                        <flux:badge color="green">{{ __('organizations.type') }}: {{ ucfirst($filterType) }}</flux:badge>
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

        {{-- Organizations Table --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-neutral-900 border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <button wire:click="sortBy('name')" class="flex items-center gap-1 text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider hover:text-gray-900 dark:hover:text-white">
                                    {{ __('organizations.name') }}
                                    @if($sortField === 'name')
                                        <flux:icon.chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }} class="size-4" />
                                    @endif
                                </button>
                            </th>
                            <th class="px-6 py-3 text-left">
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('organizations.type') }}
                                </span>
                            </th>
                            <th class="px-6 py-3 text-left">
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('organizations.industry') }}
                                </span>
                            </th>
                            <th class="px-6 py-3 text-left">
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('organizations.contacts_count') }}
                                </span>
                            </th>
                            <th class="px-6 py-3 text-left">
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('organizations.status') }}
                                </span>
                            </th>
                            <th class="px-6 py-3 text-right">
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('organizations.actions') }}
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($organizations as $organization)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-900/50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 size-10 rounded-full bg-gradient-to-br from-purple-500 to-blue-600 flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($organization->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                {{ $organization->name }}
                                            </div>
                                            @if($organization->website)
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $organization->website }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ $organization->getTypeLabel() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    {{ $organization->industry ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1 text-sm text-gray-600 dark:text-gray-400">
                                        <flux:icon.users class="size-4" />
                                        {{ $organization->contacts_count }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        {{ $organization->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                        {{ $organization->status === 'inactive' ? 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                                    ">
                                        {{ ucfirst($organization->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <flux:button href="{{ route('organizations.show', $organization->id) }}" size="sm" variant="ghost" icon="eye">
                                            {{ __('organizations.view') }}
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <flux:icon.building-office class="size-12 text-gray-400" />
                                        <p class="text-gray-500 dark:text-gray-400">{{ __('organizations.no_organizations_found') }}</p>
                                        @if($search || $filterType || $filterStatus)
                                            <flux:button wire:click="resetFilters" size="sm">
                                                {{ __('contacts.clear_filters') }}
                                            </flux:button>
                                        @else
                                            <flux:button href="#" size="sm">
                                                {{ __('organizations.create_first_organization') }}
                                            </flux:button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($organizations->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $organizations->links() }}
                </div>
            @endif
        </div>

        {{-- Stats Footer --}}
        <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400">
            <div>
                {{ __('organizations.showing') }} {{ $organizations->firstItem() ?? 0 }} {{ __('organizations.to') }} {{ $organizations->lastItem() ?? 0 }} {{ __('organizations.of') }} {{ $organizations->total() }} {{ __('organizations.organizations') }}
            </div>
        </div>
    </div>
