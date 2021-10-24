@extends('frontend.layouts.master')


@section('content')



<!-- Content -->

<div class="page-content bg-white">
    <!-- inner page banner -->
    <div class="page-banner ovbl-dark" style="background-image:url({{asset('images/banner/banner3.jpg')}});">
        <div class="container">
            <div class="page-banner-entry">
              <br/>
              <br/>
              
     </div>
        </div>
    </div>
<!-- Breadcrumb row -->
<div class="breadcrumb-row">
  <div class="container">
    <ul class="list-inline">
      <li><a href="{{route('home')}}">Home</a></li>
      <li>Contact Us</li>
    </ul>
  </div>
</div>
<!-- Breadcrumb row END -->

    <!-- inner page banner -->
    <div class="page-banner contact-page section-sp2">
        <div class="container">
            <div class="row">
      <div class="col-lg-5 col-md-5 m-b30">
        <div class="bg-primary text-white contact-info-bx">
          <h2 class="m-b10 title-head">Contact <span>Information</span></h2>

          <div class="widget widget_getintuch">
            <ul>
              <li><i class="ti-location-pin"></i>Hayat Rose Park
                  Level 5, House No 16
                  Main Road, Bashundhara Residential Area
                  Dhaka 1229
                  Bangladesh</li>
              <li><i class="ti-mobile"></i>+88 01766 343 434</li>
              <li><i class="ti-email"></i>info@globalskills.com.bd</li>
            </ul>
          </div>
          <h5 class="m-t0 m-b20">Follow Us</h5>
          <ul class="list-inline contact-social-bx">
            <li><a href="#" class="btn outline radius-xl"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#" class="btn outline radius-xl"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#" class="btn outline radius-xl"><i class="fa fa-linkedin"></i></a></li>
            <li><a href="#" class="btn outline radius-xl"><i class="fa fa-google-plus"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-7 col-md-7">
        <form id="contact-frm" class="contact-bx ajax-form" action="{{ route('store-contact') }}" >
          <input type="hidden" id="token" value="{{ @csrf_token() }}">

          <div id="res" ></div>
        <div class="ajax-message"></div>
          <div class="heading-bx left">
            <h2 class="title-head">Get In <span>Touch</span></h2>

          </div>
          <div class="row placeani">
            <div class="col-lg-6">
              <div class="form-group">
                <div class="input-group">
                  <label>Your Name</label>
                  <input name="name" type="text" class="form-control valid-character">
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <div class="input-group">
                  <label>Your Email Address</label>
                  <input name="email" type="email" class="form-control" >
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <div class="input-group">
                  <label>Your Phone</label>
                  <input name="phone" type="text"  class="form-control int-value">
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <div class="input-group">
                  <label>Type Message</label>
                  <textarea name="msg" rows="4" class="form-control" ></textarea>
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <button name="submit" type="submit" value="Submit" class="btn button-md"> Send Message</button>
            </div>
          </div>
        </form>
      </div>
    </div>
        </div>
</div>
    <!-- inner page banner END -->
</div>
<!-- Content END-->
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js" integrity="sha512-XKa9Hemdy1Ui3KSGgJdgMyYlUg1gM+QhL6cnlyTe2qzMCYm4nAZ1PsVerQzTTXzonUR+dmswHqgJPuwCq1MaAg==" crossorigin="anonymous"></script>

<script>
       $(document).ready(function(){
           $("#contact-frm").submit(function(e){
               e.preventDefault();
               let url = $(this).attr('action');
               $("#btn").attr('disabled', true);
               $.post(url,
               {
                   '_token': $("#token").val(),
                   email: $("#email").val(),
                   name: $("#name").val(),
                   phone: $("#phone").val(),
                   message: $("#msg").val()
               },
               function (response) {
                   if(response.code == 400){
                       $("#btn").attr('disabled', false);
                       let error = '<span class="alert alert-danger">'+response.msg+'</span>';
                       $("#res").html(error);
                   }else if(response.code == 200){
                       $("#btn").attr('disabled', false);
                       let success = '<span class="alert alert-success">'+response.msg+'</span>';
                       $("#res").html(success);
                   }
               });


           })
       })
   </script>


@endpush



@endsection
