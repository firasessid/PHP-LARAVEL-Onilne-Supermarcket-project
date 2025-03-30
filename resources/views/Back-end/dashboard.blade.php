@section('content')
@extends('layouts.back-main')
@section('main-container')

<section class="content-main">
    <div class="content-header">
        <!-- Inclure une seule fois dans le layout principal -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/highcharts-3d.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <div>
            <h2 class="content-title card-title">Dashboard</h2>
            <p>Whole data about your business here</p>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-3">
            <div class="card card-body mb-4 card-modern">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light"><i
                            class="text-primary material-icons md-monetization_on"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Revenue</h6>
                        <h6 class="mb-1 card-text">€{{ number_format($totalEarnings) }}</h6>
                        <span class="text-sm"> Shipping fees are not included </span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4 card-modern">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light"><i
                            class="text-success material-icons md-local_shipping"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Orders</h6>
                        <h6 class="mb-1 card-text">{{ $ordersCount }}</h6>

                        <span class="text-sm"> Including pending orders </span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4 card-modern">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-warning-light"><i
                            class="text-warning material-icons md-qr_code"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Products</h6>
                        <h6 class="mb-1 card-text">{{ $productsCount }}</h6>

                        <span class="text-sm"> In {{$categoriesCount}} Categories </span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4 card-modern">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light">
                        <i class="text-primary material-icons md-person"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Registred Users</h6>
                        <h6 class="mb-1 card-text">{{ number_format($usersCount) }}</h6>

                        <span class="text-sm"> Including different roles. </span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4 card-modern">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-info-light"><i
                            class="text-info material-icons md-shopping_basket"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Monthly Earning</h6>
                        <h6 class="mb-1 card-text">€{{ number_format($currentMonthEarnings) }}</h6>

                        <span class="text-sm"> Based on net income. </span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4 card-modern">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-warning-light"><i
                            class="text-warning material-icons md-visibility"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Products Views</h6>
                        <h6 class="mb-1 card-text">{{  number_format($viewsCount)  }}</h6>

                        <span class="text-sm">From differents products pages </span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4 card-modern">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-info-light"><i
                            class="text-info material-icons md-shopping_cart"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Quantity Sold</h6>
                        <h6 class="mb-1 card-text">{{number_format($soldProducts) }}</h6>

                        <span class="text-sm">All ordered products </span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4 card-modern">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light"><i
                            class="text-success material-icons md-credit_card"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Transactions made</h6>
                        <h6 class="mb-1 card-text">{{ number_format($totalTransactions) }}</h6>

                        <span class="text-sm">All payments methods</span>
                    </div>
                </article>
            </div>
        </div>
    </div>






    <div class="row">
        <div class="col-12">

            <div class="card mb-4">
                <article class="card-body">
                    <div class="chart-header">
                        <h5 class="chart-title">Users and Oders </h5>
                        <input type="month" id="selectedDate" class="form-control" />
                    </div>

                    <div id="loading" class="text-center py-4" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                    </div>

                    <div id="chartContainer" style="height: 500px;"></div>
                </article>
            </div>


            <div class="card mb-4 shadow-sm">
                <article class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4" style="gap: 10px;">
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #2C3E50; margin: 0;">
                            Payment methods
                        </h3>
                        <div class="col-md-3 col-8" style="margin-left: auto;">
                            <input type="month" id="month-filter" class="form-control"
                                style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.375rem 0.75rem;">
                        </div>
                    </div>

                    <div id="container" style="height: 450px; min-width: 310px; background: white;">
                        <div class="alert alert-info text-center py-3">
                            <i class="fas fa-spinner fa-spin me-2"></i>Loading data...
                        </div>
                    </div>


                </article>
            </div>
        </div>




        <div class="col-xl-6 col-lg-12">
        <div class="card mb-4 shadow-sm">
                    <article class="card-body">


                        <figure class="highcharts-figure position-relative">
                            <div id="paymentStatusContainer">
                                <div class="chart-loading">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Chargement...</span>
                                    </div>
                                </div>
                            </div>
                        </figure>


                    </article>
                    <br>
                    <br>
                    <br>
                    <br>
                    
                </div>
                </div>


                <div class="col-xl-6 col-lg-12">
                    <div class="card mb-4 shadow-sm">
                        <article class="card-body">
                            <h5 class="card-title mb-4" style="color: #2C3E50; font-size: 1.25rem; font-weight: 600;">
                                Active Status
                            </h5>

                            @php
                                $calculatePercentage = function ($active, $total) {
                                    return $total > 0 ? round(($active / $total) * 100, 2) : 0;
                                };

                                // Nouvelle palette de couleurs
                                $colorPalette = [
                                    'background' => '#F8F9FA',
                                    'bars' => ['#00C9A7', '#4E89AE', '#44BBA4', '#547AA5'],
                                    'text' => '#2C3E50'
                                ];
                            @endphp

                            @foreach($statusData as $label => $data)
                                <div class="mb-4" style="position: relative;">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color: {{ $colorPalette['text'] }}; font-size: 0.9rem;">
                                            {{ ucfirst($label) }}
                                        </span>
                                        <span
                                            style="color: {{ $colorPalette['text'] }}; font-size: 0.9rem; font-weight: 500;">
                                            {{ $calculatePercentage($data['active'], $data['total']) }}%
                                        </span>
                                    </div>

                                    <div class="progress"
                                        style="height: 10px; border-radius: 8px; background-color: {{ $colorPalette['background'] }}; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $calculatePercentage($data['active'], $data['total']) }}%;
                                                            background-color: {{ $colorPalette['bars'][$loop->index % count($colorPalette['bars'])] }};
                                                            border-radius: 8px;
                                                            transition: width 0.5s ease-in-out;
                                                            box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        </div>
                                    </div>

                                    <small style="color: #7F8C8D; font-size: 0.8rem; display: block; margin-top: 4px;">
                                        ({{ $data['active'] }} active / {{ $data['total'] }} total)
                                    </small>
                                </div>
                            @endforeach
                        </article>
                    </div>
                </div>




            <div class="card mb-4">
                <header class="card-header">
                    <h4 class="card-title">Latest orders</h4>
                    <div class="row align-items-center">
                        <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                            <div class="custom_select">
                                <select class="form-select select-nice">
                                    <option selected>All Categories</option>
                                    <option>Women's Clothing</option>
                                    <option>Men's Clothing</option>
                                    <option>Cellphones</option>
                                    <option>Computer & Office</option>
                                    <option>Consumer Electronics</option>
                                    <option>Jewelry & Accessories</option>
                                    <option>Home & Garden</option>
                                    <option>Luggage & Bags</option>
                                    <option>Shoes</option>
                                    <option>Mother & Kids</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-6">
                            <input type="date" value="02.05.2021" class="form-control" />
                        </div>
                        <div class="col-md-2 col-6">
                            <div class="custom_select">
                                <select class="form-select select-nice">
                                    <option selected>Status</option>
                                    <option>All</option>
                                    <option>Paid</option>
                                    <option>Chargeback</option>
                                    <option>Refund</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="text-center">
                                            <div class="form-check align-middle">
                                                <input class="form-check-input" type="checkbox"
                                                    id="transactionCheck01" />
                                                <label class="form-check-label" for="transactionCheck01"></label>
                                            </div>
                                        </th>
                                        <th class="align-middle" scope="col">Order ID</th>
                                        <th class="align-middle" scope="col">Billing Name</th>
                                        <th class="align-middle" scope="col">Date</th>
                                        <th class="align-middle" scope="col">Total</th>
                                        <th class="align-middle" scope="col">Payment Status</th>
                                        <th class="align-middle" scope="col">Payment Method</th>
                                        <th class="align-middle" scope="col">View Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $p)



                                        <tr>
                                            <td class="text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="transactionCheck02" />
                                                    <label class="form-check-label" for="transactionCheck02"></label>
                                                </div>
                                            </td>
                                            <td><a href="#" class="fw-bold">#{{ $p->id }}</a></td>
                                            <td>{{ $p->userName }}</td>
                                            <td>{{$p->created_at}}</td>
                                            <td>${{ $p->grand_total }}</td>
                                            <td>
                                                @if($p->status == 'not paid')
                                                    <span class="badge badge-pill badge-soft-danger">Not paid</span>

                                                @else
                                                    <span class="badge badge-pill badge-soft-success">Paid</span>

                                                @endif
                                            </td>
                                            @if($p->payment_method == 'paypal')

                                                <td><i class="material-icons md-payment font-xxl text-muted mr-5"></i> Paypal
                                                </td>
                                            @elseif ($p->payment_method == 'card')
                                                <td><i class="material-icons md-payment font-xxl text-muted mr-5"></i>
                                                    Mastercard
                                                </td>
                                            @else
                                                <td><i class="material-icons md-payment font-xxl text-muted mr-5"></i> Cash on
                                                    delevry
                                                </td>
                                            @endif

                                            <td>
                                                <a href="#" class="btn btn-xs"> View details</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- table-responsive end// -->
                </div>
            </div>


