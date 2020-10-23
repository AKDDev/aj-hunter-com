<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Goal
        </h2>
    </x-slot>

    <form method="post" action="{{ route('goals.update',['goal' => $goal->id]) }}">
        {{ method_field('put') }}
        @csrf
        <input type="hidden" id="id" value="{{ $goal->id}}"/>
        <div>
            <label for="name">Goal Name</label>
            <input type="text" id="name" value="{{ $goal->goal }}"/>
        </div>
        <div>
            <label for="status">Status</label>
            <select id="status">
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}"{{ $goal->status_id === $status->id?'selected':'' }}>{{ $status->status }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="active">Active</label>
            <input type="checkbox" value="true" id="active"{{ $goal->active?'checked':''}}/>
        </div>

        @if ($errors->any())
            <div class="">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button type="submit">
            Create Goal
        </button>
    </form>
</x-app-layout>
