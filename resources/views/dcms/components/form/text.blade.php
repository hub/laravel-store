@php
  $attributesDefault = [
    'class' => 'form-control',
    'required',
  ];

  if (isset($required) && false === $required) {
    unset($attributesDefault[array_search('required', $attributesDefault)]);
  }

  if ( !empty($attributes) ) {
    $attributesDefault = array_merge($attributesDefault, $attributes);
  }
  $method = $method ?? 'text';
  $icon = isset($icon) ? "<i class='fa fa-{$icon} prefix grey-text'></i> " : null;

  $value = old($name) ?? $value ?? null;
@endphp

<div class="md-form">
  {!! Form::label($name, "{$icon} {$title}", [], false) !!}
  @if ( 'password' == $method )
    {!! Form::$method($name, $attributesDefault) !!}
  @else
    {!! Form::$method($name, $value, $attributesDefault) !!}
  @endif
  
  @if ($errors->has($name))
      <span class="invalid-feedback" style="display: block;">
          <strong>{{ $errors->first($name) }}</strong>
      </span>
  @endif
</div>