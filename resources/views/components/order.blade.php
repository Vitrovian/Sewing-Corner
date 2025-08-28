<a href="{{ route('orders.show', $order->id) }}" class="block rounded-md bg-slate-200 shadow-md hover:shadow-lg transition-shadow duration-300">
    <article class="flex flex-col p-6 h-full relative">
        <header class="mb-4">
            <h3 class="font-semibold text-xl text-gray-800">{{ $order->service_type }}</h3>
            <span class="absolute top-4 right-4 text-sm text-gray-500">{{ $order->created_at->format('d-m-Y') }}</span>
        </header>
        <p class="font-normal mb-6 mt-2 max-h-[150px] overflow-y-auto text-sm text-gray-600 leading-relaxed">
            {{ $order->description }}
        </p>
        <footer class="flex justify-between items-center mt-auto">
            <div class="flex items-center gap-2">
                <x-icon name="user" class="size-6 text-gray-500"/>
                <span class="text-sm font-semibold text-gray-700">{{ $order->user->name }}</span>
            </div>
            <div class="flex items-center gap-2">
                
                @if ($order->price == 0)
                    @if (auth()->user()->role === \App\Enums\UserRole::Admin)
                        <span class="text-sm font-semibold text-red-600">Задайте ціну</span>
                        <x-icon name="value" class="size-4 fill-red-600"/>
                    @else
                        <span class="text-sm font-semibold text-yellow-500">Очікуйте оцінювання</span>
                        <x-icon name="value" class="size-4 fill-yellow-500"/>
                    @endif
                @else
                    <span class="text-sm font-semibold text-gray-700">{{ $order->price }}</span>
                    <x-icon name="value" class="size-4 fill-emerald-400"/>
                @endif
                
            </div>
        </footer>
    </article>
</a>
