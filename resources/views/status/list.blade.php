<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Statuses
    </h2>
    <div class="">
        <a href="{{route('statuses.create')}}">New</a>
    </div>
  
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
                    <tr>
                        <td>{{ $status->status }}</td>
                        <td>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-app-layout>
