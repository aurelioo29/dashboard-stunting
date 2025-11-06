<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class Form extends Component
{
    use WithFileUploads;

    public ?int $editingId = null;

    public string $type = 'news';
    public string $title = '';
    public ?string $excerpt = '';
    public string $content = '';
    public bool $is_published = false;
    public ?string $published_at = null; // 'YYYY-MM-DDTHH:MM'
    public $cover_image; // TemporaryUploadedFile

    public function mount(?int $editingId = null): void
    {
        $this->editingId = $editingId;

        if ($editingId) {
            $p = \App\Models\Post::findOrFail($editingId);
            $this->type         = $p->type;
            $this->title        = $p->title;
            $this->excerpt      = $p->excerpt ?? '';
            $this->content      = $p->content ?? '';
            $this->is_published = (bool)$p->is_published;
            $this->published_at = $p->published_at ? $p->published_at->format('Y-m-d\TH:i') : null;
        }
    }

    public function rules(): array
    {
        return [
            'type'         => ['required', 'in:news,tips'],
            'title'        => ['required', 'string', 'max:160'],
            'excerpt'      => ['nullable', 'string', 'max:500'],
            'content'      => ['required', 'string'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'cover_image'  => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $post = Post::findOrFail($this->editingId);
            // Gate::authorize('update', $post); // aktifkan kalau policy sudah siap
        } else {
            // Gate::authorize('create', Post::class);
            $post = new Post();
            $post->user_id = auth()->id();
        }

        $post->fill([
            'type'         => $this->type,
            'title'        => $this->title,
            'excerpt'      => $this->excerpt ?: null,
            'content'      => $this->content,
            'is_published' => $this->is_published,
            'published_at' => $this->published_at ? Carbon::parse($this->published_at) : null,
        ]);

        if (empty($post->slug)) {
            $post->slug = \App\Models\Post::makeUniqueSlug($this->title, $this->editingId);
        }

        try {
            $post->save();
        } catch (QueryException $e) {
            if ((int)$e->getCode() === 23000) {
                $post->slug = $post->slug . '-' . Str::random(4);
                $post->save();
            } else {
                throw $e;
            }
        }

        if ($post->is_published && !$post->published_at) {
            $post->published_at = now();
        }

        if ($this->cover_image) {
            if ($post->cover_image) Storage::disk('public')->delete($post->cover_image);
            $post->cover_image = $this->cover_image->store('covers', 'public');
        }

        $post->save();

        $this->resetForm();
        $this->dispatch('post-updated');
        session()->flash('success', $this->editingId ? 'Updated.' : 'Created.');
        return redirect()->route('dashboard.posts.index');
    }

    #[On('edit-post')]
    public function fillFrom(int $id): void
    {
        $p = Post::findOrFail($id);
        // Gate::authorize('update', $p);

        $this->editingId   = $p->id;
        $this->type        = $p->type;
        $this->title       = $p->title;
        $this->excerpt     = $p->excerpt ?? '';
        $this->content     = $p->content ?? '';
        $this->is_published = (bool)$p->is_published;
        $this->published_at = $p->published_at ? $p->published_at->format('Y-m-d\TH:i') : null;
        $this->cover_image = null;

        $this->dispatch('scrollTop');
    }

    public function resetForm(): void
    {
        $this->editingId = null;
        $this->type = 'news';
        $this->title = '';
        $this->excerpt = '';
        $this->content = '';
        $this->is_published = false;
        $this->published_at = null;
        $this->cover_image = null;
    }

    public function render()
    {
        return view('livewire.posts.form');
    }
}
