<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add New Count
        </h2>
    </x-slot>

    <form method="post" action="{{ route('counts.store') }}">
        @csrf
        <div>
            <label for="count">Type Name</label>
            <input type="text" id="count" name="count"/>
        </div>

        @if ($errors->any())
            <div class="">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button type="submit">
            Create Type
        </button>
    </form>
</x-app-layout>
