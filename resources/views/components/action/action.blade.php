@if($action == 'get')
    <a {{ $attributes->merge(['class' => 'block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out']) }}>
        {{ $slot }}
    </a>
@else
    <form method="POST" action="{{ $attributes->get('href') }}">
        @csrf
        @method($action)
        <a
           {{ $attributes->merge(['class' => 'block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out']) }}
           onclick="event.preventDefault(); this.closest('form').submit();"
        >
            {{ $slot }}
        </a>
    </form>

@endif