</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.getElementById('container');
        const monthFilter = document.getElementById('month-filter');
        let chart;

        Highcharts.setOptions({
            lang: {
                decimalPoint: '.', // Point décimal en anglais
                thousandsSep: ',', // Séparateur de milliers en anglais
                // Pas besoin de spécifier les mois, l'anglais est par défaut
            },
            colors: ['#00C9A7', '#4E89AE', '#44BBA4']
        });

        async function loadData(month) {
            try {
                const response = await fetch(`/payment-method?month=${month}`);
                if (!response.ok) throw new Error('Error loading data');

                const data = await response.json();

                if (!data.length) throw new Error('No data available');

                // Transformation des données
                const days = data.map(item => new Date(item.day).getDate());
                const paypalData = data.map(item => parseFloat(item.paypal));
                const cardData = data.map(item => parseFloat(item.card));
                const codData = data.map(item => parseFloat(item.cod));

                // Destruction de l'ancien graphique
                if (chart) chart.destroy();

                // Création du nouveau graphique
                chart = Highcharts.chart('container', {
                    chart: {
                        type: 'line',
                        backgroundColor: 'white',
                        spacing: [20, 15, 25, 15]
                    },
                    title: { text: null },
                    xAxis: {
                        categories: days,
                        title: {
                            text: 'Days of the month',
                            style: {
                                color: '#6C757D',
                                fontSize: '0.875rem'
                            }
                        },
                        labels: {
                            formatter: function () {
                                // Formatage en anglais
                                return `${this.value} ${Highcharts.dateFormat('%b', new Date(month))}`;
                            }
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Amount (USD)',
                            style: {
                                color: '#6C757D',
                                fontSize: '0.875rem'
                            }
                        },
                        labels: {
                            formatter: function () {
                                return `$${Highcharts.numberFormat(this.value, 0)}`;
                            }
                        }
                    },
                    plotOptions: {
                        line: {
                            marker: {
                                radius: 5,
                                symbol: 'circle'
                            },
                            lineWidth: 2.5,
                            animation: {
                                duration: 800
                            }
                        }
                    },
                    series: [{
                        name: 'Paypal',
                        data: paypalData,
                        zIndex: 1
                    }, {
                        name: 'Card',
                        data: cardData,
                        zIndex: 2
                    }, {
                        name: 'Cash on delivery',
                        data: codData,
                        zIndex: 3
                    }],
                    tooltip: {
                        headerFormat: '<b>Day {point.key}</b><br>',
                        pointFormat: '<span style="color:{point.color}">●</span> {series.name}: <b>${point.y:,.2f}</b>',
                        shared: true,
                        backgroundColor: 'rgba(255,255,255,0.95)'
                    },
                    legend: {
                        align: 'center',
                        verticalAlign: 'bottom',
                        layout: 'horizontal',
                        itemStyle: {
                            color: '#6C757D',
                            fontSize: '0.875rem'
                        },
                        margin: 20,
                        padding: 10
                    }
                });

            } catch (error) {
                container.innerHTML = `
                            <div class="alert alert-danger py-2" 
                                style="background-color: #F8D7DA; border-color: #F5C6CB; color: #721C24;">
                                ${error.message}
                            </div>`;
            }
        }

        // Initialisation
        monthFilter.value = new Date().toISOString().slice(0, 7);
        loadData(monthFilter.value);

        // Écouteur de changement
        monthFilter.addEventListener('change', function () {
            loadData(this.value);
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const chartContainer = document.getElementById('paymentStatusContainer');
        const loadingIndicator = chartContainer.querySelector('.chart-loading');
        let paymentStatusChart = null;

        // Nouvelle palette de couleurs moderne
        Highcharts.setOptions({
            lang: {
                decimalPoint: ',',
                thousandsSep: ' ',
                loading: 'Chargement en cours...',
                noData: 'Aucune donnée disponible'
            },
            colors: ['#00C9A7', '#4E89AE', '#44BBA4', '#547AA5', '#3DC7BE']
        });

        function initChart(data) {
            if (paymentStatusChart) {
                paymentStatusChart.destroy();
            }

            paymentStatusChart = Highcharts.chart(chartContainer, {
                chart: {
                    type: 'pie',
                    backgroundColor: 'transparent', // Fond clair
                    options3d: {
                        enabled: true,
                        alpha: 35 // Effet 3D plus subtil
                    }
                },
                title: {
                    text: 'Current Orders Status ',
                    align: 'left',
                    style: {
                        fontSize: '18px',
                        fontWeight: '600',
                        color: '#2C3E50' // Titre plus contrasté
                    }
                },
                tooltip: {
                    valueSuffix: ' commandes',
                    backgroundColor: 'rgb(255, 255, 255)',
                    borderColor: '#DEE2E6'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 25,
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y}',
                            style: {
                                fontSize: '14px',
                                color: '#2C3E50'
                            },
                            connectorColor: '#7F8C8D'
                        },
                        showInLegend: true // Légende activée
                    }
                },
                series: [{
                    name: 'Part',
                    colorByPoint: true,
                    data: data
                }],
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 768
                        },
                        chartOptions: {
                            legend: {
                                itemStyle: {
                                    color: '#2C3E50'
                                }
                            }
                        }
                    }]
                }
            });

            loadingIndicator.style.display = 'none';
        }

        async function loadChartData() {
            try {
                loadingIndicator.style.display = 'block';

                const response = await fetch('/payment-status');
                if (!response.ok) throw new Error('Erreur de chargement des données');

                const data = await response.json();
                const chartData = data.map(item => ({
                    name: item.status,
                    y: item.count
                }));

                initChart(chartData);

            } catch (error) {
                console.error(error);
                chartContainer.innerHTML = `
                            <div class="alert alert-danger">
                                Erreur: ${error.message}
                            </div>
                        `;
            }
        }

        loadChartData();
    });
