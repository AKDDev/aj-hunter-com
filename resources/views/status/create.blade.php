<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add New Status
        </h2>
    </x-slot>

    <form method="post" action="{{ route('statuses.store') }}">
        <div>
            <label for="name">Status Name</label>
            <input type="text" id="status"/>
        </div>
        <button type="submit">
            Create Status
        </button>
    </form>
</x-app-layout>
