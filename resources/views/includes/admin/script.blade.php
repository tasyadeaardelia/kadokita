<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

@yield('script-datatables')

<!-- Custom scripts for all pages-->
<script src="{{ asset('backend/js/sb-admin-2.min.js')}}"></script>

@yield('script-chart')

@yield('script-tags-input')

{{-- <!-- Plugins Init js -->
<script src="{{ asset('backend/vendor/pages/form-advanced.js') }}"></script> --}}

<!-- Tinymce js -->
@yield('script-tinymce')


<script type='text/javascript'>
    function showPreview(event) 
    {
     var reader = new FileReader();
     reader.onload = function()
     {
      var output = document.getElementById('preview');
      output.src = reader.result;
     }
     reader.readAsDataURL(event.target.files[0]);
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@if(Session::has('sukses')) 
    <script>toastr.success("{{ Session::get('sukses') }}")</script>
@endif

@if(Session::has('gagal')) 
    <script>toastr.error("{{ Session::get('gagal') }}")</script>
@endif
