@extends('layout.main')

@section('title', '登录商城')
@section('body')
<!-- 登录主体部分start -->
<div class="login w990 bc mt10">
    <div class="login_hd">
        <h2>用户登录</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            @if(count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="/login" method="post">
                <ul>
                    <li>
                        <label for="">用户名：</label>
                        <input type="text" class="txt" name="username" />
                    </li>
                    <li>
                        <label for="">密码：</label>
                        <input type="password" class="txt" name="password" />
                        <a href="">忘记密码?</a>
                    </li>
                    <li class="checkcode">
                        <label for="">验证码：</label>
                        <input type="text"  name="checkcode" />
                        <img id="check_captcha" src="/captcha" alt="" />
                        <span>看不清？<a href="Javascript:change_captcha();">换一张</a></span>
                    </li>
                    <li>
                        <label for="">&nbsp;</label>
                        <input type="checkbox" class="chb"  /> 保存登录信息
                    </li>
                    <li>
                        <label for="">&nbsp;</label>
                        {{csrf_field()}}
                        <input type="submit" value="" class="login_btn" />
                    </li>
                </ul>
            </form>

            <div class="coagent mt15">
                <dl>
                    <dt>使用合作网站登录商城：</dt>
                    <dd class="qq"><a href=""><span></span>QQ</a></dd>
                    <dd class="weibo"><a href=""><span></span>新浪微博</a></dd>
                    <dd class="yi"><a href=""><span></span>网易</a></dd>
                    <dd class="renren"><a href=""><span></span>人人</a></dd>
                    <dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
                    <dd class=""><a href=""><span></span>百度</a></dd>
                    <dd class="douban"><a href=""><span></span>豆瓣</a></dd>
                </dl>
            </div>
        </div>

        <div class="guide fl">
            <h3>还不是商城用户</h3>
            <p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>

            <a href="regist.html" class="reg_btn">免费注册 >></a>
        </div>

    </div>
</div>
<script>
    function change_captcha(){
        var obj = document.getElementById("check_captcha");
        obj.src = '/captcha?'+Math.random();
    }
</script>
<!-- 登录主体部分end -->
@endsection
