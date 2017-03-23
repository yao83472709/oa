    /*页面加载时获取默认选中的省份并获取市与区*/
    var reid = $('select[name=province] option:selected').val();
    getcity(reid,'city');

    /*当省级菜单改变时获取市与区*/
    $('select[name=province]').change(function () {
       var reid = $(this).val();
       getcity(reid,'city');
    })
    /*当市级菜单改变时获取区*/
    $('select[name=city]').change(function () {
       var reid = $(this).val();
       getcity(reid,'county');
    })

    function getcity(reid,type) {
       var nodes= '';
       $.post("/area/getarea",
          {reid:reid,_token:$('input[name=_token]').val()}, 
          function(result){
             $.each(result,function(n,value) {
                nodes += "<option value="+n+">"+value+"</option>";
             });
             if(type == 'city') {
                $('select[name=city]').html(nodes);
                reid = $('select[name=city] option:selected').val();
                getcity(reid,'county')
                
             }
             if(type == 'county') {
                $('select[name=county]').html(nodes);
             } 
          }
       );
       
    }
