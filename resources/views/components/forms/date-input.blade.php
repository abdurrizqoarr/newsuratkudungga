@props(['id', 'name', 'label', 'model', 'required' => false])

<div>
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <input type="date" id="{{ $id }}" name="{{ $name }}" wire:model="{{ $model }}"
        {{ $attributes->merge(['class' => 'mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md outline-none focus:border-emerald-500 focus:ring-emerald-500']) }}>

    @error($name)
        <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
    @enderror
</div>
