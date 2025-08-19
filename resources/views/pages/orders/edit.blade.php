<x-layout>
    <div class="flex items-center justify-center min-h-screen p-10 ">
        <div class="max-w-6xl w-full rounded-2xl shadow-xl border border-slate-200 bg-gradient-to-br from-slate-300 to-stone-300   p-8 transition-all duration-300 hover:shadow-2xl">
            <h2 class="text-3xl font-bold mb-6 text-center text-gray-800 border-b pb-4 border-slate-200">Редагування замовлення</h2>
            
            {{-- Перевірка на наявність помилок --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                    <h4 class="text-red-800 font-semibold mb-2">Помилки при заповненні форми:</h4>
                    <ul class="ml-4 text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                
            <form method="POST" action="{{ route('orders.update', $order->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="flex flex-col md:flex-row gap-8">
                    {{-- Ліва колонка: Основна інформація --}}
                    <div class="w-full md:w-1/2 space-y-5 bg-slate-50 p-6 rounded-xl shadow-inner">
                        {{-- Поле для статусу тільки для адміністратора --}}
                        @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                            <div class="transition-all duration-200 hover:translate-y-[-2px]">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                                <select id="status" name="status" class="block w-full border border-gray-300 bg-white rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-3 appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNNyAxMGw1IDUgNS01SDd6IiBmaWxsPSIjNkI3MjgwIi8+PC9zdmc+')] bg-no-repeat bg-right-4 bg-center-y">
                                    <option value="new" @selected($order->status === 'new') class="py-2">Новий</option>
                                    <option value="processing" @selected($order->status === 'processing') class="py-2">В обробці</option>
                                    <option value="completed" @selected($order->status === 'completed') class="py-2">Виконано</option>
                                    <option value="canceled" @selected($order->status === 'canceled') class="py-2">Скасовано</option>
                                </select>
                            </div>
                        @else
                            {{-- Приховане поле статусу для звичайних користувачів --}}
                            <input type="hidden" name="status" value="{{ $order->status }}">
                        @endif

                        <div class="transition-all duration-200 hover:translate-y-[-2px]">
                            <label for="service_type" class="block text-sm font-medium text-gray-700 mb-1">Тип послуги</label>
                            <select id="service_type" name="service_type" class="block w-full border border-gray-300 bg-white rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-3 appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1zbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNN7AxMGw1IDUgNS01SDd6IiBmaWxsPSIjNkI3MjgwIi8+PC9zdmc+')] bg-no-repeat bg-right-4 bg-center-y">
                                <option value="repair" @selected($order->service_type === 'repair') class="py-2">Ремонт</option>
                                <option value="sewing" @selected($order->service_type === 'sewing') class="py-2">Пошив</option>
                                <option value="other" @selected($order->service_type === 'other') class="py-2">Інше</option>
                            </select>
                        </div>

                        <div class="transition-all duration-200 hover:translate-y-[-2px]">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Опис роботи</label>
                            <textarea id="description" name="description" rows="8" class="mt-1 block w-full border border-gray-300 bg-white rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-3 resize-none">{{ $order->description }}</textarea>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-violet-600 to-violet-800 text-white rounded-lg font-semibold shadow-lg hover:from-violet-500 hover:to-violet-700 focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 cursor-pointer transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl">
                                Оновити замовлення
                            </button>
                        </div>
                    </div>

                    {{-- Права колонка: Зображення --}}
                    <div class="w-full md:w-1/2 space-y-5">
                        <div class="flex flex-col bg-gradient-to-br from-violet-50 to-slate-100 p-6 rounded-xl shadow-sm border border-slate-100">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Оновити зображення</label>
                            <p class="text-xs text-slate-500 mb-3 italic">Нові зображення замінять існуючі</p>
                            <input type="file" id="image_upload" name="images[]" accept="image/*" multiple class="hidden">
                            <label for="image_upload" class="cursor-pointer px-4 py-3 bg-white hover:bg-gray-50 border border-gray-300 rounded-lg shadow-sm text-center text-slate-700 font-medium transition-all duration-200 transform hover:scale-[1.01] hover:border-violet-400 hover:text-violet-700 hover:shadow-md">
                                <span class="flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Обрати файли
                                </span>
                            </label>
                            
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Поточні зображення
                                </h4>
                                <div id="current_preview" class="grid grid-cols-2 gap-3">
                                    @if ($order->images && is_array(json_decode($order->images)))
                                        @foreach (json_decode($order->images) as $image)
                                            <div class="relative rounded-lg overflow-hidden shadow-md group transition-all duration-300 hover:shadow-lg transform hover:scale-[1.02]">
                                                <img src="{{ asset('storage/' . ltrim($image, '/')) }}" class="w-full h-40 object-cover">
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                                                    <span class="text-white text-xs px-2 py-1 ml-2 mb-2 bg-black/30 rounded">Поточне фото</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-span-2 flex items-center justify-center h-40 bg-slate-100 rounded-lg text-slate-400 text-sm">
                                            Немає завантажених зображень
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Нові зображення
                                </h4>
                                <div id="new_preview" class="grid grid-cols-2 gap-3 min-h-[100px]">
                                    <div class="col-span-2 flex items-center justify-center h-40 bg-slate-50 border border-dashed border-slate-200 rounded-lg text-slate-400 text-sm">
                                        Нові фото з'являться тут після вибору
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Блок статусу оплати --}}
            <div class="mt-8 mb-6">
                <div class="flex items-center gap-4 p-4 rounded-xl shadow-inner bg-white/70 border border-slate-200">
                    @if($order->payment_status === \App\Enums\PaymentStatus::Paid)
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-green-100">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-800 text-sm font-medium">Оплачено</span>
                            @if($order->payment_date)
                                <p class="text-xs text-gray-500 mt-1">Дата оплати: {{ $order->payment_date->format('d.m.Y H:i') }}</p>
                            @endif
                        </div>
                    @elseif($order->payment_status === \App\Enums\PaymentStatus::Pending)
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-yellow-100">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="inline-block px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm font-medium">Очікує оплати</span>
                        </div>
                    @elseif($order->payment_status === \App\Enums\PaymentStatus::Failed)
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-800 text-sm font-medium">Не вдалося оплатити</span>
                        </div>
                    @elseif($order->payment_status === \App\Enums\PaymentStatus::Cash)
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-indigo-100">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="inline-block px-3 py-1 rounded-full bg-indigo-100 text-indigo-800 text-sm font-medium">Готівкою при отриманні</span>
                        </div>
                    @endif
                </div>

                @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                    <form method="POST" action="{{ route('orders.updatePaymentType', $order->id) }}" class="mt-4 flex flex-col md:flex-row items-center gap-3">
                        @csrf
                        @method('PUT')
                        <label for="payment_type" class="block text-sm font-medium text-gray-700 mb-1 md:mb-0">Статус оплати:</label>
                        <select id="payment_type" name="payment_status" class="block w-60 border border-gray-300 bg-white rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-2">
                            <option value="pending" @selected($order->payment_status === \App\Enums\PaymentStatus::Pending)>Очікує оплати</option>
                            <option value="cash" @selected($order->payment_status === \App\Enums\PaymentStatus::Cash)>Готівкою при отриманні</option>
                            <option value="failed" @selected($order->payment_status === \App\Enums\PaymentStatus::Failed)>Не вдалося оплатити</option>
                            <option value="paid" @selected($order->payment_status === \App\Enums\PaymentStatus::Paid)>Оплачено</option>
                        </select>
                        <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            Зберегти зміни
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

