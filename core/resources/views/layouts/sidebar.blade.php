<nav class="mt-2 sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


      @php
          if(Auth::check()){
            $user_permissions = Session::get('user_permissions');              
            $role = Auth::user()->role;  
          }
          else
          {
            $user_permissions[0] = array();
            $role = 0;
          }
          //If table not included
          
          /* Debugging Perpose only
          if(empty($user_permissions[0])) 
          {
            $user_permissions[0] = array('users.index', 'users.create', 
                  'role.index', 'role.create', 
                  'template.index', 'template.create',
                  'glass.index', 'glass.create', 
                  'hardwareitem.index', 'hardwareitem.create', 'hardwarecategory.index', 'hardwarecategory.create',
                  'miter.index', 'miter.create', 
                  'oversize.edit', 'fabrication.edit', 'report.index'
                  );
          }*/
      @endphp  
      
      @if(in_array('home', $user_permissions[0]))            
			<li class="nav-item">
				<a href="{{route('home')}}" class="nav-link">
				  <i class="mdi mdi-home menu-icon"></i>
				  <p class="menu-title main-menu-title">Dashboard</p>
				</a>
      </li>
      @endif
	  
	  @if($role == 1)
		  <li class="nav-item has-treeview {{Route::currentRouteName() == 'role.index' || Route::currentRouteName() == 'role.create' || Route::currentRouteName() == 'role.edit' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{Route::currentRouteName() == 'role.index' || Route::currentRouteName() == 'role.create' || Route::currentRouteName() == 'role.edit' ? 'changecolor active' : '' }}">
              <i class="mdi mdi-directions menu-icon"></i>
              <p class="menu-title main-menu-title">Role Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a class="nav-link {{Route::currentRouteName() == 'role.index' ? 'changecolor active' : '' }}" href="{{route('role.index')}}">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>  View All Roles</p>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{Route::currentRouteName() == 'role.create' ? 'changecolor active' : '' }}" href="{{route('role.create')}}">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p> Add Role</p>
                </a>
              </li>
            </ul>
          </li>
      @endif
	  
	  @if(in_array('company.index', $user_permissions[0]) || 
          in_array('company.create', $user_permissions[0]) )      
      <li class="nav-item has-treeview {{Route::currentRouteName() == 'company.index' || Route::currentRouteName() == 'company.create' || Route::currentRouteName() == 'role.edit' ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{Route::currentRouteName() == 'company.index' || Route::currentRouteName() == 'company.create' || Route::currentRouteName() == 'role.edit' ? 'changecolor active' : '' }}">
          <i class="mdi mdi-microsoft menu-icon"></i>
          <p class="menu-title">Company Management
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          @if(in_array('company.index', $user_permissions[0]))
          <li class="nav-item">
            <a class="nav-link {{Route::currentRouteName() == 'company.index' ? 'changecolor active' : '' }}" href="{{route('company.index')}}">
              <i class="fa fa-arrow-right nav-icon"></i>
              View All Companies
            </a>
          </li>
          @endif

          @if(in_array('company.create', $user_permissions[0]))
          <li class="nav-item">
            <a class="nav-link {{Route::currentRouteName() == 'company.create' ? 'changecolor active' : '' }}" href="{{route('company.create')}}">
              <i class="fa fa-arrow-right nav-icon"></i>
              Add Company
            </a>
          </li>
          @endif
        </ul>
      </li>
      @endif
     

      @if(in_array('users.index', $user_permissions[0]) || 
          in_array('users.create', $user_permissions[0]) )
          <li class="nav-item has-treeview {{Route::currentRouteName() == 'users.index' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{Route::currentRouteName() == 'users.index' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'changecolor active' : '' }}">
              <i class="mdi mdi-account menu-icon"></i>
              <p class="menu-title main-menu-title">Users Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(in_array('users.index', $user_permissions[0]))  
              <li class="nav-item">
                <a class="nav-link {{Route::currentRouteName() == 'users.index' ? 'changecolor active' : '' }}" href="{{route('users.index')}}">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>View All Users</p>
                </a>
              </li>
              @endif

              @if(in_array('users.create', $user_permissions[0])) 
              <li class="nav-item">
                <a class="nav-link {{Route::currentRouteName() == 'users.create' ? 'changecolor active' : '' }}" href="{{route('users.create')}}">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
      @endif
	  
	  
	  @if(in_array('testtype.index', $user_permissions[0]) || 
          in_array('testtype.create', $user_permissions[0]) )
          <li class="nav-item has-treeview {{Route::currentRouteName() == 'testtype.index' || Route::currentRouteName() == 'testtype.create' || Route::currentRouteName() == 'testtype.edit' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{Route::currentRouteName() == 'testtype.index' || Route::currentRouteName() == 'testtype.create' || Route::currentRouteName() == 'testtype.edit' ? 'changecolor active' : '' }}">
              <i class="mdi mdi-account menu-icon"></i>
              <p class="menu-title main-menu-title">Test Type Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(in_array('testtype.index', $user_permissions[0]))  
              <li class="nav-item">
                <a class="nav-link {{Route::currentRouteName() == 'testtype.index' ? 'changecolor active' : '' }}" href="{{route('testtype.index')}}">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>View All Test Types</p>
                </a>
              </li>
              @endif

              @if(in_array('testtype.create', $user_permissions[0])) 
              <li class="nav-item">
                <a class="nav-link {{Route::currentRouteName() == 'testtype.create' ? 'changecolor active' : '' }}" href="{{route('testtype.create')}}">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Add Test Type Method</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
      @endif
	  
	  
	  @if(in_array('sample.index', $user_permissions[0]) || 
          in_array('sample.create', $user_permissions[0]) )
          <li class="nav-item has-treeview {{Route::currentRouteName() == 'sample.index' || Route::currentRouteName() == 'sample.create' || Route::currentRouteName() == 'sample.edit' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{Route::currentRouteName() == 'sample.index' || Route::currentRouteName() == 'sample.create' || Route::currentRouteName() == 'sample.edit' ? 'changecolor active' : '' }}">
              <i class="mdi mdi-account menu-icon"></i>
              <p class="menu-title main-menu-title">Sample Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(in_array('sample.index', $user_permissions[0]))  
              <li class="nav-item">
                <a class="nav-link {{Route::currentRouteName() == 'sample.index' ? 'changecolor active' : '' }}" href="{{route('sample.index')}}">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>View All Samples</p>
                </a>
              </li>
              @endif

              @if(in_array('sample.create', $user_permissions[0])) 
              <li class="nav-item">
                <a class="nav-link {{Route::currentRouteName() == 'sample.create' ? 'changecolor active' : '' }}" href="{{route('sample.create')}}">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Add Sample</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
      @endif
	  
	  @if(in_array('sampleassignment.index', $user_permissions[0]))
		  <li class="nav-item">
				<a href="{{route('sampleassignment.index')}}" class="nav-link">
					<i class="mdi mdi-home menu-icon"></i>
					<p class="menu-title main-menu-title">Sampleassignment Page</p>
				</a>
		  </li>
      @endif
	  
	  
	  @if(in_array('rowpdfgenerate.index', $user_permissions[0]))
		  <li class="nav-item">
				<a href="{{route('rowpdfgenerate.index')}}" class="nav-link">
					<i class="mdi mdi-home menu-icon"></i>
					<p class="menu-title main-menu-title">Rowpdf Generate Page</p>
				</a>
		  </li>
      @endif
	  
	  @if(in_array('testcertification.index', $user_permissions[0]))
		  <li class="nav-item">
				<a href="{{route('testcertification.index')}}" class="nav-link">
					<i class="mdi mdi-home menu-icon"></i>
					<p class="menu-title main-menu-title">Test Certification Page</p>
				</a>
		  </li>
      @endif
	  
	  @if(in_array('reviewsample.index', $user_permissions[0]))
		  <li class="nav-item">
				<a href="{{route('reviewsample.index')}}" class="nav-link">
					<i class="mdi mdi-home menu-icon"></i>
					<p class="menu-title main-menu-title">Review And Finalise Page</p>
				</a>
		  </li>
      @endif
        </ul>
</nav>