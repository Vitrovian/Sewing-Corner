@php
    // Визначення кольорів для різних статусів
    $statusColors = [
        'new' => ['bg' => 'bg-blue-200', 'text' => 'text-blue-800'],
        'processing' => ['bg' => 'bg-yellow-200', 'text' => 'text-yellow-800'],
        'completed' => ['bg' => 'bg-green-200', 'text' => 'text-green-800'],
        'canceled' => ['bg' => 'bg-red-200', 'text' => 'text-red-800']
    ];
    
    // Отримуємо кольори для поточного статусу або використовуємо сірі за замовчуванням 
    $bgColor = isset($status) && is_string($status) && isset($statusColors[$status]) ? $statusColors[$status]['bg'] : 'bg-gray-200';
    $textColor = isset($status) && is_string($status) && isset($statusColors[$status]) ? $statusColors[$status]['text'] : 'text-gray-800';
    
    // Визначення назви статусу українською
    $statusNames = [
        'new' => 'Новий',
        'processing' => 'В процесі ремонту/пошиття',
        'completed' => 'Виконано',
        'canceled' => 'Скасовано'
    ];
    
    $statusName = isset($status) && is_string($status) ? ($statusNames[$status] ?? ucfirst($status)) : 'Невідомо';
@endphp

<span class="inline-flex items-center">
    <strong class="text-xl mr-1">Статус:</strong>
    <span class="px-4 py-1 rounded-full text-xl {{ $bgColor }} {{ $textColor }}">
        {{ $statusName }}
    </span>
</span>