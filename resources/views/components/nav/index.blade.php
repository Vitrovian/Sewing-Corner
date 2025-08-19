@php
    $items = collect(config('watch.nav_items'))->reject(
        fn($label, $routeName) => in_array($routeName, ['terms', 'privacy', 'about'])
    );
@endphp

<nav>
    <ul class="flex gap-2">
        <!-- Пункти меню для гостей -->
        @guest
        @foreach ($items->reject(fn($label, $routeName) => in_array($routeName, ['dashboard', 'orders.index'])) as $routeName => $label)
            <x-nav.item  
                :href="route($routeName)"
                :is-active="request()->routeIs($routeName)"
                :class="($routeName === 'login' || $routeName === 'register')
                    ? 'px-4 py-2 rounded-md text-lg font-medium transition-all duration-200 ' . 
                      (request()->routeIs($routeName) 
                          ? 'bg-gray-900 text-white shadow-lg' 
                          : 'text-gray-800 hover:bg-gray-100')
                    : 'px-3 py-2 text-lg text-black hover:text-black transition'">
                {{ $label }}
            </x-nav.item>
        @endforeach
        @endguest

        <!-- Пункти меню для авторизованих користувачів -->
        @auth
        @foreach ($items->reject(fn($label, $routeName) => in_array($routeName, ['login', 'register'])) as $routeName => $label)
            <x-nav.item  
                :href="route($routeName)"
                :is-active="request()->routeIs($routeName)"
                :class="($routeName === 'dashboard')
                    ? 'px-4 py-2 rounded-md text-lg font-medium transition-all duration-200 ' . 
                      (request()->routeIs($routeName) 
                          ? 'bg-gray-900 text-white shadow-lg' 
                          : 'text-gray-800 hover:bg-gray-100')
                    : 'px-3 py-2 text-lg text-black hover:text-black transition'">
                {{ $label }}
            </x-nav.item>
        @endforeach
        @endauth
    </ul>
</nav>
