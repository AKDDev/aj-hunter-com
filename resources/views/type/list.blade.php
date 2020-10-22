<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Types
        </h2>
        <div class="">
            <a href="{{route('types.create')}}">New</a>
        </div>
    </x-slot>
    @if($types->count() == 0)
        <x-message :message="$message"></x-message>
    @else
        <table>
            <thead>
                <th>Type</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach($types as $type)
                    <tr>
                        <td>{{ $type->type }}</td>
                        <td>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
</x-app-layout>
