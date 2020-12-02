<x-app-layout>
    <x-page>
        <h2>
            Edit Type
        </h2>


        <form method="post" action="{{ route('types.update',['type' => $type->id]) }}">
            {{ method_field('put') }}
            <input type="hidden" id="id" name="id" value="{{ $type->id }}"/>
            @csrf
            <x-form.input name="type" type="text" :value="old('type', $type->type)">Type Name</x-form.input>
            <x-form.errors :errors="$errors"></x-form.errors>
            <x-button type="submit">Create Type</x-button>
        </form>
    </x-page>
</x-app-layout>
