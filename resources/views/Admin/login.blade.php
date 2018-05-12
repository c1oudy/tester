<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/vue.js') }}"></script>
    <title>Document</title>
</head>
<body>
    <div id="login">
        <img class="loginbg" src="{{ asset('image/loginbg.jpg') }}" alt="">
        <div class="login-box">
            <div class="title">后台管理登录</div>
            <hr>
            <div class="content">
                <form action="{{ action('Admin\LoginController@checklogin') }}" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <p><span>账号:</span><input placeholder="请输入账号" type="text" name="username"></p>
                    @if($errors->has('username'))
                        <p><span></span><span class="error">{{ $errors->first('username') }}</span></p>
                    @endif
                    <p><span>密码:</span><input placeholder="请输入密码" type="text" name="password"></p>
                    @if($errors->has('password'))
                        <p><span></span><span class="error">{{ $errors->first('password') }}</span></p>
                    @endif
                    <p><span>验证码:</span><input placeholder="请输入验证码" type="text" name="captcha"></p>
                    <p>
                        <span></span><img src="{{ captcha_src('default') }}" onclick="this.src='{{captcha_src()}}'+Math.random()" alt="">
                    </p>
                    @if($errors->has('captcha'))
                        <p><span></span><span class="error">{{ $errors->first('captcha') }}</span></p>
                    @endif
                    @if($errors->has('loginstatu'))
                        <p><span></span><span class="error">{{ $errors->first('loginstatu') }}</span></p>
                    @endif
                    <p><input align="right" type="submit" id="logbtn" value="登录"></p>
                </form>
            </div>
        </div>
    </div>

</body>
<script>
    
</script>
</html>