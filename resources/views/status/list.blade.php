<x-app-layout>
    <x-page>
        <h2>
            Statuses
        </h2>
        <div class="my-3">
            <x-button-link href="{{route('statuses.create')}}">New</x-button-link>
        </div>

        @if($statuses->count() == 0)
            <x-message :message="$message"></x-message>
        @else
            <table class="w-full">
                <thead>
                <th>Status</th>
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($statuses as $status)
                    <tr>
                        <td>{{ $status->status }}</td>
                        <td>
                            <x-action.button>
                                <x-action.action href="{{ route('statuses.edit',['status' => $status->id]) }}">Edit</x-action.action>
                                <x-action.action
                                    href="{{ route('statuses.delete',['status' => $status->id]) }}"
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
