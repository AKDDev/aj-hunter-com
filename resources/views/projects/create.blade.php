<x-app-layout>
    <x-page>
        <h2>
            Add New Project
        </h2>

        <form method="post" action="{{ route('projects.store') }}">
            @csrf
            <x-form.input name="name" type="text" :value="old('name')">Project Name</x-form.input>
            <x-form.select name="status" :selected="old('status')" :options="$statuses->pluck('status','id')">Status</x-form.select>
            <x-form.checkbox name="active" :value="1" :checked="old('checked',[])">Active</x-form.checkbox>
            <x-form.errors :errors="$errors"></x-form.errors>
            <x-button type="submit">Create Project</x-button>
        </form>
    </x-page>
</x-app-layout>
