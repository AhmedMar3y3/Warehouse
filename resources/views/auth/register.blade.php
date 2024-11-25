<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>نظام إدارة المخازن </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

   <!-- Vendor CSS Files -->
   <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
   <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
   <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
   <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
   <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
   <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
   <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
 
   <!-- Template Main CSS File -->
   <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
  <!-- Start #main -->
  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">


              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">إنشاء حساب مستخدم</h5>
                    <p class="text-center small">أدخل بياناتك الشخصية لإنشاء حساب</p>
                  </div>
                  @if (Session::has('success'))
                      <div class="alert alert-success">{{Session::get('success')}}</div>
                  @endif
                  @if (Session::has('error'))
                      <div class="alert alert-danger">{{ Session::get('error') }}</div>
                  @endif
                  <form class="row g-3" action="{{ route('auth.registerUser') }}" method="POST">
                    @csrf
                    <div class="col-12">
                        <label for="yourName" class="form-label text-end w-100">اسمك</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                    </div>
                
                    <div class="col-12">
                        <label for="yourEmail" class="form-label text-end w-100">بريدك الإلكتروني</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        <span class="text-danger">@error('email'){{ $message }}@enderror</span>
                    </div>
                    <div class="col-12">
                        <label for="yourPhone" class="form-label text-end w-100">هاتفك</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        <span class="text-danger">@error('phone'){{ $message }}@enderror</span>
                    </div>
                
                    <div class="col-12">
                        <label for="yourPassword" class="form-label text-end w-100">كلمة المرور</label>
                        <input type="password" name="password" class="form-control">
                        <span class="text-danger">@error('password'){{ $message }}@enderror</span>
                    </div>
                
                    <div class="col-12">
                        <label for="yourPasswordConfirmation" class="form-label text-end w-100">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" class="form-control">
                        <span class="text-danger">@error('password_confirmation'){{ $message }}@enderror</span>
                    </div>

                
                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">إنشاء حساب</button>
                    </div>
                    <div class="col-12 text-end">
                      <p class="small mb-0">هل لديك حساب بالفعل؟ <a href="{{ route('auth.login') }}">تسجيل الدخول</a></p>
                    </div>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main>
  <!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

   <!-- Vendor JS Files -->
   <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
   <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
   <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
   <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
   <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
   <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
   <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
 
   <!-- Template Main JS File -->
   <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>