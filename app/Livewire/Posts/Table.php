<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class Table extends Component
{
    use WithPagination;

    public string $filterType = '';
    public string $filterStatus = '';
    public string $filterSearch = '';

    // Persist filters ke URL (?type=&status=&q=)
    public array $queryString = [
        'filterType'   => ['as' => 'type', 'except' => ''],
        'filterStatus' => ['as' => 'status', 'except' => ''],
        'filterSearch' => ['as' => 'q', 'except' => ''],
    ];

    #[On('post-updated')]
    public function refreshList(): void
    {
        $this->resetPage();
    }

    public function updatedFilterSearch(): void
    {
        $this->resetPage();   // biar balik ke page 1 saat ngetik
    }
    public function updatedFilterType(): void
    {
        $this->resetPage();
    }
    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    // Reset pagination setiap filter berubah
    public function updated($field): void
    {
        if (in_array($field, ['filterType', 'filterStatus', 'filterSearch'], true)) {
            $this->resetPage();
        }
    }

    // ===== Live suggestions untuk kotak search =====
    #[Computed]
    public function suggestions()
    {
        if ($this->filterSearch === '' || mb_strlen($this->filterSearch) < 2) {
            return collect();
        }

        return Post::query()
            ->select('id', 'title', 'type')
            ->where(function ($q) {
                $q->where('title', 'like', "%{$this->filterSearch}%")
                    ->orWhere('excerpt', 'like', "%{$this->filterSearch}%");
            })
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();
    }

    public function edit(int $id): void
    {
        $this->dispatch('edit-post', id: $id);
        $this->dispatch('scrollTop');
    }

    public function delete(int $id): void
    {
        $p = Post::findOrFail($id);
        // Gate::authorize('delete', $p);
        $p->delete();
        $this->resetPage();
        session()->flash('success', 'Deleted.');
    }

    public function publishNow(int $id): void
    {
        $p = Post::findOrFail($id);
        // Gate::authorize('update', $p);
        $p->update(['is_published' => true, 'published_at' => now()]);
        $this->dispatch('post-updated');
        session()->flash('success', 'Published.');
    }

    public function schedule(int $id, string $when): void
    {
        $p = Post::findOrFail($id);
        $p->update([
            'is_published' => true,
            'published_at' => Carbon::parse($when),
        ]);
        $this->dispatch('post-updated');
        session()->flash('success', 'Scheduled.');
    }

    public function unpublish(int $id): void
    {
        $p = Post::findOrFail($id);
        // Gate::authorize('update', $p);
        $p->update(['is_published' => false]);
        $this->dispatch('post-updated');
        session()->flash('success', 'Unpublished.');
    }

    public function render()
    {
        $query = Post::query()
            ->when($this->filterType, fn($q) => $q->where('type', $this->filterType))
            ->when($this->filterStatus, function ($q) {
                return match ($this->filterStatus) {
                    'draft'     => $q->where('is_published', false),
                    'scheduled' => $q->where('is_published', true)->where('published_at', '>', now()),
                    'published' => $q->where('is_published', true)->where('published_at', '<=', now()),
                    default     => $q,
                };
            })
            ->when(
                $this->filterSearch,
                fn($q) =>
                $q->where(
                    fn($qq) =>
                    $qq->where('title', 'like', "%{$this->filterSearch}%")
                        ->orWhere('excerpt', 'like', "%{$this->filterSearch}%")
                )
            )
            ->orderByRaw("
                CASE
                    WHEN is_published=1 AND published_at>NOW() THEN 0
                    WHEN is_published=1 AND (published_at<=NOW() OR published_at IS NULL) THEN 1
                    ELSE 2
                END
            ")
            ->orderByDesc('published_at')
            ->orderByDesc('created_at');

        $posts = $query->paginate(10);

        return view('livewire.posts.table', compact('posts'));
    }
}
