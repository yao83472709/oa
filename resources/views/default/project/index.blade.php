@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('self_head')

@endsection

@section('content')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                 @if($projects)
                    <div class="ibox-title">
                        <h5>{{ trans('project/list.page_title') }}</h5>
                        <div class="ibox-tools">
                            <a class="btn btn-primary btn-xs create-btn">{{ trans('project/list.create_title') }}</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-1">
                                <button class="btn btn-white btn-sm refresh-link" id="loading-example-btn" type="button">
                                    <i class="fa fa-refresh"></i> {{ trans('project/list.refresh') }}
                                </button>
                            </div>
                            <div class="col-md-11">
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" placeholder="{{ trans('project/list.placeholder') }}"> 
                                    <span class="input-group-btn">
                                        <button class="btn btn-sm btn-primary" type="button">
                                            <i class="fa fa-search"></i> {{ trans('project/list.search') }}
                                        </button> 
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="clients-list">
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th data-toggle="true">{{ trans('project/fields.number') }}</th>
                                                    <th>{{ trans('project/fields.name') }}</th>
                                                    <th>{{ trans('project/fields.company') }}</th>
                                                    <th>{{ trans('project/fields.type') }}</th>
                                                    <th>{{ trans('project/fields.salesman') }}</th>
                                                    <th>{{ trans('project/fields.status') }}</th>
                                                    <th>{{ trans('project/fields.created_at') }}</th>
                                                    <th>{{ trans('common.action') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($projects as $project)
                                                    <tr>
                                                    	<td >{{ $project->number }}</td>                                                   
                                                        <td >{{ $project->name }}</td>
                                                        
                                                        @if($project->customer)
                                                        <td>{{ $project->customer->company }}</td>
                                                        <td>{{ $project->type }}</td>
                                                        <td >
                                                            @if(isset($project->salesman))
                                                            <a data-id="{{ $project->salesman->id }}" class="client-link client-avatar">
                                                                <img alt="image" src="{{ $project->salesman->head_portrait }}">
                                                                {{ $project->salesman->name }}
                                                            </a>
                                                            @endif  
                                                        </td>
                                                        @else
                                                        <td>{!! trans('common.no_data') !!}</td>
                                                        <td>{!! trans('common.no_data') !!}</td>
                                                        <td>{!! trans('common.no_data') !!}</td>
                                                        @endif                                                         
                                                        <td class="client-status">
                                                        @if($project->status)
                                                        <span class="label label-primary">{{ $project->status }}</span>
                                                        @else
                                                        {!! trans('common.no_data') !!}
                                                        @endif
                                                        </td>
                                                        <td >{{ $project->created_at }}</td>
                                                        <td class="tooltip-demo">
                                                        @if(Auth::user()->level() >1 &&  Auth::user()->is_salesman || Auth::user()->level() > 2 )
                                                            <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm edit_btn" data-original-title="{{ trans('project/list.edit') }}" data-id="{{$project->id}}">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        @endif
                                                            <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm more_btn" data-original-title="{{ trans('project/list.more') }}" data-id="{{$project->id}}" data-isapply="{{ $project->isapply }}">
                                                                <i class="fa fa-user"></i>
                                                            </button>                                                
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="12" class="footable-visible">
                                                        {!! $projects->render() !!}
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                @else
                    <div class="middle-box text-center animated fadeInRightBig">
                        <h3 class="font-bold">{{ trans('project/list.no_data') }}</h3>
                        <div class="error-desc">
                            {{ trans('project/list.no_data_tip') }}
                            <br><a class="btn btn-primary m-t create-btn" >{{ trans('project/list.create') }}</a>
                        </div>
                    </div>
                @endif
                </div>
            </div>
            
        </div>
    </div>
</body>
@endsection

@section('self_js')
<!-- 自定义js -->
<script src="/js/content.js?v=1.0.0"></script>
<script src="/js/plugins/suggest/bootstrap-suggest.min.js"></script>
<script>
$(function () {
    /*查看详情*/
    $('.more_btn').click(function () {
        var project_id = $(this).attr('data-id')
        layer.open({
          type: 2,
          title: "{{ trans('project/list.details') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['900px', '650px'],
          offset: '8%',
          shift: 2,
          content: ["{{ url('projects') }}/"] + project_id,
        });
    })
    /*新建项目*/
    $('.create-btn').click(function () {
         layer.open({
          type: 2,
          title: "{{ trans('project/list.create_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '650px'],
          offset: '8%',
          shift: 2,
          content: ["{{ url('projects/create') }}"],
        });
    })

    $('.edit_btn').click(function() {
        var projectid = $(this).attr('data-id')
        //iframe窗
        layer.open({
          type: 2,
          title: "{{ trans('project/list.edit_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '520px'],
          offset: '8%',
          shift: 2,
          content: ['projects/'+projectid+'/edit'], //iframe的url
        });
    })
});
</script>
@endsection


