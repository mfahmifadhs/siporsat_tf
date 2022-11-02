@extends('v_user.layout.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h4 class="m-0">Alat Tulis Kantor</h4>
            </div>
        </div>
    </div>
</div>

<section class="content text-capitalize">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">Usulan Pengadaan/Distribusi ATK</h3>
                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 form-group small">Menunggu Persetujuan</div>
                            <div class="col-md-4 form-group small text-right">{{ $usulan->where('status_proses_id', 1)->count() }}</div>
                            <div class="col-md-12">
                                <hr style="border: 1px solid grey;margin-top:-1vh;">
                            </div>
                            <div class="col-md-8 form-group small">Sedang Diproses</div>
                            <div class="col-md-4 form-group small text-right">{{ $usulan->where('status_proses_id', 2)->count() }}</div>
                            <div class="col-md-12">
                                <hr style="border: 1px solid grey;margin-top:-1vh;">
                            </div>
                            <div class="col-md-8 form-group small">Menunggu Konfirmasi</div>
                            <div class="col-md-4 form-group small text-right">{{ $usulan->where('status_proses_id', 4)->count() }}</div>
                            <div class="col-md-12">
                                <hr style="border: 1px solid grey;margin-top:-1vh;">
                            </div>
                            <div class="col-md-8 form-group small">Selesai</div>
                            <div class="col-md-4 form-group small text-right">{{ $usulan->where('status_proses_id', 5)->count() }}</div>
                            <div class="col-md-12">
                                <hr style="border: 1px solid grey;margin-top:-1vh;">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center font-weight-bold">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ url('unit-kerja/atk/usulan/pengadaan/baru') }}" class="btn btn-primary btn-xs py-1">
                                    <i class="fas fa-plus-circle"></i> Usulan Pengadaan
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ url('unit-kerja/atk/usulan/distribusi/baru') }}" class="btn btn-primary btn-xs py-1">
                                    <i class="fas fa-plus-circle"></i> Usulan Distribusi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">Daftar Usulan</h3>
                    </div>
                    <div class="card-body">
                        <table id="table-usulan" class="table table-bordered m-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pengusul</th>
                                    <th>Usulan</th>
                                    <th>Status Pengajuan</th>
                                    <th>Status Proses</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <?php $no = 1;
                            $no2 = 1; ?>
                            <tbody>
                                @foreach($usulan as $dataUsulan)
                                <tr>
                                    <td class="text-center pt-3">{{ $no++ }}</td>
                                    <td class="small">
                                        {{ \Carbon\Carbon::parse($dataUsulan->tanggal_usulan)->isoFormat('DD MMMM Y') }} <br>
                                        No. Surat : {{ $dataUsulan->no_surat_usulan }} <br>
                                        Pengusul : {{ ucfirst(strtolower($dataUsulan->nama_pegawai)) }} <br>
                                        Unit Kerja : {{ ucfirst(strtolower($dataUsulan->unit_kerja)) }}
                                    </td>
                                    <td class="small">
                                        @foreach($dataUsulan->detailUsulanAtk as $dataAtk)
                                        <b>Kode Barang. {{ $dataAtk->atk_id }}</b> <br>
                                        {{ ucfirst(strtolower($dataAtk->kategori_atk.' - '.$dataAtk->merk_atk)) }} <br>
                                        Jumlah : {{ ucfirst(strtolower($dataAtk->jumlah_pengajuan.' '.$dataAtk->satuan)) }} <br>
                                        @endforeach
                                    </td>
                                    <td class="text-center pt-4">
                                        @if($dataUsulan->status_pengajuan_id == 1)
                                        <span class="badge badge-sm badge-pill badge-success">disetujui</span>
                                        @elseif($dataUsulan->status_pengajuan_id == 2)
                                        <span class="badge badge-sm badge-pill badge-danger">ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-center text-capitalize pt-4">
                                        @if($dataUsulan->status_proses_id == 1)
                                        <span class="badge badge-sm badge-pill badge-warning">menunggu <br> persetujuan</span>
                                        @elseif ($dataUsulan->status_proses_id == 2)
                                        <span class="badge badge-sm badge-pill badge-warning">sedang <br> diproses ppk</span>
                                        @elseif ($dataUsulan->status_proses_id == 3)
                                        <span class="badge badge-sm badge-pill badge-warning">menunggu <br> konfirmasi pengusul</span>
                                        @elseif ($dataUsulan->status_proses_id == 4)
                                        <span class="badge badge-sm badge-pill badge-warning">sedang diproses <br> petugas gudang</span>
                                        @elseif ($dataUsulan->status_proses_id == 5)
                                        <span class="badge badge-sm badge-pill badge-success">selesai</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a type="button" class="btn btn-primary" data-toggle="dropdown">
                                            <i class="fas fa-bars"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item btn" href="{{ url('unit-kerja/surat/usulan-atk/'. $dataUsulan->id_form_usulan) }}">
                                                <i class="fas fa-file"></i> Surat Usulan
                                            </a>
                                            @if ($dataUsulan->status_proses_id == 5)
                                            <a class="dropdown-item btn" href="{{ url('unit-kerja/surat/bast-atk/'. $dataUsulan->id_form_usulan) }}">
                                                <i class="fas fa-file"></i> Surat Bast
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 form-group">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p class="fw-light" style="margin: auto;">{{ $message }}</p>
                </div>
                @endif
                @if ($message = Session::get('failed'))
                <div class="alert alert-danger">
                    <p class="fw-light" style="margin: auto;">{{ $message }}</p>
                </div>
                @endif
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mt-1 font-weight-bold small">Filter Stok Barang</h4>
                        <div class="card-tools">
                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label>Kelompok</label> <br>
                                <select name="kategori" class="form-control text-capitalize select2-1">
                                    <option value="">-- KATEGORI BARANG --</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Kategori</label> <br>
                                <select name="jenis" id="jenis`+ i +`" class="form-control text-capitalize select2-2">
                                    <option value="">-- JENIS BARANG --</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Nama Barang</label> <br>
                                <select name="nama" id="barang`+ i +`" class="form-control text-capitalize select2-3">
                                    <option value="">-- NAMA BARANG --</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Nama Barang</label> <br>
                                <select name="merk" id="merktipe`+ i +`" class="form-control text-capitalize select2-4">
                                    <option value="">-- MERK/TIPE BARANG --</option>
                                </select>
                            </div>
                            <div class="col-sm-12 mt-2 text-right">
                                <button id="searchChartData" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <a href="{{ url('unit-kerja/atk/dashboard') }}" class="btn btn-danger">
                                    <i class="fas fa-undo"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div id="notif-konten-chart"></div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div id="konten-chart-google-chart">
                        <div id="piechart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <table id="table-atk" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Merk/Tipe Barang</th>
                                    <th>Stok Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; $googleChartData1 = json_decode($googleChartData) @endphp
                                @foreach ($googleChartData1->atk as $dataAtk)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <b class="text-primary">{{ $dataAtk->id_kategori_atk }}</b> <br>
                                        {{ $dataAtk->kategori_atk }}</td>
                                    <td>
                                        <b class="text-primary">{{ $dataAtk->id_atk }}</b> <br>
                                        {{ $dataAtk->merk_atk}}
                                    </td>
                                    <td>{{ $dataAtk->total_atk }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
    // Jumlah Kendaraan
    $(function() {

        $("#table-usulan").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "info": false,
            "paging": true
        })

        $("#table-atk").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "info": false,
            "paging": true
        })

        let total = 1
        let j = 0

        for (let i = 1; i <= 4; i++) {
            $(".select2-" + i).select2({
                ajax: {
                    url: `{{ url('unit-kerja/atk/select2-dashboard/` + i + `/distribusi') }}`,
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            _token: CSRF_TOKEN,
                            search: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            })
        }

    });

    let chart
    let chartData = JSON.parse(`<?php echo $googleChartData; ?>`)
    let dataChart = chartData.all
    google.charts.load('current', {
        'packages': ['corechart']
    })
    google.charts.setOnLoadCallback(function() {
        drawChart(dataChart)
    })

    function drawChart(dataChart) {

        chartData = [
            ['Jenis ATK', 'Stok']
        ]
        console.log(dataChart)
        dataChart.forEach(data => {
            chartData.push(data)
        })

        var data = google.visualization.arrayToDataTable(chartData);

        var options = {
            legend: {
                'position': 'top',
                'alignment': 'center'
            },
            chartArea: {
                width: 400,
                height: 300
            }
        }

        chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }

    $('body').on('click', '#searchChartData', function() {
        let kategori = $('select[name="kategori"').val()
        let jenis = $('select[name="jenis"').val()
        let nama = $('select[name="nama"').val()
        let merk = $('select[name="merk"').val()
        let url = ''

        if (kategori || jenis || nama || merk) {
            url = '<?= url("/unit-kerja/atk/grafik?kategori='+kategori+'&jenis='+jenis+'&nama='+nama+'&merk='+merk+'") ?>'
        } else {
            url = '<?= url("/unit-kerja/atk/grafik") ?>'
        }

        jQuery.ajax({
            url: url,
            type: "GET",
            success: function(res) {
                console.log(res.message);
                let dataTable = $('#table-atk').DataTable()
                if (res.message == 'success') {
                    $('.notif-tidak-ditemukan').remove();
                    $('#konten-chart-google-chart').show();
                    let data = JSON.parse(res.data)
                    drawChart(data.chart)

                    dataTable.clear()
                    dataTable.draw()
                    let no = 1

                    data.table.forEach(element => {
                        dataTable.row.add([
                            no++,
                            `<b class="text-primary">` + element.id_kategori_atk +`</b> <br>` + element.kategori_atk,
                            `<b class="text-primary">` + element.id_atk +`</b> <br>` + element.merk_atk,
                            element.total_atk
                        ]).draw(false)
                    })

                } else {
                    dataTable.clear()
                    dataTable.draw()
                    $('.notif-tidak-ditemukan').remove();
                    $('#konten-chart-google-chart').hide();
                    var html = ''
                    html += '<div class="notif-tidak-ditemukan">'
                    html += '<div class="card bg-danger">'
                    html += '<div class="card-body text-white">'
                    html += '<h5 class="font-weight-bold text-center">'
                    html += 'Data tidak dapat ditemukan'
                    html += '</h5>'
                    html += '</div>'
                    html += '</div>'
                    html += '</div>'
                    $('#notif-konten-chart').append(html)
                }
            },
        })
    })
</script>
@endsection

@endsection