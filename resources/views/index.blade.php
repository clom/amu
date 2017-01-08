@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-info">
            <div class="panel-heading">
                <p>Information.</p>
            </div>
            <div class="panel-body">
                <p>Welcomte to Amu System</p>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    出発時刻(Departing Time)
                </div>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <thead>
                            <th>停留所(Bus Stop)</th>
                            <th>出発時刻(Dep. time)</th>
                        </thead>
                        <tbody id="deptime">
                            <tr><td class="info" colspan="2">本日の運用は終了致しました。</td></tr>
                        </tbody>
                    </table>
                    <label>到着予定時刻 (Arrival Time)</label>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Service Status
                </div>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <thead>
                            <th>サービス名</th>
                            <th>稼働状況</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection