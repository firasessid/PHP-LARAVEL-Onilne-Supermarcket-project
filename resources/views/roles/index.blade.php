@section('content')
@extends('layouts.back-main')
@section('main-container')
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Roles list</h2>
        @can('role-create')
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
                            <th>Permissions</th>
                            @if (auth()->user()->can('role-delete') || auth()->user()->can('role-edit'))
                            <th class="text-end">Action</th>
                            @else

@endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                        @unless ($role->name === 'admin')

                        <tr>
                            <td width="20%"> <!-- Increased width to 60% -->
                                <a href="{{ route('roles.show', $role->id) }}" class="itemside">
                                    <div class="info pl-3">
                                        <h6 class="mb-0 title">{{ $role->name }}</h6>
                                        <small class="text-muted">Role ID: #{{ $role->id }}</small>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <!-- Increased width to 60% -->
                                @if(!empty($role->permissions))
                                @foreach($role->permissions as $permission)
                                <span class="badge badge-pill badge-soft-success mb-2">{{ $permission->name }}</span>
                                @endforeach
                                @endif
                            <td class="text-end" width="12%">
                                <form method="POST" action="{{ route('roles.destroy', $role->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    @can('role-edit')

                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-xs btn-primary btn-flat" data-toggle="tooltip" title="Edit">Edit</a>
                                   @endcan
                                    @can('role-delete')

                                    <button type="submit" class="btn btn-sm font-sm btn-light rounded show_confirm">
                                        <i class="material-icons md-delete_forever"></i> Delete
                                    </button>
                                    @endcan

                                </form>
                            </td>
                        </tr>
                        @endunless

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
    <div class="pagination-area mt-15 mb-50">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                <!-- Pagination links here -->
            </ul>
        </nav>
    </div>
</section>
@endsection

