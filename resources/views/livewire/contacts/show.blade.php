
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        {{-- Header with Actions --}}
        <div class="flex items-start justify-between">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 size-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl">
                    {{ $contact->initials }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $contact->full_name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        @if($contact->position)
                            {{ $contact->position }}
                            @if($contact->organization)
                                · {{ $contact->organization->name }}
                            @endif
                        @elseif($contact->organization)
                            {{ $contact->organization->name }}
                        @endif
                    </p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            {{ $contact->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                            {{ $contact->status === 'inactive' ? 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                            {{ $contact->status === 'archived' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : '' }}
                        ">
                            {{ ucfirst($contact->status) }}
                        </span>
                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400 rounded-full">
                            {{ $contact->getSourceLabel() }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <flux:button href="{{ route('contacts.index') }}" variant="ghost" icon="arrow-left">
                    {{ __('contacts.back') }}
                </flux:button>
                <flux:button wire:click="toggleInteractionForm" variant="primary" icon="plus">
                    {{ __('contacts.new_interaction') }}
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
            {{-- Left Column: Contact Info --}}
            <div class="space-y-6">
                {{-- Contact Details Card --}}
                <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('contacts.contact_information') }}</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Email</p>
                            <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 flex items-center gap-2">
                                <flux:icon.envelope class="size-4" />
                                {{ $contact->email }}
                            </a>
                        </div>
                        @if($contact->phone)
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">{{ __('contacts.phone_label') }}</p>
                                <a href="tel:{{ $contact->phone }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 flex items-center gap-2">
                                    <flux:icon.phone class="size-4" />
                                    {{ $contact->phone }}
                                </a>
                            </div>
                        @endif
                        @if($contact->organization)
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Organización</p>
                                <p class="text-gray-900 dark:text-white">{{ $contact->organization->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $contact->organization->getTypeLabel() }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Tags Card --}}
                @if($contact->tags && count($contact->tags) > 0)
                    <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Etiquetas</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($contact->tags as $tag)
                                <span class="px-3 py-1 text-sm bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full">
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
                            <span class="text-gray-600 dark:text-gray-400">{{ __('contacts.interactions_label') }}</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $contact->interactions->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('contacts.created_label') }}</span>
                            <span class="text-gray-900 dark:text-white">{{ $contact->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('contacts.last_update_label') }}</span>
                            <span class="text-gray-900 dark:text-white">{{ $contact->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Interactions Timeline --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- New Interaction Form (when visible) --}}
                @if($showInteractionForm)
                    <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('contacts.new_interaction') }}</h3>
                            <flux:button wire:click="toggleInteractionForm" variant="ghost" size="sm" icon="x-mark">
                            </flux:button>
                        </div>
                        <form wire:submit="saveInteraction">
                            <div class="grid gap-4">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <flux:select wire:model="interactionType" label="{{ __('contacts.interaction_type') }}" required>
                                        <option value="email">📧 {{ __('contacts.interaction_email') }}</option>
                                        <option value="call">📞 {{ __('contacts.interaction_call') }}</option>
                                        <option value="meeting">🤝 {{ __('contacts.interaction_meeting') }}</option>
                                        <option value="event">📅 {{ __('contacts.interaction_event') }}</option>
                                        <option value="note">📝 {{ __('contacts.interaction_note') }}</option>
                                        <option value="other">📌 {{ __('contacts.interaction_other') }}</option>
                                    </flux:select>

                                    <flux:input
                                        wire:model="interactionDate"
                                        type="datetime-local"
                                        label="{{ __('contacts.interaction_date') }}"
                                        required
                                    />
                                </div>

                                <flux:input
                                    wire:model="interactionSubject"
                                    label="{{ __('contacts.interaction_subject') }}"
                                    placeholder="{{ __('contacts.interaction_subject_placeholder') }}"
                                    required
                                />

                                <flux:textarea
                                    wire:model="interactionDescription"
                                    label="{{ __('contacts.interaction_description') }}"
                                    placeholder="{{ __('contacts.interaction_description_placeholder') }}"
                                    rows="3"
                                />

                                <div class="grid gap-4 md:grid-cols-3">
                                    <flux:input
                                        wire:model="interactionDuration"
                                        type="number"
                                        label="{{ __('contacts.interaction_duration') }}"
                                        placeholder="60"
                                        min="0"
                                    />

                                    <flux:select wire:model="interactionOutcome" label="{{ __('contacts.interaction_outcome') }}">
                                        <option value="">{{ __('contacts.interaction_outcome_none') }}</option>
                                        <option value="positive">✅ {{ __('contacts.interaction_outcome_positive') }}</option>
                                        <option value="neutral">➖ {{ __('contacts.interaction_outcome_neutral') }}</option>
                                        <option value="negative">❌ {{ __('contacts.interaction_outcome_negative') }}</option>
                                    </flux:select>
                                </div>

                                <flux:textarea
                                    wire:model="interactionNextSteps"
                                    label="{{ __('contacts.interaction_next_steps') }}"
                                    placeholder="{{ __('contacts.interaction_next_steps_placeholder') }}"
                                    rows="2"
                                />

                                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <flux:button wire:click="toggleInteractionForm" type="button" variant="ghost">
                                        {{ __('contacts.interaction_cancel') }}
                                    </flux:button>
                                    <flux:button type="submit" variant="primary">
                                        {{ __('contacts.interaction_save') }}
                                    </flux:button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- Interactions Timeline --}}
                <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
                        {{ __('contacts.interaction_timeline') }} ({{ $contact->interactions->count() }})
                    </h3>

                    @if($contact->interactions->count() > 0)
                        <div class="space-y-6">
                            @foreach($contact->interactions->sortByDesc('date') as $interaction)
                                <div class="relative pl-6 pb-6 border-l-2 border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                                    {{-- Timeline Icon --}}
                                    <div class="absolute -left-[13px] top-0 size-6 rounded-full bg-white dark:bg-neutral-800 border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center text-sm">
                                        {{ $interaction->type_icon }}
                                    </div>

                                    {{-- Interaction Card --}}
                                    <div class="bg-gray-50 dark:bg-neutral-900/50 rounded-lg p-4">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900 dark:text-white">{{ $interaction->subject }}</h4>
                                                <div class="flex items-center gap-2 mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                    <span>{{ $interaction->getTypeLabel() }}</span>
                                                 ·
                                                    <span>{{ $interaction->date->format('d/m/Y H:i') }}</span>
                                                    @if($interaction->duration)
                                                        · <span>{{ $interaction->duration_formatted }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                @if($interaction->outcome)
                                                    <span class="px-2 py-1 text-xs rounded-full
                                                        {{ $interaction->outcome === 'positive' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                                        {{ $interaction->outcome === 'neutral' ? 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                                                        {{ $interaction->outcome === 'negative' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                                    ">
                                                        {{ $interaction->outcome_label }}
                                                    </span>
                                                @endif
                                                <flux:button
                                                    wire:click="deleteInteraction({{ $interaction->id }})"
                                                    wire:confirm="{{ __('contacts.interaction_delete_confirm') }}"
                                                    size="sm"
                                                    variant="ghost"
                                                    icon="trash"
                                                    class="text-red-600"
                                                >
                                                </flux:button>
                                            </div>
                                        </div>

                                        @if($interaction->description)
                                            <div class="mt-3 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                                {{ $interaction->description }}
                                            </div>
                                        @endif

                                        @if($interaction->next_steps)
                                            <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded">
                                                <p class="text-xs font-medium text-blue-700 dark:text-blue-400 mb-1">{{ __('contacts.interaction_next_steps_label') }}</p>
                                                <p class="text-sm text-blue-900 dark:text-blue-300 whitespace-pre-line">{{ $interaction->next_steps }}</p>
                                            </div>
                                        @endif

                                        @if($interaction->creator)
                                            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 text-xs text-gray-500 dark:text-gray-400">
                                                {{ __('contacts.interaction_created_by') }} {{ $interaction->creator->name }} · {{ $interaction->created_at->diffForHumans() }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <flux:icon.chat-bubble-left-right class="size-12 text-gray-400 mx-auto mb-3" />
                            <p class="text-gray-500 dark:text-gray-400 mb-4">{{ __('contacts.no_interactions') }}</p>
                            <flux:button wire:click="toggleInteractionForm" variant="primary" size="sm">
                                {{ __('contacts.record_first_interaction') }}
                            </flux:button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

