@props(['options' => []])

<select {{ $attributes->merge(['class' => 'form-select border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm']) }}>
    @foreach ($options as $value => $label)
        <option value="{{ $value }}">{{ $label }}</option>
    @endforeach
</select>
