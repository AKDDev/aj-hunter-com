<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add New Project
        </h2>
    </x-slot>
    <form method="post" action="{{ route('projects.store') }}">

    </form>
</x-app-layout>
