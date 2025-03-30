@section('content')
@extends('layouts.back-main')
@section('main-container')
<section class="content-main">
<style>
    .form-check {
        margin-bottom: 10px; /* Adds space between each checkbox */
    }
    .form-check-label {
        margin-left: 5px; /* Adds space between checkbox and label text */
    }
</style>  
<div class="content-header">
    <h2 class="content-title">Edit Role</h2>
    {!! Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role->id]]) !!}

    <button type="submit" class="btn btn-primary">Save</button>
</div>

<div class="col-lg-7">
    <div class="card mb-4">
        <div class="card-header">
            <h4>Permissions list</h4>
        </div>
        <div class="card-body">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mb-4">
                <label for="name" class="form-label">Role name:</label>
                {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
            </div>

            <div class="mb-4">
                <label class="form-label">Permissions:</label>
                <div class="row">
                    @foreach($permissions as $value)
                    <div class="col-md-4">
                        <div class="form-check">
                            {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'form-check-input']) }}
                            <label class="form-check-label">
                                {{ $value->name }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>
</section>
@endsection
