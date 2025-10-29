@props(['link', 'text'])

<a href="{{ $link }}"
   class="px-3 py-2 rounded-md hover:bg-blue-100 hover:text-blue-600 transition duration-300 text-center"
   aria-label="{{ $text }}"
>
    {{ $text }}
</a>