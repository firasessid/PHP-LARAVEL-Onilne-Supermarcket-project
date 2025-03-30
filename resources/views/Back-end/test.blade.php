

@section('content')
@extends('layouts.back-main')
@section('main-container')

<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Roles list</h2>
        @can('user-create')
        <div>
            <a href="{{ route('roles.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Create new</a>
        </div>
       @endcan
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row gx-3">
                <div class="col-lg-4 col-md-6 me-auto">
                    <input type="text" placeholder="Search..." class="form-control" />
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <select class="form-select">
                        <option>Status</option>
                        <option>Active</option>
                        <option>Disabled</option>
                        <option>Show all</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <select class="form-select">
                        <option>Show 20</option>
                        <option>Show 30</option>
                        <option>Show 40</option>
                    </select>
                </div>
            </div>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Date</th>

                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)

                        <tr>

                            <td width="40%">
                                <a href="#" class="itemside">

                                    <div class="info pl-3">
                                        <h6 class="mb-0 title">{{ $role->name }}</h6>
                                        <small class="text-muted">User ID: #{{ $role->id }}</small>
                                    </div>
                                </a>
                            </td>


                            <td>{{ $role->created_at }}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('roles.show', $role->id) }}">Show</a>
                                @can('role-edit')
                                <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">Edit</a>
                                @endcan
                                @can('role-delete')
                                <form method="POST" action="{{ route('roles.destroy', $role->id) }}">
                                    @csrf
                                    @method('DELETE') <!-- Use the method helper instead of manually adding the _method input -->
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                {!! $data->render() !!}

                <!-- table-responsive.// -->
            </div>
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
    <div class="pagination-area mt-15 mb-50">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                <li class="page-item active"><a class="page-link" href="#">01</a></li>
                <li class="page-item"><a class="page-link" href="#">02</a></li>
                <li class="page-item"><a class="page-link" href="#">03</a></li>
                <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="#">16</a></li>
                <li class="page-item">
                    <a class="page-link" href="#"><i class="material-icons md-chevron_right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
</section>




@endsection
