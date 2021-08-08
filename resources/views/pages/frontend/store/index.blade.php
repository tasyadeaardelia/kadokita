@extends('layouts.admin')

@section('title', 'Toko Saya')

@section('content')
    <div class="container-fluid">
        

            <div class="row d-flex justify-content-center align-items-center" style="margin-top:150px; margin-bottom:10px;">
                <i class="fas fa-store"></i>
            </div>

            <div class="row d-flex justify-content-center align-items-center">
                <p>Maaf, anda belum buka toko. Klik dibawah ini jika ingin membuka toko</p>
            </div>
            <div class="row d-flex justify-content-center align-items center">
                <form class="d-inline" method="POST" action="{{ route('store.store') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Buka Toko</button>.
                </form>
            </div>

    </div>
@endsection