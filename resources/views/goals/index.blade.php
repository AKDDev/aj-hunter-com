<x-app-layout>
    <x-page>
        <h2>
            Goals
        </h2>
        <div class="my-3">
            <x-button-link href="{{ route('goals.create') }}">New</x-button-link>
        </div>

        @if($goals->count() == 0)
            <x-message :message="$message"></x-message>
        @else
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Goal</th>
                        <th>Start - End</th>
                        <th>Status</th>
                        <th>Goal</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($goals as $goal)
                        <tr>
                            <td>{{ $goal->project->project }}</td>
                            <td>{{ $goal->goal }}</td>
                            <td>
                                {{ $goal->start }} to <br/>
                                {{ $goal->end?$goal->end:'Never' }}
                            </td>
                            <td>{{ $goal->status->status }}</td>
                            <td>{{ $goal->total }} {{ $goal->type->type }}</td>
                            <td>
                                <x-action.button>
                                    <x-action.action href="{{ route('goals.edit',['goal' => $goal->id]) }}">Edit</x-action.action>
                                    <x-action.action
                                        href="{{ route('goals.delete',['goal' => $goal->id]) }}"
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
