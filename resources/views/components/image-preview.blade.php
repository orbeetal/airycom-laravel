@props([
    'src' => '',
    'alt' => 'image',
    'width' => 'w-20',
    'ratio' => 'aspect-video'
])

<a
    href="{{ $src }}"
    target="_blank"
    class="mx-auto block {{ $width }} {{ $ratio }} overflow-hidden border"
>
    <img
        src="{{ $src }}"
        alt="{{ $alt }}"
        class="w-full {{ $ratio }} object-cover"
    />
</a>
    