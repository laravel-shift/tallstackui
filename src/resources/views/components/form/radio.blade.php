@php
    $personalize = $classes();
    $wire = $wireable($attributes);
    $error = $wire && $errors->has($wire->value());
    [$position, $alignment, $label] = $sloteable($label);
@endphp

<x-wrapper.radio :$id :$wire :$label :$position :$alignment>
    <input @if ($id) id="{{ $id }}" @endif type="radio" {{ $attributes->class([
            $personalize['input.class'],
            $personalize['input.sizes.' . $size],
            $colors['background'],
            $personalize['error'] => $error
    ]) }}>
</x-wrapper.radio>
