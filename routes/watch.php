<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/watches', 'pages::watches.index')->name('watches.index');
Route::livewire('/watches/create', 'pages::watches.create')->name('watches.create');
Route::livewire('/watches/{watch}/edit', 'pages::watches.edit')->name('watches.edit');
Route::livewire('/watches/{watch}', 'pages::watches.show')->name('watches.show');
