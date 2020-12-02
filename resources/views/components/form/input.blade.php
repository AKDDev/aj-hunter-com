<div class="mb-2">
    <label
        class="block font-medium text-sm text-gray-700"
        for="{{ $name }}"
    >
        {{ $slot }}
    </label>
    <input
        {{ $attributes->merge(['class' => 'form-input rounded-md shadow-sm w-full']) }}
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value }}"
    />
</div>
