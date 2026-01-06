
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Contactos</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Gestiona todos tus contactos</p>
            </div>
            <flux:button href="{{ route('contacts.create') }}" icon="user-plus" variant="primary">
                Nuevo Contacto
            </flux:button>
        </div>

        {{-- Filters --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            <div class="grid gap-4 md:grid-cols-4">
                {{-- Search --}}
                <div class="md:col-span-2">
                    <flux:input
                        wire:model.live.debounce.300ms="search"
                        type="search"
                        placeholder="Buscar contactos..."
                        icon="magnifying-glass"
                    />
                </div>

                {{-- Status Filter --}}
                <div>
                    <flux:select wire:model.live="filterStatus">
                        <option value="">Todos los estados</option>
                        <option value="active">Activos</option>
                        <option value="inactive">Inactivos</option>
                        <option value="archived">Archivados</option>
                    </flux:select>
                </div>

                {{-- Organization Filter --}}
                <div>
                    <flux:select wire:model.live="filterOrganization">
                        <option value="">Todas las organizaciones</option>
                        @foreach($organizations as $org)
                            <option value="{{ $org->id }}">{{ $org->name }}</option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            {{-- Active Filters Display --}}
            @if($search || $filterStatus || $filterOrganization || $filterSource)
                <div class="flex items-center gap-2 mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Filtros activos:</span>
                    @if($search)
                        <flux:badge color="blue">Búsqueda: "{{ $search }}"</flux:badge>
                    @endif
                    @if($filterStatus)
                        <flux:badge color="green">Estado: {{ ucfirst($filterStatus) }}</flux:badge>
                    @endif
                    @if($filterOrganization)
                        <flux:badge color="purple">Organización filtrada</flux:badge>
                    @endif
                    <flux:button wire:click="resetFilters" size="sm" variant="ghost">
                        Limpiar filtros
                    </flux:button>
                </div>
            @endif
        </div>

        {{-- Flash Message --}}
        @if (session()->has('message'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        {{-- Contacts Table --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-neutral-900 border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <button wire:click="sortBy('first_name')" class="flex items-center gap-1 text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider hover:text-gray-900 dark:hover:text-white">
                                    Nombre
                                    @if($sortField === 'first_name')
                                        <flux:icon.chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }} class="size-4" />
                                    @endif
                                </button>
                            </th>
                            <th class="px-6 py-3 text-left">
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Email & Teléfono
                                </span>
                            </th>
                            <th class="px-6 py-3 text-left">
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Organización
                                </span>
                            </th>
                            <th class="px-6 py-3 text-left">
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Estado
                                </span>
                            </th>
                            <th class="px-6 py-3 text-left">
                                <button wire:click="sortBy('created_at')" class="flex items-center gap-1 text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider hover:text-gray-900 dark:hover:text-white">
                                    Creado
                                    @if($sortField === 'created_at')
                                        <flux:icon.chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }} class="size-4" />
                                    @endif
                                </button>
                            </th>
                            <th class="px-6 py-3 text-right">
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Acciones
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($contacts as $contact)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-900/50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 size-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                                            {{ $contact->initials }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                {{ $contact->full_name }}
                                            </div>
                                            @if($contact->position)
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $contact->position }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <div class="text-gray-900 dark:text-white">{{ $contact->email }}</div>
                                        @if($contact->phone)
                                            <div class="text-gray-500 dark:text-gray-400">{{ $contact->phone }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($contact->organization)
                                        <div class="text-sm">
                                            <div class="text-gray-900 dark:text-white">{{ $contact->organization->name }}</div>
                                            <div class="text-gray-500 dark:text-gray-400">{{ $contact->organization->getTypeLabel() }}</div>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400 dark:text-gray-500">Sin organización</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        {{ $contact->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                        {{ $contact->status === 'inactive' ? 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                                        {{ $contact->status === 'archived' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                    ">
                                        {{ ucfirst($contact->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $contact->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <flux:button href="{{ route('contacts.show', $contact->id) }}" size="sm" variant="ghost" icon="eye">
                                            Ver
                                        </flux:button>
                                        <flux:button
                                            wire:click="deleteContact({{ $contact->id }})"
                                            wire:confirm="¿Estás seguro de eliminar este contacto?"
                                            size="sm"
                                            variant="ghost"
                                            icon="trash"
                                            class="text-red-600 hover:text-red-700"
                                        >
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <flux:icon.user-group class="size-12 text-gray-400" />
                                        <p class="text-gray-500 dark:text-gray-400">No se encontraron contactos</p>
                                        @if($search || $filterStatus || $filterOrganization)
                                            <flux:button wire:click="resetFilters" size="sm">
                                                Limpiar filtros
                                            </flux:button>
                                        @else
                                            <flux:button href="{{ route('contacts.create') }}" size="sm">
                                                Crear primer contacto
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
            @if($contacts->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $contacts->links() }}
                </div>
            @endif
        </div>

        {{-- Stats Footer --}}
        <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400">
            <div>
                Mostrando {{ $contacts->firstItem() ?? 0 }} - {{ $contacts->lastItem() ?? 0 }} de {{ $contacts->total() }} contactos
            </div>
        </div>
    </div>

