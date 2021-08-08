@extends('layouts.app')

@section('content')
    <div class="site-section">
        <div class="container">
            {{-- Cek apakah user sudah melengkapi alamat ?, --}}
            @if(!Auth::user()->address)
            {{-- Jika belum punya, maka dipaksa untuk mengisi alamat nya --}}
                <div class="row mb-5">
                    <div class="col-md-12">
                        <div class="border p-4 rounded" role="alert">
                            Kamu belum melengkapi alamat kamu, silahkan lengkapi <a href="{{ route('profil')}}">disini</a>.
                        </div>
                    </div>
                </div>
            @else
            
            
                <form method="POST" action="{{ route('checkout')}}">
                    @csrf
                    {{-- tampilan detail penerima --}}
                    <div class="row" @if(!Auth::user()->address) hidden @else @endif>
                        <div class="col-md-6 mb-5 mb-md-0">
                            <h2 class="h3 mb-3 text-black">Detail Penerima</h2>
                                <div class="p-3 p-lg-5 border">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="nama_penerima" class="text-black">Fullname <span class="text-danger">*</span></label>
                                            <input type="text" disabled class="form-control" id="nama_penerima" name="nama_penerima" value="{{ $carts->user->fullname }}">
                                            <input type="hidden" name="id_penerima" value="{{ $carts->user_id }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="alamat_tujuan" class="text-black">Alamat <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="alamat_tujuan" name="alamat_tujuan" placeholder="Alamat Tujuan" value="{{ $carts->user->address }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="provinsi_tujuan" class="text-black">Provinsi <span class="text-danger">*</span></label>
                                            <input type="text" disabled class="form-control" id="provinsi_tujuan" name="provinsi_tujuan" value="{{ $carts->user->province->title}}">
                                            <input type="hidden" name="id_provinsi_tujuan" value="{{ $carts->user->province_id }}">
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <label for="kota_tujuan" class="text-black">Kabupaten /Kota <span class="text-danger">*</span></label>
                                            
                                                <input type="text" disabled class="form-control" id="kota_tujuan" name="kota_tujuan" value="{{ $carts->user->city->title}}">
                                                <input type="hidden" id="id_kota_tujuan" name="id_kota_tujuan" value="{{ $carts->user->city_id}}">
                                        
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <div class="col-md-6">
                                            <label for="email_penerima" class="text-black">Alamat Email <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="email_penerima" name="email_penerima" value="{{ $carts->user->email }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="hp_penerima" class="text-black">Phone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="hp_penerima" name="hp_penerima" value="{{ $carts->user->phone_number}}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <div class="col-md-12">
                                            <label for="courier" class="text-black">Jasa Kurir</label>
                                            <select name="courier" required class="form-control" id="province">
                                                <option value="">Pilih Jasa Kurir</option>
                                                @foreach($courier as $key => $value)
                                                    <option value="{{ $value->code }}">{{ $value->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="c_order_notes" class="text-black">Kartu Ucapan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="custom_card" id="c_order_notes" cols="30" rows="5" required class="form-control" placeholder="Selamat Ulang Tahun, Teman"></textarea>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-5">
                                <div class="col-md-12">
                                    <h2 class="h3 mb-3 text-black">Your Order</h2>
                                    <div class="p-3 p-lg-5 border">
                                        <table class="table site-block-order-table mb-5">
                                            <thead>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </thead>    
                                            <tbody>
                                                @php $totalPrice = 0 @endphp
                                                @php $total = 0 @endphp
                                                
                                                    <tr>
                                                        <td>{{ $carts->product->name}}<strong class="mx-2">x</strong> {{ $carts->quantity}}</td>
                                                        <input type="text" hidden class="form-control" value="{{ $carts->product_id}}" name="product_id">
                                                        <td>
                                                            @php
                                                            $total += ($carts->quantity*$carts->product->price);
                                                            $subtotal = ($carts->quantity*$carts->product->price);
                                                            @endphp
                                                            Rp.{{ $subtotal }}
                                                        </td>
                                                    </tr>
                                            
                                                <tr>
                                                    <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
                                                    <td class="text-black">
                                                        @php $totalPrice += $total @endphp 
                                                        Rp.{{ number_format($totalPrice ?? 0) }}
                                                        <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">
                                                    </td>
                                                </tr>
                                                <tr class="jasa_kurir">
                                                    <td class="text-black font-weight-bold"><strong>Jasa Pengiriman</strong></td>
                                                    <td class="text-black">
                                                        <select name="jasa_selected" class="custom-select" id="jasa_kurir">
                                                            <option value="">Pilih Jasa Pengiriman</option>
                                                            
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr class="ongkos_kirim">
                                                    
                                                </tr>
                                                <tr>
                                                    <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                                                    <td class="text-black font-weight-bold"><strong id="order-total"></strong></td>
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="form-group">
                                            <input type="text" hidden class="form-control mb-4" placeholder="" name="ongkos_kirim" value="">
                                            <input type="text" hidden class="form-control mb-4" placeholder="" name="total_price" value="">
                                            <button class="btn btn-primary btn-lg py-3 btn-block checkout" type="submit">Place Order</button>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            
        

                <div class="row mt-4">
                    <div class="col-md-6 mb-5 mb-md-0">
                        <h2 class="h3 mb-3 text-black">Detail Pengirim</h2>
                            <div class="p-3 p-lg-5 border">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="nama_toko" class="text-black">Nama Toko </label>
                                        <input type="text" disabled class="form-control" id="nama_toko" name="nama_toko" value="{{ $carts->product->store->name }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="pemilik_toko" class="text-black">Nama Pemilik</label>
                                        <input type="text" disabled class="form-control" id="pemilik_toko" name="pemilik_toko" placeholder="Pemilik Toko" value="{{ $carts->product->store->user->fullname }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="alamat_asal" class="text-black">Alamat Pengirim </label>
                                        <input type="text" disabled class="form-control" id="alamat_asal" name="alamat_asal" placeholder="Alamat Asal" value="{{$carts->product->store->user->address_one }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="provinsi_asal" class="text-black">Provinsi </label>
                                        <input type="text" disabled class="form-control" id="provinsi_asal" name="province_asal" value="{{ $carts->product->store->user->province->title}}">
                                        <input type="hidden" disabled class="form-control" id="id_provinsi_asal" name="id_provinsi_asal" value="{{ $carts->product->store->user->province_id}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="city_asal" class="text-black">Kabupaten /Kota </label>
                                        <input type="text" disabled class="form-control" id="kota_asal" name="city_asal" value="{{ $carts->product->store->user->city->title}}">
                                        <input type="hidden" disabled class="form-control" id="id_kota_asal" name="id_kota_asal" value="{{ $carts->product->store->user->city_id}}">
                                    </div>
                                </div>
                                <div class="form-group row mb-5">
                                    <div class="col-md-12">
                                        <label for="nomor_pemilik_toko" class="text-black">Phone </label>
                                        <input type="text" disabled class="form-control" id="nomor_pemilik_toko" name="nomor_pemilik_toko" value="{{$carts->product->store->user->phone_number}}">
                                    </div>
                                </div>
                                <div class="form-group row mb-5">
                                    <div class="col-md-12">
                                        <label for="nama_produk" class="text-black">Nama Produk </label>
                                        <input type="text" disabled class="form-control" id="nama_produk" name="nama_produk" value="{{ $carts->product->name}}">
                                        <input type="hidden" class="form-control" id="berat" name="berat" value="{{ $carts->product->weight}}">
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            @endif
    
        </div>
    </div>
@endsection

@push('addon-script')

    
    <script>
         $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>

<script>
    $(document).ready(function() {
        let isProcessing = false;
        $('.ongkos_kirim').empty();
        $('select[name="courier"]').on('change', function(){
            let token            = $("meta[name='csrf-token']").attr("content");
            let city_origin      = $('input[id=id_kota_asal]').val();
            let city_destination = $('input[name=id_kota_tujuan]').val();
            let courier          = $('select[name=courier]').val();
            let weight           = $('input[name=berat]').val();

            if(isProcessing) {
                return;
            }

            isProcessing = true;

            jQuery.ajax({
                url: "/ongkir",
                data: {
                    _token: token,
                    city_origin: city_origin,
                    city_destination: city_destination,
                    courier: courier,
                    weight: weight,
                },
                dataType: "JSON",
                type: "POST",
                success: function(response) {
                    isProcessing = false;
                    if(response) {
                        $('#jasa_kurir').empty();
                        // $('.jasa_kurir').addClass('d-block');
                        $.each(response[0]['costs'], function (key, value) {
                            $('#jasa_kurir').append('<option value=""></option><option value="'+value.cost[0].value+'">'+response[0].code.toUpperCase()+' : <strong>'+value.service+'</strong> - Rp. '+value.cost[0].value+' ('+value.cost[0].etd+' hari)</option>')
                        });
                        
                    }
                }
            });
        });

        $('select[name="jasa_selected"]').on('change', function(){
            let ongkir = $(this).val();
            let totalPrice = $('input[name="totalPrice"]').val();
            $('#order-total').empty();
            if(ongkir) {
                let total_biaya = parseInt(totalPrice) + parseInt(ongkir);
                $('.ongkos_kirim').empty();

                $('.ongkos_kirim').append('<td class="text-black font-weight-bold" id="ongkos_kirim"><strong>Ongkos Kirim</strong></td><td class="text-black">'+ongkir+'<td>');
                    
                $('#order-total').append(total_biaya);

                $('input[name="total_price"]').val(total_biaya);
                $('input[name="ongkos_kirim"]').val(ongkir);
            }
            else{
                $('.ongkos_kirim').empty();
            }
        });

        
    });
</script>


@endpush