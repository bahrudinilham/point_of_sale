@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#5D5FEF] text-start text-base font-medium text-[#5D5FEF] bg-[#5D5FEF]/10 focus:outline-none focus:text-[#5D5FEF] focus:bg-[#5D5FEF]/20 focus:border-[#5D5FEF] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-muted hover:text-foreground hover:bg-background hover:border-border focus:outline-none focus:text-foreground focus:bg-background focus:border-border transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
