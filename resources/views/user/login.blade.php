<x-layout>
    <div class="flex items-center justify-center min-h-screen b">
        <div class="w-full max-w-md p-8 bg-gradient-to-br from-slate-300 to-stone-300 border-2 border-slate-400 rounded-2xl shadow-2xl">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Вхід</h2>

            {{-- Повідомлення про помилки --}}
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-700 bg-red-100 border border-red-300 px-4 py-3 rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Повідомлення про успіх --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Логін --}}
                <div>
                    <label for="login" class="block text-sm font-medium text-gray-700">Ім'я або Email</label>
                    <input 
                        id="login"
                        name="login"
                        type="text"
                        value="{{ old('login') }}"
                        placeholder="Введіть ім'я або email"
                        required
                        autocomplete="off"
                        class="w-full mt-1 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 bg-white"
                    >
                </div>

                {{-- Пароль --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Пароль</label>
                    <input 
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Пароль"
                        required
                        class="w-full mt-1 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 bg-white"
                    >
                </div>

                {{-- Запам'ятати --}}
                <div class="flex items-center">
                    <input 
                        id="remember" 
                        name="remember" 
                        type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-violet-600 focus:ring-violet-500"
                    >
                    <label for="remember" class="ml-2 text-sm text-gray-600 cursor-pointer">Запам'ятати мене</label>
                </div>

                {{-- Кнопка --}}
                <div class="flex justify-center">
                    <button 
                        type="submit"
                        class="w-full py-3 bg-violet-600 text-white text-sm font-medium rounded-lg shadow hover:bg-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition transform hover:scale-105 duration-200 cursor-pointer"
                    >
                        Увійти
                    </button>
                </div>

                {{-- Забули пароль --}}
                <div class="text-center mt-4">
                    <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-violet-500 hover:underline">
                        Забули пароль?
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>
