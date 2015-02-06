@extends('core::admin.master')

@section('main')

    <h1>
        <a href="{{ route('admin.menus.edit', $menu->id) }}" title="{{ trans('menulinks::global.Back') }}">
            <span class="text-muted fa fa-arrow-circle-left"></span><span class="sr-only">{{ trans('menulinks::global.Back') }}</span>
        </a>
        @lang('menulinks::global.New')
    </h1>

    {{ Form::open( array( 'route' => array('admin.menus.menulinks.index', $menu->id), 'files' => true, 'method' => 'post', 'role' => 'form' ) ) }}
        @include('menulinks::admin._form')
    {{ Form::close() }}

@stop
