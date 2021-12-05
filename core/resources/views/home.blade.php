@extends('layouts.app')

@section('content')
<section class="main-content-section style-8">
<style>
.searchfilter #quotelist-table_filter {
    float: left;
    margin-left: 0px !important;
}
</style>

    <!-- Main content -->
    <section class="content">
	  <div class="main-panel">
          <div class="content-wrapper">
            
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> Dashboard </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                  </li>
                </ul>
              </nav>
            </div>

            <div class="card">
            <div class="card-body">
        <div class="row dashboard-card">
          <div class="col-lg-12 pb-4">
              Welcome to MattBio Metallurgical Testing Web Application ..
            </div>
            </div>
 </div>
 </div>
  </div>

</div>
      </section>

  
</section>

<script>

function process(date){
   var parts = date.split("/");
   return new Date(parts[2], parts[0] - 1, parts[1]);
}
function isValidDate(s) {
  var bits = s.split('/');
  var d = new Date(bits[2] + '/' + bits[0] + '/' + bits[1]);
  return !!(d && (d.getMonth() + 1) == bits[0] && d.getDate() == Number(bits[1]));
}

$.ajaxSetup({
headers: {
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

</script>
@endsection
