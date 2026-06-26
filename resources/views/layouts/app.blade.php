<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#2C2926">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-title" content="MyWatches">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="manifest" href="/manifest.webmanifest">
        <link rel="icon" href="/icon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/icon-192.png">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

        @livewireStyles
        @fluxAppearance
    </head>
    <body>
        <nav class="dock-menu" aria-label="Navigation principale">
            <div class="dock-menu__link-group dock-menu__link-group--left">
                <a class="dock-menu__link dock-menu__link--left" href="{!! route('wishlist.index') !!}">Wishlist</a>
            </div>

            <a class="dock-menu__brand" href="{!! route('pages::dashboard') !!}" aria-label="MyWatches">
                <span class="dock-menu__logo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="194" height="27" viewBox="0 0 194 27" fill="none" aria-hidden="true"><path fill="#2C2926" d="M0 25.704V.504h4.932l9.18 14.94-3.24-.036L20.16.504h4.716v25.2h-5.292v-8.64q0-3.24.144-5.832.18-2.592.576-5.148l.648 1.692-7.38 11.448h-2.376L3.96 7.848l.612-1.764q.396 2.412.54 4.968.18 2.52.18 6.012v8.64zm33.698 0V13.14l.252 1.764L23.762.504h6.228l7.776 11.16-2.448-.108L42.338.504h6.012L38.594 15.3l.54-2.448v12.852zm18.313 0L44.343.504h5.544l4.104 14.076q.252.756.432 1.656.216.864.324 1.692.144.792.216 1.512l.18 1.152-.864-.036.54-2.52a98 98 0 0 1 .396-1.836q.216-.828.504-1.656L59.68 4.14h4.464l3.888 10.404q.432 1.08.684 2.088.288.972.468 1.908.18.9.324 1.836l-.756.144q.108-.756.144-1.296.072-.576.108-1.044l.144-.936q.072-.504.216-1.152.144-.684.432-1.584L73.863.504h5.472l-7.74 25.2h-4.032L61.371 10.8l.576.072-5.796 14.832zm22.216 0 9.9-25.2h4.824l9.828 25.2h-5.544l-5.076-13.572q-.216-.576-.54-1.476l-.612-1.908-.612-1.908a25 25 0 0 1-.432-1.548h.972a41 41 0 0 1-.504 1.692q-.252.864-.54 1.8-.288.9-.612 1.764a75 75 0 0 0-.612 1.692L79.59 25.704zm4.608-5.292 1.764-4.32h11.556l1.8 4.32zm22.625 5.292V5.364h-7.344V.504h20.304v4.86h-7.56v20.34zm23.062.36q-2.772 0-5.112-.936a12.5 12.5 0 0 1-4.032-2.7 12.6 12.6 0 0 1-2.628-4.14q-.936-2.412-.936-5.256 0-2.772.972-5.112a12.1 12.1 0 0 1 2.736-4.104 12.5 12.5 0 0 1 4.14-2.736q2.376-.972 5.148-.972 1.8 0 3.528.504 1.764.468 3.204 1.404a10.3 10.3 0 0 1 2.52 2.232l-3.384 3.744a10 10 0 0 0-1.764-1.476 7.2 7.2 0 0 0-1.98-.972 6.4 6.4 0 0 0-2.16-.36 7.4 7.4 0 0 0-2.916.576 7.2 7.2 0 0 0-2.34 1.62q-1.008 1.008-1.62 2.484-.576 1.44-.576 3.204 0 1.8.576 3.276.576 1.44 1.62 2.484a7.6 7.6 0 0 0 2.484 1.584q1.476.54 3.24.54 1.152 0 2.232-.324a7.8 7.8 0 0 0 1.98-.9 8.2 8.2 0 0 0 1.656-1.332l2.664 4.212q-.9.972-2.376 1.764-1.44.792-3.24 1.26-1.8.432-3.636.432m25.325-.36V.504h5.4v25.2zm-15.876 0V.504h5.4v25.2zm2.16-10.116.036-4.896h16.452v4.896zm21.363 10.116V.504h17.028v4.752h-11.736v15.696h11.988v4.752zm2.52-10.548v-4.608h12.78v4.608zm24.184 10.908q-2.34 0-4.284-.576a11.1 11.1 0 0 1-3.42-1.692 13.5 13.5 0 0 1-2.664-2.7l3.384-3.852q1.764 2.448 3.492 3.348a8.56 8.56 0 0 0 3.816.864q1.116 0 1.98-.324.9-.324 1.404-.864.504-.576.504-1.368 0-.576-.252-1.044a2.5 2.5 0 0 0-.72-.864 4.6 4.6 0 0 0-1.116-.684 8 8 0 0 0-1.44-.54q-.792-.252-1.728-.396-2.016-.468-3.528-1.116-1.512-.684-2.52-1.656a6.7 6.7 0 0 1-1.512-2.268q-.468-1.26-.468-2.844 0-1.62.72-2.988a7.4 7.4 0 0 1 1.98-2.412A9.6 9.6 0 0 1 180.778.54Q182.47 0 184.342 0q2.304 0 4.032.504t2.988 1.512a8.5 8.5 0 0 1 2.16 2.376l-3.42 3.312a8.5 8.5 0 0 0-1.656-1.692 5.8 5.8 0 0 0-1.908-1.008 6.2 6.2 0 0 0-2.088-.36q-1.188 0-2.052.324-.864.288-1.368.9-.468.576-.468 1.368 0 .648.324 1.152t.936.9q.612.36 1.476.648t1.908.504q1.98.396 3.564 1.044t2.7 1.584a6.1 6.1 0 0 1 1.764 2.16q.612 1.224.612 2.772 0 2.556-1.224 4.356t-3.384 2.772q-2.16.936-5.04.936"/></svg>
                </span>
            </a>

            <div class="dock-menu__link-group dock-menu__link-group--right">
                <a class="dock-menu__link dock-menu__link--right" href="{!! route('watches.index') !!}">Collection</a>
            </div>
        </nav>
        {{ $slot }}

        @livewireScripts
        @fluxScripts
    </body>
</html>
