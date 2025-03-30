@section('content')
@extends('layouts.back-main')
@section('main-container')
<div class="container-fluid">
    <h2 class="my-4">Analytique des Coupons</h2>

    <!-- Section des KPI -->
    <div class="row mb-4 g-4">
        <!-- Taux de Conversion -->
        <div class="col-md-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="kpi-icon bg-conversion">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <div class="ms-3 w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-uppercase text-muted mb-0">Taux de Conversion</h6>
                                <span class="badge bg-success-subtle text-success">+4.2%</span>
                            </div>
                            <h2 class="mt-2 mb-0 fw-bold">{{ number_format($globalMetrics['conversion_rate'], 1) }}%
                            </h2>

                        </div>
                    </div>
                    <div class="kpi-progress">
                        <div class="progress-bar" style="width: {{ $globalMetrics['conversion_rate'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenu Généré -->
        <div class="col-md-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="kpi-icon bg-revenue">
                            <i class="bi bi-currency-euro"></i>
                        </div>
                        <div class="ms-3 w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-uppercase text-muted mb-0">Revenu Généré</h6>
                                <span class="badge bg-danger-subtle text-danger">-1.8%</span>
                            </div>
                            <h2 class="mt-2 mb-0 fw-bold">
                                {{ number_format($globalMetrics['total_revenue'], 0, ',', ' ') }}€</h2>
                            <div class="text-muted small mt-1">
                                <span>Moyenne : {{ $globalMetrics['avg_revenue_per_coupon'] }}€</span>
                                <span class="float-end">30j</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Engagement Moyen -->
        <div class="col-md-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="kpi-icon bg-engagement">
                            <i class="bi bi-activity"></i>
                        </div>
                        <div class="ms-3 w-100">
                            <h6 class="text-uppercase text-muted mb-0">Engagement</h6>
                            <h2 class="mt-2 mb-1 fw-bold">{{ number_format($globalMetrics['avg_engagement'], 1) }}/10
                            </h2>
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1" style="height: 4px;">
                                    <div class="progress-bar bg-engagement"
                                        style="width: {{ $globalMetrics['avg_engagement'] * 10 }}%"></div>
                                </div>
                                <small
                                    class="text-muted ms-2">{{ number_format($globalMetrics['avg_engagement'] * 10, 0) }}%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Modèle -->
        <div class="col-md-3">
            <div class="card kpi-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="kpi-icon bg-performance">
                            <i class="bi bi-cpu"></i>
                        </div>
                        <div class="ms-3 w-100">
                            <h6 class="text-uppercase text-muted mb-0">Performance IA</h6>
                            <h2 class="mt-2 mb-0 fw-bold">{{ number_format($globalMetrics['avg_confidence'], 1) }}%</h2>
                            <div class="mt-3">
                                <div class="d-flex small text-muted justify-content-between">
                                    <span>Précision</span>
                                    <span>Recall</span>
                                    <span>F1-score</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .kpi-card {
            transition: transform 0.2s;
            border-radius: 12px;
            overflow: hidden;
        }

        .kpi-card:hover {
            transform: translateY(-3px);
        }

        .kpi-icon {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .bg-conversion {
            background: rgba(101, 87, 255, 0.1);
            color: #6557ff;
        }

        .bg-revenue {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .bg-engagement {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .bg-performance {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .kpi-progress {
            height: 3px;
            background: rgba(0, 0, 0, 0.05);
            margin-top: 1rem;
            border-radius: 2px;
        }

        .kpi-progress .progress-bar {
            background: #6557ff;
            height: 100%;
            border-radius: 2px;
            transition: width 0.8s ease;
        }

        .sparkline-revenue {
            height: 40px;
            margin-top: 1rem;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 40"><path fill="none" stroke="%236557ff" stroke-width="2" d="M2 30 L20 15 L40 25 L60 10 L80 20 L98 5"/></svg>');
        }
    </style>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Graphiques -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Performance par Segment</h5>
                    <canvas id="segmentPerformanceChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Tendance d'Utilisation</h5>
                    <canvas id="usageTrendChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    <style>
    
    .table-hover tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

</style>

<div class="card mb-4">
    <header class="card-header">
        <h4 class="card-title">Coupons Performance</h4>
        <div class="row align-items-center">
            <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                <div class="custom_select">
                    <select class="form-select select-nice">
                        <option selected>All Segments</option>
                        <option>VIP</option>
                        <option>Fidèle</option>
                        <option>Nouveau</option>
                        <option>Occasionnel</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <input type="date" value="{{ now()->format('Y-m-d') }}" class="form-control" />
            </div>
            <div class="col-md-2 col-6">
                <div class="custom_select">
                    <select class="form-select select-nice">
                        <option selected>Statut</option>
                        <option>Tous</option>
                        <option>Actif</option>
                        <option>Inactif</option>
                    </select>
                </div>
            </div>
        </div>
    </header>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="align-middle" scope="col">Code</th>
                        <th class="align-middle" scope="col">Segment</th>
                        <th class="align-middle" scope="col">Distribution</th>
                        <th class="align-middle" scope="col">Usage</th>
                        <th class="align-middle" scope="col">Conversion Rate</th>
                        <th class="align-middle" scope="col">Revenue</th>
                        <th class="align-middle" scope="col">Engagement</th>
                        <th class="align-middle" scope="col">Trust</th>
                        <th class="align-middle" scope="col">Average Time</th>
                        <th class="align-middle" scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $coupon)
                    <tr>
                        <td><a href="#" class="fw-bold">{{ $coupon->code }}</a></td>
                        <td>{{ $coupon->target_segment }}</td>
                        <td>{{ $coupon->sent_count }}</td>
                        <td>{{ $coupon->used_count }}</td>
                        <td>{{ number_format($coupon->conversion_rate, 1) }}%</td>
                        <td>{{ number_format($coupon->distributions_sum_revenue_impact, 0, ',', ' ') }} €</td>
                        <td>{{ number_format($coupon->avg_engagement, 1) }}/10</td>
                        <td>{{ number_format($coupon->distributions_avg_confidence, 1) }}%</td>
                        <td>{{ round($coupon->avg_redemption_time, 1) }} jours</td>
                        <td>
                            <span class="badge badge-pill badge-soft-{{ $coupon->status ? 'success' : 'danger' }}">
                                {{ $coupon->status ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Scripts pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique de performance par segment
    new Chart(document.getElementById('segmentPerformanceChart'), {
        type: 'bar',
        data: {
            labels: @json($segmentPerformance->pluck('segment')),
            datasets: [{
                label: 'Taux de Conversion (%)',
                data: @json($segmentPerformance->pluck('conversion_rate')),
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        }
    });

    // Graphique de tendance d'utilisation
    new Chart(document.getElementById('usageTrendChart'), {
        type: 'line',
        data: {
            labels: @json($usageTrend->keys()),
            datasets: [{
                label: 'Utilisations par Jour',
                data: @json($usageTrend->values()),
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.3
            }]
        }
    });
</script>

@endsection
@endsection