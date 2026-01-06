<?php

namespace App\Livewire\Campaigns;

use Livewire\Component;
use App\Models\Campaign;
use App\Models\Segment;

class Create extends Component
{
    public $name = '';
    public $description = '';
    public $type = '';
    public $status = 'draft';
    public $segment_id = '';
    public $scheduled_at = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'type' => 'required|in:email,sms,phone,event,social',
        'status' => 'required|in:draft,scheduled,active,paused,completed,cancelled',
        'segment_id' => 'nullable|exists:segments,id',
        'scheduled_at' => 'nullable|date',
    ];

    public function save()
    {
        $this->validate();

        Campaign::create([
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'status' => $this->status,
            'segment_id' => $this->segment_id ?: null,
            'scheduled_at' => $this->scheduled_at ?: null,
            'created_by' => auth()->id(),
        ]);

        session()->flash('message', 'Campaña creada exitosamente.');
        
        return redirect()->route('campaigns.index');
    }

    public function render()
    {
        $segments = Segment::orderBy('name')->get();

        return view('livewire.campaigns.create', [
            'segments' => $segments,
        ])->layout('components.layouts.app', ['title' => __('campaigns.new_campaign')]);
    }
}
