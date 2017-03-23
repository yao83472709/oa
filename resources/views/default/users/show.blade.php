@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('self_head')

@endsection

@section('content')
<body class="gray-bg">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox ">
            <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <dl class="dl-horizontal">                                
                                    <dt>{{ trans('fields.common.status') }}：</dt>
                                    <dd>{!! $customer->text_status !!}</dd>
                                    <dt>{{ trans('fields.customer.name') }}：</dt>
                                    <dd>{{ $customer->name }}</dd>
                                    @if(!$customer->lose)
                                    <dt>{{ trans('fields.customer.company') }}：</dt>
                                    <dd>{{ $customer->company }}</dd>
                                    @endif
                                    <dt>{{ trans('fields.customer.developer') }}：</dt>
                                    <dd class="project-people">
                                        <a title="{{ $customer->developer->name }}">
                                            <img src="{{ $customer->developer->head_portrait }}" class="img-circle" alt="{{ $customer->developer->name }}">
                                            {{ $customer->developer->name }}
                                        </a>
                                    </dd>
                                    <dt>{{ trans('fields.customer.salesman') }}：</dt>
                                    <dd class="project-people">
                                    @if($customer->salesman)
                                        <a title="{{ $customer->salesman->name }}">
                                            <img src="{{ $customer->salesman->head_portrait }}" class="img-circle" alt="{{ $customer->salesman->name }}">
                                        </a>
                                    @else
                                        <span class="label label-warning">{{ trans('list.customer.not_assigned') }}</span>
                                    @endif
                                    </dd>
                                </dl>
                            </div>
                            <div id="cluster_info" class="col-sm-6">
                                <dl class="dl-horizontal">
                                    <dt>{{ trans('fields.customer.business_type') }}：</dt>
                                    <dd>{{ $customer->business_type }}</dd>
                                    <dt>{{ trans('fields.customer.business_origin') }}：</dt>
                                    <dd>{{ $customer->origin }}</dd>                                                                        
                                    <dt>{{ trans('fields.common.updated_at') }}：</dt>
                                    <dd>{{ $customer->updated_at }}</dd>
                                    <dt>{{ trans('fields.common.created_at') }}：</dt>
                                    <dd>{{ $customer->created_at }}</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="panel blank-panel">
                            <h3>{{ trans('fields.common.description') }}：</h3>
                            <p>
                                @if($customer->description)
                                    {{ $customer->description }}
                                @else
                                    {{ trans('show.common.no_data') }}
                                @endif
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
