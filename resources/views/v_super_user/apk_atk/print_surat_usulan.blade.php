<!DOCTYPE html>
<html lang="en">

@foreach($usulan as $dataUsulan)

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $dataUsulan->id_form_usulan }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dist_admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist_admin/css/adminlte.min.css') }}">
</head>

<body>
    <div class="">
        <div class="row">
            <div class="col-md-2">
                <h2 class="page-header ml-4">
                    <img src="{{ asset('dist_admin/img/logo-kemenkes-icon.png') }}">
                </h2>
            </div>
            <div class="col-md-8 text-center">
                <h2 class="page-header">
                    <h5 style="font-size: 30px;text-transform:uppercase;"><b>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</b></h5>
                    <h5 style="font-size: 30px;text-transform:uppercase;"><b>{{ $dataUsulan->unit_utama }}</b></h5>
                    <p style="font-size: 20px;"><i>Jl. H.R. Rasuna Said Blok X.5 Kav. 4-9, Blok A, 2nd Floor, Jakarta 12950<br>Telp.: (62-21) 5201587, 5201591 Fax. (62-21) 5201591</i></p>
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
        <div class="row" style="font-size: 22px;">
            <div class="col-md-12 form-group text-capitalize">
                <div class="form-group row mb-3 text-center">
                    <div class="col-md-12 text-uppercase">
                        usulan pengajuan <br>
                        nomor surat : {{ $dataUsulan->no_surat_usulan }}
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-3">Pengusul</div>
                    <div class="col-md-9">: {{ ucfirst(strtolower($dataUsulan->nama_pegawai)) }}</div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-3">Jabatan</div>
                    <div class="col-md-9">: {{ ucfirst(strtolower($dataUsulan->keterangan_pegawai)) }}</div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-3">Unit Kerja</div>
                    <div class="col-md-9">: {{ ucfirst(strtolower($dataUsulan->unit_kerja)) }}</div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-3">Tanggal Usulan</div>
                    <div class="col-md-9">: {{ \Carbon\Carbon::parse($dataUsulan->tanggal_usulan)->isoFormat('DD MMMM Y') }}</div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-3">Rencana Pengguna</div>
                    <div class="col-md-9">: {{ $dataUsulan->rencana_pengguna }}</div>
                </div>
            </div>
            <div class="col-12 table-responsive mt-4 mb-5">
                <table class="table table-bordered m-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            @if ($form->jenis_form == 'pengadaan')
                            <th>Jenis Barang</th>
                            @endif
                            <th>Nama Barang</th>
                            <th>Merk/Tipe</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <?php $no = 1; ?>
                    <tbody>
                        @if ($form->jenis_form == 'pengadaan')
                        @foreach($dataUsulan->pengadaanAtk as $dataAtk)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $dataAtk->jenis_barang }}</td>
                            <td>{{ $dataAtk->nama_barang }}</td>
                            <td>{{ $dataAtk->spesifikasi }}</td>
                            <td>{{ $dataAtk->jumlah }}</td>
                            <td>{{ $dataAtk->satuan }}</td>
                            <td>{{ $dataAtk->status.' '.$dataAtk->keterangan }}</td>
                        </tr>
                        @endforeach
                        @else
                        @foreach($dataUsulan->detailUsulanAtk as $dataAtk)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $dataAtk->kategori_atk }}</td>
                            <td>{{ $dataAtk->merk_atk }}</td>
                            <td>{{ $dataAtk->jumlah_pengajuan }}</td>
                            <td>{{ $dataAtk->satuan }}</td>
                            <td>{{ $dataAtk->keterangan }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 text-capitalize">
                <div class="row text-center">
                    <label class="col-sm-6">Yang Mengusulkan, <br> {{ ucfirst(strtolower($dataUsulan->keterangan_pegawai)) }}</label>
                    @if ($dataUsulan->otp_usulan_pimpinan != null)
                    <label class="col-sm-6">Disetujui Oleh, <br> {{ ucfirst(strtolower($pimpinan->jabatan)) }}</label>
                    @endif
                </div>
            </div>
            <div class="col-md-12 mt-4 text-capitalize">
                <div class="row text-center">
                    <label class="col-sm-6">{!! QrCode::size(100)->generate('https://siporsat.app/surat/usulan-atk/'.$dataUsulan->otp_usulan_pengusul) !!}</label>
                    @if ($dataUsulan->otp_usulan_pimpinan != null)
                    <label class="col-sm-6">{!! QrCode::size(100)->generate('https://siporsat.app/surat/usulan-atk/'.$dataUsulan->otp_usulan_pimpinan) !!}</label>
                    @endif
                </div>
            </div>
            <div class="col-md-12 mt-4 text-capitalize">
                <div class="row text-center">
                    <label class="col-sm-6">{{ ucfirst(strtolower($dataUsulan->nama_pegawai)) }}</label>
                    @if ($dataUsulan->otp_usulan_pimpinan != null )
                    <label class="col-sm-6">{{ ucfirst(strtolower($pimpinan->nama_pegawai)) }}</label>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
@endforeach
