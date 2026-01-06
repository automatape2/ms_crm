<?php

namespace App\Livewire\Contacts;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contact;
use App\Models\Organization;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterOrganization = '';
    public $filterSource = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterOrganization' => ['except' => ''],
        'filterSource' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterStatus = '';
        $this->filterOrganization = '';
        $this->filterSource = '';
        $this->resetPage();
    }

    public function deleteContact($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        session()->flash('message', 'Contacto eliminado exitosamente.');
    }

    public function render()
    {
        $contacts = Contact::query()
            ->with('organization')
            ->when($this->search, function ($query) {
                $query->search($this->search);
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterOrganization, function ($query) {
                $query->where('organization_id', $this->filterOrganization);
            })
            ->when($this->filterSource, function ($query) {
                $query->where('source', $this->filterSource);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $organizations = Organization::active()->orderBy('name')->get();

        return view('livewire.contacts.index', [
            'contacts' => $contacts,
            'organizations' => $organizations,
        ])->layout('components.layouts.app', ['title' => 'Contactos']);
    }
}
