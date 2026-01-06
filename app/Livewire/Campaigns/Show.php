<?php

namespace App\Livewire\Campaigns;

use Livewire\Component;
use App\Models\Campaign;

class Show extends Component
{
    public Campaign $campaign;

    public function mount($id)
    {
        $this->campaign = Campaign::with(['segment', 'creator', 'activities'])
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.campaigns.show')
            ->layout('components.layouts.app', ['title' => $this->campaign->name]);
    }
}
