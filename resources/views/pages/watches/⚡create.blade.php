<?php

use App\Enums\MovementEnum;
use App\Http\Requests\WatchRequest;
use App\Models\Brand;
use App\Models\Watch;
use Illuminate\Support\Collection;
use Livewire\Component;

new class extends Component {

    public Collection $brands;

    public ?string $model = null;
    public ?string $picture = null;
    public ?string $brand_id = null;
    public ?string $price = null;
    public ?string $movement = null;
    public bool $showBrandModal = false;
    public ?string $newBrandName = null;

    public function mount(): void
    {
        $this->brands = Brand::orderBy('name')->get();
    }

    public function save()
    {
        $validated = $this->validate(
            (new WatchRequest())->rules()
        );

        Watch::create($validated);

        return to_route('watches.index');
    }

    public function openBrandModal(): void
    {
        $this->resetValidation('newBrandName');
        $this->showBrandModal = true;
    }

    public function closeBrandModal(): void
    {
        $this->resetValidation('newBrandName');
        $this->newBrandName = null;
        $this->showBrandModal = false;
    }

    public function createBrand(): void
    {
        $validated = $this->validate([
            'newBrandName' => ['required', 'string', 'max:255'],
        ]);

        $brand = Brand::firstOrCreate([
            'name' => trim($validated['newBrandName']),
        ]);

        $this->brands = Brand::orderBy('name')->get();
        $this->brand_id = (string) $brand->id;
        $this->closeBrandModal();
    }

    public function selectedBrandName(): string
    {
        if (!$this->brand_id) {
            return 'A définir';
        }

        return $this->brands->firstWhere('id', (int)$this->brand_id)?->name ?? 'A définir';
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

        return number_format((int)$this->price, 0, ',', ' ');
    }
};
?>

<div class="mx-auto flex w-full max-w-6xl flex-col gap-6">
    <header class="page-header">
        <div class="flex min-w-0 flex-col gap-2">
            <a href="{!! route('watches.index') !!}"
               class="text-sm font-medium text-secondary/70 transition hover:text-main">
                <- Retour aux montres
            </a>
            <h1 class="big-title">Créer une montre</h1>
        </div>
        <p class="max-w-md text-sm leading-6 text-secondary/70">
            Ajoutez les détails essentiels de votre pièce pour garder une collection claire et élégante.
        </p>
    </header>

    <section class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_22rem]">
        <form wire:submit.prevent="save" class="watch-form-card">
            <div class="flex flex-col gap-1">
                <h2 class="title">Détails</h2>
                <p class="text-sm text-secondary/60">Les informations principales de la montre.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="field-container md:col-span-2">
                    <label for="model">Modèle</label>
                    <input id="model" type="text" wire:model.live.debounce.250ms="model"
                           placeholder="Speedmaster Professional">
                </div>

                <div class="field-container">
                    <div class="flex items-center justify-between gap-3">
                        <label for="brand">Marque</label>
                        <button type="button" wire:click="openBrandModal" class="text-xs font-semibold text-secondary/60 transition hover:text-main">
                            + Ajouter
                        </button>
                    </div>
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
                        <input id="price" type="number" min="0" wire:model.live.debounce.250ms="price"
                               placeholder="6500" class="pr-10">
                        <span
                            class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm font-semibold text-secondary/50">€</span>
                    </div>
                </div>

                <div class="field-container">
                    <label for="picture">Image</label>
                    <input id="picture" type="url" wire:model.live.debounce.400ms="picture" placeholder="https://...">
                </div>
            </div>

            <div class="form-actions">
                <a href="{!! route('watches.index') !!}"
                   class="text-center text-sm font-medium text-secondary/70 transition hover:text-main">
                    Annuler
                </a>
                <button type="submit" class="btn">Enregistrer la montre</button>
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
                    <p class="text-xs font-bold uppercase text-secondary/50">Nouvelle pièce</p>
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

    @if($showBrandModal)
        <div class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="brand-modal-title">
            <form wire:submit.prevent="createBrand" class="brand-modal">
                <div class="flex flex-col gap-1">
                    <h2 id="brand-modal-title" class="font-playfair text-3xl font-black italic text-main">Nouvelle marque</h2>
                    <p class="text-sm text-secondary/60">Ajoutez simplement son nom.</p>
                </div>

                <div class="field-container">
                    <label for="newBrandName">Nom</label>
                    <input id="newBrandName" type="text" wire:model.live.debounce.250ms="newBrandName" placeholder="Tudor" autofocus>
                    @error('newBrandName')
                        <p class="text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="button" wire:click="closeBrandModal" class="text-center text-sm font-medium text-secondary/70 transition hover:text-main">
                        Annuler
                    </button>
                    <button type="submit" class="btn">Ajouter la marque</button>
                </div>
            </form>
        </div>
    @endif
</div>
