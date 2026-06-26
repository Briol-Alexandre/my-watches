<?php

use App\Enums\MovementEnum;
use App\Models\Watch;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

new class extends Component {
    public Collection $watches;
    public int $totalPrice;

    public function mount(): void
    {
        $this->watches = Watch::with('brand')->get();

        $this->totalPrice = 0;
        foreach ($this->watches as $watch) {
            $this->totalPrice += $watch->price;
        }
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
    <h1 class="big-title">
        Votre collection
    </h1>
    <section class="card-container">
        <article aria-labelledby="watch-count" class="card">
            <h2 id="watch-count" class="card-title">Total collection</h2>
            <p class="card-value">{{ $this->watches->count() }} <span>montres</span></p>
        </article>
        <article aria-labelledby="total-price" class="card">
            <h2 id="total-price" class="card-title">Valeur estimée</h2>
            <p class="card-value">{{ $this->totalPrice }} <span>€</span></p>
        </article>
    </section>
    <section aria-labelledby="your-watches" class="flex flex-col gap-3">
        <div class="section-heading">
            <h2 id="your-watches" class="title">Vos montres</h2>
            <a href="{!! route('watches.create') !!}" class="btn">+ Ajouter une montre</a>
        </div>
        <div class="watch-grid">
            @forelse($this->watches as $watch)
                <a href="{!! route('watches.show', $watch) !!}" class="watch-card" aria-labelledby="watch-{{ $watch->id }}-title">
                    <div class="watch-card__image">
                        @if($watch->picture)
                            <img src="{{ $watch->picture }}" alt="{{ $watch->model }}">
                        @else
                            <span>Aperçu</span>
                        @endif
                    </div>
                    <div class="flex min-w-0 flex-col gap-4">
                        <div class="min-w-0">
                            <p class="truncate text-xs font-bold uppercase text-secondary/50">{{ $watch->brand?->name ?? 'Marque inconnue' }}</p>
                            <h3 id="watch-{{ $watch->id }}-title" class="break-words font-playfair text-2xl font-black italic text-main sm:text-3xl">{{ $watch->model }}</h3>
                        </div>
                        <dl class="grid grid-cols-1 gap-3 text-sm min-[360px]:grid-cols-2">
                            <div>
                                <dt class="text-secondary/50">Mouvement</dt>
                                <dd class="font-semibold text-main">{{ $this->movementLabel($watch->movement) }}</dd>
                            </div>
                            <div>
                                <dt class="text-secondary/50">Valeur</dt>
                                <dd class="font-semibold text-main">{{ $this->formattedPrice($watch->price) }} €</dd>
                            </div>
                        </dl>
                    </div>
                </a>
            @empty
                <p class="text-base text-secondary/50 italic">Pas de montre enregistrée. <a href="{!! route('watches.create') !!}" class="not-italic text-secondary">Ajoutez-en une !</a></p>
            @endforelse
        </div>
    </section>

</div>
