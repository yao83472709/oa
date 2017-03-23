@extends($httpView.'.layouts.master')
@section('title')
    {{ $httpTitle }}
@endsection
@section('content')
    <body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ trans('fields.account.type_project_show') }}</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="12">
                            <thead>
                            <tr>
                                <th >{{ trans('fields.account.form.stage') }}</th>
                                <th>{{ trans('fields.account.form.price') }}</th>
                                <th>{{ trans('fields.account.form.time') }}</th>
                                <th>{{ trans('fields.account.form.examine_time') }}</th>
                                <th>{{ trans('fields.account.form.examine_user') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($datas as $data)
                                <tr>
                                    <td>{{ $data->stage }}</td>
                                    <td>{{ $data->price }}</td>
                                    <td>{{ $data->price_time }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    <td>{{ $data->user_name }}</td>
                                </tr>
                            @endforeach


                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="8">
                                    <ul class="pagination pull-right"></ul>
                                </td>
                            </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
@endsection