<?php

use App\Enums\MovementEnum;
use App\Models\Watch;
use App\Models\WishlistWatch;
use Livewire\Component;

new class extends Component {
    public WishlistWatch $wishlistWatch;

    public function mount(WishlistWatch $wishlistWatch): void
    {
        $this->wishlistWatch = $wishlistWatch->load('brand');
    }

    public function transferToCollection()
    {
        $watch = Watch::create($this->wishlistWatch->toWatchAttributes());

        $this->wishlistWatch->delete();

        return to_route('watches.show', $watch);
    }

    public function destroy()
    {
        $this->wishlistWatch->delete();

        return to_route('wishlist.index');
    }

    public function movementLabel(): string
    {
        return MovementEnum::tryFrom($this->wishlistWatch->movement ?? '')?->label() ?? 'A définir';
    }

    public function formattedPrice(): string
    {
        return number_format($this->wishlistWatch->price, 0, ',', ' ');
    }
};
?>

<div class="mx-auto flex w-full max-w-6xl flex-col gap-6">
    <header class="page-header">
        <div class="flex min-w-0 flex-col gap-2">
            <a href="{!! route('wishlist.index') !!}" class="text-sm font-medium text-secondary/70 transition hover:text-main">
                <- Retour à la wishlist
            </a>
            <h1 class="big-title">{{ $this->wishlistWatch->model }}</h1>
        </div>
        <div class="action-bar">
            <button type="button" wire:click="transferToCollection" class="btn">Transférer vers ma collection</button>
            <a href="{!! route('wishlist.edit', $this->wishlistWatch) !!}" class="btn btn-secondary">Modifier</a>
            <button type="button" wire:click="destroy" class="btn btn-danger">Supprimer</button>
        </div>
    </header>

    <section class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_22rem]">
        <article class="watch-detail-card">
            <div class="watch-detail-card__image">
                @if($this->wishlistWatch->picture)
                    <img src="{{ $this->wishlistWatch->picture }}" alt="{{ $this->wishlistWatch->model }}">
                @else
                    <span>Aperçu</span>
                @endif
            </div>
        </article>

        <aside class="watch-preview-card" aria-label="Détails de la montre souhaitée">
            <div class="flex min-w-0 flex-col gap-4">
                <div class="min-w-0">
                    <p class="truncate text-xs font-bold uppercase text-secondary/50">{{ $this->wishlistWatch->brand?->name ?? 'Marque inconnue' }}</p>
                    <h2 class="break-words font-playfair text-2xl font-black italic text-main sm:text-3xl">{{ $this->wishlistWatch->model }}</h2>
                </div>
                <dl class="grid grid-cols-1 gap-3 text-sm min-[360px]:grid-cols-2">
                    <div>
                        <dt class="text-secondary/50">Marque</dt>
                        <dd class="font-semibold text-main">{{ $this->wishlistWatch->brand?->name ?? 'A définir' }}</dd>
                    </div>
                    <div>
                        <dt class="text-secondary/50">Mouvement</dt>
                        <dd class="font-semibold text-main">{{ $this->movementLabel() }}</dd>
                    </div>
                    <div class="min-[360px]:col-span-2">
                        <dt class="text-secondary/50">Budget</dt>
                        <dd class="font-playfair text-2xl font-black italic text-main">{{ $this->formattedPrice() }}
                            <span class="text-lg font-normal text-secondary">€</span></dd>
                    </div>
                </dl>
            </div>
        </aside>
    </section>
</div>
