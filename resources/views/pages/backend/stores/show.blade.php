@extends('layouts.admin')

@section('title', 'Manajemen Toko - Admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        @foreach($stores as $store)
        <div class="row">
            <div class="col-lg-10 col-6">
                <h1 class="h3 mb-2 ml-4 text-gray-900">Detail Toko {{ $store->name }}</h1>
            </div>
            <div class="col-lg-2 col-3">
                @if($store->is_approved == 0)
                    <a href="{{ route('new-store') }}" class="btn btn-primary mb-4">Kembali</a>
                @else
                    <a href="{{ route('approved-store') }}" class="btn btn-primary mb-4">Kembali</a>
                @endif
            </div>
        </div>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                
            </div>
            <div class="card-body table-responsive">
               <table class="table">
                    <tr class="text-center" >
                        <th colspan="2" style="border: none;">Data Toko</th>
                    </tr>
                    <tr>
                        <th>Nama Toko</th>
                        <td>{{ $store->name }}</td>
                    </tr>
                    <tr>
                        <th>Url Toko</th>
                        <td>{{ $store->url }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $store->description }}</td>
                    </tr>
                    <tr>
                        <th>Profil Toko</th>
                        <td>
                            <img src="{{ asset('/library/store/'.$store->profil)}}" alt="" style="width: 20%;">
                        </td>
                    </tr>
                    <tr>
                        <th>Nama Pemilik</th>
                        <td>{{ $store->user->fullname }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat pada tanggal</th>
                        <td>{{ date('d F Y H:s:i', strtotime($store->created_at)) }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir di update</th>
                        <td>{{ date('d F Y H:s:i', strtotime($store->updated_at)) }}</td>
                    </tr>
                    <tr class="text-center">
                        <th colspan="2" style="border: none;">Data Penjual</th>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $store->user->username }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $store->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Profil Pemilik</th>
                        <td>
                            <img src="{{ asset('library/users/'.$store->user->profil)}}" alt="" style="width: 20%;">
                        </td>
                    </tr>
                    <tr>
                        <th>Provinsi</th>
                        <td>{{ $store->user->province->title }}</td>
                    </tr>
                    <tr>
                        <th>Kota</th>
                        <td>{{ $store->user->city->title }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $store->user->address }}</td>
                    </tr>
                    <tr>
                        <th>Kode Pos</th>
                        <td>{{ $store->user->zip_code }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Hp</th>
                        <td>{{ $store->user->phone_number }}</td>
                    </tr>
                    <tr>
                        <th>Akun Bank</th>
                        <td>{{ $store->user->account_number }}</td>
                    </tr>
                    <tr>
                        <th>KTP</th>
                        <td>
                            <img src="{{ asset('library/users/'.$store->user->id_card)}}" alt="" style="width: 20%;">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: none;">
                            @if($store->is_approved == 0)
                                <form method="POST" action="{{ route('accept-store', $store->url)}}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="1" name="is_approved">
                                    <button class="btn btn-primary" type="submit">Setujui</button>
                                </form>
                            @else
                                <div class="row ">
                                    <div class="col-lg-4 col-4" style="margin-right: 50px;">
                                        <form method="POST" action="{{ route('cancel approved', $store->url)}}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" value="0" name="is_approved">
                                            <button class="btn btn-danger" type="submit">Batalkan Persetujuan Toko</button>
                                        </form>
                                    </div>
                                </div>
                                
                            @endif
                        </td>
                    </tr>
               </table>
            </div>
        </div>
        @endforeach
    </div>
    <!-- /.container-fluid -->
@endsection