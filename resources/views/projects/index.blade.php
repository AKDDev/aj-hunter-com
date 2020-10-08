<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Projects
        </h2>
    </x-slot>
    <table>
        <thead>
            <th>Project</th>
            <th>A</th>
            <th>Status</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($projects as $project)
                <td>{{ $project->project }}</td>
                <td>{{ $project->active }}</td>
                <td>{{ $project->status->status }}</td>
                <td>

                </td>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
