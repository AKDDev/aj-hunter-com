<form method="post" action="{{ route('counts.store') }}">
    @csrf
    <div>
        <label for="count">Amount</label>
        <input type="number" id="count" name="count"/>
    </div>
    <div>
        <label for="type_id">Type</label>
        <select id="type_id" name="type_id">
            @foreach($types as $type)
                <option value="{{ $type->id }}">{{$type->type }}</option>
            @endforeach
        </select>
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
        Add Count
    </button>
</form>
