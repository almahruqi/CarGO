@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_users'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Ads</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_ads'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-car fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Ads</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_ads'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Approved Ads</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['approved_ads'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- User Growth Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Growth (Last 30 Days)</h6>
                </div>
                <div class="card-body">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Ad Growth Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Advertisement Growth (Last 30 Days)</h6>
                </div>
                <div class="card-body">
                    <canvas id="adGrowthChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribution Charts -->
    <div class="row">
        <!-- Ad Status Distribution -->
        <div class="col-xl-4 col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Advertisement Status Distribution</h6>
                </div>
                <div class="card-body">
                    <canvas id="adStatusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Popular Makes -->
        <div class="col-xl-4 col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Popular Car Makes</h6>
                </div>
                <div class="card-body">
                    <canvas id="popularMakesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Price Distribution -->
        <div class="col-xl-4 col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Price Distribution</h6>
                </div>
                <div class="card-body">
                    <canvas id="priceDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <!-- Recent Users -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Users</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                <tr>
                                    <td>{{ $user->full_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Ads -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Advertisements</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Posted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAds as $ad)
                                <tr>
                                    <td>{{ $ad->title }}</td>
                                    <td>{{ $ad->user->full_name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $ad->status === 'approved' ? 'success' : ($ad->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($ad->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $ad->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // User Growth Chart
    new Chart(document.getElementById('userGrowthChart'), {
        type: 'line',
        data: {
            labels: @json($userGrowth->pluck('date')),
            datasets: [{
                label: 'New Users',
                data: @json($userGrowth->pluck('count')),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        }
    });

    // Ad Growth Chart
    new Chart(document.getElementById('adGrowthChart'), {
        type: 'line',
        data: {
            labels: @json($adGrowth->pluck('date')),
            datasets: [{
                label: 'New Ads',
                data: @json($adGrowth->pluck('count')),
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }]
        }
    });

    // Ad Status Distribution
    new Chart(document.getElementById('adStatusChart'), {
        type: 'doughnut',
        data: {
            labels: @json($adStatusDistribution->pluck('status')),
            datasets: [{
                data: @json($adStatusDistribution->pluck('count')),
                backgroundColor: ['#4e73df', '#1cc88a', '#e74a3b']
            }]
        }
    });

    // Popular Makes
    new Chart(document.getElementById('popularMakesChart'), {
        type: 'bar',
        data: {
            labels: @json($popularMakes->pluck('make')),
            datasets: [{
                label: 'Number of Ads',
                data: @json($popularMakes->pluck('count')),
                backgroundColor: 'rgba(54, 162, 235, 0.5)'
            }]
        }
    });

    // Price Distribution
    new Chart(document.getElementById('priceDistributionChart'), {
        type: 'pie',
        data: {
            labels: @json($priceDistribution->pluck('range')),
            datasets: [{
                data: @json($priceDistribution->pluck('count')),
                backgroundColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e',
                    '#e74a3b'
                ]
            }]
        }
    });
</script>
@endpush
@endsection 