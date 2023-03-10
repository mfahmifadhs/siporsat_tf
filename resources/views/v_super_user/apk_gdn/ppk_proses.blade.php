@extends('v_super_user.layout.app')

@section('content')

<div class="content-header">
    <div class="container">
        <div class="row mb-2 text-capitalize">
            <div class="col-sm-6">
                <h1 class="m-0">proses penyelesaian pekerjaan </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('super-user/oldat/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ url('super-user/oldat/pengajuan/daftar/seluruh-pengajuan') }}">Daftar Pengajuan</a></li>
                    <li class="breadcrumb-item active">Buat Berita Acara</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container">
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
        <div class="card">
            @foreach($pengajuan as $dataPengajuan)
            <form class="form-pengajuan" action="{{ url('super-user/ppk/gdn/pengajuan/proses-'. $form .'/'. $dataPengajuan->id_form_usulan) }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <input type="hidden" name="id_form_usulan" value="{{ $id }}">
                    <input type="hidden" name="pegawai_id" value="{{ $dataPengajuan->id_pegawai }}">
                    <span id="kode_otp"></span>
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-12"><label class="text-muted">Informasi Pengusul</label></div>
                        <label class="col-sm-2 col-form-label">Nomor Surat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control text-uppercase" name="no_surat_bast" value="{{ 'bast/gdn/'.$form.'/'.$idBast.'/'.\Carbon\Carbon::now()->isoFormat('MMMM').'/'.\Carbon\Carbon::now()->isoFormat('Y') }} " readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tanggal Penyelesaian </label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control text-capitalize" name="tanggal_bast" value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DD') }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama Pengusul </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $dataPengajuan->nama_pegawai }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Jabatan Pengusul </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control text-capitalize" value="{{ $dataPengajuan->keterangan_pegawai }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Unit Kerja </label>
                        <div class="col-sm-10">
                            <input type="hidden" name="unit_kerja_id" value="{{ $dataPengajuan->id_unit_kerja }}">
                            <input type="text" class="form-control text-capitalize" value="{{ $dataPengajuan->unit_kerja }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row mt-4">
                        <div class="col-md-12"><label class="text-muted">Informasi Perbaikan</label></div>
                    </div>
                    @foreach($dataPengajuan->detailUsulanGdn as $i => $dataPerbaikan)
                    <input type="hidden" name="id_barang[]" value="{{ $dataPerbaikan->id_barang }}">
                    <hr>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Lokasi Perbaikan </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control text-capitalize" value="{{ $dataPerbaikan->lokasi_bangunan }}" readonly>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control text-capitalize" value="{{ $dataPerbaikan->lokasi_spesifik }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Bidang Kerusakan </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control text-capitalize" value="{{ $dataPerbaikan->bid_kerusakan }}" readonly>
                        </div>
                        <label class="col-sm-2 col-form-label">Keterangan </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control text-capitalize" value="{{ $dataPerbaikan->keterangan }}" readonly>
                        </div>
                    </div>
                    @endforeach

                    <div class="form-group row">
                        <label class="col-sm-2">&nbsp;</label>
                        <div class="col-sm-10">
                            <button type="reset" class="btn btn-default btn-md">BATAL</button>
                            <button type="submit" id="btnSubmit" class="btn btn-primary" onclick="return confirm('Apakah data sudah benar ?')">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
            @endforeach
        </div>
    </div>
</section>

@section('js')
<script>
    $('.image').change(function() {
        let reader = new FileReader();

        reader.onload = (e) => {
            $('#preview-image-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    $(function() {
        let resOTP = ''
        $(document).on('click', '#btnKirimOTP', function() {
            let jenisForm = "{{ $id }}"
            let tujuan = "verifikasi {{ $form }} barang"
            jQuery.ajax({
                url: '/super-user/sendOTP?jenisForm=' + jenisForm,
                data: {
                    "tujuan": tujuan
                },
                type: "GET",
                success: function(res) {
                    // console.log(res)
                    alert('Berhasi mengirim kode OTP')
                    resOTP = res
                }
            });
        });
        $(document).on('click', '#btnCheckOTP', function() {
            let inputOTP = $('#inputOTP').val()
            console.log(inputOTP)
            $('#kode_otp').append('<input type="hidden" class="form-control" name="kode_otp" value="' + resOTP + '">')
        })

        $("#table-barang").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": false,
            "paging": false,
            "info": false,
            "sort": false,
        }).buttons().container().appendTo('#table-barang_wrapper .col-md-6:eq(0)');
    });
    $('.image').change(function() {
        let idtarget = $(this).data('idtarget');
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-image-before-upload' + idtarget).attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);

    });
</script>
@endsection

@endsection
