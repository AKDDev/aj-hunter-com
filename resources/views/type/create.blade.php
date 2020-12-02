<x-app-layout>
    <x-page>
        <h2>
            Add New Type
        </h2>

        <form method="post" action="{{ route('types.store') }}">
            @csrf
            <x-form.input name="type" type="text" :value="old('type')">Type Name</x-form.input>
            <x-form.errors :errors="$errors"></x-form.errors>
            <x-button type="submit">Create Type</x-button>
        </form>
    </x-page>
</x-app-layout>
