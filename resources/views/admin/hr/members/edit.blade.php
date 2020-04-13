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

        <form action="" method="post" class="form-horizontal">
            @csrf
            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <label for="status" class="control-label col-sm-2">
                    Status
                </label>
                <div class="col-sm-6">
                    <select name="status" id="status" class="form-control">
                        @foreach(NZS\Core\HR\Member::getStatusesAsChoices() as $value => $text)
                            <option value="{{ $value }}"
                                @if($value == $member->status)
                                    selected
                                @endif
                                >
                                {{ $text }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="col-sm-4">
                    {{ $errors->first('status') }}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="1" name="has_badge"
                                @if($member->has_badge)
                                    checked
                                @endif
                                /> Czy osoba otrzymała przypinkę
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="is_member" value="1"
                                @if($member->is_member)
                                    checked
                                @endif
                                /> Czy osoba jest członkiem
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group {{ $errors->has('member_since') ? 'has-error' : '' }}">
                <label for="member_since" class="control-label col-sm-2">
                    Członek od
                </label>
                <div class="col-sm-6">
                    <input type="text" name="member_since" id="member_since"
                        value="{{ $member->member_since ? $member->member_since->format('Y-m-d') : null }}"
                        class="form-control datepicker"
                        />
                </div>
                <div class="col-sm-4">
                    {{ $errors->first('member_since') }}
                </div>
            </div>

            <div class="form-group {{ $errors->has('member_to') ? 'has-error' : '' }}">
                <label for="member_to" class="control-label col-sm-2">
                    Członek do
                </label>
                <div class="col-sm-6">
                    <input type="text" name="member_to" id="member_to"
                        value="{{ $member->member_to ? $member->member_to->format('Y-m-d') : null }}"
                        class="form-control datepicker"
                        />
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
        </form>

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