<script>
document.getElementById('image_upload').addEventListener('change', function(event) {
    const files = event.target.files;
    
    if (files.length > 2) {
        alert('Можна завантажити не більше 2 зображень!');
        event.target.value = ''; // Очистити вибір зображень
        return;
    }

    // Очищаємо контейнер для нових зображень
    const newPreviewContainer = document.getElementById('new_preview');
    newPreviewContainer.innerHTML = '';
    
    // Додаємо нові зображення у превью
    if (files.length === 0) {
        newPreviewContainer.innerHTML = `
            <div class="col-span-2 flex items-center justify-center h-40 bg-slate-50 border border-dashed border-slate-200 rounded-lg text-slate-400 text-sm">
                Нові фото з'являться тут після вибору
            </div>
        `;
        return;
    }
    
    Array.from(files).forEach((file, index) => {
        const imgContainer = document.createElement('div');
        imgContainer.className = 'relative rounded-lg overflow-hidden shadow-md group transition-all duration-300 hover:shadow-lg transform hover:scale-[1.02]';
        
        const img = document.createElement('img');
        img.classList.add('w-full', 'h-40', 'object-cover');
        
        const overlay = document.createElement('div');
        overlay.className = 'absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end';
        overlay.innerHTML = `<span class="text-white text-xs px-2 py-1 ml-2 mb-2 bg-black/30 rounded">Нове фото ${index + 1}</span>`;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
        
        imgContainer.appendChild(img);
        imgContainer.appendChild(overlay);
        newPreviewContainer.appendChild(imgContainer);
    });
});
</script>
</x-layout>