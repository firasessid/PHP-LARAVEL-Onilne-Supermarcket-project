@extends('layouts.app')
@section('content')
    <div class="content-wrapper" >

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Roles</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Role Page</li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                  <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                    </div>
                  </div>
              </div>
              

            </div>
        </section>
      

        <section class="content mx-2">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Title</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                  
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {{ $role->name }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Permissions:</strong>
                                @if(!empty($rolePermissions))
                                    @foreach($rolePermissions as $v)
                                        <label class="label label-success">{{ $v->name }},</label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

            
                </div>

                <div class="card-footer">
                    Footer
                </div>

            </div>

        </section>

    </div>

@endsection