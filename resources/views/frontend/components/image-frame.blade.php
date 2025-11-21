@props([
    'image' => asset('images/logo-placeholder.jpg'),
])

<div class="card-bg card-shadow rounded-2xl overflow-hidden flex flex-col card-hover w-full h-full">
    <img src="{{ $image }}" class="w-full h-48 object-cover">
</div>
