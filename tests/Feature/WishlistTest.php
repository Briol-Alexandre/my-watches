<?php

use App\Models\Brand;
use App\Models\Watch;
use App\Models\WishlistWatch;
use Livewire\Livewire;

test('a wishlist watch can be transferred to the collection', function () {
    $brand = Brand::create(['name' => 'Tudor']);

    $wishlistWatch = WishlistWatch::create([
        'model' => 'Black Bay 58',
        'picture' => null,
        'brand_id' => $brand->id,
        'price' => 3800,
        'movement' => 'automatic',
    ]);

    Livewire::test('pages::wishlist.show', ['wishlistWatch' => $wishlistWatch])
        ->call('transferToCollection')
        ->assertRedirect();

    expect(WishlistWatch::whereKey($wishlistWatch->id)->exists())->toBeFalse();

    $watch = Watch::where('model', 'Black Bay 58')->first();

    expect($watch)->not->toBeNull()
        ->and($watch->brand_id)->toBe($brand->id)
        ->and($watch->price)->toBe(3800)
        ->and($watch->movement)->toBe('automatic');
});
