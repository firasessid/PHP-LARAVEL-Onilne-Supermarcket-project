

@section('content')
@extends('layouts.back-main')
@section('main-container')
<style>
    .table-hover thead th {
        white-space: nowrap;
        padding: 12px 15px !important;
        text-align: center;
    }
    .table-hover tbody td {
        text-align: right;
        vertical-align: middle;
    }
    .table-hover tbody td:first-child,
    .table-hover tbody td:nth-child(2),
    .table-hover tbody td:nth-child(3) {
        text-align: left;
    }
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }
    .table-hover tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .btn-flat {
        padding: 4px 10px;
        font-size: 12px;
    }
</style>

<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Users List</h2>
        @can('user-create')
        <div>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="material-icons md-plus"></i> Create New
            </a>
        </div>
        @endcan
    </div>

    <div class="card mb-4">
   <!-- Formulaire de filtre -->
<form action="{{ route('users.index') }}" method="GET" class="card mb-4">
    <header class="card-header">
        <div class="row gx-3 align-items-center">
            <!-- Champ de recherche -->
            <div class="col-lg-4 col-md-6 me-auto">
                <input type="text" placeholder="Search..." class="form-control" name="search" value="{{ request('search') }}">
            </div>

            <!-- Filtre par segment -->
           <!-- Filtre par segment -->
<div class="col-lg-2 col-md-3 col-6">
    <select name="segment" class="form-select" onchange="this.form.submit()">
        <option value="all" {{ request('segment') == 'all' ? 'selected' : '' }}>All Types</option>
        @foreach ($segments as $seg)
            @if ($seg !== 'all' && !empty($seg)) <!-- Vérifier que $seg n'est pas vide -->
                <option value="{{ $seg }}" {{ request('segment') == $seg ? 'selected' : '' }}>
                    {{ ucfirst($seg) }}
                </option>
            @endif
        @endforeach
    </select>
</div>

            <!-- Sélecteur pour définir le nombre d'éléments par page -->
            <div class="col-lg-2 col-md-3 col-6">
                <select name="per_page" class="form-select" onchange="this.form.submit()">
                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>Show 20</option>
                    <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>Show 30</option>
                    <option value="40" {{ request('per_page') == 40 ? 'selected' : '' }}>Show 40</option>
                </select>
            </div>
        </div>
    </header>
</form>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Loyalty Points</th>
                            <th>Total Spending</th>
                            <th>Purchase Frequency</th>
                            <th>AVG Spending</th>
                            <th>Registered</th>
                            @if (auth()->user()->can('user-delete') || auth()->user()->can('user-edit'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $user)
                        @unless ($user->hasRole('admin') || ($user->id === auth()->user()->id))
                        <tr>
                            <td>
                                <a href="#" class="itemside">
                                    <div class="info">
                                        <h6 class="mb-0 title">{{ $user->name }}</h6>
                                        <small class="text-muted">User ID: #{{ $user->id }}</small>
                                    </div>
                                </a>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ ucfirst($user->segment) }}</td>
                            <td>{{ number_format($user->loyalty_points) }}</td>
                            <td>€{{ number_format($user->purchase_frequency * $user->avg_spending, 2) }}</td>
                            <td>{{ number_format($user->purchase_frequency, 2) }}</td>
                            <td>€{{ number_format($user->avg_spending, 2) }}</td>
                            <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="action-buttons">
                                        @can('user-edit')
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-xs btn-primary btn-flat">
edit                                        </a>
                                        @endcan
                                        @can('user-delete')
                                        <button type="submit" class="btn btn-sm btn-light btn-flat show_confirm">
                                            <i class="material-icons md-delete_forever"></i>
                                        </button>
                                        @endcan
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endunless
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="pagination-area mt-30 mb-50">
        @if ($data->hasPages())
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    {{-- Previous Page Link --}}
                    @if ($data->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link"><i class="material-icons md-chevron_left"></i></span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $data->previousPageUrl() }}" rel="prev">
                                <i class="material-icons md-chevron_left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Page Numbers --}}
                    @php
                        $start = max(1, $data->currentPage() - 2);
                        $end = min($data->lastPage(), $data->currentPage() + 2);
                    @endphp

                   

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page === $data->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ sprintf('%02d', $page) }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $data->url($page) }}">{{ sprintf('%02d', $page) }}</a>
                            </li>
                        @endif
                    @endfor

                  

                    {{-- Next Page Link --}}
                    @if ($data->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $data->nextPageUrl() }}" rel="next">
                                <i class="material-icons md-chevron_right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link"><i class="material-icons md-chevron_right"></i></span>
                        </li>
                    @endif
                </ul>
            </nav>
        @endif
    </div>

</section>





@endsection
