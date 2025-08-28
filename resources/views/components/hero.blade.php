<section>
    @guest
    <div class="container flex flex-col gap-6 justify-center items-center min-h-screen py-40 px-4">
        <div>
            <h1 class="font-extrabold text-5xl">Вітаєммо у Sewing Corner</h1>
        </div>
        <p class="text-xl font-medium">Що обирете?</p>
        <div class="flex gap-2 mt-6"> 
        
            <a href="{{ route('login') }}" class="whitespace-nowrap font-semibold px-14 py-2 bg-violet-400 hover:bg-violet-500 rounded-xl flex justify-center items-center w-40">Війти</a>
            <a href="{{ route('register') }}" class="whitespace-nowrap font-semibold px-14 py-2 bg-violet-400 hover:bg-violet-500 rounded-xl flex justify-center items-center w-40">Зареєструватися</a>
        </div>
       
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
    </div> 
    @endguest
</section>