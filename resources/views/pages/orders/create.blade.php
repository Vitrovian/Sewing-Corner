<x-layout>
    <div class="flex items-center justify-center min-h-screen">
        <div class="max-w-2xl w-full p-8 rounded-xl shadow-xl border-2 border-slate-400 bg-gradient-to-l from-slate-400 to-stone-300">
            <h2 class="text-2xl font-bold mb-6 text-center">Створення замовлення</h2>
            
            {{-- Перевірка на наявність помилок --}}
            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('store-order') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label for="service_type" class="block text-sm font-medium text-gray-700 mb-2">Тип послуги</label>
                    <select id="service_type" name="service_type" class="block w-full border border-gray-300 bg-white rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-2">
                        <option value="repair">Ремонт</option>
                        <option value="sewing">Пошив</option>
                        <option value="other">Інше</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Опис роботи</label>
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full border border-gray-300 bg-white rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 px-4 py-2 resize-none" placeholder="Додайте опис роботи..."></textarea>
                </div>

                <div class="flex flex-col mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Додати зображення (обов'язково 2)</label>
                    <input type="file" id="image_upload" name="images[]" accept="image/*" multiple class="hidden">
                    <label for="image_upload" class="cursor-pointer px-4 py-2 bg-gray-300 rounded-lg shadow hover:bg-gray-400 text-center">Обрати файли</label>
                    <div id="preview" class="grid grid-cols-2 gap-4 mt-4">
                        <img id="preview1" class="w-full h-40 object-cover rounded-lg shadow-md hidden">
                        <img id="preview2" class="w-full h-40 object-cover rounded-lg shadow-md hidden">
                    </div>
                </div>

                <div class="flex justify-center mt-6 gap-4">
                    <button type="submit" class="px-4 py-2 bg-violet-600 text-white rounded shadow hover:bg-violet-500 focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 cursor-pointer transition duration-300">
                        Створити замовлення
                    </button>
                </div>
                <div class="flex justify-center mt-2">
                    <a href="{{ url('/orders') }}" class="px-4 py-2 bg-red-600 text-gray-800 rounded shadow hover:bg-red-500 focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 cursor-pointer transition duration-300">
                        Відмінити
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>

<script>
document.getElementById('image_upload').addEventListener('change', function(event) {
    const files = event.target.files;
    
    if (files.length > 2) {
        alert('Можна завантажити тільки 2 зображення!');
        event.target.value = ''; // Очистити вибір зображень
        return;
    }

    const preview1 = document.getElementById('preview1');
    const preview2 = document.getElementById('preview2');

    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            if (index === 0) {
                preview1.src = e.target.result;
                preview1.classList.remove('hidden');
            } else if (index === 1) {
                preview2.src = e.target.result;
                preview2.classList.remove('hidden');
            }
        };
        reader.readAsDataURL(file);
    });
});
</script>