@extends('user.dashboard-layout')

@section('subtitle')
    <div class="text-xl text-gray-700 font-medium text-center">
        Тут ви можете керувати всіма замовленнями та користувачами.
        <p class="text-green-600 font-semibold ">Ви адміністратор!</p>
    </div>
@endsection

@section('content')
        
    <div class="flex flex-col md:flex-row gap-8">
        {{-- Інформація про профіль адміністратора --}}
        <div class="border border-slate-300 bg-white shadow-xl rounded-xl p-6 w-full md:w-1/3">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">Ваш профіль</h2>
            <ul class="text-gray-700 space-y-3">
                <li><strong class="text-gray-900">Ім'я:</strong> {{ auth()->user()->name }}</li>
                <li><strong class="text-gray-900">Email:</strong> {{ auth()->user()->email }}</li>
                <li><strong class="text-gray-900">Телефон:</strong> {{ auth()->user()->phone ?? 'Не вказано' }}</li>
                <li><strong class="text-gray-900">Роль:</strong> <span class="text-green-600 font-semibold">Адміністратор</span></li>
            </ul>
        </div>

        {{-- Адмінські блоки  --}}
        <div class="w-full md:w-2/3">
            {{-- Об'єднаний блок управління --}}
            <div class="border border-slate-300 bg-white shadow-xl rounded-xl p-6">
                <h2 class="text-center text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">Адміністративна панель</h2>
                <div class="space-y-4">
                    <a href="{{ route('orders.index') }}"
                    class="w-full block px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-center transition transform hover:scale-105 duration-300 text-lg"
                    >
                        Переглянути всі замовлення
                    </a>
                    
                    <a href="{{ route('admin.list') }}"
                    class="w-full block px-6 py-3 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 text-center transition transform hover:scale-105 duration-300 text-lg">
                        Список користувачів
                    </a>

                    <a href="{{ route('create-order') }}" class="w-full px-6 py-3 bg-violet-600 text-white rounded-lg shadow-md hover:bg-violet-500 focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 inline-block text-center transition duration-300 ease-in-out transform hover:scale-105">
                        Створити замовлення
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Кнопка редагування профілю --}}
    <div class="flex justify-center mt-4">
        <a href="{{ route('profile.edit') }}"
           class="px-6 py-3 bg-yellow-500 text-white rounded-lg shadow-md hover:bg-yellow-400 focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition transform hover:scale-105 duration-300 text-lg">
            Редагувати профіль
        </a>
    </div>
    {{-- Вихід --}}
    <form action="{{ route('logout') }}" method="POST" class="mt-4 flex justify-center">
        @csrf
        <button
            type="submit"
            class="px-6 py-3 bg-red-600 text-white rounded-lg shadow-md hover:bg-red-500 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition transform hover:scale-105 duration-300 text-lg cursor-pointer">
            Вихід
        </button>
    </form>
@endsection
