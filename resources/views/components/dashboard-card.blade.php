@props(['title', 'count', 'color' => 'text-gray-300'])

<div class="bg-white rounded-lg shadow p-6 text-center hover:scale-105 transition">
    <h3 class="font-semibold text-lg mb-2">{{ $title }}</h3>
    <p class="text-3xl font-bold {{ $color }}">{{ $count }}</p>
</div>
