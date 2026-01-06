<?php

namespace App\Livewire\Contacts;

use Livewire\Component;
use App\Models\Contact;
use App\Models\Interaction;

class Show extends Component
{
    public Contact $contact;
    
    // New interaction form
    public $showInteractionForm = false;
    public $interactionType = 'note';
    public $interactionSubject = '';
    public $interactionDescription = '';
    public $interactionDate = '';
    public $interactionDuration = '';
    public $interactionOutcome = '';
    public $interactionNextSteps = '';

    public function mount($id)
    {
        $this->contact = Contact::with(['organization', 'interactions.creator'])
            ->findOrFail($id);
        $this->interactionDate = now()->format('Y-m-d\TH:i');
    }

    public function toggleInteractionForm()
    {
        $this->showInteractionForm = !$this->showInteractionForm;
    }

    public function saveInteraction()
    {
        $this->validate([
            'interactionType' => 'required|in:email,call,meeting,event,note,other',
            'interactionSubject' => 'required|string|max:255',
            'interactionDescription' => 'nullable|string',
            'interactionDate' => 'required|date',
            'interactionDuration' => 'nullable|integer|min:0',
            'interactionOutcome' => 'nullable|in:positive,neutral,negative',
            'interactionNextSteps' => 'nullable|string',
        ]);

        Interaction::create([
            'contact_id' => $this->contact->id,
            'organization_id' => $this->contact->organization_id,
            'type' => $this->interactionType,
            'subject' => $this->interactionSubject,
            'description' => $this->interactionDescription,
            'date' => $this->interactionDate,
            'duration' => $this->interactionDuration ?: null,
            'outcome' => $this->interactionOutcome ?: null,
            'next_steps' => $this->interactionNextSteps,
            'created_by' => auth()->id(),
        ]);

        // Reset form
        $this->reset([
            'showInteractionForm',
            'interactionType',
            'interactionSubject',
            'interactionDescription',
            'interactionDuration',
            'interactionOutcome',
            'interactionNextSteps',
        ]);
        $this->interactionDate = now()->format('Y-m-d\TH:i');

        // Reload contact with interactions
        $this->contact->load('interactions.creator');

        session()->flash('message', 'Interacción registrada exitosamente.');
    }

    public function deleteInteraction($id)
    {
        $interaction = Interaction::where('contact_id', $this->contact->id)
            ->findOrFail($id);
        
        $interaction->delete();

        $this->contact->load('interactions.creator');

        session()->flash('message', 'Interacción eliminada exitosamente.');
    }

    public function render()
    {
        return view('livewire.contacts.show');
    }
}
