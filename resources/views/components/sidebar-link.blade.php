{{-- Sidebar Link Component --}}
@props(['href', 'active' => false, 'icon' => ''])

@php
$classes = $active
    ? 'flex items-center gap-3 rounded-lg bg-emerald-600 px-3 py-2.5 text-sm font-medium text-white transition'
    : 'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        {!! $icon !!}
    @endif
    {{ $slot }}
</a>
