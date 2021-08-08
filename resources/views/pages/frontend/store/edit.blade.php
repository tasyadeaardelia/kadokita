@extends('layouts.admin')

@section('title', 'Edit Toko Saya')

@section('content')
    <div class="container-fluid">

         <!-- DataTales Example -->
         <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">TOKO SAYA</h6>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('store.update', $store->id)}}" method="post" enctype='multipart/form-data'>
                    @method('PUT')
                    @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Nama Toko</label>
                            <div class="col-lg-9">
                                <input class="form-control  @error('name') is-invalid @enderror" type="text" name="name" required value="{{ $store->name }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Url Toko</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control @error('url') is-invalid @enderror" name="url" required value="{{ $store->url }}">
                                @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Deskripsi Toko</label>
                            <div class="col-lg-9">
                                <textarea name="description" id="description" class="form-control" value="{{ $store->description }}">{{ $store->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-lg-3 col-form-label form-control-label">Profil Toko</label>
                            <div class="col-lg-9">
                                <input type="file" name="profil" required accept="image/*" onchange="showPreview(event);">
                                <div class="preview-img">
                                    <img id="preview">
                                    @if($store->profil)
                                        <img src="{{asset('/library/store/'.$store->profil) }}" alt="" style="margin-top: 20px; max-width:300px;">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-9">
                                <input type="hidden" name="user_id" required value="{{ $store->user->id }}">
                            </div>
                        </div>

                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="ktp">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapsektp" aria-expanded="false" aria-controls="collapsektp">
                                        Bukti Identitas Diri
                                    </button>
                                </h5>
                            </div>
                  
                            <div id="collapsektp" class="collapse show" aria-labelledby="ktp" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">Upload KTP</label>
                                        <div class="col-lg-9">
                                            <input type="file" name="id_card" required accept="image/*">
                                            
                                                @if($store->user->id_card)
                                                    <img src="{{asset('/library/seller/'.$store->user->id_card) }}" alt="" style="margin-top: 20px; max-width:300px;">
                                                @endif
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
          
                        <div class="card mt-4">
                            <div class="card-header" id="headingOption">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOption" aria-expanded="false" aria-controls="collapseOption">
                                    Data Penjual
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOption" class="collapse" aria-labelledby="headingOption" data-parent="#accordion">
                                <div class="card-body">
                                   
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Nama Lengkap</label>
                                            <div class="col-lg-9">
                                                <input class="form-control @error('fullname') is-invalid @enderror" type="text" name="fullname" required value="{{ $store->user->fullname }}">
                                                @error('fullname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Gender</label>
                                            <div class="col-lg-9">
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

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">No Hp</label>
                                            <div class="col-lg-9">
                                                <input class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" required value="{{ $store->user->phone_number}}" >
                                                @error('phone_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Bank</label>
                                            <div class="col-lg-9">
                                                <input class="form-control @error('account_number') is-invalid @enderror" type="text" name="account_number" required value="{{ $store->user->account_number }}">
                                                @error('account_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row hidden">
                                            <div class="col-lg-9">
                                                <input class="form-control" type="hidden" name="user_id" required value="{{ $store->user->id}}">
                                            </div>
                                        </div>
                                   
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header" id="alamat">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseAlamat" aria-expanded="false" aria-controls="collapseAlamat">
                                    Data Alamat
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseAlamat" class="collapse" aria-labelledby="alamat" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="" class="col-lg-3 col-form-label form-control-label">Provinsi</label>
                                        <div class="col-lg-9">
                                            <select name="province" required class="form-control" id="province">
                                                    <option value="">Pilih Provinsi</option>
                                                    @foreach($provinces as $province => $value)
                                                        <option value="{{ $province }}">{{ $value}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                
                                    <div class="form-group row">
                                        <label for="" class="col-lg-3 col-form-label form-control-label">Kabupaten / Kota</label>
                                        <div class="col-lg-9">
                                            <select name="city" required class="form-control" id="city">
                                                <option value="">Pilih kabupaten/kota</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">Alamat Lengkap</label>
                                        <div class="col-lg-9">
                                            <textarea name="address" id="address" class="form-control">{{ $store->user->address }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group mt-4">
                        <input class="btn btn-danger" type="reset" value="Reset">
                        <button class="btn btn-primary" type="submit">Submit</button>   
                    </div>

                </form>
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
