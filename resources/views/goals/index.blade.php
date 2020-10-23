<x-app-layout>
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Goals
        </h2>
        <div class="">
            <a href="{{ route('goals.create') }}">New</a>
        </div>
    
        @if($goals->count() == 0)
            <x-message :message="$message"></x-message>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Goal</th>
                        <th>A</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($goals as $goal)
                        <tr>
                            <td>{{ $goal->goal }}</td>
                            <td>{{ $goal->active }}</td>
                            <td>{{ $goal->status->status }}</td>
                            <td>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
