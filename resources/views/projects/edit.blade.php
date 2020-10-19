<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Project
        </h2>
    </x-slot>

    <form method="post" action="{{ route('projects.update',['project' => $project->id]) }}">
        {{ method_field('put') }}
        <input type="hidden" id="id" value="{{ $project->id}}"/>
        <div>
            <label for="project">Project Name</label>
            <input type="text" id="project" value="{{ $project->project }}"/>
        </div>
        <div>
            <label for="status_id">Status</label>
            <select id="status_id">
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}"{{ $project->status_id === $status->id?'selected':'' }}>{{ $status->status }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="active">Active</label>
            <input type="checkbox" value="true" id="active"{{ $project->active?'checked':''}}/>
        </div>
        <button type="submit">
            Create Project
        </button>
    </form>
</x-app-layout>
