<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Status
        </h2>
    </x-slot>

    <form method="post" action="{{ route('statuses.update',['status' => $status->id]) }}">
        {{ method_field('put') }}
        <input type="hidden" id="id" name="id" value="{{ $status->id }}"/>
        @csrf
        <div>
            <label for="status">Status Name</label>
            <input type="text" id="status" name="status" value="{{ $status->status }}"/>
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
            Edit Status
        </button>
    </form>
</x-app-layout>
