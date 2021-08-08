@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

         <!-- DataTales Example -->
         <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">TOKO SAYA</h6>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    @foreach($shop as $item)
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Nama Toko</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" name="name" required value="{{ $item->name }}">
                            </div>
                        </div>
                    
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Url Toko</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="url" required value="{{ $item->url }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Deskripsi Toko</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="description" required value="{{ $item->description }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-3 col-form-label form-control-label">Profil Toko</label>
                        <div class="col-lg-9">
                            <input type="file" name="profil" id="">
                        </div>
                    </div>
                    @endforeach
                    <div class="form-group row">
                        <label for="" class="col-lg-3 col-form-label form-control-label">Provinsi</label>
                        <div class="col-lg-9">
                            {{-- <input type="text" name="location" id="" required value="{{ $location }}"> --}}
                            <select name="province" required class="form-control" id="province">
                                <option value="">Pilih provinsi</option>
                                @foreach($provinces as $value)
                                    <option value="{{ $value->name }}">
                                        {{ $value->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-3 col-form-label form-control-label">Kabupaten / Kota</label>
                        <div class="col-lg-9">
                            {{-- <input type="text" name="location" id="" required value="{{ $location }}"> --}}
                            <select name="regencies" required class="form-control" id="regencies">
                                {{-- <option value="">Pilih kabupaten/kota</option>
                                @foreach($regencies  as $value)
                                <option value="
                                    $value->name
                                ">
                                {{ $value->name }}
                                </option>
                                @endforeach --}}
                                <option value="">== SELECT KOTA ==</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-3 col-form-label form-control-label">Kecamatan</label>
                        <div class="col-lg-9">
                            {{-- <input type="text" name="location" id="" required value="{{ $location }}"> --}}
                            <select name="districts" required class="form-control" id="">
                                <option value="">Kecamatan</option>
                                @foreach($districts  as $value)
                                <option value="
                                    $value->name
                                ">
                                {{ $value }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-3 col-form-label form-control-label">Kelurahan/Desa/label>
                        <div class="col-lg-9">
                            {{-- <input type="text" name="location" id="" required value="{{ $location }}"> --}}
                            <select name="status" required class="form-control" id="">
                                <option value="">Kelurahan/Desa</option>
                                @foreach($villages  as $value)
                                <option value="
                                    $value->name
                                ">
                                {{ $value->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOptionGroup">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOptionGroup" aria-expanded="true" aria-controls="collapseOptionGroup">
                                        Grup Opsi
                                    </button>
                                </h5>
                            </div>
                  
                            <div id="collapseOptionGroup" class="collapse show" aria-labelledby="headingOptionGroup" data-parent="#accordion">
                                <div class="card-body">
                                    <form method="post" enctype='multipart/form-data' action=" ">
                                        @csrf
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label form-control-label">Nama Grup Opsi</label>
                                                <div class="col-lg-9">
                                                    <input class="form-control" type="text" name="name" required value="{{ old('name') }}">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <input class="btn btn-danger" type="reset" value="Reset">
                                                <button class="btn btn-primary" type="submit">Submit</button>   
                                            </div>
                                    </form>
                                </div>
                            </div>  
                        </div>
          
                      <div class="card">
                        <div class="card-header" id="headingOption">
                          <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOption" aria-expanded="false" aria-controls="collapseOption">
                              Opsi
                            </button>
                          </h5>
                        </div>
                        <div id="collapseOption" class="collapse" aria-labelledby="headingOption" data-parent="#accordion">
                          <div class="card-body">
                              <form method="post" enctype='multipart/form-data' action=" ">
                                  @csrf
                                      <div class="form-group row">
                                          <label class="col-lg-3 col-form-label form-control-label">Nama Grup Opsi</label>
                                          <div class="col-lg-9">
                                              <input class="form-control" type="text" name="name" required value="{{ old('name') }}">
                                          </div>
                                      </div>
                                      
                                      <div class="form-group">
                                          <input class="btn btn-danger" type="reset" value="Reset">
                                          <button class="btn btn-primary" type="submit">Submit</button>   
                                      </div>
                              </form>
                          </div>
                        </div>
                      </div>
                  </div>
            </div>
        </div>

    </div>
@endsection
