<form method="post" action="{{ route('counts.store') }}">
    @csrf
    <x-form.select name="goal_id" :selected="old('goal_id')" :options="$goals->pluck('goal','id')">Goal</x-form.select>
    <x-form.input name="when" type="date" :value="old('when')">When?</x-form.input>
    <x-form.input name="value" type="number" :value="old('count')">Amount</x-form.input>
    <x-form.errors :errors="$errors"></x-form.errors>
    <x-button type="submit">Add Count</x-button>
</form>
