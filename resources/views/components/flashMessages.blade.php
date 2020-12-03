<div>
    @if(session()->has('error'))
        <div class="bg-red-200 text-red-800 border border-red-800 p-3">{{ session('error') }}</div>
    @endif

    @if(session()->has('success'))
        <div class="bg-green-200 text-green-800 border border-green-800 p-3">{{ session('success') }}</div>
    @endif

        @if(session()->has('message'))
            <div class="bg-blue-200 text-blue-800 border border-blue-800 p-3">{{ session('message') }}</div>
        @endif
</div>
