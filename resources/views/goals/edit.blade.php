<x-app-layout>
    <x-page>
        <h2>
            Add New Goal
        </h2>

        <form method="post" action="{{ route('goals.update',['goal' => $goal->id]) }}">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="{{ $goal->id }}"/>
            <x-form.select name="project_id" :selected="old('project_id',$goal->project_id)" :options="$projects->pluck('project','id')">Project</x-form.select>
            <x-form.input name="goal" type="text" :value="old('goal', $goal->goal)">Goal Name</x-form.input>
            <x-form.select name="status_id" :selected="old('status_id', $goal->status_id)" :options="$statuses->pluck('status','id')">Status</x-form.select>
            <x-form.input name="total" type="number" :value="old('total',$goal->total)">Total</x-form.input>
            <x-form.select name="type_id" :selected="old('type_id', $goal->type_id)" :options="$types->pluck('type','id')">Type</x-form.select>
            <x-form.input name="start" type="date" :value="old('start', $goal->start)">Start</x-form.input>
            <x-form.input name="end" type="date" :value="old('end', $goal->end)">End</x-form.input>
            <x-form.errors :errors="$errors"></x-form.errors>
            <x-button type="submit">Edit Goal</x-button>
        </form>
    </x-page>
</x-app-layout>
