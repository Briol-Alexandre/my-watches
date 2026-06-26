<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/wishlist', 'pages::wishlist.index')->name('wishlist.index');
Route::livewire('/wishlist/create', 'pages::wishlist.create')->name('wishlist.create');
Route::livewire('/wishlist/{wishlistWatch}/edit', 'pages::wishlist.edit')->name('wishlist.edit');
Route::livewire('/wishlist/{wishlistWatch}', 'pages::wishlist.show')->name('wishlist.show');
