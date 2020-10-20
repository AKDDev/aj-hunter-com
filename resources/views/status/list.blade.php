<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Statuses
        </h2>
    </x-slot>
    @if($statuses->count() == 0)
        <x-message :message="$message"></x-message>
    @else
        <table>
            <thead>
                <th>Status</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach($statuses as $status)
                    <td>{{ $status->status }}</td>
                    <td>

                    </td>
                @endforeach
            </tbody>
        </table>
        @endif
</x-app-layout>
