@if ($errors->any())
    <div class="text-red-800 bg-red-200 border-red-800 rounded p-2 my-2">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="p-1">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
