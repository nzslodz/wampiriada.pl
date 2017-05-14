@extends('layouts.admin')

@section('title')

        Edytuj {{ $member->present()->fullName() }}
@stop

@section('content')
    <div class="page-header">
        <h1>
                Edytuj {{ $member->present()->fullName() }}
        </h1>
    </div>

    <div class="container">

        {{ Form::open(array('class' => 'form-horizontal')) }}

            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                {{ Form::label('status', 'Status', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::select('status', NZS\Core\HR\Member::getStatusesAsChoices(), $member->status, ['class' => 'form-control']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('status') }}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-2">
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('has_badge', '1', $member->has_badge, ['class' => '']) }} Czy osoba otrzymała przypinkę
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-2">
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('is_member', '1', $member->is_member, ['class' => '']) }} Czy osoba jest członkiem
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group {{ $errors->has('member_since') ? 'has-error' : '' }}">
                {{ Form::label('member_since', 'Członek od', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::text('member_since', $member->member_since ? $member->member_since->format('Y-m-d') : null, ['class' => 'form-control datepicker']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('member_since') }}
                </div>
            </div>

            <div class="form-group {{ $errors->has('member_to') ? 'has-error' : '' }}">
                {{ Form::label('member_since', 'Członek do', ['class' => 'control-label col-sm-2']) }}
                <div class="col-sm-6">
                    {{ Form::text('member_to', $member->member_to ? $member->member_to->format('Y-m-d') : null, ['class' => 'form-control datepicker']) }}
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('member_to') }}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    @foreach(storyboard()->choices('_save') as $value => $transition)
                        <button class="btn btn-default" name="_save" type="submit" value="{{ $value }}">{{ $transition }}</button>
                    @endforeach
                </div>
            </div>
        {{ Form::close() }}

    </div>

@stop

@section('extrahead')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
@stop

@section('script')
      <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
       <script type="text/javascript">
            $(function() {
                $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
            })
       </script>
@stop
