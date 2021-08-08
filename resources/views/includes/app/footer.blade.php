<div class="container">
    <div class="row">
        <div class="col-lg-6 mb-5 mb-lg-0">
            <div class="row">
                <div class="col-md-12 justify-content-center">
                    <img src="{{ asset('frontend/images/logo.png')}}" alt="" width="80%">
                </div>
               
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
            
        </div>
        <div class="col-md-6 col-lg-3" id="kontak">
            <div class="block-5 mb-5">
                <h3 class="footer-heading mb-4">Info Kontak</h3>
                <ul class="list-unstyled">
                    @foreach($admin as $a)
                        <li class="address">{{ $a->address}}</li>
                        <li class="phone"><a href="tel://{{ $a->phone_number}}">{{ $a->phone_number}}</a></li>
                        <li class="email">{{ $a->email }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</div>