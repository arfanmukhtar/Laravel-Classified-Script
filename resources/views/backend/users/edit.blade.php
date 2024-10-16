@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('common.user')  @lang('common.edit')</div>

                <div class="panel-body">
                    <form action="{{ url('admin/staff/' . $user->id) }}" method="POST">
                        <input type="hidden" name="_method" value="put">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name">@lang('common.name')</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                        </div>

                        <div class="form-group">
                            <label for="email">@lang('common.email')</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="form-group">
                            <label for="role_id">@lang('common.role')</label>
                            <select class="form-control" id="role_id" name="role_id">
                                @foreach($roles as $id => $role)
                                    <option value="{{ $role->id }}" {{ !($role->id == old('role_id', $user->role_id)) ?: 'selected="selected"' }} >{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">@lang('common.update')</button>
                            <a class="btn btn-link" href="{{ url('users') }}">@lang('common.cancel')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection