<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }} row">
    @if (isset($label))
        <div class="col-md-2">
            {{ html()->label($label)
                    ->class('form-control-label')
                    ->for($name) }}
        </div>
    @endif
    <div class="col-md-10">
        {{ html()->textarea($name, old($name) ?: ($object->{$name} ?? ''))
                ->class('form-control richtext')
                ->placeholder($placeholder ?? '')
                ->attribute($attribute ?? null)
                ->attributes($attributes ?? []) }}

        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @elseif (isset($help_text))
            <span class="help-block">{{ $help_text }}</span>
        @endif
    </div>
</div>
