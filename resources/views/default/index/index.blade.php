@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('content')
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
    <div id="wrapper">
        <!--左侧导航开始-->
        @include($cfg_style.'.partials.navbar')
        <!--左侧导航结束-->

        <!--右侧部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <!--右侧顶部部分结束-->
            @include($cfg_style.'.partials.top')
            <!--右侧顶部部分开始-->
            <div class="row J_mainContent" id="content-main">
                <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="{{ url('home') }}" frameborder="0" data-id="index_v1.html" seamless>
                    
                </iframe>
            </div>
            <!--右侧底部部分结束-->
            @include($cfg_style.'.partials.bottom')
            <!--右侧底部部分开始-->
        </div>
        <!--右侧部分结束-->

        <!--右侧边栏开始-->
        @include($cfg_style.'.partials.right')
        <!--右侧边栏结束-->

        <!--mini聊天窗口开始-->
        @include($cfg_style.'.partials.chat_box')
        <!--mini聊天窗口结束-->
    </div>
</body>
@endsection

@section('self_js')
<script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<!-- 自定义js -->
<script src="/js/hplus.js?v=4.1.0"></script>
<script type="text/javascript" src="/js/contabs.js"></script>
<!-- 第三方插件 -->
<script src="/js/plugins/pace/pace.min.js"></script>
@endsection
