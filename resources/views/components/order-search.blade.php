<form action="{{ route('orders.index') }}" class="w-full mx-auto border-b-2  border-slate-500 rounded-full hover:border-violet-700" method="GET">
    <div class="flex items-center gap-2 bg-white border border-stone-300 rounded-full shadow-md px-4 py-2">
        <!-- Поле пошуку -->
        <div class="flex-grow">
            <input 
                type="search" 
                name="search"
                placeholder="Пошук замовлення за назвою або описом" 
                value="{{ request('search') }}"
                class="w-full bg-transparent border-none focus:outline-none focus:ring-0 text-gray-700 placeholder-gray-400"
            >
        </div>
       
        <button 
            type="submit" 
            class="flex items-center justify-center rounded-full bg-violet-500 p-2 hover:bg-violet-700 transition duration-300 ease-in-out cursor-pointer"
        >
            <x-icon name="magnifying-glass" class="size-6 fill-white"/>
        </button>
    </div>
</form>