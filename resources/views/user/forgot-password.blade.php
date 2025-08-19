<x-layout>
    <div class="flex items-center justify-center min-h-screen">
        <div class="max-w-md w-full p-6 rounded-xl shadow-xl border-2 border-slate-400 bg-gradient-to-l from-slate-400 to-stone-300">
            <h2 class="text-2xl font-bold mb-6 text-center">Скидання Паролю</h2>

            @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif  

            <form method="POST" action="{{ route('password.email') }}" autocomplete="off">
                @csrf
            
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Електронна пошта</label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        placeholder="Введіть вашу електронну пошту" 
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-3 bg-white" 
                        value="{{ old('email') }}" 
                        autocomplete="off" 
                        required
                    >
                </div>

                <div class="mb-4 flex justify-center">
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-violet-600 text-white rounded shadow hover:bg-violet-700 focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 cursor-pointer"
                    >
                        Скинути Пароль
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-violet-500 hover:underline">
                        Повернутися до входу
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>