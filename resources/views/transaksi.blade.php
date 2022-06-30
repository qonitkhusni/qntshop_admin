@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Table Transaksi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Transaksi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Transaksi Belum Dibayar</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Total</th>
                    <th>Bank</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($listPanding as $data)
                    <tr>
                        <td>{{"Rp.".number_format($data->total_transfer)}}</td>
                        <td>{{ $data->bank }}</td>
                        <td>{{ $data->status}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
        </div>

        <br>

        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Transaksi Diproses</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Total</th>
                    <th>Bank</th>
                    <th>Status</th>
                    <th>Bukti Transfer</th>
                    <th style="width: 140px">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($listDone as $data)
                    <tr>
                        <td>{{"Rp.".number_format($data->total_transfer)}}</td>
                        <td>{{ $data->bank }}</td>
                        <td>{{ $data->status}}</td>
                        <td><a href="{{ asset('storage/transfer/'.$data->buktiTransfer)}}" target="_blank">Lihat Bukti Transfer</a></td>
                        <td>
                          @if($data->status == "Dikirim")
                          <a href="{{ route('transaksiSelesai', $data->id) }}">
                            <button type="button" class="btn btn-block btn-success btn-xs">Selesai</button>
                          </a>
                          @elseif($data->status == "Dibayar")
                          <a href="{{ route('transaksiConfirm', $data->id) }}">
                            <button type="button" class="btn btn-block btn-info btn-xs">Proses</button>
                          </a>
                          @elseif($data->status == "Proses")
                          <a href="{{ route('transaksiKirim', $data->id) }}">
                            <button type="button" class="btn btn-block btn-success btn-xs">Kirim</button>
                          </a>
                          @elseif($data->status == "Selesai" || $data->status == "Batal")
                          <a href="#">
                            <button type="button" class="btn btn-block btn-info btn-xs">Detail</button>
                          </a>
                          @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection