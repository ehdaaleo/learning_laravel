@php
    $types = [
        'primary' => 'bg-slate-900 text-white hover:bg-slate-700',
        'secondary' => 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-100',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-700',
        'success' => 'bg-emerald-600 text-white hover:bg-emerald-700',
        'warning' => 'bg-amber-400 text-slate-900 hover:bg-amber-300',
        'outline' => 'border border-sky-300 bg-sky-50 text-sky-700 hover:bg-sky-100',
    ];

    $sizes = [
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-5 py-3 text-base',
    ];

    $typeClass = $types[$type] ?? $types['primary'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<button type="{{ $buttonType }}" {{ $attributes->merge(['class' => trim("inline-flex items-center justify-center rounded-xl font-semibold transition $typeClass $sizeClass")]) }}>
    {{ $slot }}
</button>
