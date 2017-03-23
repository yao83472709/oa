<?php
/*
|--------------------------------------------------------------------------
| 项目路由
|--------------------------------------------------------------------------
|
*/

Route::group(['middleware' => ['web']], function () {
	/*猪八戒采集数据*/
	Route::get('collection/getData','CollectionController@getData');
	Route::get('bajie/order/{type}','CollectionController@index');
	Route::get('bajie/notice/{type}','CollectionController@notice');
	Route::post('bajie/noticeUpdate','CollectionController@noticeUpdate');

	/*用户验证模块*/
	Route::group(['namespace' => 'auth'], function () {
		Route::get('login', 'AuthController@getLogin');
		Route::get('/logout', 'AuthController@getLogout');
		Route::post('/auth/login', 'AuthController@postLogin');
	});

	/*用户验证中间件*/
	Route::group(['middleware' => ['auth']], function () {
		/*视图*/
		Route::group(['namespace' => 'View'], function() {
			/*系统入口*/
			Route::resource('/','IndexController@index');
			/*首页*/
			Route::get('home','IndexController@home');
			/*权限*/
			Route::group(['namespace' => 'Roles'], function() {
				Route::resource('roles','RolesController');
				Route::get('permissions/{roleid}','PermissionsController@Distribution');				
			});
			/*评分等级*/
			Route::resource('marks','MarksController');
			/*用户模块*/			
			Route::group(['namespace' => 'Users'], function() {
				/*用户*/
				Route::resource('users','UsersController');
			});
			/*客户模块*/
			Route::group(['namespace' => 'Customers'], function() {
				/*客户*/
				Route::resource('customers','CustomersController');
				Route::get('mycustomers','CustomersController@myCustomers');
				Route::get('mycustomers_show/{id}','CustomersController@myCustomersShow');
				/*客户状态*/
				Route::resource('customerstatus','CustomerstatusController');
				/*业务类型*/
				Route::resource('businesstype','BusinessTypeController');
				/*业务来源*/
				Route::resource('businessorigin','BusinessOriginController');
				/*跟单申请*/
				Route::get('documentary/apply','DocumentaryController@Apply');				
				
			});			

			/*系统设置模块*/
			Route::group(['namespace' => 'System'], function() {
				Route::resource('sysconfig','SysConfigController');
				Route::resource('department','DepartmentController');
			});

			/*项目模块*/
			Route::group(['namespace'=>'Projects'], function(){
				/*项目状态*/
				Route::resource('workgrade','WorkGradeController');
				/*项目成员*/
				Route::resource('projectsmember','ProjectsMembersController');
				/*项目*/
				Route::resource('projects','ProjectsController');
				Route::get('projects/create/{customer_id}','ProjectsController@saleManCreate');
				/*下载项目文件*/
				Route::get('download/project/{project_id}/{department_id}','ProjectsViceController@downloadProjectFile');
				/*下载备案资料*/
				Route::get('download/record/{project_id}','ProjectsController@downloadRecordFile');
				/*下载开发资料*/
				Route::get('download/relevant/{project_id}','ProjectsController@downloadRelevantFile');
				/*任务*/
				Route::resource('works','WorkController');
				/*更改工单*/
				Route::resource('changes','ChangeController');
				/*完成*/
				Route::resource('completes','CompleteController');
				
			});

            //账务模块
            Route::group(['namespace'=>'Account'], function(){
                //项目账显示
                Route::resource('account/project','ProjectController');
                //流水账
                Route::resource('account/run','RunController');
                Route::resource('account/runtype','RunTypeController');
                Route::resource('account/salary','SalaryController');
                Route::resource('account','AccountController');
            });

		});


		/*接口*/
		Route::group(['namespace' => 'Service'], function() {
			/*权限*/
			Route::group(['namespace' => 'Roles'], function() {
				/*角色*/
				Route::post('roles/store','RolesController@store');
				Route::post('roles/update','RolesController@update');
				Route::post('roles/destroy','RolesController@destroy');
				/*权限*/
				Route::post('permissions/fill','PermissionsController@Fill');
			});
			/*员工*/
			Route::group(['namespace' => 'Users'], function() {
				Route::post('users/store','UsersController@store');
				Route::post('users/update','UsersController@update');
				Route::get('getsalesmans/{company_id}','UsersController@getSalesmans');
				Route::post('users/getdepartmentusers','UsersController@getUsersByDepartment');

			});	
			/*评分等级*/
			Route::post('marks/store','MarksController@store');
			Route::post('marks/update','MarksController@update');
			Route::post('marks/destroy','MarksController@destroy');
			/*客户模块*/
			Route::group(['namespace' => 'Customers'], function() {
				/*客户*/
				Route::post('customer/store','CustomersController@store');
				Route::post('customer/update','CustomersController@update');
				Route::post('customer/destroy','CustomersController@destroy');
				/*客户状态*/
				Route::post('customerstatus/store','CustomerstatusController@store');
				Route::post('customerstatus/update','CustomerstatusController@update');
				Route::post('customerstatus/destroy','CustomerstatusController@destroy');
				Route::post('customerstatus/sort','CustomerstatusController@sort');
				/*业务类型*/
				Route::post('businesstype/store','BusinessTypeController@store');
				Route::post('businesstype/update','BusinessTypeController@update');
				Route::post('businesstype/destroy','BusinessTypeController@destroy');
				Route::post('businesstype/sort','BusinessTypeController@sort');
				/*业务来源*/
				Route::post('businessorigin/store','BusinessOriginController@store');	
				Route::post('businessorigin/update','BusinessOriginController@update');
				Route::post('businessorigin/destroy','BusinessOriginController@destroy');
				Route::post('businessorigin/sort','BusinessOriginController@sort');
				/*客户操作记录*/
				Route::post('documentary/store','DocumentaryController@store');
				Route::post('documentary/distribution','DocumentaryController@Distribution');
				Route::post('documentary/dodistribution','DocumentaryController@doDistribution');
				/*客户动态记录*/
				Route::post('customersdynamic/store','CustomersDynamicController@store');
			});

			/*项目模块*/
			Route::group(['namespace' => 'Projects'], function() {
				/*项目成员*/
				Route::post('projects/members/store','ProjectsMembersController@store');
				Route::post('projects/members/update','ProjectsMembersController@update');				
				Route::post('projects/members/leader','ProjectsMembersController@addLeadr');				
				Route::post('projects/members/replace','ProjectsMembersController@replace');				
				Route::post('projects/members/destroy','ProjectsMembersController@destroy');
				/*项目详细信息*/
				Route::post('projects/vice/update','ProjectsViceController@update');
				/*项目*/
				Route::post('projects/store','ProjectsController@store');
				Route::post('projects/update','ProjectsController@update');
				Route::post('projects/destroy','ProjectsController@destroy');
				/*任务等级*/
				Route::post('workgrade/store','WorkGradeController@store');
				Route::post('workgrade/update','WorkGradeController@update');
				Route::post('workgrade/destroy','WorkGradeController@destroy');
				Route::post('workgrade/sort','WorkGradeController@sort');
			});


			/*系统设置模块*/
			Route::group(['namespace' => 'System'], function() {
				/*系统配置*/
				Route::resource('sysconfig/update','SysConfigController@update');				
				/*部门*/
				Route::post('department/store','DepartmentController@store');
				Route::post('department/update','DepartmentController@update');
				Route::post('department/destroy','DepartmentController@destroy');
				Route::post('department/sort','DepartmentController@sort');
			});

			/*获取地区*/
			Route::post('area/getarea','AreaController@getArea');
			/*文件上传与管理*/
			Route::post('files/upload','UploadController@fileUpload');			

            //账务模块
            Route::group(['namespace'=>'Account'], function(){
                //项目账显示
                Route::post('account/project/create','ProjectController@create');
                Route::post('account/project/getproject','ProjectController@getProject');
                Route::post('account/project/getprojectid','ProjectController@getProjectArr');
                Route::post('account/project/getprojectid','ProjectController@getProjectArr');
                Route::post('account/project/getAccountProject','ProjectController@getAccountProject');
                Route::post('account/run/create','RunController@create');
                Route::post('account/runtype/create','RunTypeController@create');
                Route::post('account/runtype/edit','RunTypeController@edit');
                Route::post('account/runtype/destroy','RunTypeController@destroy');
                Route::post('account/runtype/systype','RunTypeController@get_sys_type');
                Route::post('account/type','TypeController@getTppe');
                Route::post('account/salary/reward','SalaryController@reward');
                Route::post('account/salary/deduct','SalaryController@deduct');
                Route::post('account/salary','SalaryController@index');
                Route::post('account/account/create','AccountController@create');
            });

		});
		
	});

});




