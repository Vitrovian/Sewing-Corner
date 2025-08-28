<x-layout>
    <section class="pt-24 px-6">
        <div class="max-w-6xl mx-auto flex flex-col gap-10 pb-24">
            <h1 class="text-center font-bold text-4xl md:text-5xl text-gray-800 dark:text-gray-100">{{ $order->title }}</h1>
            <div class="bg-gradient-to-br from-slate-300 to-stone-300 rounded-xl shadow-lg p-6 border-b border-slate-200">
                
                {{-- Інформація про замовлення --}}
                <div class="flex flex-wrap justify-center items-center gap-2 mb-6 text-gray-800">
                    <span class="text-xl"><strong>Створено:</strong> {{ $order->updated_at->format('d.m.Y') }}</span>
                    <span class="mx-2 text-gray-400">|</span>
                    <span class="text-xl"><strong>Замовник:</strong> {{ $order->user->name }}</span>
                    <span class="mx-2 text-gray-400">|</span>
                    <x-order-status :status="$order->status" />
                    <span class="mx-2 text-gray-400">|</span>
                    <span class="text-xl"><strong>Ціна:</strong>
                        @if ($order->price)
                            {{ $order->price }} грн
                        @else
                            <span class="text-red-600">Не вказана</span>
                        @endif
                    </span>
                    <span class="mx-2 text-gray-400">|</span>
                    {{-- Додаємо статус оплати тут --}}
                    @if($order->payment_status === \App\Enums\PaymentStatus::Paid)
                        <span class="inline-block px-4 py-2 rounded-full bg-green-100 text-green-800 text-base font-semibold shadow">
                            Оплачено
                        </span>
                    @elseif($order->payment_status === \App\Enums\PaymentStatus::Pending)
                        <span class="inline-block px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 text-base font-semibold shadow">
                            Очікує оплати
                        </span>
                    @elseif($order->payment_status === \App\Enums\PaymentStatus::Failed)
                        <span class="inline-block px-4 py-2 rounded-full bg-red-100 text-red-800 text-base font-semibold shadow">
                            Не вдалося оплатити
                        </span>
                    @elseif($order->payment_status === \App\Enums\PaymentStatus::Cash)
                        <span class="inline-block px-4 py-2 rounded-full bg-indigo-100 text-indigo-800 text-base font-semibold shadow">
                            Готівкою при отриманні
                        </span>
                    @endif
                </div>

                <p class="text-lg text-center text-gray-700 mb-8 leading-relaxed">
                    {{ $order->description }}
                </p>

                {{-- Галерея зображень --}}
                @if ($order->images && is_array(json_decode($order->images)))
                    <div class="flex justify-center gap-6 mb-8 cursor-pointer">
                        @foreach (json_decode($order->images) as $img)
                            <div class="overflow-hidden rounded-xl shadow-md hover:shadow-xl transform hover:scale-[1.03] transition-all duration-300 ease-in-out">
                                <img 
                                    src="{{ asset('storage/' . ltrim($img, '/')) }}"
                                    class="w-full h-64 object-cover rounded-xl"
                                    alt="Зображення замовлення"
                                    onerror="this.src='{{ asset('images/placeholder.png') }}'"
                                    style="cursor: zoom-in;"
                                    onclick="showImageModal('{{ asset('storage/' . ltrim($img, '/')) }}')"
                                >
                            </div>
                        @endforeach
                    </div>
                @endif
        
                {{-- Кнопки дій --}}
                <div class="flex flex-wrap justify-center gap-4 mt-6 ">
                    <a href="{{ route('orders.edit', $order->id) }}" class="px-6 py-2 text-black bg-yellow-500 hover:bg-yellow-600 rounded-lg font-semibold shadow transition-all focus:ring-offset-2 transform hover:scale-105 duration-200 cursor-pointer">Змінити</a>
                    
                    @if (auth()->user()->role === \App\Enums\UserRole::Admin)
                        <button 
                            onclick="openSetPriceModal(event)" 
                            class="px-6 py-2 text-black bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold shadow transition-all focus:ring-offset-2 transform hover:scale-105 duration-200 cursor-pointer">
                            Задати ціну
                        </button>
                    @endif
                    {{-- Показувати кнопку скасування тільки якщо замовлення не виконано --}}
                    @if($order->status !== 'completed' && $order->status !== 'canceled' && $order->status !== 'processing')
                        {{-- Кнопка скасування --}}
                        <a href="#" onclick="openCancelModal(event)" class="px-6 py-2 text-black bg-red-600 hover:bg-red-700 rounded-lg font-semibold shadow transition-all focus:ring-offset-2 transform hover:scale-105 duration-200 cursor-pointer">Скасувати</a>
                    @endif
                    

                </div>
            </div>            
        </div>
    </section>

    {{-- Модальне вікно для збільшення зображення --}}
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 items-center justify-center z-50 hidden">
        <div class="relative flex">
            <img id="modalImage" class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-lg" />
            <button onclick="hideImageModal()" class="absolute top-2 right-2 text-white text-3xl font-bold p-2 hover:bg-gray-700 rounded-full cursor-pointer transition duration-300 ease-in-out" aria-label="Закрити">&times;</button>
        </div>
    </div>

    {{-- Модальне вікно для скасування --}}
    <div id="cancelModal" class="fixed inset-0 bg-gray-700 bg-opacity-60 flex items-center justify-center з-50" style="display: none;">
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-sm w-full text-center">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Скасувати замовлення?</h2>
            <p class="mb-6 text-gray-600">Ви впевнені, що хочете скасувати це замовлення?</p>
            <form method="POST" action="{{ route('orders.cancel', $order->id) }}" class="flex flex-col sm:flex-row justify-center gap-4">
                @csrf
                <input type="hidden" name="status" value="canceled">
                <button type="button" onclick="closeCancelModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-semibold cursor-pointer">
                    Відмінити
                </button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold cursor-pointer">
                    Так, скасувати
                </button>
            </form>
        </div>
    </div>

    {{-- Модальне вікно для встановлення ціни --}}
    <div id="setPriceModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-all duration-200" style="display: none;">
        <div class="bg-white rounded-xl shadow-lg p-6 max-w-sm w-full scale-90 transition-all duration-200">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Встановити ціну</h2>
                <button type="button" onclick="closeSetPriceModal()" class="text-gray-400 hover:text-gray-700 focus:outline-none cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('orders.setPrice', $order->id) }}" method="POST">
                @csrf
                <label for="price-modal" class="block text-sm font-medium text-gray-700 mb-2">Ціна (грн):</label>
                <input 
                    type="number" 
                    id="price-modal" 
                    name="price" 
                    step="1" 
                    min="0" 
                    value="{{ $order->price }}" 
                    class="block w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:ring-violet-500 focus:border-violet-500 transition-colors duration-200 text-base bg-white text-gray-900"
                    required
                    placeholder="0"
                >
                @error('price')
                    <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                @enderror
                <div class="flex justify-end gap-3 mt-2">
                    <button 
                        type="button" 
                        onclick="closeSetPriceModal()" 
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg font-medium transition-colors duration-200 cursor-pointer">
                        Скасувати
                    </button>
                    <button 
                        type="submit" 
                        class="bg-violet-600 hover:bg-violet-700 text-white px-5 py-2 rounded-lg font-medium shadow transition-all duration-200 cursor-pointer">
                        Зберегти
                    </button>
                </div>
            </form>
        </div>
    </div>
    
<script src="{{ asset('js/order-show.js') }}"></script>

</x-layout>
