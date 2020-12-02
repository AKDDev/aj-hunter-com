<x-app-layout>
    <x-page>
        <h2>
            Add New Goal
        </h2>

        <form method="post" action="{{ route('goals.store') }}">
            @csrf
            <x-form.select name="project_id" :selected="old('project_id')" :options="$projects->pluck('project','id')">Project</x-form.select>
            <x-form.input name="goal" type="text" :value="old('goal')">Goal Name</x-form.input>
            <x-form.select name="status_id" :selected="old('status_id')" :options="$statuses->pluck('status','id')">Status</x-form.select>
            <x-form.input name="total" type="number" :value="old('total')">Total</x-form.input>
            <x-form.select name="type_id" :selected="old('type_id')" :options="$types->pluck('type','id')">Type</x-form.select>
            <x-form.input name="start" type="date" :value="old('start')">Start</x-form.input>
            <x-form.input name="end" type="date" :value="old('end')">End</x-form.input>
            <x-form.errors :errors="$errors"></x-form.errors>
            <x-button type="submit">Create Goal</x-button>
        </form>
    </x-page>
</x-app-layout>
