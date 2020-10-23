<x-guest-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $goal->goal }}
        <small>{{ $goal->status->status }}</small>
    </h2>
</x-guest-layout>
