@extends('layouts.app')

@section('content')
    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0">
                    <a href="{{ route('home')}}">Home</a> 
                    <span class="mx-2 mb-0">/</span> 
                    <strong class="text-black">Cart</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row mb-5" data-aos="fade-up" data-aos-delay="200">
                <form class="col-md-12" method="post">
                    <div class="site-blocks-table">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">Image</th>
                                    <th class="product-name">Product</th>
                                    <th class="product-name">Nama Toko</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-total">Total</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalPrice = 0 @endphp
                                @php $total = 0 @endphp
                                @forelse($carts as $cart)
                                    <tr>
                                        <td class="product-thumbnail">
                                            <img src="{{ asset('library/products/'.$cart->photo)}}" alt="Image" class="img-fluid">
                                        </td>
                                        <td class="product-name">
                                            <h2 class="h5 text-black">{{ $cart->nama_produk }}</h2>
                                        </td>
                                        <td class="product-name">
                                            {{ $cart->nama_toko}}
                                        </td>
                                        <td>Rp.{{ number_format($cart->price) }}</td>
                                        <td>
                                            
                                            {{ $cart->quantity }}
                                            
                                        </td>
                                        <td>
                                            @php
                                                $total += ($cart->quantity*$cart->price);
                                                $subtotal = ($cart->quantity*$cart->price);
                                            @endphp
                                            Rp.{{ $subtotal }}
                                        </td>
                                        <td>
                                            {{-- <form method="post" action="{{ route('cart.destroy', $cart->id)}}">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger btn-sm" type="submit">
                                                    X
                                                </button>
                                            </form> --}}
                                            <button class="btn btn-danger btn-sm btnItemDelete" data-cartid="{{ $cart->id }}" >
                                                X
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">Anda masih belum memasukan apapun ke keranjang.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="row" data-aos="fade-up" data-aos-delay="150">
                <div class="col-md-6">
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <a  href="{{ route('kado') }}" class="btn btn-outline-primary btn-sm btn-block">Lanjutkan Belanja</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pl-5"> 
                    <div class="row justify-content-end"> 
                        <div class="col-md-7"> 
                            <div class="row"> 
                                <div class="col-md-12 text-right border-bottom mb-5"> 
                                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3> 
                                </div> 
                            </div> 
                            <div class="row mb-5"> 
                                <div class="col-md-6"> 
                                    <span class="text-black">Total</span> 
                                </div> 
                                <div class="col-md-6 text-right"> 
                                    <strong class="text-black"> 
                                        @php $totalPrice += $total @endphp 
                                        Rp.{{ number_format($totalPrice ?? 0) }}</strong> 
                                </div>
                            </div> 
                            <div class="row"> 
                                <div class="col-md-12"> 
                                    <button class="btn btn-primary btn-lg py-3 btn-block" onclick="window.location='{{ route('checkout')}}'">Proses Checkout</button> 
                                </div> 
                            </div>
                        </div> 
                    </div> 
                </div>
            </div>

        </div>
    </div>
@endsection

@push('addon-script')
    
        <script src="https://code.jquery.com/jquery-3.4.1.min.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $('.btnItemDelete').on('click', function(event){
            event.preventDefault();
            var cartid = $(this).data('cartid');
            var token = $('meta[name="csrf-token"]').attr('content');

            jQuery.ajax({
                url: "/cart/delete/"+cartid,
                dataType: "JSON",
                type: 'DELETE',
                data: {
                    "id":cartid,
                    _token:$('meta[name="csrf-token"]').attr('content')
                },
                success:function(){
                    alert('Item tersebut berhasil di hapus. Silahkan refresh halaman kembali');
                },
                error:function(){
                    alert(token);
                }
            });
        });
    </script>


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




