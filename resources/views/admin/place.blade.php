@extends('layouts.app_admin')

@section('content')
    <div class="container">
        <h2>停留所管理</h2>
        <hr>
        <div class="panel panel-primary" id="editPlacePanel" style="display:none;">
            <div class="panel-heading">
                停留所編集 <span class="pull-right glyphicon glyphicon-remove" id="closePanel"></span>
            </div>
            <form action="{{url('/api/v1/admin/place')}}" method="put" class="form-horizontal" id="editPlace">
                <div class="panel-body">
                    <label>停留所名</label>
                    <input type="hidden" class="form-control" id="place_id" name="place_id" placeholder="停留所名">
                    <input type="text" class="form-control" id="place_name" name="place_name" placeholder="停留所名">
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-info">登録</button>
                </div>
            </form>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p>停留所情報</p>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <thead>
                        <th>停留所名</th>
                        <th>Action</th>
                        </thead>
                        <tbody id="PlaceList"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    停留所登録
                </div>
                <form action="{{url('/api/v1/admin/place')}}" method="post" class="form-horizontal" id="addPlace">
                    <div class="panel-body">
                        <label>停留所名</label>
                        <input type="text" class="form-control" id="place_name" name="place_name" placeholder="停留所名">
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-info">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        getPlace();
        function getPlace(){
            $.ajax({
                type: 'get',
                url: '/api/v1/admin/place',
                dataType: 'json',
                success: function (data) {
                    $('#PlaceList').empty();
                    var placetable = '';
                    data.forEach(function(place){
                        placetable = placetable + '<tr><td>'+place.name+'</td><td><button class="btn btn-default" onclick="editPlace(\''+place.id+'\')">変更</button>&nbsp;<button class="btn btn-danger" onclick="deletePlace(\''+place.id+'\')">削除</button></td></tr>';
                        $('#PlaceList').html(placetable);
                    });
                }
            });
        }
        $(function() {
           $('#closePanel').click(function (event) {
               $('#editPlacePanel').hide('normal');
           });
        });

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#editPlace').submit(function (event) {
                // HTMLでの送信をキャンセル
                event.preventDefault();

                // 操作対象のフォーム要素を取得
                var $form = $(this);

                // 送信ボタンを取得
                // （後で使う: 二重送信を防止する。）
                var $button = $form.find('button');
                // 送信
                $.ajax({
                    url: $form.attr('action') + '/' + $('#editPlace').children().children('#place_id').val(),
                    type: 'PUT',
                    dataType: 'json',
                    data: JSON.stringify({
                        name: $('#editPlace').children().children('#place_name').val(),
                    }),
                    timeout: 10000,  // 単位はミリ秒

                    // 送信前
                    beforeSend: function (xhr, settings) {
                        // ボタンを無効化し、二重送信を防止
                        $button.attr('disabled', true);
                    },
                    // 応答後
                    complete: function (xhr, textStatus) {
                        // ボタンを有効化し、再送信を許可
                        $button.attr('disabled', false);
                    },

                    // 通信成功時の処理
                    success: function (result, textStatus, xhr) {
                        console.log('edit done');
                        $('#editPlace').children().children('#place_id').val("");
                        $('#editPlace').children().children('#place_name').val("");
                        $('#editPlacePanel').hide('normal');
                        getPlace();
                    },

                    // 通信失敗時の処理
                    error: function (xhr, textStatus, error) {
                        console.log('error edit action');
                    }
                });
            });

            $('#addPlace').submit(function (event) {
                // HTMLでの送信をキャンセル
                event.preventDefault();

                // 操作対象のフォーム要素を取得
                var $form = $(this);

                // 送信ボタンを取得
                // （後で使う: 二重送信を防止する。）
                var $button = $form.find('button');
                // 送信
                $.ajax({
                    url: $form.attr('action'),
                    type: $form.attr('method'),
                    dataType: 'json',
                    data: JSON.stringify({
                        name: $('#addPlace').children().children('#place_name').val(),
                    }),
                    timeout: 10000,  // 単位はミリ秒

                    // 送信前
                    beforeSend: function (xhr, settings) {
                        // ボタンを無効化し、二重送信を防止
                        $button.attr('disabled', true);
                    },
                    // 応答後
                    complete: function (xhr, textStatus) {
                        // ボタンを有効化し、再送信を許可
                        $button.attr('disabled', false);
                    },

                    // 通信成功時の処理
                    success: function (result, textStatus, xhr) {
                        console.log('add done');
                        $('#addPlace').children().children('#place_name').val("");
                        getPlace();
                    },

                    // 通信失敗時の処理
                    error: function (xhr, textStatus, error) {
                        console.log('error add action');
                    }
                });
            });
        });

        function editPlace(id) {
            $.ajax({
                type: 'get',
                url: '/api/v1/admin/place/' + id,
                dataType: 'json',
                data: JSON.stringify({}),
                timeout: 10000,  // 単位はミリ秒

                success: function (data){
                    $('#editPlacePanel').show('normal');
                    $('#editPlace').children().children('#place_id').val(data.id);
                    $('#editPlace').children().children('#place_name').val(data.name);
                },
                // 通信失敗時の処理
                error: function (xhr, textStatus, error) {
                    console.log('error editData action');
                }
            });
        }

        function deletePlace(id) {
            if(!confirm('削除します\nよろしいですか？')) {
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'delete',
                url: '/api/v1/admin/place/' + id,
                dataType: 'json',
                data: JSON.stringify({}),
                timeout: 10000,  // 単位はミリ秒

                success: function (data){
                    getPlace();
                },
                // 通信失敗時の処理
                error: function (xhr, textStatus, error) {
                    console.log('error delete action');
                }
            });
        }
    </script>
@endsection