<x-app-layout>
    <x-page>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Status
        </h2>


        <form method="post" action="{{ route('statuses.update',['status' => $status->id]) }}">
            @csrf
            @method('put')
            <input type="hidden" id="id" name="id" value="{{ $status->id }}"/>
            <x-form.input name="status" type="text" :value="old('status', $status->status)">Status Name</x-form.input>
            <x-form.errors :errors="$errors"></x-form.errors>
            <x-button type="submit">Edit Status</x-button>
        </form>
    </x-page>
</x-app-layout>
