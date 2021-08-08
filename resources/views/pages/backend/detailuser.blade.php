@extends('layouts.admin')

@section('title', 'Detail Pengguna - Admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-10 col-6">
                <h1 class="h3 mb-2 text-gray-900">User</h1>
            </div>
            <div class="col-lg-2 col-6">
                <a href="{{ route('users.index') }}" class="btn btn-primary mb-4">Kembali</a>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"></h6>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <tr class="text-center" >
                        <th colspan="2" style="border: none;">Pengguna</th>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $user->fullname }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>No Handphone</th>
                        <td>{{ $user->phone_number }}</td>
                    </tr>
                    <tr>
                        <th>Foto</th>
                        <td>
                            <img src="{{ asset('/library/user/profil'.$user->profil)}}" alt="" style="width: 20%;">
                        </td>
                    </tr>
               </table>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection