@extends('layouts.admin')

@section('title')
    {{ $member->present()->fullName() }}
@stop

@section('content')

    <div class="page-header">
        <div class="btn-toolbar pull-right">
            <div class="btn-group">
                <a href="{{ route('admin-hr-members-edit', $member)}}" class="btn btn-default"><i class="fa fa-pencil"></i> Edytuj</a>
                <a href="{{ route('admin-hr-members-delete', $member)}}" class="btn btn-default"><span class="glyphicon glyphicon-minus"></span> Usuń</a>
            </div>
        </div>
        <h2>

            {{ $member->present()->fullName() }}
        </h2>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <dl>
                <dt>E-mail</dt>
                <dd>{{ $member->user->email }}</dd>
                <dt>Status</dt>
                <dd>{{ $member->getStatus() }}</dd>
            </dl>
        </div>
    </div>

@stop
