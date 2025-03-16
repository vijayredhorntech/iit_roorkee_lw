<?php

namespace App\Livewire\Accounts;

use App\Models\Title as TitleModel;
use Livewire\Component;

class Title extends Component
{
    public $showTitleModal = false;
    public $title = '';
    public $titleId = null;
    public $isEditing = false;

    protected $rules = [
        'title' => 'required|string|max:255'
    ];

    public function showTitleModel()
    {
        $this->resetForm();
        $this->showTitleModal = true;
    }

    public function editTitle($id)
    {
        $title = TitleModel::findOrFail($id);
        $this->titleId = $title->id;
        $this->title = $title->title;
        $this->isEditing = true;
        $this->showTitleModal = true;
    }

    public function deleteTitle($id)
    {
        TitleModel::findOrFail($id)->delete();
        session()->flash('success', 'Title deleted successfully!');
    }

    public function saveTitle()
    {
        $this->validate();

        if ($this->isEditing) {
            $title = TitleModel::findOrFail($this->titleId);
            $title->update(['title' => $this->title]);
            session()->flash('success', 'Title updated successfully!');
        } else {
            TitleModel::create(['title' => $this->title]);
            session()->flash('success', 'Title added successfully!');
        }

        $this->resetForm();
        $this->showTitleModal = false;
    }

    public function resetForm()
    {
        $this->reset(['title', 'titleId', 'isEditing']);
        $this->resetValidation();
    }

    public function render()
    {
        $titles = TitleModel::all();
        return view('livewire.accounts.title')
            ->with('titles', $titles);
    }
}
