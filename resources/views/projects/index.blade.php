<x-app-layout>
    <x-page>
        <h2>
            Projects
        </h2>
        <div class="my-3">
            <x-button-link href="{{ route('projects.create') }}">New</x-button-link>
        </div>

        @if($projects->count() == 0)
            <x-message :message="$message"></x-message>
        @else
            <table class="w-full">
                <thead>
                <tr>
                    <th>Project</th>
                    <th>A</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->project }}</td>
                        <td>
                            <x-yes-no :value="$project->active"></x-yes-no>
                        </td>
                        <td>{{ $project->status->status }}</td>
                        <td>
                            <x-action.button>
                                <x-action.action href="{{ route('projects.edit',['project' => $project->id]) }}">Edit</x-action.action>
                                <x-action.action
                                    href="{{ route('projects.delete',['project' => $project->id]) }}"
                                    action="delete"
                                >
                                    Delete
                                </x-action.action>
                            </x-action.button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </x-page>
</x-app-layout>
