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

            <form method="POST" action="{{ route('password.update') }}" autocomplete="off">
                @csrf
            
                <input type="hidden" name="token" value="{{ $token }}">
                 <!-- Новий Пароль -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Новий Пароль</label>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        placeholder="Новий Пароль" 
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-3 bg-white" 
                        autocomplete="new-password" 
                        required
                    >
                </div>

                <!-- Повторити Пароль -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Повторіть Пароль</label>
                    <input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        placeholder="Повторіть Пароль" 
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-3 bg-white" 
                        autocomplete="new-password" 
                        required
                    >
                </div>

                <div class="mb-4 flex justify-center">
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-violet-600 text-white rounded shadow hover:bg-violet-700 focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 cursor-pointer"
                    >
                        Встановити Пароль
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>