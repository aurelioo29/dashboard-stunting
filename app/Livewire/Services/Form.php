<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class Form extends Component
{
    use WithFileUploads;

    public ?int $editingId = null;

    public string $title = '';
    public bool $is_active = true;
    public int $sort_order = 0;

    // icon bisa PNG/SVG
    public $icon_file; // TemporaryUploadedFile

    public function mount(?int $editingId = null): void
    {
        $this->editingId = $editingId;

        if ($editingId) {
            $s = Service::findOrFail($editingId);
            $this->title      = $s->title;
            $this->is_active  = (bool)$s->is_active;
            $this->sort_order = (int)$s->sort_order;
        }
    }

    public function rules(): array
    {
        return [
            'title'      => ['required', 'string', 'max:160'],
            'is_active'  => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
            // SVG bukan "image" menurut validator Laravel, jadi pakai mimes/mimetypes
            'icon_file'  => ['nullable', 'file', 'max:2048', 'mimetypes:image/png,image/svg+xml'],
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $service = Service::findOrFail($this->editingId);
        } else {
            $service = new Service();
        }

        $service->fill([
            'title'      => $this->title,
            'is_active'  => $this->is_active,
            'sort_order' => $this->sort_order,
        ]);

        if (empty($service->slug)) {
            $service->slug = Service::makeUniqueSlug($this->title, $this->editingId);
        }

        try {
            $service->save();
        } catch (QueryException $e) {
            if ((int)$e->getCode() === 23000) {
                $service->slug = $service->slug . '-' . Str::random(4);
                $service->save();
            } else {
                throw $e;
            }
        }

        if ($this->icon_file) {
            if ($service->icon_path) {
                Storage::disk('public')->delete($service->icon_path);
            }
            $service->icon_path = $this->icon_file->store('services', 'public');
            $service->save();
        }

        $this->resetForm();
        $this->dispatch('service-updated');
        session()->flash('success', $this->editingId ? 'Service updated.' : 'Service created.');

        return redirect()->route('dashboard.services.index');
    }

    #[On('edit-service')]
    public function fillFrom(int $id): void
    {
        $s = Service::findOrFail($id);

        $this->editingId  = $s->id;
        $this->title      = $s->title;
        $this->is_active  = (bool)$s->is_active;
        $this->sort_order = (int)$s->sort_order;
        $this->icon_file  = null;

        $this->dispatch('scrollTop');
    }

    public function resetForm(): void
    {
        $this->editingId  = null;
        $this->title      = '';
        $this->is_active  = true;
        $this->sort_order = 0;
        $this->icon_file  = null;
    }

    public function render()
    {
        return view('livewire.services.form');
    }
}
