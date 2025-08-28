<x-layout>
    <div class="flex items-center justify-center min-h-screen">
        <div class="max-w-md w-full bg-white p-6 rounded-xl shadow-md text-center">
            <h1 class="text-2xl font-bold mb-4">Перевірте вашу електронну пошту</h1>
            <p class="text-gray-700 mb-6">
                Вам надіслано посилання для верифікації. Будь ласка, перевірте вашу електронну пошту.
            </p>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-violet-500 text-white rounded shadow hover:bg-violet-600 cursor-pointer">
                    Надіслати посилання ще раз
                </button>
            </form>

            {{-- Кнопка виходу --}}
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-6">
                @csrf
                <button
                    type="submit"
                    class="px-6 py-3 bg-red-600 text-white hover:bg-red-500 rounded-lg shadow-md cursor-pointer focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-300 ease-in-out transform hover:scale-105"
                >
                    Вихід
                </button>
            </form>
        </div>
    </div>
</x-layout>