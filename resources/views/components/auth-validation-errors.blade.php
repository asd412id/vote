@props(['errors'])

@if ($errors->any())
<div {{ $attributes }}>
    <div class="font-medium text-center text-red-600 capitalize">
        {{ $errors->all()[0] }}
    </div>
</div>
@endif