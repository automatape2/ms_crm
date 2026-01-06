<div class="max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('campaigns.new_campaign') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('campaigns.new_campaign_subtitle') }}</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <form wire:submit="save">
            {{-- Basic Information --}}
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('campaigns.basic_info') }}</h2>
                <div class="grid gap-6">
                    <div>
                        <flux:input
                            wire:model="name"
                            label="{{ __('campaigns.name') }} *"
                            placeholder="{{ __('campaigns.name_placeholder') }}"
                            required
                        />
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <flux:textarea
                            wire:model="description"
                            label="{{ __('campaigns.description') }}"
                            placeholder="{{ __('campaigns.description_placeholder') }}"
                            rows="3"
                        />
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Campaign Settings --}}
            <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('campaigns.settings') }}</h2>
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <flux:select wire:model="type" label="{{ __('campaigns.type') }} *" required>
                            <option value="">{{ __('campaigns.select_type') }}</option>
                            <option value="email">📧 {{ __('campaigns.type_email') }}</option>
                            <option value="sms">💬 {{ __('campaigns.type_sms') }}</option>
                            <option value="phone">📞 {{ __('campaigns.type_phone') }}</option>
                            <option value="event">📅 {{ __('campaigns.type_event') }}</option>
                            <option value="social">📱 {{ __('campaigns.type_social') }}</option>
                        </flux:select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <flux:select wire:model="status" label="{{ __('campaigns.status') }} *" required>
                            <option value="draft">{{ __('campaigns.status_draft') }}</option>
                            <option value="scheduled">{{ __('campaigns.status_scheduled') }}</option>
                            <option value="active">{{ __('campaigns.status_active') }}</option>
                        </flux:select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <flux:select wire:model="segment_id" label="{{ __('campaigns.segment') }}">
                            <option value="">{{ __('campaigns.all_contacts') }}</option>
                            @foreach($segments as $segment)
                                <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                            @endforeach
                        </flux:select>
                        @error('segment_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <flux:input
                            wire:model="scheduled_at"
                            type="datetime-local"
                            label="{{ __('campaigns.scheduled_at') }}"
                        />
                        @error('scheduled_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between">
                <flux:button href="{{ route('campaigns.index') }}" variant="ghost">
                    {{ __('contacts.cancel') }}
                </flux:button>
                <div class="flex gap-3">
                    <flux:button type="submit" variant="primary" icon="check">
                        {{ __('campaigns.save_campaign') }}
                    </flux:button>
                </div>
            </div>
        </form>
    </div>
</div>
