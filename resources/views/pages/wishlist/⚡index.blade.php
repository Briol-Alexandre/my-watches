<?php

use App\Enums\MovementEnum;
use App\Models\WishlistWatch;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

new class extends Component {
    public Collection $wishlistWatches;
    public int $totalPrice;

    public function mount(): void
    {
        $this->wishlistWatches = WishlistWatch::with('brand')->latest()->get();
        $this->totalPrice = $this->wishlistWatches->sum('price');
    }

    public function movementLabel(?string $movement): string
    {
        return MovementEnum::tryFrom($movement ?? '')?->label() ?? 'A définir';
    }

    public function formattedPrice(int $price): string
    {
        return number_format($price, 0, ',', ' ');
    }
};
?>

<div class="mx-auto flex w-full max-w-6xl flex-col gap-5">
    <h1 class="big-title">Votre wishlist</h1>

    <section class="card-container">
        <article aria-labelledby="wishlist-count" class="card">
            <h2 id="wishlist-count" class="card-title">Total wishlist</h2>
            <p class="card-value">{{ $this->wishlistWatches->count() }} <span>envies</span></p>
        </article>
        <article aria-labelledby="wishlist-total-price" class="card">
            <h2 id="wishlist-total-price" class="card-title">Budget estimé</h2>
            <p class="card-value">{{ $this->formattedPrice($this->totalPrice) }} <span>€</span></p>
        </article>
    </section>

    <section aria-labelledby="wishlist-watches" class="flex flex-col gap-3">
        <div class="section-heading">
            <h2 id="wishlist-watches" class="title">Montres souhaitées</h2>
            <a href="{!! route('wishlist.create') !!}" class="btn">Ajouter une envie</a>
        </div>

        <div class="watch-grid">
            @forelse($this->wishlistWatches as $wishlistWatch)
                <a href="{!! route('wishlist.show', $wishlistWatch) !!}" class="watch-card" aria-labelledby="wishlist-watch-{{ $wishlistWatch->id }}-title">
                    <div class="watch-card__image">
                        @if($wishlistWatch->picture)
                            <img src="{{ $wishlistWatch->picture }}" alt="{{ $wishlistWatch->model }}">
                        @else
                            <span>Aperçu</span>
                        @endif
                    </div>
                    <div class="flex min-w-0 flex-col gap-4">
                        <div class="min-w-0">
                            <p class="truncate text-xs font-bold uppercase text-secondary/50">{{ $wishlistWatch->brand?->name ?? 'Marque inconnue' }}</p>
                            <h3 id="wishlist-watch-{{ $wishlistWatch->id }}-title" class="break-words font-playfair text-2xl font-black italic text-main sm:text-3xl">{{ $wishlistWatch->model }}</h3>
                        </div>
                        <dl class="grid grid-cols-1 gap-3 text-sm min-[360px]:grid-cols-2">
                            <div>
                                <dt class="text-secondary/50">Mouvement</dt>
                                <dd class="font-semibold text-main">{{ $this->movementLabel($wishlistWatch->movement) }}</dd>
                            </div>
                            <div>
                                <dt class="text-secondary/50">Budget</dt>
                                <dd class="font-semibold text-main">{{ $this->formattedPrice($wishlistWatch->price) }} €</dd>
                            </div>
                        </dl>
                    </div>
                </a>
            @empty
                <p class="text-base italic text-secondary/50">Aucune envie enregistrée. <a href="{!! route('wishlist.create') !!}" class="not-italic text-secondary">Ajoutez votre prochaine cible.</a></p>
            @endforelse
        </div>
    </section>
</div>
