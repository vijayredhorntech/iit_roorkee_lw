<?php

namespace App\Livewire\Instruments;

use App\Models\InstrumentCategory;
use Livewire\Component;

class CategoryForm extends Component
{
    public $title;
    public $description;
    public $status = 1;

    public $isEditing = false;
    public $categoryId = null;

    protected $listeners = [
        'editCategory' => 'loadCategoryData',
        'resetForm' => 'resetForm'
    ];

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }

    public function loadCategoryData($categoryId)
    {
        $this->categoryId = $categoryId;
        $this->isEditing = true;
        $category = InstrumentCategory::findOrFail($categoryId);

        $this->title = $category->title;
        $this->description = $category->description;
        $this->status = $category->status;
    }

    public function submit()
    {
        $this->validate();

        if ($this->isEditing) {
            $this->updateCategory();
        } else {
            $this->createCategory();
        }
    }

    public function createCategory()
    {
        $category = new InstrumentCategory();
        $category->title = $this->title;
        $category->description = $this->description;
        $category->status = $this->status;
        $category->save();

        $this->resetForm();
        session()->flash('success', 'Category created successfully!');

        $this->dispatch('categoryCreated');
    }

    public function updateCategory()
    {
        $category = InstrumentCategory::findOrFail($this->categoryId);
        $category->title = $this->title;
        $category->description = $this->description;
        $category->save();

        $this->resetForm();
        session()->flash('success', 'Category updated successfully!');

        $this->dispatch('categoryUpdated');
    }

    public function resetForm()
    {
        $this->reset([
            'title',
            'description',
            'isEditing',
            'categoryId'
        ]);

        $this->status = 1;
    }

    public function render()
    {
        return view('livewire.instruments.category-form');
    }
}
