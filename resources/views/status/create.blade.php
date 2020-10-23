<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Add New Status
    </h2>
   
    <form method="post" action="{{ route('statuses.store') }}">
        @csrf
        <div>
            <label for="status">Status Name</label>
            <input type="text" id="status" name="status"/>
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
            Create Status
        </button>
    </form>
</x-app-layout>
