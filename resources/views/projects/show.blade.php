<x-guest-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $project->project }}
        <small>{{ $project->status->status }}</small>
    </h2>
</x-guest-layout>
