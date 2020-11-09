<div>
    <label
        class="block font-medium text-sm text-gray-700"
        for="{{ $name }}"
    >
        {{ $slot }}
    </label>
    <select
        {{ $attributes->merge(['class' => 'form-select rounded-md shadow-sm w-full']) }}
        id="{{ $name }}"
        name="{{ $name  }}"
    >
        @foreach($options as $key => $value)
            <option
                value="{{ $key }}"
                {{ $selected == $key?'selected':'' }}
            >
                {{ $value }}
            </option>
        @endforeach
    </select>
</div>
