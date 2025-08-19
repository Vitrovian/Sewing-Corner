<x-layout>
    <div class="flex flex-col items-center justify-center min-h-screen gap-16">
        
        {{-- Телефон --}}
        <div class="flex flex-col items-center gap-3 text-center">
            <p class="text-violet-600 text-2xl font-semibold tracking-wide">Номер телефону:</p>
            <p class="select-all cursor-pointer text-4xl font-bold text-slate-800 hover:text-violet-700 transition duration-300">
                +3809911223344
            </p>
        </div>

        {{-- Соцмережі --}}
        <div class="flex flex-col items-center gap-4 text-center">
            <p class="text-violet-600 text-2xl font-semibold tracking-wide">Соціальні мережі:</p>
            <ul class="flex gap-6 flex-wrap justify-center">
                @foreach (config('watch.social_networks') as $name => $href)
                    <li>
                        <a href="{{ $href }}" target="_blank" rel="noopener noreferrer">
                            <x-icon :$name class="size-16 fill-slate-700 hover:fill-violet-600 transition duration-300 transform hover:scale-110" />
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
</x-layout>
