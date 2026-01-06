<div class="flex h-full w-full flex-1 flex-col gap-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('organizations.new_organization') }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('organizations.subtitle') }}</p>
        </div>
    </div>

    {{-- Form --}}
    <form wire:submit="save" class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="grid gap-6 md:grid-cols-2">
            {{-- Basic Information --}}
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('organizations.basic_information') }}</h3>
            </div>

            {{-- Name --}}
            <div class="md:col-span-2">
                <flux:input
                    wire:model="name"
                    label="{{ __('organizations.name_label') }}"
                    placeholder="{{ __('organizations.name_placeholder') }}"
                    required
                />
                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Type --}}
            <div>
                <flux:select wire:model="type" label="{{ __('organizations.type_label') }}" required>
                    <option value="">{{ __('organizations.type_select') }}</option>
                    <option value="gobierno">{{ __('dashboard.gobierno') }}</option>
                    <option value="ong">{{ __('dashboard.ong') }}</option>
                    <option value="empresa">{{ __('dashboard.empresa') }}</option>
                    <option value="comunidad">{{ __('dashboard.comunidad') }}</option>
                    <option value="otro">{{ __('dashboard.otro') }}</option>
                </flux:select>
                @error('type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Industry --}}
            <div>
                <flux:input
                    wire:model="industry"
                    label="{{ __('organizations.industry_label') }}"
                    placeholder="{{ __('organizations.industry_placeholder') }}"
                />
                @error('industry') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Contact Information --}}
            <div class="md:col-span-2 mt-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('organizations.contact_information') }}</h3>
            </div>

            {{-- Email --}}
            <div>
                <flux:input
                    wire:model="email"
                    type="email"
                    label="{{ __('organizations.email_label') }}"
                    placeholder="{{ __('organizations.email_placeholder') }}"
                />
                @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Phone --}}
            <div>
                <flux:input
                    wire:model="phone"
                    label="{{ __('organizations.phone_label') }}"
                    placeholder="{{ __('organizations.phone_placeholder') }}"
                />
                @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Website --}}
            <div class="md:col-span-2">
                <flux:input
                    wire:model="website"
                    type="url"
                    label="{{ __('organizations.website_label') }}"
                    placeholder="{{ __('organizations.website_placeholder') }}"
                />
                @error('website') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Address --}}
            <div class="md:col-span-2 mt-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('organizations.address_section') }}</h3>
            </div>

            {{-- Street --}}
            <div class="md:col-span-2">
                <flux:input
                    wire:model="street"
                    label="{{ __('organizations.street_label') }}"
                    placeholder="{{ __('organizations.street_placeholder') }}"
                />
                @error('street') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- City --}}
            <div>
                <flux:input
                    wire:model="city"
                    label="{{ __('organizations.city_label') }}"
                    placeholder="{{ __('organizations.city_placeholder') }}"
                />
                @error('city') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- State --}}
            <div>
                <flux:input
                    wire:model="state"
                    label="{{ __('organizations.state_label') }}"
                    placeholder="{{ __('organizations.state_placeholder') }}"
                />
                @error('state') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Country --}}
            <div>
                <flux:input
                    wire:model="country"
                    label="{{ __('organizations.country_label') }}"
                    placeholder="{{ __('organizations.country_placeholder') }}"
                />
                @error('country') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Status --}}
            <div>
                <flux:select wire:model="status" label="{{ __('organizations.status_label') }}" required>
                    <option value="active">{{ __('organizations.active') }}</option>
                    <option value="inactive">{{ __('organizations.inactive') }}</option>
                </flux:select>
                @error('status') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <flux:button href="{{ route('organizations.index') }}" variant="ghost">
                {{ __('organizations.cancel') }}
            </flux:button>
            <flux:button type="submit" variant="primary">
                {{ __('organizations.save') }}
            </flux:button>
        </div>
    </form>
</div>
