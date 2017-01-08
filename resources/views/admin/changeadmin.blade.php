@extends('layouts.app_admin')

@section('content')
    <div class="container">
        <h2>管理者管理</h2>
        <hr>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p>管理者情報</p>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Mail</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="UserList"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-2">
        </div>
    </div>
    <script>
        getUser();
        function getUser() {
            $.ajax({
                type: 'get',
                url: '/api/v1/admin/permission',
                dataType: 'json',
                success: function (data) {
                    $('#UserList').empty();
                    var usertable = '';
                    data.forEach(function(user){
                        usertable = usertable + '<tr><td>'+user.id+'</td><td>'+user.name+'</td><td>'+user.email+'</td><td>'+ (user.is_admin? '管理者' : '非管理者') +'</td><td><button class="btn btn-default" onclick="switchUser('+user.id+')">変更</button></td></tr>';
                        $('#UserList').html(usertable);
                    });
                }
            });
        }

        function switchUser(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/api/v1/admin/permission/'+id,
                type: 'PUT',
                dataType: 'json',
                timeout: 10000,  // 単位はミリ秒

                // 送信前
                beforeSend: function (xhr, settings) {
                },
                // 応答後
                complete: function (xhr, textStatus) {
                },
                // 通信成功時の処理
                success: function (result, textStatus, xhr) {
                    console.log('update done.')
                    getUser();
                },

                // 通信失敗時の処理
                error: function (xhr, textStatus, error) {
                    console.log('miss update');
                }
            });
        }

    </script>
@endsection