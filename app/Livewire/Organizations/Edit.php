<?php

namespace App\Livewire\Organizations;

use Livewire\Component;
use App\Models\Organization;

class Edit extends Component
{
    public Organization $organization;
    
    public $name = '';
    public $type = '';
    public $industry = '';
    public $website = '';
    public $email = '';
    public $phone = '';
    public $status = 'active';
    public $street = '';
    public $city = '';
    public $state = '';
    public $country = '';
    public $description = '';
    public $notes = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|in:gobierno,ong,empresa,comunidad,otro',
        'industry' => 'nullable|string|max:255',
        'website' => 'nullable|url|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:50',
        'status' => 'required|in:active,inactive',
        'street' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'notes' => 'nullable|string',
    ];

    public function mount($id)
    {
        $this->organization = Organization::findOrFail($id);
        
        $this->name = $this->organization->name;
        $this->type = $this->organization->type;
        $this->industry = $this->organization->industry ?? '';
        $this->website = $this->organization->website ?? '';
        $this->email = $this->organization->email ?? '';
        $this->phone = $this->organization->phone ?? '';
        $this->status = $this->organization->status;
        $this->description = $this->organization->description ?? '';
        $this->notes = $this->organization->notes ?? '';
        
        // Parse address if it exists
        if ($this->organization->address) {
            $address = is_array($this->organization->address) 
                ? $this->organization->address 
                : json_decode($this->organization->address, true);
            
            $this->street = $address['street'] ?? '';
            $this->city = $address['city'] ?? '';
            $this->state = $address['state'] ?? '';
            $this->country = $address['country'] ?? '';
        }
    }

    public function update()
    {
        $this->validate();

        $address = array_filter([
            'street' => $this->street,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
        ]);

        $this->organization->update([
            'name' => $this->name,
            'type' => $this->type,
            'industry' => $this->industry,
            'website' => $this->website,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'address' => $address ?: null,
            'description' => $this->description,
            'notes' => $this->notes,
        ]);

        session()->flash('message', 'Organización actualizada exitosamente.');
        
        return redirect()->route('organizations.show', $this->organization->id);
    }

    public function render()
    {
        return view('livewire.organizations.edit')
            ->layout('components.layouts.app', ['title' => __('organizations.edit_organization')]);
    }
}
