@extends('layouts.admin')

@section('title', 'Pengaturan Akun')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-900">Akun Saya</h1>
            <p>Perbaharui Akun</p>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="dashboard-content">
                    <div class="row">
                      <div class="col-12">
                          <form  action="{{ route('dashboard-settings-redirect','profil') }}" method="POST" enctype="multipart/form-data">
                        
                          @csrf
                          <div class="card">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text"  class="form-control" id="fullname" name="fullname" value="{{ $user->fullname }}"/>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"/>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="address">Alamat Utama</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}"/>
                                  </div>
                                </div>
                                
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label for="provinces_id">Provinsi</label>
                                    <select name="province" required class="form-control" id="province">
                                        <option value="">Pilih Provinsi</option>
                                        @foreach($provinces as $province => $value)
                                        <option value="{{ $province }}">{{ $value}}</option>
                                        @endforeach
                                  </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label for="regencies_id">Kota</label>
                                    <select name="city" required class="form-control" id="city">
                                        <option value="">Pilih kabupaten/kota</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label for="zip_code">Kode Pos</label>
                                    <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ $user->zip_code }}"/>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="phone_number">No Handphone</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"  value="{{ $user->phone_number }}"/>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Gender</label>
                                   
                                        <select name="gender" required class="form-control" id="">
                                            <option value="">== SELECT GENDER ==</option>
                                            @foreach($values as $value)
                                            <option value="
                                                @if ($value === 'male')
                                                    male
                                                @elseif ($value === 'female')
                                                    female
                                                @endif
                                            ">
                                                @if ($value === 'male')
                                                    Male
                                                @elseif ($value === 'female')
                                                    Female
                                                @endif
                                            </option>
                                            @endforeach
                                        </select>
                                    
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="profil_user">Profil</label>
                                    <input type="file" name="profil" class="form-control">
                                  </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
<script>
    $(document).ready(function() {
        $('select[name="province"]').on('change', function(){
            let provinceId = $(this).val();
            if(provinceId) {
                jQuery.ajax({
                    url:'/province/'+provinceId+'/cities',
                    type:"GET",
                    dataType:"json",
                    success:function(data){
                        $('select[name="city"]').empty();
                        $.each(data, function(key,value){
                            $('select[name="city"]').append('<option value="'+key+'">' + value+ '</option>' );
                        });
                    },
                });
            }
            else{
                $('select[name="city"]').empty();
            }
        });
    });
</script>
@endpush


