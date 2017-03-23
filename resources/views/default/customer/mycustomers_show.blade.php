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
                                    <dt>{{ trans('customer/fields.status') }}：</dt>
                                    <dd>{!! $customer->text_status !!}</dd>
                                    <dt>{{ trans('customer/fields.name') }}：</dt>
                                    <dd>{{ $customer->name }}</dd>
                                    <dt>{{ trans('customer/fields.company') }}：</dt>
                                    <dd>{{ $customer->company }}</dd>
                                    <dt>{{ trans('customer/fields.phone') }}：</dt>
                                    <dd>{{ $customer->phone }}</dd>
                                    <dt>{{ trans('customer/fields.email') }}：</dt>
                                    <dd>{{ $customer->email }}</dd>
                                    <dt>{{ trans('customer/fields.offer') }}：</dt>
                                    <dd>{{ $customer->offer }}</dd>
                                    <dt>{{ trans('customer/fields.developer') }}：</dt>
                                    <dd class="project-people">
                                        <a title="{{ $customer->developer->name }}">
                                            <img src="{{ $customer->developer->head_portrait }}" class="img-circle" alt="{{ $customer->developer->name }}">
                                            {{ $customer->developer->name }}
                                        </a>
                                    </dd>
                                    <dt>{{ trans('customer/fields.salesman') }}：</dt>
                                    <dd class="project-people">
                                    @if($customer->salesman)
                                        <a title="{{ $customer->salesman->name }}">
                                            <img src="{{ $customer->salesman->head_portrait }}" class="img-circle" alt="{{ $customer->salesman->name }}">
                                            {{ $customer->salesman->name }}
                                        </a>
                                    @else
                                        <span class="label label-warning">{{ trans('customer/list.not_assigned') }}</span>
                                    @endif
                                    </dd>
                                </dl>
                            </div>
                            <div id="cluster_info" class="col-sm-6">
                                <dl class="dl-horizontal">
                                    <dt>{{ trans('customer/fields.business_type') }}：</dt>
                                    <dd>{{ $customer->business_type }}</dd>
                                    <dt>{{ trans('customer/fields.business_origin') }}：</dt>
                                    <dd>{{ $customer->origin }}</dd>                                                                        
                                    <dt>{{ trans('customer/fields.province') }}：</dt>   
                                    <dd>{{ $customer->province }}</dd>
                                    <dt>{{ trans('customer/fields.city') }}：</dt>
                                    <dd>{{ $customer->city }}</dd>
                                    <dt>{{ trans('customer/fields.county') }}：</dt>
                                    <dd>{{ $customer->county }}</dd>
                                    <dt>{{ trans('customer/fields.detailed_address') }}：</dt>
                                    <dd>{{ $customer->address }}</dd>
                                    <dt>{{ trans('customer/fields.updated_at') }}：</dt>
                                    <dd>{{ $customer->updated_at }}</dd>
                                    <dt>{{ trans('customer/fields.created_at') }}：</dt>
                                    <dd>{{ $customer->created_at }}</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="panel blank-panel">
                            <h3>{{ trans('customer/fields.description') }}：</h3>
                            <p>
                                @if($customer->description)
                                    {{ $customer->description }}
                                @else
                                    {{ trans('customer/show.no_data') }}
                                @endif
                            </p>
                        </div>
                        @if(!Auth::user()->is_developer)
                        <button type="button" class="btn btn-primary btn-sm btn-block create-btn">
                            <i class="fa fa-envelope"></i> {{ trans('customer/show.establish') }}
                        </button>
                        @endif
                        <div class="row m-t-sm">
                            <div class="col-sm-12">
                                <div class="panel blank-panel">
                                    <div class="panel-heading">
                                        <div class="panel-options">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="project_detail.html#tab-1">{{ trans('customer/show.news') }}</a>
                                                </li>
                                                <li class=""><a data-toggle="tab" href="project_detail.html#tab-2">{{ trans('customer/show.projects') }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="panel-body">

                                        <div class="tab-content">
                                            <div id="tab-1" class="tab-pane active">
                                                <div class="feed-activity-list">
                                                @if($dynamics) 
                                                    @foreach($dynamics as $dynamic)
                                                    <div class="feed-element">
                                                        <a class="pull-left" href="profile.html#">
                                                            <img src="{{ $dynamic->user->head_portrait }}" class="img-circle" alt="{{ $dynamic->user->name }}">
                                                        </a>
                                                        <div class="media-body ">
                                                            <small class="pull-right">{{ $dynamic->created }}</small>
                                                            <strong>{{ $dynamic->status }}</strong>
                                                            <br>
                                                            <small class="text-muted">{{ $dynamic->created_at }} {{ trans('customer/show.from') }} {{ $dynamic->user->name }}</small>
                                                            <div class="well">{{ $dynamic->content }}</div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @else
                                                    <div class="middle-box text-center animated fadeInRightBig">
                                                        <h3 class="font-bold">{{ trans('customer/show.no_news') }}</h3>
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                            <div id="tab-2" class="tab-pane">
                                            @if($projects) 
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ trans('project/fields.status') }}</th>
                                                            <th>{{ trans('project/fields.name') }}</th>
                                                            <th>{{ trans('project/fields.start') }}</th>
                                                            <th>{{ trans('project/fields.end') }}</th>
                                                            <th>{{ trans('project/fields.deal_price') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($projects as $project)
                                                        <tr>
                                                            <td>{!! trans('project/fields.is_finish_val.'.$project->is_finish) !!}</td>
                                                            <td>{{ $project->name }}</td>
                                                            <td>{{ $project->start }}</td>
                                                            <td>{{ $project->end }}</td>
                                                            <td>
                                                                <p class="small">
                                                                    {{ $project->deal_price }}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                @else
                                                    <div class="middle-box text-center animated fadeInRightBig">
                                                        <h3 class="font-bold">{{ trans('customer/show.no_news') }}</h3>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection

@section('self_js')
<!-- 自定义js -->
<script src="/js/content.js?v=1.0.0"></script>
<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/js/plugins/suggest/bootstrap-suggest.min.js"></script>
<script>
$(function () {
    /*新建项目*/
    $('.create-btn').click(function () {
         var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
         parent.layer.full(index); 

         layer.open({
          type: 2,
          title: "{{ trans('project/list.create_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '650px'],
          offset: '8%',
          shift: 2,
          content: ["{{ url('projects/create/'.$customer->id) }}"],
        });
    })
});
</script>
@endsection
