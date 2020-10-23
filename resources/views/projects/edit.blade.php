<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Project
    </h2>

    <form method="post" action="{{ route('projects.update',['project' => $project->id]) }}">
        {{ method_field('put') }}
        @csrf
        <input type="hidden" id="id" value="{{ $project->id}}"/>
        <div>
            <label for="name">Project Name</label>
            <input type="text" id="name" value="{{ $project->project }}"/>
        </div>
        <div>
            <label for="status">Status</label>
            <select id="status">
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}"{{ $project->status_id === $status->id?'selected':'' }}>{{ $status->status }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="active">Active</label>
            <input type="checkbox" value="true" id="active"{{ $project->active?'checked':''}}/>
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
