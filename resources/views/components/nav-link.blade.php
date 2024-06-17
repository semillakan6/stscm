@props(['active', 'icon' => ''])

@php
    $classes = $active ?? false
        ? 'btn btn-link btn-active'
        : 'btn btn-link';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} style="text-decoration:none">
    {!! $icon !!} &nbsp; {{ $slot }}
</a>
