<div class="flex h-full w-full flex-1 flex-col gap-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('organizations.edit_organization') }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $organization->name }}</p>
        </div>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    {{-- Form --}}
    <form wire:submit="update" class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="grid gap-6 md:grid-cols-2">
            {{-- Basic Information --}}
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información Básica</h3>
            </div>

            {{-- Name --}}
            <div class="md:col-span-2">
                <flux:input
                    wire:model="name"
                    label="Nombre *"
                    placeholder="Nombre de la organización"
                    required
                />
                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Type --}}
            <div>
                <flux:select wire:model="type" label="Tipo *" required>
                    <option value="">Seleccionar tipo</option>
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
                    label="Industria"
                    placeholder="Ej: Tecnología, Salud, Educación"
                />
                @error('industry') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Contact Information --}}
            <div class="md:col-span-2 mt-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información de Contacto</h3>
            </div>

            {{-- Email --}}
            <div>
                <flux:input
                    wire:model="email"
                    type="email"
                    label="Email"
                    placeholder="contacto@organizacion.com"
                />
                @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Phone --}}
            <div>
                <flux:input
                    wire:model="phone"
                    label="Teléfono"
                    placeholder="+1 234 567 8900"
                />
                @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Website --}}
            <div class="md:col-span-2">
                <flux:input
                    wire:model="website"
                    type="url"
                    label="Sitio Web"
                    placeholder="https://ejemplo.com"
                />
                @error('website') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Address --}}
            <div class="md:col-span-2 mt-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Dirección</h3>
            </div>

            {{-- Street --}}
            <div class="md:col-span-2">
                <flux:input
                    wire:model="street"
                    label="Calle"
                    placeholder="Calle Principal 123"
                />
                @error('street') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- City --}}
            <div>
                <flux:input
                    wire:model="city"
                    label="Ciudad"
                    placeholder="Ciudad"
                />
                @error('city') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- State --}}
            <div>
                <flux:input
                    wire:model="state"
                    label="Estado/Provincia"
                    placeholder="Estado"
                />
                @error('state') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Country --}}
            <div>
                <flux:input
                    wire:model="country"
                    label="País"
                    placeholder="País"
                />
                @error('country') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Status --}}
            <div>
                <flux:select wire:model="status" label="Estado *" required>
                    <option value="active">{{ __('organizations.active') }}</option>
                    <option value="inactive">{{ __('organizations.inactive') }}</option>
                </flux:select>
                @error('status') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Additional Information --}}
            <div class="md:col-span-2 mt-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información Adicional</h3>
            </div>

            {{-- Description --}}
            <div class="md:col-span-2">
                <flux:textarea
                    wire:model="description"
                    label="Descripción"
                    placeholder="Descripción de la organización..."
                    rows="3"
                />
                @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Notes --}}
            <div class="md:col-span-2">
                <flux:textarea
                    wire:model="notes"
                    label="Notas Internas"
                    placeholder="Notas internas sobre la organización..."
                    rows="3"
                />
                @error('notes') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <flux:button href="{{ route('organizations.show', $organization) }}" variant="ghost">
                Cancelar
            </flux:button>
            <flux:button type="submit" variant="primary">
                Actualizar Organización
            </flux:button>
        </div>
    </form>
</div>
