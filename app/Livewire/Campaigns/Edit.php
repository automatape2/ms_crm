<?php

namespace App\Livewire\Campaigns;

use Livewire\Component;
use App\Models\Campaign;
use App\Models\Segment;

class Edit extends Component
{
    public Campaign $campaign;
    
    public $name = '';
    public $description = '';
    public $type = '';
    public $status = '';
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

    public function mount($id)
    {
        $this->campaign = Campaign::findOrFail($id);
        
        $this->name = $this->campaign->name;
        $this->description = $this->campaign->description ?? '';
        $this->type = $this->campaign->type;
        $this->status = $this->campaign->status;
        $this->segment_id = $this->campaign->segment_id ?? '';
        $this->scheduled_at = $this->campaign->scheduled_at ? $this->campaign->scheduled_at->format('Y-m-d\TH:i') : '';
    }

    public function update()
    {
        $this->validate();

        $this->campaign->update([
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'status' => $this->status,
            'segment_id' => $this->segment_id ?: null,
            'scheduled_at' => $this->scheduled_at ?: null,
        ]);

        session()->flash('message', 'Campaña actualizada exitosamente.');
        
        return redirect()->route('campaigns.show', $this->campaign->id);
    }

    public function render()
    {
        $segments = Segment::orderBy('name')->get();

        return view('livewire.campaigns.edit', [
            'segments' => $segments,
        ])->layout('components.layouts.app', ['title' => __('campaigns.edit_campaign')]);
    }
}
