<?php

namespace App\Livewire\Reference;

use App\Models\PosterOutput;
use Livewire\Component;
use App\Models\RefParticipant;
use Livewire\WithFileUploads;

class Participants extends Component
{
    use WithFileUploads;

    public $poster_file;
    public $id, $participant, $category, $school, $participant_no, $participant_id;
    public $poster_photos;

    protected $rules = [
        'poster_file' => 'required|file|max:51200|mimes:jpg,png,jpeg',
    ];

    protected $messages = [
        'poster_file.required' => 'Please select a file to upload',
        'poster_file.max' => 'File size must be less than 50MB',
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
    public function uploadOutput()
    {
        $this->validate();
        $output =  PosterOutput::where('participant_id', $this->participant_id)->first();
        if (!$output) {
            $output = new PosterOutput();
            $output->participant_id = $this->participant_id;
        }
        $path = $this->poster_file->store('uploads', 'public');
        $output->output_file = $path;
        $output->save();
        $this->reset('poster_file');
        $this->dispatch('reset-poster-files');
        return session()->flash("status", 'File uploaded successfully! Path: ' . $path);
    }
    public function addPoster($id)
    {
        $this->participant_id = $id;
        $this->reset('poster_file');
        $this->reset('poster_photos');
        $this->getPosterFile($id);
        $this->dispatch('openPosterModal');
    }
    public function getPosterFile($id)
    {
        $output = PosterOutput::where('participant_id', $id)->first();
        // Loop

        if ($output) {
            $this->poster_photos = $output->output_file ? asset('storage/' . $output->output_file) : null;
        }

        return null;
    }
    public function deleteParticipant($id){
        $this->id = $id;
        $this->dispatch('openDeleteModal');
    }   
    public function executeDeleteParticipant(){
        $participant = RefParticipant::find($this->id);
        if($participant){
            $participant->delete();
             return session()->flash("status", "Sucessfully deleted!");
        }
        return session()->flash("error", "Failed to delete");
        $this->dispatch('hideDeleteModal');
    }   
}
