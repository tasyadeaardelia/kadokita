<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        @hasrole('admin')

        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-wallet fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">
                    @if($transaction_to_all)
                        {{ $transaction_to_all->count() }}
                    @endif
                </span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Notifikasi
                </h6>
                @foreach($transaction_to_all as $item)
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('transfertostore.show', $item->id)}}">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">{{ date('d F Y H:i',strtotime($item->created_at)) }}</div>
                            <span class="font-weight-bold">
                                {{ $item->transaction->user->fullname }}
                                Telah berhasil membayar produk {{ $item->product->name }}, silahkan transfer ke toko {{ $item->product->store->name}}
                            </span>
                        </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="{{ route('transfertostore.index') }}">Semua Transaksi</a>
                @endforeach
            </div>
        </li>

         <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">
                    @if($verif_toko && $transactions_for_notif)
                        @php echo number_format($verif_toko->count() + $transactions_for_notif->count()); @endphp
                    @elseif($verif_toko)
                        {{ $verif_toko->count() }}
                    @elseif($transactions_for_notif)
                        {{ $transactions_for_notif->count()}}
                    @endif
                </span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Notifikasi
                </h6>
                @foreach($verif_toko as $item)
                    <a class="dropdown-item d-flex align-items-center" 
                        @if($item->url != null)
                            href="{{ route('show-store-to-approved', $item->url) }}"
                        @endif 
                    >
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">{{ date('d F Y H:i',strtotime($item->created_at)) }}</div>
                            <span class="font-weight-bold">{{ $item->user->fullname }} telah membuka toko, 
                                @if($item->url != null)
                                    lihat berkas dan verifikasi
                                @else
                                    namun belum melengkapi nama dan url toko. Sehingga belum dapat dilakukan pengecekan
                                @endif
                            </span>
                        </div>
                    </a>
                @endforeach
                @foreach($transactions_for_notif as $item)
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('transaction.show',$item->id) }}">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">{{ date('d F Y H:i',strtotime($item->created_at)) }}</div>
                            <span class="font-weight-bold">{{ $item->transaction->user->fullname }} telah berhasil membayar, silahkan input resi</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </li>
        @endhasrole

        @hasanyrole('seller|buyer')
            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts -->
                    <span class="badge badge-danger badge-counter">
                        @if($buy_notif && $transaction_pending && $transactions_for_notif)
                            @php echo number_format($buy_notif->count() + $transaction_pending->count() + $transactions_for_notif->count()); @endphp
                        @elseif($buy_notif)
                            {{ $buy_notif->count()}}
                        @elseif($transaction_pending)
                            {{ $transaction_pending->count()}}
                        @elseif($transactions_for_notif)
                            {{ $$transactions_for_notif->count()}}
                        @endif
                    </span>
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Notifikasi
                    </h6>
                    @foreach($transactions_for_notif as $item)
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('transaction.show',$item->id) }}">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ date('d F Y H:i',strtotime($item->created_at)) }}</div>
                                <span class="font-weight-bold">{{ $item->transaction->user->fullname }} telah berhasil membayar, silahkan input resi</span>
                            </div>
                        </a>
                    @endforeach
                    @foreach($buy_notif as $item)
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('detail-user-transaction',$item->id) }}">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ date('d F Y H:i',strtotime($item->created_at)) }}</div>
                                <span class="font-weight-bold">{{ $item->product->name}} telah ada resinya, </span>
                            </div>
                        </a>
                    @endforeach
                    @foreach($transaction_pending as $item)
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('bayar-sekarang',$item->transaction->code) }}" onclick="event.preventDefault();
                    document.getElementById('bayar').submit();">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">{{ date('d F Y H:i',strtotime($item->created_at)) }}</div>
                            <span class="font-weight-bold">{{ $item->product->name}} belum dibayar, lakukan pembayaran sekarang</span>
                        </div>
                    </a>
                    <form id="bayar" action="{{ route('bayar-sekarang',$item->transaction->code) }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @endforeach
                </div>
            </li>
        @endhasanyrole

       

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->fullname }}</span>
                <img class="img-profile rounded-circle"
                    src="{{ asset('library/users/profil/'.Auth::user()->profil) }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('profil')}}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="{{ route('form-update-password')}}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Update Password
                </a>
                <a class="dropdown-item" href="{{ route('home') }}">
                    <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-400"></i>
                    Dashboard Kadokita
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>