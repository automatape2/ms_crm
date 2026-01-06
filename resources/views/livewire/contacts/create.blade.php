<x-layouts.app title="Nuevo Contacto">
    <div class="max-w-3xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Nuevo Contacto</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Agrega un nuevo contacto al CRM</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <form wire:submit="save">
                {{-- Personal Information --}}
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información Personal</h2>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <flux:input
                                wire:model="first_name"
                                label="Nombre *"
                                placeholder="Ej: María"
                                required
                            />
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:input
                                wire:model="last_name"
                                label="Apellido *"
                                placeholder="Ej: González"
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
                                label="Email *"
                                placeholder="maria@example.com"
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
                                label="Teléfono"
                                placeholder="+1 234 567 890"
                            />
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <flux:input
                                wire:model="position"
                                label="Cargo / Posición"
                                placeholder="Ej: Directora de Comunicaciones"
                            />
                            @error('position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Organization & Classification --}}
                <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Organización y Clasificación</h2>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <flux:select wire:model="organization_id" label="Organización">
                                <option value="">Sin organización</option>
                                @foreach($organizations as $org)
                                    <option value="{{ $org->id }}">{{ $org->name }}</option>
                                @endforeach
                            </flux:select>
                            @error('organization_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:select wire:model="status" label="Estado *" required>
                                <option value="active">Activo</option>
                                <option value="inactive">Inactivo</option>
                                <option value="archived">Archivado</option>
                            </flux:select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:select wire:model="source" label="Fuente *" required>
                                <option value="manual">Manual</option>
                                <option value="import">Importación</option>
                                <option value="form">Formulario</option>
                                <option value="api">API</option>
                            </flux:select>
                            @error('source')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:input
                                wire:model="tags"
                                label="Etiquetas"
                                placeholder="tag1, tag2, tag3"
                                description="Separadas por comas"
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
                        Cancelar
                    </flux:button>
                    <div class="flex gap-3">
                        <flux:button type="submit" variant="primary" icon="check">
                            Guardar Contacto
                        </flux:button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Help Text --}}
        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
            <p class="text-sm text-blue-700 dark:text-blue-400">
                <strong>💡 Consejo:</strong> Los campos marcados con * son obligatorios. Puedes agregar etiquetas personalizadas para clasificar mejor tus contactos.
            </p>
        </div>
    </div>
</x-layouts.app>
