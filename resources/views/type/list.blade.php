<x-app-layout>
    <x-page>
        <h2>
            Types
        </h2>
        <div class="">
            <x-button-link href="{{route('types.create')}}">New</x-button-link>
        </div>

        @if($types->count() == 0)
            <x-message :message="$message"></x-message>
        @else
            <table class="w-full">
                <thead>
                <th>Type</th>
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($types as $type)
                    <tr>
                        <td>{{ $type->type }}</td>
                        <td>
                            <x-action.button>
                                <x-action.action href="{{ route('types.edit',['type' => $type->id]) }}">Edit</x-action.action>
                                <x-action.action
                                    href="{{ route('types.delete',['type' => $type->id]) }}"
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
