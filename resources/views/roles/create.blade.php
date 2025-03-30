@extends('layouts.back-main')

@section('main-container')
<style>
    .form-check {
        margin-bottom: 10px; /* Adds space between each checkbox */
    }
    .form-check-label {
        margin-left: 5px; /* Adds space between checkbox and label text */
    }
</style>

<section class="content-main">
    <div class="content-header">
        <div class="col-9">
            <div class="content-header">
                <h2 class="content-title">Create role</h2>
                <div>
                    {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
                    <button id="showAlertButton" type="submit" class="btn btn-md rounded font-sm hover-up ">Create</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <h4>Permissions list</h4>
            </div>
            <div class="card-body">
                @if (count($errors) > 0)
                   
                @endif

                <div class="mb-4">
                    <label for="name" class="form-label">Role name:</label>
                    {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : '')]) !!}
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <div class="mb-4">
    <label class="form-label">Permissions:</label>
    <div class="row">
        @foreach($permissions as $permission)
            <div class="col-md-4"> <!-- Displays 3 checkboxes per row -->
                <div class="form-check">
                    {{ Form::checkbox('permissions[]', $permission->id, false, ['class' => 'form-check-input']) }}
                    <label class="form-check-label">
                        {{ $permission->name }}
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
