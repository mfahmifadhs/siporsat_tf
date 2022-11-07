@extends('v_user.layout.app')

@section('css')
<style type="text/css" media="print">
    @page {
        size: auto;
        /* auto is the initial value */
        margin: 0mm;
        /* this affects the margin in the printer settings */
        margin-top: -22vh;
        margin-left: -1.8vh;
    }

    .header-confirm .header-text-confirm {
        padding-top: 8vh;
        line-height: 2vh;
    }

    .header-confirm img {
        margin-top: 3vh;
        height: 2vh;
        width: 2vh;
    }

    .print,
    .pdf,
    .logo-header,
    .nav-right {
        display: none;
    }

    nav,
    footer {
        display: none;
    }
</style>
@endsection

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container">
        <div class="row text-capitalize">
            <div class="col-sm-12">
                <h4>Surat Usulan Pengajuan</h4>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 form-group">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p style="color:white;margin: auto;">{{ $message }}</p>
                </div>
                @elseif ($message = Session::get('failed'))
                <div class="alert alert-danger">
                    <p style="color:white;margin: auto;">{{ $message }}</p>
                </div>
                @endif
            </div>
            <div class="col-md-12 form-group">
                <a href="{{ url('unit-kerja/'.$modul.'/dashboard') }}" class="btn btn-primary print mr-2">
                    <i class="fas fa-home"></i>
                </a>
                @if($usulan->otp_usulan_kabag != null || $usulan->otp_usulan_pimpinan != null)
                <a href="{{ url('unit-kerja/cetak-surat/usulan-'. $modul.'/'. $usulan->id_form_usulan) }}" rel="noopener" target="_blank" class="btn btn-danger pdf">
                    <i class="fas fa-print"></i>
                </a>
                @endif
            </div>
            <div class="col-md-12 form-group ">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <h2 class="page-header ml-4">
                                    <img src="{{ asset('dist_admin/img/logo-kemenkes-icon.png') }}">
                                </h2>
                            </div>
                            <div class="col-md-8 text-center">
                                <h2 class="page-header">
                                    <h5 style="font-size: 24px;text-transform:uppercase;"><b>kementerian kesehatan republik indonesia</b></h5>
                                    <h5 style="font-size: 24px;text-transform:uppercase;"><b>{{ $usulan->unit_utama }}</b></h5>
                                    <p style="font-size: 16px;"><i>Jl. H.R. Rasuna Said Blok X.5 Kav. 4-9, Blok A, 2nd Floor, Jakarta 12950<br>Telp.: (62-21) 5201587, 5201591 Fax. (62-21) 5201591</i></p>
                                </h2>
                            </div>
                            <div class="col-md-2">
                                <h2 class="page-header">
                                    <img src="{{ asset('dist_admin/img/logo-germas.png') }}" style="width: 128px; height: 128px;">
                                </h2>
                            </div>
                            <div class="col-md-12">
                                <hr style="border-width: medium;border-color: black;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group text-capitalize">
                                <div class="form-group row mb-0">
                                    <div class="col-md-2">Nomor Surat</div>
                                    <div class="col-md-10 text-uppercase">: {{ $usulan->no_surat_usulan }}</div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-2">Pengusul</div>
                                    <div class="col-md-10">: {{ ucfirst(strtolower($usulan->nama_pegawai)) }}</div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-2">Jabatan</div>
                                    <div class="col-md-10">: {{ ucfirst(strtolower($usulan->keterangan_pegawai)) }}</div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-2">Unit Kerja</div>
                                    <div class="col-md-10">: {{ ucfirst(strtolower($usulan->unit_kerja)) }}</div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-2">Tanggal Usulan</div>
                                    <div class="col-md-10">: {{ \Carbon\Carbon::parse($usulan->tanggal_usulan)->isoFormat('DD MMMM Y') }}</div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-2">Total Pengajuan</div>
                                    <div class="col-md-10">: {{ $usulan->total_pengajuan }} ruangan</div>
                                </div>
                                @if($usulan->rencana_pengguna != null)
                                <div class="form-group row mb-0">
                                    <div class="col-md-2">Rencana Pengguna</div>
                                    <div class="col-md-10">: {{ $usulan->rencana_pengguna }}</div>
                                </div>
                                @endif
                            </div>
                            <div class="col-12 mt-4 mb-5">
                                @if ($modul == 'oldat')
                                <table class="table table-bordered m-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Merk/Tipe Barang</th>
                                            <th>Tahun Perolehan</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody>
                                        @foreach($usulan->detailPerbaikan as $dataBarang)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $dataBarang->kode_barang.'.'.$dataBarang->nup_barang }}</td>
                                            <td>{{ $dataBarang->kategori_barang }}</td>
                                            <td>{{ $dataBarang->merk_tipe_barang }}</td>
                                            <td>{{ $dataBarang->tahun_perolehan }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @elseif ($modul == 'atk')
                                <table class="table table-bordered m-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Merk/Tipe</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody>
                                        @foreach($usulan->detailUsulanAtk as $dataAtk)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $dataAtk->kategori_atk }}</td>
                                            <td>{{ $dataAtk->merk_atk }}</td>
                                            <td>{{ $dataAtk->jumlah_pengajuan }}</td>
                                            <td>{{ $dataAtk->satuan }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @elseif ($modul == 'gdn')
                                <table class="table table-bordered m-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Lokasi Perbaikan</th>
                                            <th>Lokasi Spesifik</th>
                                            <th>Bidang Kerusakan</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody>
                                        @foreach($usulan->detailUsulanGdn as $dataGdn)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $dataGdn->lokasi_bangunan }}</td>
                                            <td>{{ $dataGdn->lokasi_spesifik }}</td>
                                            <td>{{ $dataGdn->bid_kerusakan }}</td>
                                            <td>{{ $dataGdn->keterangan }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @elseif ($modul == 'aadb')
                                @if($usulan->jenis_form == '1')
                                <table class="table table-bordered m-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis AADB</th>
                                            <th>Jenis Kendaraan</th>
                                            <th>Merk/Tipe</th>
                                            <th>Tahun Perolehan</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody>
                                        @foreach($usulan->usulanKendaraan as $dataKendaraan)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $dataKendaraan->jenis_aadb }}</td>
                                            <td>{{ ucfirst(strtolower($dataKendaraan->jenis_kendaraan)) }}</td>
                                            <td>{{ $dataKendaraan->merk_tipe_kendaraan }}</td>
                                            <td>{{ $dataKendaraan->tahun_kendaraan }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @elseif($usulan->jenis_form == '2')
                                <table class="table table-bordered m-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kendaraan</th>
                                            <th>Kilometer Terakhir</th>
                                            <th>Tanggal Servis Terakhir</th>
                                            <th>Jatuh Tempo Servis</th>
                                            <th>Tanggal Ganti Oli Terakhir</th>
                                            <th>Jatuh Tempo Ganti Oli</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody>
                                        @foreach($usulan->usulanServis as $dataServis)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $dataServis->merk_tipe_kendaraan }}</td>
                                            <td>{{ $dataServis->kilometer_terakhir }}</td>
                                            <td>{{ $dataServis->tgl_servis_terakhir }}</td>
                                            <td>{{ $dataServis->jatuh_tempo_servis }}</td>
                                            <td>{{ $dataServis->tgl_ganti_oli_terakhir }}</td>
                                            <td>{{ $dataServis->jatuh_tempo_ganti_oli }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @elseif($usulan->jenis_form == '3')
                                <table class="table table-bordered m-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kendaraan</th>
                                            <th>No. Plat</th>
                                            <th>Masa Berlaku STNK</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody>
                                        @foreach($usulan->usulanSTNK as $dataSTNK)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $dataSTNK->merk_tipe_kendaraan }}</td>
                                            <td>{{ $dataSTNK->no_plat_kendaraan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($dataSTNK->mb_stnk_lama)->isoFormat('DD MMMM Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @elseif($usulan->jenis_form == '4')
                                <table class="table table-bordered m-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kendaraan</th>
                                            <th>Voucher 25</th>
                                            <th>Voucher 50</th>
                                            <th>Voucher 100</th>
                                            <th>Total</th>
                                            <th>Bulan Pengadaan</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody>
                                        @foreach($usulan->usulanVoucher as $dataVoucher)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $dataVoucher->merk_tipe_kendaraan }}</td>
                                            <td>{{ $dataVoucher->voucher_25 }}</td>
                                            <td>{{ $dataVoucher->voucher_50 }}</td>
                                            <td>{{ $dataVoucher->voucher_100 }}</td>
                                            <td>Rp {{ number_format($dataVoucher->total_biaya, 0, ',', '.') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($dataVoucher->bulan_pengadaan)->isoFormat('MMMM Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                                @endif
                            </div>
                            <div class="col-md-12 text-capitalize">
                                <div class="row text-center">
                                    <label class="col-sm-6">Yang Mengusulkan, <br> {{ ucfirst(strtolower($usulan->keterangan_pegawai)) }}</label>
                                    @if ($usulan->otp_usulan_kabag != null || $usulan->otp_usulan_pimpinan != null)
                                    <label class="col-sm-6">Disetujui Oleh, <br> {{ ucfirst(strtolower($pimpinan->keterangan_pegawai)) }}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mt-4 text-capitalize">
                                <div class="row text-center">
                                    <label class="col-sm-6">{!! QrCode::size(100)->generate('https://siporsat.app/usulan/'.$usulan->otp_usulan_pengusul) !!}</label>
                                    @if ($usulan->otp_usulan_kabag != null || $usulan->otp_usulan_pimpinan != null)
                                    <label class="col-sm-6">{!! QrCode::size(100)->generate('https://siporsat.app/usulan/'.$usulan->otp_usulan_kabag) !!}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mt-4 text-capitalize">
                                <div class="row text-center">
                                    <label class="col-sm-6">{{ ucfirst(strtolower($usulan->nama_pegawai)) }}</label>
                                    @if ($usulan->otp_usulan_kabag != null || $usulan->otp_usulan_pimpinan != null )
                                    <label class="col-sm-6">{{ ucfirst(strtolower($pimpinan->nama_pegawai)) }}</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
