<div class="flex h-full w-full flex-1 flex-col gap-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Resumen de tu CRM</p>
        </div>
        <div class="flex gap-3">
            <flux:button href="{{ route('contacts.create') }}" icon="user-plus" variant="primary">
                Nuevo Contacto
            </flux:button>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        {{-- Total Contacts --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Contactos</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['total_contacts'] ?? 0 }}</p>
                    @if(isset($stats['contact_growth']))
                        <p class="text-xs mt-2 {{ $stats['contact_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $stats['contact_growth'] > 0 ? '+' : '' }}{{ $stats['contact_growth'] }}% este mes
                        </p>
                    @endif
                </div>
                <div class="bg-blue-100 dark:bg-blue-900/30 rounded-full p-3">
                    <flux:icon.users class="size-8 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
        </div>

        {{-- Total Organizations --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Organizaciones</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['total_organizations'] ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-900/30 rounded-full p-3">
                    <flux:icon.building-office class="size-8 text-purple-600 dark:text-purple-400" />
                </div>
            </div>
        </div>

        {{-- Interactions This Month --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Interacciones (mes)</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['interactions_this_month'] ?? 0 }}</p>
                    @if(isset($stats['positive_interactions']))
                        <p class="text-xs text-green-600 mt-2">
                            {{ $stats['positive_interactions'] }} positivas
                        </p>
                    @endif
                </div>
                <div class="bg-green-100 dark:bg-green-900/30 rounded-full p-3">
                    <flux:icon.chat-bubble-left-right class="size-8 text-green-600 dark:text-green-400" />
                </div>
            </div>
        </div>

        {{-- Active Campaigns --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Campañas Activas</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['active_campaigns'] ?? 0 }}</p>
                </div>
                <div class="bg-orange-100 dark:bg-orange-900/30 rounded-full p-3">
                    <flux:icon.megaphone class="size-8 text-orange-600 dark:text-orange-400" />
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid gap-4 md:grid-cols-2">
        {{-- Interactions by Type --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Interacciones por Tipo</h3>
            <div class="space-y-3">
                @php
                    $typeIcons = [
                        'email' => '📧',
                        'call' => '📞',
                        'meeting' => '🤝',
                        'event' => '📅',
                        'note' => '📝',
                        'other' => '📌',
                    ];
                    $typeLabels = [
                        'email' => 'Email',
                        'call' => 'Llamadas',
                        'meeting' => 'Reuniones',
                        'event' => 'Eventos',
                        'note' => 'Notas',
                        'other' => 'Otros',
                    ];
                    $total = array_sum($stats['interactions_by_type'] ?? []);
                @endphp
                @forelse($stats['interactions_by_type'] ?? [] as $type => $count)
                    @php
                        $percentage = $total > 0 ? round(($count / $total) * 100, 1) : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $typeIcons[$type] ?? '' }} {{ $typeLabels[$type] ?? ucfirst($type) }}
                            </span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $count }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm">No hay interacciones este mes</p>
                @endforelse
            </div>
        </div>

        {{-- Organizations by Type --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Organizaciones por Tipo</h3>
            <div class="space-y-3">
                @php
                    $orgLabels = [
                        'gobierno' => 'Gobierno',
                        'ong' => 'ONG',
                        'empresa' => 'Empresa',
                        'comunidad' => 'Comunidad',
                        'otro' => 'Otro',
                    ];
                    $orgColors = [
                        'gobierno' => 'bg-blue-600',
                        'ong' => 'bg-green-600',
                        'empresa' => 'bg-purple-600',
                        'comunidad' => 'bg-orange-600',
                        'otro' => 'bg-gray-600',
                    ];
                    $totalOrgs = array_sum($stats['organizations_by_type'] ?? []);
                @endphp
                @forelse($stats['organizations_by_type'] ?? [] as $type => $count)
                    @php
                        $percentage = $totalOrgs > 0 ? round(($count / $totalOrgs) * 100, 1) : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $orgLabels[$type] ?? ucfirst($type) }}
                            </span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $count }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="{{ $orgColors[$type] ?? 'bg-gray-600' }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm">No hay organizaciones registradas</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent & Upcoming Interactions --}}
    <div class="grid gap-4 md:grid-cols-2">
        {{-- Recent Interactions --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Interacciones Recientes</h3>
            <div class="space-y-4">
                @forelse($recentInteractions as $interaction)
                    <div class="flex items-start gap-3 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                        <div class="text-2xl">{{ $interaction->type_icon }}</div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {{ $interaction->subject }}
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                {{ $interaction->contact->full_name }}
                                @if($interaction->organization)
                                    · {{ $interaction->organization->name }}
                                @endif
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                {{ $interaction->date->diffForHumans() }}
                            </p>
                        </div>
                        @if($interaction->outcome)
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $interaction->outcome === 'positive' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                {{ $interaction->outcome === 'neutral' ? 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                                {{ $interaction->outcome === 'negative' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : '' }}
                            ">
                                {{ $interaction->outcome_label }}
                            </span>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm">No hay interacciones recientes</p>
                @endforelse
            </div>
            <a href="{{ route('contacts.index') }}" class="block mt-4 text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                Ver todos los contactos →
            </a>
        </div>

        {{-- Upcoming Interactions --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Próximas Actividades</h3>
            <div class="space-y-4">
                @forelse($upcomingInteractions as $interaction)
                    <div class="flex items-start gap-3 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                        <div class="text-2xl">{{ $interaction->type_icon }}</div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {{ $interaction->subject }}
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                {{ $interaction->contact->full_name }}
                                @if($interaction->organization)
                                    · {{ $interaction->organization->name }}
                                @endif
                            </p>
                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1 font-medium">
                                {{ $interaction->date->format('d/m/Y H:i') }} ({{ $interaction->date->diffForHumans() }})
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm">No hay actividades programadas</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Active Campaigns --}}
    @if(count($activeCampaigns) > 0)
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Campañas Activas</h3>
            <div class="grid gap-4 md:grid-cols-3">
                @foreach($activeCampaigns as $campaign)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2 py-1 text-xs rounded-full font-medium
                                {{ $campaign->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                {{ $campaign->status === 'scheduled' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                            ">
                                {{ $campaign->status_label }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $campaign->type_label }}</span>
                        </div>
                        <h4 class="font-medium text-gray-900 dark:text-white mb-1">{{ $campaign->name }}</h4>
                        <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2">{{ $campaign->description }}</p>
                        @if($campaign->scheduled_at)
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                                📅 {{ $campaign->scheduled_at->format('d/m/Y') }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
