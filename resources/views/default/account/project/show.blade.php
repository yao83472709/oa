@extends($cfg_style.'.layouts.master')
@section('title',$cfg_company.'_'.$cfg_webname)
@section('content')
    <body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ trans('account\fields.project.type_project_show') }}</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="12">
                            <thead>
                            <tr>
                                <th >{{ trans('account\fields.project.form.stage') }}</th>
                                <th>{{ trans('account\fields.project.form.price') }}</th>
                                <th>{{ trans('account\fields.project.form.time') }}</th>
                                <th>{{ trans('account\fields.project.form.examine_time') }}</th>
                                <th>{{ trans('account\fields.project.form.examine_user') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($datas as $data)
                                <tr>
                                    <td>{{ $data->stage }}</td>
                                    <td>@if(!empty($data->price)){{ trans('account\common.money_sign') }}{{ $data->price }}@endif</td>
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