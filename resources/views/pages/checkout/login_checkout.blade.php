@extends('welcome')
@section('content')

<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <?php
                    $message = Session::get('message');
                    if($message)
                    {
                        echo '<span class="text-alert" style="color: red; width: 100%; text-align: center;">'.$message.'</span>';
                        Session::put('message', null);
                    }
                ?>
                <div class="login-form"><!--login form-->
                    <h2>Đăng nhập tài khoản</h2>
                    <form action="{{ URL::to('/login-checkout-customer') }}" method="post">
                        {{ csrf_field() }}
                        <input type="text" name="email_account" placeholder="Email" />
                        <input type="password" name="password_account" placeholder="Password" />
                        <span>
                            <input type="checkbox" class="checkbox"> 
                            Ghi nhớ đăng nhập
                        </span>

                        <span>
                            <a href="{{ url('/quen-mat-khau') }}">Quên mật khẩu</a>
                        </span>
                        <button type="submit" class="btn btn-default">Đăng nhập</button>
                    </form>

                    <style>
                        ul.list-login
                        {
                            margin: 10px;
                            padding: 0;
                        }
                        ul.list-login li
                        {
                            display: inline;
                            margin: 5px;
                        }
                    </style>
                    <ul class="list-login">
                        <li><a href="{{ url('login-customer-google') }}"><img width="10%" src="{{ asset('frontend/images/gg.png') }}" alt="Đăng nhập bằng tài khoản google"></a></li>

                        <li><a href="{{ url('login-customer-facebook') }}"><img width="10%" src="{{ asset('frontend/images/fb.png') }}" alt="Đăng nhập bằng tài khoản facebook"></a></li>
                    </ul>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">Hoặc</h2>
            </div>
            <div class="col-sm-4">
                <?php
                    $message = Session::get('message');
                    if($message)
                    {
                        echo '<span class="text-alert" style="color: green; width: 100%; text-align: center;">'.$message.'</span>';
                        Session::put('message', null);
                    }
                ?>
                <div class="signup-form"><!--sign up form-->
                    <h2>Đăng ký</h2>
                    <form action="{{ URL::to('/add-customer') }}" method="post">
                        {{ csrf_field() }}
                        <input type="text" name="customer_name" placeholder="Name"/>
                        <input type="email" name="customer_email" placeholder="Email Address"/>
                        <input type="password" name="customer_password" placeholder="Password"/>
                        <input type="text" name="customer_phone" placeholder="Phone"/>

                        {{-- <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
                        <br/>
                        @if($errors->has('g-recaptcha-response'))
                        <span class="invalid-feedback" style="display:block">
                            <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                        </span>
                        @endif --}}

                        <button type="submit" class="btn btn-default">Đăng ký</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->

@endsection