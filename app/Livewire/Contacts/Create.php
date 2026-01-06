<?php

namespace App\Livewire\Contacts;

use Livewire\Component;
use App\Models\Contact;
use App\Models\Organization;

class Create extends Component
{
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $position = '';
    public $organization_id = '';
    public $tags = '';
    public $status = 'active';
    public $source = 'manual';

    public function mount()
    {
        $this->organization_id = request()->query('organization_id', '');
    }

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:contacts,email',
        'phone' => 'nullable|string|max:255',
        'position' => 'nullable|string|max:255',
        'organization_id' => 'nullable|exists:organizations,id',
        'tags' => 'nullable|string',
        'status' => 'required|in:active,inactive,archived',
        'source' => 'required|in:manual,import,form,api',
    ];

    public function save()
    {
        $this->validate();

        $tags = $this->tags ? array_map('trim', explode(',', $this->tags)) : [];

        Contact::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'position' => $this->position,
            'organization_id' => $this->organization_id ?: null,
            'tags' => $tags,
            'status' => $this->status,
            'source' => $this->source,
            'created_by' => auth()->id(),
        ]);

        session()->flash('message', 'Contacto creado exitosamente.');
        
        return redirect()->route('contacts.index');
    }

    public function render()
    {
        $organizations = Organization::active()->orderBy('name')->get();

        return view('livewire.contacts.create', [
            'organizations' => $organizations,
        ])->layout('components.layouts.app', ['title' => 'Nuevo Contacto']);
    }
}
