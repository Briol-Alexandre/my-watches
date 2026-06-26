<?php

use App\Enums\MovementEnum;
use App\Http\Requests\WatchRequest;
use App\Models\Brand;
use App\Models\Watch;
use Illuminate\Support\Collection;
use Livewire\Component;

new class extends Component {
    public Watch $watch;
    public Collection $brands;

    public ?string $model = null;
    public ?string $picture = null;
    public ?string $brand_id = null;
    public ?string $price = null;
    public ?string $movement = null;

    public function mount(Watch $watch): void
    {
        $this->watch = $watch;
        $this->brands = Brand::orderBy('name')->get();
        $this->model = $watch->model;
        $this->picture = $watch->picture;
        $this->brand_id = (string) $watch->brand_id;
        $this->price = (string) $watch->price;
        $this->movement = $watch->movement;
    }

    public function update()
    {
        $validated = $this->validate(
            (new WatchRequest())->rules()
        );

        $this->watch->update($validated);

        return to_route('watches.show', $this->watch);
    }

    public function selectedBrandName(): string
    {
        if (!$this->brand_id) {
            return 'A définir';
        }

        return $this->brands->firstWhere('id', (int) $this->brand_id)?->name ?? 'A définir';
    }

    public function selectedMovementLabel(): string
    {
        if (!$this->movement) {
            return 'A définir';
        }

        return MovementEnum::tryFrom($this->movement)?->label() ?? 'A définir';
    }

    public function formattedPrice(): string
    {
        if (!$this->price) {
            return '0';
        }

        return number_format((int) $this->price, 0, ',', ' ');
    }
};
?>

<div class="mx-auto flex w-full max-w-6xl flex-col gap-6">
    <header class="page-header">
        <div class="flex min-w-0 flex-col gap-2">
            <a href="{!! route('watches.show', $this->watch) !!}" class="text-sm font-medium text-secondary/70 transition hover:text-main">
                <- Retour à la montre
            </a>
            <h1 class="big-title">Modifier une montre</h1>
        </div>
        <p class="max-w-md text-sm leading-6 text-secondary/70">
            Ajustez les informations de votre pièce.
        </p>
    </header>

    <section class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_22rem]">
        <form wire:submit.prevent="update" class="watch-form-card">
            <div class="flex flex-col gap-1">
                <h2 class="title">Détails</h2>
                <p class="text-sm text-secondary/60">Les informations principales de la montre.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="field-container md:col-span-2">
                    <label for="model">Modèle</label>
                    <input id="model" type="text" wire:model.live.debounce.250ms="model">
                </div>

                <div class="field-container">
                    <label for="brand">Marque</label>
                    <select id="brand" wire:model.live="brand_id">
                        <option value="">Sélectionner une marque</option>
                        @foreach($this->brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field-container">
                    <label for="movement">Mouvement</label>
                    <select id="movement" wire:model.live="movement">
                        <option value="">Sélectionner un mouvement</option>
                        @foreach(MovementEnum::cases() as $movement)
                            <option value="{{ $movement->value }}">{{ $movement->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field-container">
                    <label for="price">Prix estimé</label>
                    <div class="relative">
                        <input id="price" type="number" min="0" wire:model.live.debounce.250ms="price" class="pr-10">
                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm font-semibold text-secondary/50">€</span>
                    </div>
                </div>

                <div class="field-container">
                    <label for="picture">Image</label>
                    <input id="picture" type="url" wire:model.live.debounce.400ms="picture">
                </div>
            </div>

            <div class="form-actions">
                <a href="{!! route('watches.show', $this->watch) !!}" class="text-center text-sm font-medium text-secondary/70 transition hover:text-main">
                    Annuler
                </a>
                <button type="submit" class="btn">Enregistrer</button>
            </div>
        </form>

        <aside class="watch-preview-card" aria-label="Aperçu de la montre">
            <div class="watch-preview-card__image">
                @if($this->picture)
                    <img src="{{ $this->picture }}" alt="Aperçu de {{ $this->model ?: 'la montre' }}">
                @else
                    <span>Aperçu</span>
                @endif
            </div>
            <div class="flex min-w-0 flex-col gap-4">
                <div class="min-w-0">
                    <p class="truncate text-xs font-bold uppercase text-secondary/50">{{ $this->selectedBrandName() }}</p>
                    <h2 class="break-words font-playfair text-2xl font-black italic text-main sm:text-3xl">{{ $this->model ?: 'Votre montre' }}</h2>
                </div>
                <dl class="grid grid-cols-1 gap-3 text-sm min-[360px]:grid-cols-2">
                    <div>
                        <dt class="text-secondary/50">Marque</dt>
                        <dd class="font-semibold text-main">{{ $this->selectedBrandName() }}</dd>
                    </div>
                    <div>
                        <dt class="text-secondary/50">Mouvement</dt>
                        <dd class="font-semibold text-main">{{ $this->selectedMovementLabel() }}</dd>
                    </div>
                    <div class="min-[360px]:col-span-2">
                        <dt class="text-secondary/50">Valeur</dt>
                        <dd class="font-playfair text-2xl font-black italic text-main">{{ $this->formattedPrice() }}
                            <span class="text-lg font-normal text-secondary">€</span></dd>
                    </div>
                </dl>
            </div>
        </aside>
    </section>
</div>
