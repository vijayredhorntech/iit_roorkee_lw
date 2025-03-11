<?php

namespace App\Livewire\Instruments;

use App\Models\InstrumentCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

class CategoryList extends Component
{
    use WithPagination;

    public $showForm = false;
    public $search = '';
    public $status = 'All';
    public $isEditing = false;
    public $categoryId = null;
    public $gridView = 1;

    protected $listeners = [
        'categoryCreated' => 'handleCategoryCreated',
        'categoryUpdated' => 'handleCategoryUpdated',
    ];

    public function toggleGridView()
    {
        $this->gridView = $this->gridView = ! $this->gridView;
    }


    public function hideForm()
    {
        $this->showForm = !$this->showForm;

        if (!$this->showForm) {
            $this->isEditing = false;
            $this->categoryId = null;
            $this->dispatch('resetForm');
        }
    }

    public function editCategory($id)
    {
        $this->categoryId = $id;
        $this->isEditing = true;
        $this->showForm = true;
        $this->dispatch('editCategory', categoryId: $id);
    }

    public function deleteCategory($id)
    {
        $category = InstrumentCategory::findOrFail($id);
        $category->delete();

        session()->flash('success', 'Category successfully deleted.');
    }

    public function handleCategoryCreated()
    {
        $this->showForm = false;
    }

    public function handleCategoryUpdated()
    {
        $this->showForm = false;
        $this->isEditing = false;
        $this->categoryId = null;
        session()->flash('success', 'Category updated successfully.');
    }

    public function toggleStatus($id)
    {
        $category = InstrumentCategory::findOrFail($id);
        $category->status = !$category->status;
        $category->save();

        session()->flash('success', 'Status successfully updated.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function exportToPdf()
    {
        $query = $this->getFilteredQuery();
        $categories = $query->get();

        $pdf = PDF::loadView('exports.category-pdf', [
            'categories' => $categories
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'categories.pdf');
    }

    private function getFilteredQuery()
    {
        $query = InstrumentCategory::query()->latest();
        return $query;
    }

    public function render()
    {
        $query = InstrumentCategory::query()->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status !== 'All') {
            $query->where('status', $this->status);
        }

        if ($this->gridView)
        {
            $categories = $query->get()->all();
        } else {
            $categories = $query->paginate(10);
        }

        return view('livewire.instruments.category-list')
            ->with('categories', $categories)
            ->with('isEditing', $this->isEditing);
    }
}
