<div class="w-full py-3 mb-2">
    <input
        type="checkbox"
        {{ $attributes->merge(['class' => 'form-checkbox rounded-md shadow-sm text-orange-600']) }}
        value="{{ $value }}"
        id="{{ $name }}"
        name="{{ $name  }}"
        {{ in_array($value, $checked)?'checked':'' }}
    />
    <label
        class="font-medium text-sm text-gray-700 p-1"
        for="{{ $name }}"
    >
        {{ $slot }}
    </label>
</div>
