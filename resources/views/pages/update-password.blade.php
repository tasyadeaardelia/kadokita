@extends('layouts.admin')

@section('title', 'Pengaturan Akun')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-900">Akun Saya</h1>
            <p>Perbaharui Password</p>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="dashboard-content">
                    <div class="row">
                      <div class="col-12">
                            <form  action="{{ route('update-password','form-update-password') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row" id="show_hide_old_password">
                                        <div class="col-sm-11 mb-3 mb-sm-0">
                                            <label for="old-password">Password Lama</label>
                                            <input id="old-password" type="password" class="form-control form-control-user @error('old-password') is-invalid @enderror" name="old-password" required autocomplete="current-password" placeholder="Password">

                                            @error('old-password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-1  input-group-addon d-flex align-items-center">
                                            <a href="">
                                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="show_hide_password">
                                        <div class="col-sm-11 mb-3 mb-sm-0">
                                            <label for="password">Update Password</label>
                                            <input id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-1  input-group-addon d-flex align-items-center">
                                            <a href="">
                                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit"  class="btn btn-success px-5">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('addon-script')
<script>
    $(document).ready(function() {
        $("#show_hide_old_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_old_password input').attr("type") == "text"){
                $('#show_hide_old_password input').attr('type', 'password');
                $('#show_hide_old_password i').addClass( "fa-eye-slash" );
                $('#show_hide_old_password i').removeClass( "fa-eye" );
            }else if($('#show_hide_old_password input').attr("type") == "password"){
                $('#show_hide_old_password input').attr('type', 'text');
                $('#show_hide_old_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_old_password i').addClass( "fa-eye" );
            }
        });


        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass( "fa-eye-slash" );
                $('#show_hide_password i').removeClass( "fa-eye" );
            }else if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_password i').addClass( "fa-eye" );
            }
        });
    });
</script>
    
@endpush



