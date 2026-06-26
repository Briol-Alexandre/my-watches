<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::dashboard')->name('pages::dashboard');

require 'watch.php';
require 'wishlist.php';
