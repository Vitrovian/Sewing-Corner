@php
    $attributes = $attributes
        ->class([
            'text-lg font-semibold',
            'flex items-center justify-center h-8',
            'hover:text-violet-500',
            'text-violet-500 border-violet-500' => $isActive,
        ]);
@endphp

<li>
    <a {{ $attributes }}>
        {{ $slot }}
    </a>
</li>
