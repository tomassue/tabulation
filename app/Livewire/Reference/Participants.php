<?php

namespace App\Livewire\Reference;

use App\Models\PosterOutput;
use Livewire\Component;
use App\Models\RefParticipant;
use Livewire\WithFileUploads;

class Participants extends Component
{
    use WithFileUploads;

    public $file, $successMessage;
    public $id, $participant, $category, $school, $participant_no;

    protected $rules = [
        'file' => 'required|file|max:51200|mimes:jpg,png,jpeg',
    ];

    protected $messages = [
        'file.required' => 'Please select a file to upload',
        'file.max' => 'File size must be less than 50MB',
        'mimes' => 'Invalid file type. Allowed: JPG, PNG, JPEG',
    ];

    public function render()
    {
        $participants = RefParticipant::orderBy('category', 'asc')->get();
        return view('livewire.reference.participants', compact('participants'));
    }

    public function saveParticipant()
    {
        $this->validate([
            'participant_no' => 'required',
            'participant' => 'required',
            'category' => 'required',
            'school' => 'required'
        ]);
        $participant = $this->id ? RefParticipant::find($this->id) : new RefParticipant();
        $participant->participant = $this->participant;
        $participant->category = $this->category;
        $participant->participant_no = $this->participant_no;
        $participant->school = $this->school;
        $participant->save();

        $this->id = null;

        return session()->flash("status", "Successfully saved");
    }
    public function addParticipant()
    {
        $this->reset();
        $this->dispatch('openModal');
    }
    public function editParticipant($id)
    {
        $participant =  RefParticipant::find($id);
        $this->participant = $participant->participant;
        $this->category = $participant->category;
        $this->participant_no = $participant->participant_no;
        $this->school = $participant->school;
        $this->id = $id;
        $this->dispatch('openModal');
    }
    public function uploadOutput($participant_id)
    {
        $this->validate();
        $path = $this->file->store('uploads', 'public');

        PosterOutput::create([
            'output_file' => $path,
            'participant_id' => $participant_id
        ]);

        $this->successMessage = 'File uploaded successfully! Path: ' . $path;
        $this->reset('file');
    }
    public function addPoster($id)
    {
        $this->dispatch('openPosterModal');
    }
}
