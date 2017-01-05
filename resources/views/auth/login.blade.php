@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">ログイン</div>
                <div class="panel-body">
                    <a href="{{url('/login/yahoo/')}}"><img src="https://s.yimg.jp/images/login/btn/btn_login_a_196.png" width="196" height="38" alt="Yahoo! JAPAN IDでログイン" border="0"></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
