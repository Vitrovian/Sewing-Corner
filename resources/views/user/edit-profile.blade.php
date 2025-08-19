<x-layout>
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 bg-gradient-to-br from-slate-300 to-stone-300 border-2 border-slate-400 rounded-2xl shadow-2xl">
            <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Редагування профілю</h2>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Ім'я</label>
                    <input name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-3 bg-white">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input name="email" id="email" type="email" value="{{ old('email', $user->email) }}" required
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-3 bg-white">
                </div>
                <div class="mb-6">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Телефон</label>
                    <input name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-3 bg-white">
                </div>
                <button type="submit"
                    class="w-full py-3 bg-violet-600 text-white text-sm font-medium rounded-lg shadow hover:bg-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition transform hover:scale-105 duration-200 cursor-pointer">
                    Зберегти
                </button>
            </form>
            <a href="{{ route('dashboard') }}"
                class="block w-full mt-4 py-3 bg-gray-400 text-white text-sm font-medium rounded-lg shadow hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center transition transform hover:scale-105 duration-200 cursor-pointer">
                Повернутися до кабінету
            </a>
        </div>
    </div>
</x-layout>