<div>
    @if(session()->has('error'))
        <div class="">{{ session('error') }}</div>
    @endif

    @if(session()->has('success'))
        <div class="">{{ session('success') }}</div>
    @endif

        @if(session()->has('message'))
            <div class="">{{ session('message') }}</div>
        @endif
</div>
