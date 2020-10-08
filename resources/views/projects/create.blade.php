<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add New Project
        </h2>
    </x-slot>

    <form method="post" action="{{ route('projects.store') }}">
        <div>
            <label for="project">Project Name</label>
            <input type="text" id="project"/>
        </div>
        <div>
            <label for="status_id">Status</label>
            <select id="status_id">
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->status }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="active">Active</label>
            <input type="checkbox" value="true" id="active"/>
        </div>
        <button type="submit">
            Create Project
        </button>
    </form>
</x-app-layout>
