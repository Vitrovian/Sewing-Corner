<x-layout>
    <section class="pt-20 px-10">
        <div class="container mx-auto flex flex-col gap-6 py-6">
            @if (auth()->user()->role === \App\Enums\UserRole::Admin)
                <h2 class="text-center font-bold text-5xl">Замовлення користувачів</h2>
            @else
                <h2 class="text-center font-bold text-5xl">Ваші Замовлення</h2>
            @endif
            <div class="w-full mx-auto flex justify-center items-center">
                <a href="{{ route('create-order') }}" class="w-1/3 px-6 py-3 bg-violet-600 text-white rounded-lg shadow-md hover:bg-violet-500 focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 inline-block text-center transition duration-300 ease-in-out transform hover:scale-105">
                    Створити замовлення
                </a>
            </div>
            <x-order-search/>
            <div class="grid grid-cols-2 gap-4">
                @foreach ($orders as $order)
                    <x-order :$order/>
                @endforeach
            </div>
            @if(method_exists($orders, 'links'))
                {{ $orders->links() }}
            @endif
        </div>
    </section>  
</x-layout>