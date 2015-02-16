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
    {!! BootForm::hidden('menu_id')->value($menu->id) !!}
    {!! BootForm::hidden('position')->value(0) !!}
    {!! BootForm::hidden('parent_id') !!}

    <div class="col-sm-6">

        @include('core::admin._tabs-lang')

        <div class="tab-content">

            @foreach ($locales as $lang)

            <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">

                {!! BootForm::text(trans('validation.attributes.title'), $lang.'[title]') !!}

                <div class="form-group @if($errors->has($lang.'.uri'))has-error @endif">
                    {!! Form::label(trans('validation.attributes.uri'))->addClass('control-label')->forId($lang . '[uri]') !!}
                    <div class="input-group">
                        <span class="input-group-addon">/</span>
                        {!! Form::text($lang . '[uri]')->addClass('form-control')->id($lang . '[uri]') !!}
                    </div>
                    {!! $errors->first($lang.'.uri', '<p class="help-block">:message</p>') !!}
                </div>

                {!! BootForm::text(trans('validation.attributes.url'), $lang.'[url]') !!}

                {!! BootForm::checkbox(trans('validation.attributes.online'), $lang.'[status]') !!}

            </div>

            @endforeach

        </div>

    </div>

    <div class="col-sm-6">
        {!! BootForm::select(trans('validation.attributes.page_id'), 'page_id', $selectPages) !!}
        {!! BootForm::select(trans('validation.attributes.module_name'), 'module_name', $selectModules) !!}
        {!! BootForm::checkbox(trans('validation.attributes.has_categories'), 'has_categories') !!}
        {!! BootForm::select(trans('validation.attributes.target'), 'target', ['' => trans('validation.values.Active tab'), '_blank' => trans('validation.values.New tab')]) !!}
        {!! BootForm::text(trans('validation.attributes.class'), 'class') !!}
        {!! BootForm::text(trans('validation.attributes.icon_class'), 'icon_class') !!}
    </div>

</div>
