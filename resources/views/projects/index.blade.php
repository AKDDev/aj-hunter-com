<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Projects
    </h2>
    <div class="">
        <a href="{{ route('projects.create') }}">New</a>
    </div>
    
    @if($projects->count() == 0)
        <x-message :message="$message"></x-message>
    @else
        <table>
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
                        <td>{{ $project->active }}</td>
                        <td>{{ $project->status->status }}</td>
                        <td>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-app-layout>
