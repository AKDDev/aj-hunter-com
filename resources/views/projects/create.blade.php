<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add New Project
        </h2>
    </x-slot>

    <form method="post" action="{{ route('projects.store') }}">
        @csrf
        <div>
            <label for="name">Project Name</label>
            <input type="text" id="name" name="name"/>
        </div>
        <div>
            <label for="status">Status</label>
            <select id="status" name="status">
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->status }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="active">Active</label>
            <input type="checkbox" value="1" id="active" name="active"/>
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
            Create Project
        </button>
    </form>
</x-app-layout>
