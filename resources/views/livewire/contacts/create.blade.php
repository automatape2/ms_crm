
    <div class="max-w-3xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('contacts.new_contact') }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('contacts.new_contact_subtitle') }}</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <form wire:submit="save">
                {{-- Personal Information --}}
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('contacts.personal_information') }}</h2>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <flux:input
                                wire:model="first_name"
                                label="{{ __('contacts.first_name') }} *"
                                placeholder="{{ __('contacts.first_name_placeholder') }}"
                                required
                            />
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:input
                                wire:model="last_name"
                                label="{{ __('contacts.last_name') }} *"
                                placeholder="{{ __('contacts.last_name_placeholder') }}"
                                required
                            />
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:input
                                wire:model="email"
                                type="email"
                                label="{{ __('contacts.email') }} *"
                                placeholder="{{ __('contacts.email_placeholder') }}"
                                required
                            />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:input
                                wire:model="phone"
                                type="tel"
                                label="{{ __('contacts.phone') }}"
                                placeholder="{{ __('contacts.phone_placeholder') }}"
                            />
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <flux:input
                                wire:model="position"
                                label="{{ __('contacts.position') }}"
                                placeholder="{{ __('contacts.position_placeholder') }}"
                            />
                            @error('position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Organization & Classification --}}
                <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('contacts.organization_classification') }}</h2>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <flux:select wire:model="organization_id" label="{{ __('contacts.organization') }}">
                                <option value="">{{ __('contacts.no_organization') }}</option>
                                @foreach($organizations as $org)
                                    <option value="{{ $org->id }}">{{ $org->name }}</option>
                                @endforeach
                            </flux:select>
                            @error('organization_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:select wire:model="status" label="{{ __('contacts.status') }} *" required>
                                <option value="active">{{ __('contacts.active') }}</option>
                                <option value="inactive">{{ __('contacts.inactive') }}</option>
                                <option value="archived">{{ __('contacts.archived') }}</option>
                            </flux:select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:select wire:model="source" label="{{ __('contacts.source') }} *" required>
                                <option value="manual">{{ __('contacts.source_manual') }}</option>
                                <option value="import">{{ __('contacts.source_import') }}</option>
                                <option value="form">{{ __('contacts.source_form') }}</option>
                                <option value="api">{{ __('contacts.source_api') }}</option>
                            </flux:select>
                            @error('source')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:input
                                wire:model="tags"
                                label="{{ __('contacts.tags') }}"
                                placeholder="{{ __('contacts.tags_placeholder') }}"
                                description="{{ __('contacts.tags_description') }}"
                            />
                            @error('tags')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-between">
                    <flux:button href="{{ route('contacts.index') }}" variant="ghost">
                        {{ __('contacts.cancel') }}
                    </flux:button>
                    <div class="flex gap-3">
                        <flux:button type="submit" variant="primary" icon="check">
                            {{ __('contacts.save_contact') }}
                        </flux:button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Help Text --}}
        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
            <p class="text-sm text-blue-700 dark:text-blue-400">
                <strong>💡 {{ __('contacts.tip') }}:</strong> {{ __('contacts.create_help_text') }}
            </p>
        </div>
    </div>

