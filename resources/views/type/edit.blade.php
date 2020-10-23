<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Type
    </h2>
    

    <form method="post" action="{{ route('types.update',['type' => $type->id]) }}">
        {{ method_field('put') }}
        <input type="hidden" id="id" name="id" value="{{ $type->id }}"/>
        @csrf
        <div>
            <label for="type">Type Name</label>
            <input type="text" id="type" name="type" value="{{ $type->type }}"/>
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
            Edit Type
        </button>
    </form>
</x-app-layout>
