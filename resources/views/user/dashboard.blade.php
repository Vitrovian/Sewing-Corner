<x-layout>
    <div class="flex flex-col items-center justify-center w-full max-w-4xl mx-auto p-8 rounded-xl shadow-xl border-2 border-slate-400 bg-gradient-to-l from-slate-300 to-stone-300 mt-32">
        {{-- Повідомлення про успіх --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 w-full" role="alert">
                <strong class="font-bold">Успіх!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <h1 class="text-4xl font-bold text-center">
            Вітаємо в особистому кабінеті,<br> 
            <span class="text-violet-500">{{ auth()->user()->name }}</span>!
        </h1>
        <p class="text-lg text-gray-600 mt-4 text-center">
            Тут ви можете керувати своїм профілем та замовленнями.
        </p>

        {{-- Блоки профілю та дій --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10 w-full">
            {{-- Інформація про профіль --}}
            <div class="border-2 border-gray-300 bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">Ваш профіль</h2>
                <ul class="text-gray-700 space-y-2">
                    <li><strong class="text-gray-900">Ім'я:</strong> {{ auth()->user()->name }}</li>
                    <li><strong class="text-gray-900">Email:</strong> {{ auth()->user()->email }}</li>
                    <li><strong class="text-gray-900">Телефон:</strong> {{ auth()->user()->phone ?? 'Не вказано' }}</li>
                </ul>
            </div>

            {{-- Кнопки дій --}}
            <div class="flex flex-col justify-center items-center space-y-4">
                <a href="{{ route('create-order') }}" 
                   class="px-6 py-3 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 inline-block text-center transition duration-300 ease-in-out transform hover:scale-105 w-full text-lg">
                    Створити замовлення
                </a>
                <a href="{{ route('orders.index') }}" 
                   class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 inline-block text-center transition duration-300 ease-in-out transform hover:scale-105 w-full text-lg">
                    Мої замовлення
                </a>
                <a href="{{ route('contact') }}" 
                   class="px-6 py-3 bg-violet-600 text-white rounded-lg shadow-md hover:bg-violet-500 focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 inline-block text-center transition duration-300 ease-in-out transform hover:scale-105 w-full text-lg">
                    Зв'язатися з нами
                </a>
            </div>
        </div>

        {{-- Кнопка редагування профілю та виходу  --}}
        <div class="flex flex-col justify-center items-center gap-4 mt-8 w-full">
            <a href="{{ route('profile.edit') }}"
               class="px-6 py-3 bg-yellow-500 text-white rounded-lg shadow-md hover:bg-yellow-400 focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition transform hover:scale-105 duration-300 text-lg text-center">
                Редагувати профіль
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="px-6 py-3 bg-red-600 text-white hover:bg-red-500 rounded-lg shadow-md cursor-pointer focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-300 ease-in-out transform hover:scale-105 text-lg text-center"
                >
                    Вихід
                </button>
            </form>
        </div>
    </div>
</x-layout>
