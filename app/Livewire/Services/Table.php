<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Table extends Component
{
    use WithPagination;

    public string $filterStatus = '';
    public string $filterSearch = '';

    public array $queryString = [
        'filterStatus' => ['as' => 'status', 'except' => ''],
        'filterSearch' => ['as' => 'q', 'except' => ''],
    ];

    #[On('service-updated')]
    public function refreshList(): void
    {
        $this->resetPage();
    }

    public function updated($field): void
    {
        if (in_array($field, ['filterStatus', 'filterSearch'], true)) {
            $this->resetPage();
        }
    }

    public function edit(int $id): void
    {
        $this->dispatch('edit-service', id: $id);
        $this->dispatch('scrollTop');
    }

    public function delete(int $id): void
    {
        $s = Service::findOrFail($id);
        $s->delete();
        $this->resetPage();
        session()->flash('success', 'Service deleted.');
    }

    public function render()
    {
        $query = Service::query()
            ->when($this->filterStatus, function ($q) {
                return match ($this->filterStatus) {
                    'active'   => $q->where('is_active', true),
                    'inactive' => $q->where('is_active', false),
                    default    => $q,
                };
            })
            ->when(
                $this->filterSearch,
                fn($q) =>
                $q->where('title', 'like', "%{$this->filterSearch}%")
            )
            ->orderBy('sort_order')
            ->orderBy('title');

        $services = $query->paginate(10);

        return view('livewire.services.table', compact('services'));
    }
}
