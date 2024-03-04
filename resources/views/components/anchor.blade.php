@props(['href'])

<a {!! $attributes->merge(['href' => $href, 'class' => 'text-decoration-none text-white']) !!}>
    {{ $slot }}
</a>