{{-- alert blade --}}
@if(session('success'))
<div id="success-alert" class="alert alert-success m-0 border-0 p-0" style="padding: 5px 5px !important">
   {{ session('success') }}
</div>
@endif

{{-- alert json --}}
<div id="modalAlertJson" class="alert alert-success m-0 border-0 p-0 d-none" style="padding: 5px 5px !important"></div>
 