</script>

<script>
    // Configuration globale Highchartsa
    Highcharts.setOptions({
        lang: {
            months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            shortMonths: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun',
                'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']
        },
        chart: {
            style: {
                fontFamily: "'Inter', system-ui, -apple-system, sans-serif"
            }
        },
        colors: ['#3b82f6', '#10b981', '#f59e0b']
    });

    // Initialisation du graphique
    let chart;

    function initChart() {
        chart = Highcharts.chart('chartContainer', {
            chart: {
                type: 'line',
                backgroundColor: 'transparent'
            },
            title: { text: null },
            credits: { enabled: false },
            xAxis: {
                type: 'datetime',
                crosshair: true,
                labels: {
                    formatter: function () {
                        return Highcharts.dateFormat('%e %b', this.value);
                    }
                }
            },
            yAxis: {
                title: { text: null },
                min: 0
            },
            tooltip: {
                shared: true,
                xDateFormat: '%A %e %B %Y'
            },
            plotOptions: {
                series: {
                    marker: {
                        radius: 4,
                        symbol: 'circle'
                    }
                }
            },
            series: [{
                name: 'Orders',
                data: []
            }, {
                name: 'Users',
                data: []
            }]
        });
    }

    // Gestion des données
    async function loadData(date) {
        $('#loading').show();

        try {
            const response = await fetch(`/dashboard/${date}`);
            if (!response.ok) throw new Error('Erreur réseau');

            const data = await response.json();

            if (!data.length) {
                chart.showLoading('Aucune donnée disponible');
                return;
            }

            // Transformation des données
            const processedData = {
                orders: [],
                users: []
            };

            data.forEach(item => {
                const timestamp = new Date(item.date).getTime();
                processedData.orders.push([timestamp, item.orders]);
                processedData.users.push([timestamp, item.users]);
            });

            // Mise à jour du graphique
            chart.series[0].setData(processedData.orders);
            chart.series[1].setData(processedData.users);

        } catch (error) {
            console.error('Erreur:', error);
            chart.showLoading(`Erreur: ${error.message}`);
        } finally {
            $('#loading').hide();
        }
    }

    // Initialisation
    $(document).ready(function () {
        if (!window.Highcharts) {
            $('#chartContainer').html('<div class="alert alert-danger">Highcharts non chargé!</div>');
            return;
        }

        initChart();

        const datePicker = $('#selectedDate');
        const currentDate = new Date().toISOString().slice(0, 7); // Format YYYY-MM
        datePicker.val(currentDate);

        // Premier chargement
        loadData(currentDate);

        // Écouteur d'événement
        datePicker.on('change', function () {
            loadData(this.value);
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style>
    .analytics-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s;
    }

    .analytics-card:hover {
        transform: translateY(-2px);
    }

    .chart-header {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .chart-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }

    #selectedDate {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        max-width: 220px;
        transition: all 0.2s ease;
    }

    #selectedDate:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    .highcharts-container {
        margin: 0 auto;
    }
</style>
<style>
    /* Styles inchangés */
    .card-modern {
        border: none;
        border-radius: 18px;
        background: linear-gradient(145deg, rgb(255, 255, 255) 0%, rgb(255, 255, 255) 100%);
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.08);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        position: relative;
    }

    .card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(16, 185, 129, 0.12);
    }

    .card-modern::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #10b981 0%, #10b981 100%) !important;
        transition: opacity 0.3s ease;
    }

    .card-modern:hover::after {
        opacity: 1;
    }

    /* Nouveaux styles ajoutés */
    .icontext {
        align-items: center;
        /* Centre verticalement */
        justify-content: flex-start;
        /* Alignement à gauche */

        display: flex;
        gap: 20px;
        /* Espace entre l'icône et le texte */
        padding: 8px 0;
        /* Ajustement de l'espace vertical dans la carte */
    }



    .icontext .icon {
        width: 60px !important;
        /* Taille du container */
        height: 60px !important;
        /* Taille du container */
        margin-top: 0;
        /* Supprime le décalage précédent */
        padding: 15px !important;
        align-items: center;
        /* Espace interne pour le contour */
    }

    .icontext .icon i {
        font-size: 1.8rem !important;
        /* Taille réelle de l'icône */
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        color: #10b981 !important;
        margin-top: 0;
        /* Supprime le décalage précédent */
        flex-shrink: 0;
        /* Empêche le rétrécissement */
        margin-top: 0;
        /* Supprime le décalage précédent */

    }

    .card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.3px;
    }

    .card-text {
        font-size: 1.7rem;
        font-weight: 700;
        color: rgb(64, 72, 83);
        letter-spacing: -0.3px;
    }


    .text-sm {
        font-size: 0.88rem;
        color: #64748b !important;
        line-height: 1.5;
    }

    .card-modern span:not(.text-sm) {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e293b;
        display: block;
        margin: 8px 0;
        letter-spacing: -1px;
    }

    /* Ajustement des couleurs */
    .card-modern:nth-child(1) .icon {
        background: rgba(16, 185, 129, 0.12) !important;
    }

    .card-modern:nth-child(2) .icon {
        background: rgba(16, 185, 129, 0.12) !important;
    }

    .card-modern:nth-child(3) .icon {
        background: rgba(239, 68, 68, 0.12) !important;
    }

    .card-modern:nth-child(4) .icon {
        background: rgba(245, 158, 11, 0.12) !important;
    }

    .card-modern:nth-child(5) .icon {
        background: rgba(239, 68, 68, 0.12) !important;
    }

    .card-modern:nth-child(6) .icon {
        background: rgba(139, 92, 246, 0.12) !important;
    }

    .card-modern:nth-child(7) .icon {
        background: rgba(139, 92, 246, 0.12) !important;
    }

    .card-modern:nth-child(8) .icon {
        background: rgba(245, 158, 11, 0.12) !important;
    }
</style>
<style>
    #paymentStatusContainer {
        height: 400px;
        min-width: 310px;
        position: relative;
    }

    .chart-loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
    }

    .highcharts-credits {
        display: none !important;
    }
</style>
<!-- content-main end// -->

@endsection