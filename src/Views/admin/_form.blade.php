@section('js')
    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
@stop

@section('titleLeftButton')
    <a href="{{ route('admin.menus.edit', $menu->id) }}" title="{{ trans('menulinks::global.Back') }}">
        <span class="text-muted fa fa-arrow-circle-left"></span><span class="sr-only">{{ trans('menulinks::global.Back') }}</span>
    </a>
@stop

<div class="form-group">
    <button class="btn btn-primary" value="true" id="exit" name="exit" type="submit">@lang('validation.attributes.save and exit')</button>
    <button class="btn btn-default" type="submit">@lang('validation.attributes.save')</button>
</div>

<div class="row">

    {!! BootForm::hidden('id') !!}
    {!! BootForm::hidden('menu_id', $menu->id) !!}
    {!! BootForm::hidden('position', $model->position ?: 0) !!}
    {!! BootForm::hidden('parent_id') !!}

    <div class="col-sm-6">

        @include('core::admin._tabs-lang')

        <div class="tab-content">

            @foreach ($locales as $lang)

            <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
                <div class="form-group">
                    {!! BootForm::text(trans('labels.title'), $lang.'[title]') !!}
                </div>
                <div class="form-group @if($errors->has($lang.'.uri'))has-error @endif">
                    {{ Form::label($lang.'[uri]', trans('validation.attributes.uri')) }}
                    <div class="input-group">
                        <span class="input-group-addon">/</span>
                        {{ Form::text($lang.'[uri]', $model->translate($lang)->uri, array('class' => 'form-control')) }}
                    </div>
                    {!! $errors->first($lang.'.uri', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group @if($errors->has($lang.'.url'))has-error @endif">
                    {{ Form::label($lang.'[url]', trans('validation.attributes.website')) }}
                    {{ Form::text($lang.'[url]', $model->translate($lang)->url, array('class' => 'form-control', 'placeholder' => 'http://')) }}
                    {!! $errors->first($lang.'.url', '<p class="help-block">:message</p>') !!}
                </div>
                {!! BootForm::checkbox(trans('labels.online'), $lang.'[status]') !!}
            </div>

            @endforeach

        </div>

    </div>

    <div class="col-sm-6">

        <div class="form-group">
            {{ Form::label('page_id', trans('validation.attributes.page_id')) }}
            {{ Form::select('page_id', $selectPages, null, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('module_name', trans('validation.attributes.module_name')) }}
            {{ Form::select('module_name', $selectModules, null, array('class' => 'form-control')) }}
        </div>

        <div class="checkbox">
            <label>
                {{ Form::checkbox('has_categories') }} @lang('validation.attributes.has_categories')
            </label>
        </div>

        <div class="form-group">
            {{ Form::label('target', trans('validation.attributes.target')) }}
            {{ Form::select('target', array('' => trans('validation.values.Active tab'), '_blank' => trans('validation.values.New tab')), null, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('class', trans('validation.attributes.class')) }}
            {{ Form::text('class', $model->translate($lang)->class, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('icon_class', trans('validation.attributes.icon_class')) }}
            {{ Form::text('icon_class', $model->translate($lang)->icon_class, array('class' => 'form-control')) }}
        </div>

    </div>

</div>
