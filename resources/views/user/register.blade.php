<x-layout>
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 bg-gradient-to-br from-slate-300 to-stone-300 border-2 border-slate-400 rounded-2xl shadow-2xl">
            <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Реєстрація</h2>

            {{-- Перевірка на наявність помилок і виведення їх у вигляді списку  --}}
            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            

            <form method="POST" action="{{ route('register') }}" autocomplete="off">
                @csrf

                <!-- Ім'я -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Ім'я</label>
                    <input 
                        id="name" 
                        name="name" 
                        type="text" 
                        placeholder="Ім'я" 
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-3 bg-white" 
                        value="{{ old('name') }}" 
                        autocomplete="off" 
                        required
                    >
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Електронна пошта</label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        placeholder="email" 
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-3 bg-white" 
                        value="{{ old('email') }}" 
                        autocomplete="off" 
                        required
                    >
                </div>

                <!-- Телефон -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Телефон</label>
                    <input 
                        id="phone" 
                        name="phone" 
                        type="text" 
                        placeholder="+380XXXXXXXXX" 
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-3 bg-white" 
                        value="{{ old('phone') }}" 
                        autocomplete="off" 
                        required
                    >
                </div>
                <!-- Пароль -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Пароль</label>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        placeholder="Пароль" 
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-3 bg-white" 
                        autocomplete="new-password" 
                        required
                    >
                </div>

                <!-- Підтвердження пароля -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Підтвердження пароля</label>
                    <input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        placeholder="Повторіть пароль" 
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-3 bg-white" 
                        autocomplete="new-password" 
                        required
                    >
                </div>

                <div class="flex justify-center">
                    <button 
                        type="submit" 
                        class="w-full py-3 bg-violet-600 text-white text-sm font-medium rounded-lg shadow hover:bg-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition transform hover:scale-105 duration-200 cursor-pointer"
                    >
                        Зареєструватися
                    </button>
                </div>

                <p class="mt-4 text-center">
                    Вже маєте акаунт? 
                    <a href="{{ route('login') }}" class="text-violet-600 hover:text-violet-500 hover:underline">Увійти</a>
                </p>
            </form>
        </div>
    </div>
</x-layout>