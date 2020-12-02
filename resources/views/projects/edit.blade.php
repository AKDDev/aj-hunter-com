<x-app-layout>
    <x-page>
        <h2>
            Edit Project
        </h2>

        <form method="post" action="{{ route('projects.update',['project' => $project->id]) }}">
            @csrf
            @method('put')
            <input type="hidden" id="id" name="id" value="{{ $project->id }}"/>
            <x-form.input name="name" type="text" :value="old('name', $project->project)">Project Name</x-form.input>
            <x-form.select name="status" :selected="old('status', $project->status_id)" :options="$statuses->pluck('status','id')">Status</x-form.select>
            <x-form.checkbox name="active" :value="1" :checked="old('checked', [$project->active])">Active</x-form.checkbox>
            <x-form.errors :errors="$errors"></x-form.errors>
            <x-button type="submit">Edit Project</x-button>
        </form>
    </x-page>
</x-app-layout>
