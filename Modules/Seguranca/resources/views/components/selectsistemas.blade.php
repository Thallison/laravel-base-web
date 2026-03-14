<select name="sis_id" {{ $attributes->merge(['class' => 'form-control']) }}  @error('sis_id') is-invalid @enderror>
<option value="">{{ __('Selecione um sistema') }}</option>
@foreach($sistemas as $id => $nome)

<option value="{{ $id }}"
    {{ $selected == $id ? 'selected' : '' }}>
    {{ $nome }}
</option>

@endforeach

</select>
@error('sis_id')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror