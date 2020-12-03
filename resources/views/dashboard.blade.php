<x-app-layout>
    <x-page>
        <h1>Dashboard</h1>
        <div class="md:flex">
            <div class="m-3 md:w-1/3">
                <div class="">
                    @include('count.create')
                </div>
            </div>

            <div class="md:flex-1 m-3">
                <h2>Active Goals</h2>
                <div class="flex flex-wrap">
                @foreach($goals as $goal)
                    <x-goal :goal="$goal" class="md:w-1/2"></x-goal>
                @endforeach
                </div>
            </div>
        </div>
    </x-page>
</x-app-layout>
