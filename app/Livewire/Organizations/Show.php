<?php

namespace App\Livewire\Organizations;

use Livewire\Component;
use App\Models\Organization;

class Show extends Component
{
    public Organization $organization;

    public function mount($id)
    {
        $this->organization = Organization::with(['contacts', 'creator'])
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.organizations.show')
            ->layout('components.layouts.app', ['title' => $this->organization->name]);
    }
}
