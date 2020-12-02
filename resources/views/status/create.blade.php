<x-app-layout>
    <x-page>
        <h2>
            Add New Status
        </h2>

        <form method="post" action="{{ route('statuses.store') }}">
            @csrf
            <x-form.input name="status" type="text" :value="old('status')">Status Name</x-form.input>
            <x-form.errors :errors="$errors"></x-form.errors>
            <x-button type="submit">Create Status</x-button>
        </form>
    </x-page>
</x-app-layout>
