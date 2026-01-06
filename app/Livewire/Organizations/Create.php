<?php

namespace App\Livewire\Organizations;

use Livewire\Component;
use App\Models\Organization;

class Create extends Component
{
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
    ];

    public function save()
    {
        $this->validate();

        $address = array_filter([
            'street' => $this->street,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
        ]);

        Organization::create([
            'name' => $this->name,
            'type' => $this->type,
            'industry' => $this->industry,
            'website' => $this->website,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'address' => $address,
            'created_by' => auth()->id(),
        ]);

        session()->flash('message', 'Organización creada exitosamente.');
        
        return redirect()->route('organizations.index');
    }

    public function render()
    {
        return view('livewire.organizations.create')
            ->layout('components.layouts.app', ['title' => __('organizations.new_organization')]);
    }
}
