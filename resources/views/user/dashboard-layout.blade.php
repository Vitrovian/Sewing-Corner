<x-layout>
    <div class="flex flex-col items-center justify-center w-full max-w-6xl mx-auto p-8 rounded-xl shadow-xl border-2 border-slate-400 bg-gradient-to-l from-slate-400 to-stone-300 mt-32">
        {{-- Заголовок --}}
        <h1 class="text-4xl font-bold text-center">
            Вітаємо, <span class="text-violet-500">{{ auth()->user()->name }}</span>!
        </h1>
        <p class="text-lg text-gray-600 mt-4 text-center">
            @yield('subtitle') {{-- Динамічний підзаголовок --}}
        </p>
        {{-- Контент --}}
        <div class="mt-10 w-full">
            @yield('content') {{-- Динамічний контент --}}
        </div>
    </div>
</x-layout>