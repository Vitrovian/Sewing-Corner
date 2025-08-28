@auth
    <section class="flex flex-col gap-8 pt-16 px-10"> 
        <div class="conteiner flex flex-col gap-8 p-24">
            <h2 class="text-center font-bold text-4xl">Наші останні замовлення</h2>
            <div class="grid grid-cols-2 gap-4">
                @foreach ($orders as $order)
                    <x-order :$order/>
                @endforeach
            </div>
            
            @if (method_exists($orders, 'links'))
                <div class="sm:flex-1 sm:flex sm:items-center sm:justify-between flex-1 flex flex-col items-center bg-white text-red-800 p-4 rounded shadow">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </section>  
@endauth