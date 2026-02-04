@extends('layouts.app')

@section('title', 'Edit Hak Akses')

@section('content')

<div class="container mt-4">

    <h3 class="mb-4">Dashboard Kelayakan Bantuan Masyarakat</h3>

    <!-- KPI -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Total</h6>
                    <h4>{{ $total }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center text-success">
                <div class="card-body">
                    <h6>Layak</h6>
                    <h4>{{ $layak }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center text-danger">
                <div class="card-body">
                    <h6>Tidak Layak</h6>
                    <h4>{{ $tidakLayak }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center text-primary">
                <div class="card-body">
                    <h6>Sudah Disalurkan</h6>
                    <h4>{{ $sudah }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center text-warning">
                <div class="card-body">
                    <h6>Belum Disalurkan</h6>
                    <h4>{{ $belum }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="row">
        <div class="col-md-4">
            <canvas id="chartEkonomi"></canvas>
        </div>
        <div class="col-md-4">
            <canvas id="chartRumah"></canvas>
        </div>
        <div class="col-md-4">
            <canvas id="chartKelayakan"></canvas>
        </div>
    </div>
</div>

<script>
    // Data dari controller
    const statusEkonomi = @json($statusEkonomi);
    const statusRumah = @json($statusRumah);
    const statusPenerima = @json($statusPenerima);

    // ===== Pie Chart Status Ekonomi =====
    new Chart(document.getElementById('chartEkonomi'), {
        type: 'pie',
        data: {
            labels: statusEkonomi.map(e => e.status_ekonomi),
            datasets: [{
                data: statusEkonomi.map(e => e.total),
                backgroundColor: ['#dc3545', '#ffc107', '#198754']
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Distribusi Status Ekonomi'
                }
            }
        }
    });

    // ===== Bar Chart Status Rumah =====
    new Chart(document.getElementById('chartRumah'), {
        type: 'bar',
        data: {
            labels: statusRumah.map(r => r.status_rumah ?? 'Tidak Diisi'),
            datasets: [{
                label: 'Jumlah',
                data: statusRumah.map(r => r.total),
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Distribusi Status Rumah'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // ===== Doughnut Chart Kelayakan =====
    new Chart(document.getElementById('chartKelayakan'), {
        type: 'doughnut',
        data: {
            labels: statusPenerima.map(p => p.status_penerima),
            datasets: [{
                data: statusPenerima.map(p => p.total),
                backgroundColor: ['#198754', '#dc3545']
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Status Kelayakan Bantuan'
                }
            }
        }
    });
</script>

@endsection
