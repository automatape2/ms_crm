<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\Interaction;
use App\Models\Campaign;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $stats = [];
    public $recentInteractions = [];
    public $upcomingInteractions = [];
    public $activeCampaigns = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadRecentInteractions();
        $this->loadUpcomingInteractions();
        $this->loadActiveCampaigns();
    }

    public function loadStats()
    {
        $this->stats = [
            // Totales generales
            'total_contacts' => Contact::count(),
            'active_contacts' => Contact::active()->count(),
            'total_organizations' => Organization::count(),
            'active_organizations' => Organization::active()->count(),
            
            // Estadísticas del mes actual
            'interactions_this_month' => Interaction::whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->count(),
            'positive_interactions' => Interaction::where('outcome', 'positive')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->count(),
            'active_scheduled_campaigns' => Campaign::whereIn('status', ['active', 'scheduled'])->count(),
            'contacts_this_month' => Contact::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        // Calculate growth percentages (comparing with last month)
        $lastMonthContacts = Contact::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $this->stats['contact_growth'] = $lastMonthContacts > 0
            ? round((($this->stats['contacts_this_month'] - $lastMonthContacts) / $lastMonthContacts) * 100, 1)
            : 0;

        // Interactions by type (for chart)
        $this->stats['interactions_by_type'] = Interaction::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type')
            ->toArray();

        // Organizations by type (for chart)
        $this->stats['organizations_by_type'] = Organization::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type')
            ->toArray();
    }

    public function loadRecentInteractions()
    {
        $this->recentInteractions = Interaction::with(['contact', 'organization', 'creator'])
            ->past()
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
    }

    public function loadUpcomingInteractions()
    {
        $this->upcomingInteractions = Interaction::with(['contact', 'organization', 'creator'])
            ->upcoming()
            ->orderBy('date', 'asc')
            ->limit(5)
            ->get();
    }

    public function loadActiveCampaigns()
    {
        // Load both active and scheduled campaigns (matching the KPI count)
        $this->activeCampaigns = Campaign::whereIn('status', ['active', 'scheduled'])
            ->orderBy('scheduled_at', 'asc')
            ->limit(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('components.layouts.app', ['title' => 'Dashboard CRM']);
    }
}
