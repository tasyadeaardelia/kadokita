<ul class="navbar-nav sidebar accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" 
        @hasrole('admin')
            href="{{ route('admin-dashboard')}}"
        @endhasrole
        @hasanyrole('seller|buyer')
            href="{{ route('user-dashboard')}}"
        @endhasanyrole
            >
        <div class="sidebar-brand-icon">
            <img src="{{ asset('backend/img/logo.png')}}" alt="" class="img-fluid">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="
            @hasrole('admin')
                {{ route('admin-dashboard')}}
            @endhasrole
            @hasanyrole('seller|buyer')
                {{ route('user-dashboard')}}
            @endhasanyrole
        ">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    @hasrole('admin')
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Banner
        </div>
        
        <li class="nav-item">
            <a href="{{ route('banner.index')}}" class="nav-link">
                <i class="fas fa-fw fa-bookmark"></i>
                <span>Banner</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
        
        <!-- Heading -->
        <div class="sidebar-heading">
            Post
        </div>
        
        <li class="nav-item">
            <a href="{{ route('post.index')}}" class="nav-link">
                <i class="fas fa-fw fa-stream"></i>
                <span>Post</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
        
        <!-- Heading -->
        <div class="sidebar-heading">
            Semua Toko
        </div>
        
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseAllStore"
                aria-expanded="true" aria-controls="collapseAllStore">
                <i class="fas fa-fw fa-store"></i>
                <span>Toko</span>
            </a>
            <div id="collapseAllStore" class="collapse" aria-labelledby="headingAllStore" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('store.edit', Auth::user()->id) }}">Toko Saya</a>
                    <a class="collapse-item" href="{{ route('approved-store') }}">Toko Disetujui</a>
                    <a class="collapse-item" href="{{ route('new-store') }}">Permintaan Toko</a>
                </div>
            </div>
        </li>
    @endhasrole

    @hasanyrole('admin|seller')
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">   
            Produk
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseOne"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-gifts"></i>
                <span>Produk</span>
            </a>
            <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('product.index') }}">Produk Saya</a>
                    @hasrole('admin')
                        <a class="collapse-item" href="{{ route('allproduct.index')}}">Semua Produk</a>
                        <a class="collapse-item" href="{{ route('category.index') }}">Kategori</a>
                    @endhasrole
                </div>
            </div>
        </li>
    @endhasanyrole

    @hasrole('admin')
         <!-- Divider -->
         <hr class="sidebar-divider">

         <!-- Heading -->
         <div class="sidebar-heading">
             Manajemen User
         </div>
 
         <!-- Nav Item - Pages Collapse Menu -->
         <li class="nav-item">
             <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseAllUsers"
                 aria-expanded="true" aria-controls="collapseAllUsers">
                 <i class="fas fa-fw fa-users"></i>
                 <span>Users</span>
             </a>
             <div id="collapseAllUsers" class="collapse" aria-labelledby="headingAllStore" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <a class="collapse-item" href="{{ route('users.index') }}">Users</a>
                 </div>
             </div>
         </li>

          <!-- Divider -->
          <hr class="sidebar-divider">

          <!-- Heading -->
         <div class="sidebar-heading">   
             Riwayat Transaksi
         </div>
 
         <!-- Nav Item - Pages Collapse Menu -->
         <li class="nav-item">
             <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseTransaksiAdmin"
                 aria-expanded="true" aria-controls="collapseTransaksiAdmin">
                 <i class="fas fa-gifts"></i>
                 <span>Transaksi</span>
             </a>
             <div id="collapseTransaksiAdmin" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('alltransaction.index') }}">Semua Transaksi</a>
                     <a class="collapse-item" href="{{ route('transaction.index') }}">Penjualan Produk</a>
                 </div>
             </div>
         </li>
    @endhasrole

    @hasanyrole('seller|buyer')
    
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('store.index') }}">
                <i class="fas fa-fw fa-store"></i>
                <span>Toko</span>
            </a>
        </li>

         <!-- Divider -->
         <hr class="sidebar-divider">

         <!-- Heading -->
        <div class="sidebar-heading">   
            Riwayat Transaksi
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseTransaksi"
                aria-expanded="true" aria-controls="collapseTransaksi">
                <i class="fas fa-gifts"></i>
                <span>Transaksi</span>
            </a>
            <div id="collapseTransaksi" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @hasrole('seller')
                        <a class="collapse-item" href="{{ route('transaction.index') }}">Penjualan Produk</a>
                    @endhasrole
                    @hasanyrole('seller|buyer')
                        <a class="collapse-item" href="{{ route('user-transaction') }}">Pembelian Produk</a>
                    @endhasanyrole
                </div>
            </div>
        </li>
    @endhasanyrole

    @hasanyrole('admin|seller')

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a href="{{ route('laporan.penjualan')}}" class="nav-link">
            <i class="fas fa-fw fa-download"></i>
            <span>Laporan Penjualan</span>
        </a>
    </li>

    @endhasanyrole

    <!-- Divider -->
    <hr class="sidebar-divider">
    
    <li class="nav-item">
        <a class="nav-link" href="{{ route('profil') }}">
            <i class="fas fa-fw fa-user-circle"></i>
            <span>Akun Saya</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>