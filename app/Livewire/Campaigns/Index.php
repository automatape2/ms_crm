<?php

namespace App\Livewire\Campaigns;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Campaign;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterType = '';
    public $filterStatus = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterType' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
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
        $this->reset(['search', 'filterType', 'filterStatus']);
        $this->resetPage();
    }

    public function render()
    {
        $campaigns = Campaign::query()
            ->with(['segment', 'creator'])
            ->when($this->search, function ($query) {
                $query->search($this->search);
            })
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        return view('livewire.campaigns.index', [
            'campaigns' => $campaigns,
        ])->layout('components.layouts.app', ['title' => __('campaigns.title')]);
    }
}
