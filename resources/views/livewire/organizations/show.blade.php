
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        {{-- Header with Actions --}}
        <div class="flex items-start justify-between">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 size-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl">
                    {{ strtoupper(substr($organization->name, 0, 2)) }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $organization->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        @if($organization->industry)
                            {{ $organization->industry }}
                        @endif
                    </p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            {{ $organization->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                            {{ $organization->status === 'inactive' ? 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                        ">
                            {{ ucfirst($organization->status) }}
                        </span>
                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400 rounded-full">
                            {{ $organization->getTypeLabel() }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <flux:button href="{{ route('organizations.index') }}" variant="ghost" icon="arrow-left">
                    {{ __('contacts.back') }}
                </flux:button>
                <flux:button href="{{ route('organizations.edit', $organization) }}" variant="primary" icon="pencil">
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
            {{-- Left Column: Organization Info --}}
            <div class="space-y-6">
                {{-- Organization Details Card --}}
                <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('contacts.contact_details') }}</h3>
                    <div class="space-y-4">
                        @if($organization->email)
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">{{ __('contacts.email') }}</p>
                                <a href="mailto:{{ $organization->email }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 flex items-center gap-2">
                                    <flux:icon.envelope class="size-4" />
                                    {{ $organization->email }}
                                </a>
                            </div>
                        @endif
                        @if($organization->phone)
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">{{ __('contacts.phone') }}</p>
                                <a href="tel:{{ $organization->phone }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 flex items-center gap-2">
                                    <flux:icon.phone class="size-4" />
                                    {{ $organization->phone }}
                                </a>
                            </div>
                        @endif
                        @if($organization->website)
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">{{ __('contacts.website') }}</p>
                                <a href="{{ $organization->website }}" target="_blank" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 flex items-center gap-2">
                                    <flux:icon.globe-alt class="size-4" />
                                    {{ $organization->website }}
                                </a>
                            </div>
                        @endif
                        @if($organization->full_address)
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">{{ __('contacts.address') }}</p>
                                <p class="text-gray-900 dark:text-white">{{ $organization->full_address }}</p>
                            </div>
                        @endif
                        @if($organization->city || $organization->country)
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">{{ __('contacts.location') }}</p>
                                <p class="text-gray-900 dark:text-white">
                                    @if(is_array($organization->address))
                                        @if(isset($organization->address['city'])){{ $organization->address['city'] }}@endif
                                        @if(isset($organization->address['city']) && isset($organization->address['country'])), @endif
                                        @if(isset($organization->address['country'])){{ $organization->address['country'] }}@endif
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Tags Card --}}
                @if($organization->tags && count($organization->tags) > 0)
                    <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('contacts.tags') }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($organization->tags as $tag)
                                <span class="px-3 py-1 text-sm bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 rounded-full">
                                    #{{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Stats Card --}}
                <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('contacts.statistics') }}</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('contacts.contacts') }}</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $organization->contacts->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('contacts.created') }}</span>
                            <span class="text-gray-900 dark:text-white">{{ $organization->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('contacts.last_updated') }}</span>
                            <span class="text-gray-900 dark:text-white">{{ $organization->updated_at->diffForHumans() }}</span>
                        </div>
                        @if($organization->creator)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('contacts.created_by') }}</span>
                                <span class="text-gray-900 dark:text-white">{{ $organization->creator->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Column: Contacts & Notes --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Notes Section --}}
                @if($organization->notes)
                    <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('contacts.notes') }}</h3>
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $organization->notes }}</p>
                    </div>
                @endif

                {{-- Contacts List --}}
                <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ __('contacts.contacts') }} ({{ $organization->contacts->count() }})
                        </h3>
                        <flux:button href="{{ route('contacts.create') }}?organization_id={{ $organization->id }}" size="sm" variant="primary" icon="plus">
                            {{ __('contacts.add_contact') }}
                        </flux:button>
                    </div>

                    @if($organization->contacts->count() > 0)
                        <div class="space-y-3">
                            @foreach($organization->contacts as $contact)
                                <a href="{{ route('contacts.show', $contact) }}" class="flex items-center gap-4 p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-neutral-700/50 transition-colors">
                                    <div class="flex-shrink-0 size-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                                        {{ $contact->initials }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $contact->full_name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            @if($contact->position)
                                                {{ $contact->position }}
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-500">{{ $contact->email }}</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            {{ $contact->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                            {{ $contact->status === 'inactive' ? 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                                        ">
                                            {{ ucfirst($contact->status) }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <flux:icon.users class="mx-auto size-12 text-gray-400" />
                            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('contacts.no_contacts') }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">{{ __('contacts.add_contacts_help') }}</p>
                        </div>
                    @endif
                </div>

                {{-- Description Section --}}
                @if($organization->description)
                    <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('contacts.description') }}</h3>
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $organization->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
