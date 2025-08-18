    @if(auth()->user()->hasRole('admin')|| auth()->user()->hasRole('manager'))
          <aside class="main-sidebar sidebar-dark-primary elevation-4">
    @else
            <aside class="main-sidebar sidebar-light-primary elevation-4">
    @endif
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      @if(auth()->user()->profile_image)
      <img src="{{ asset('storage/'. auth()->user()->profile_image) }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      @else
          <p></p>
      @endif
      <span class="brand-text font-weight-light"> Kids Education</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-6 pb-6 mb-6 d-flex">
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }} - {{ auth()->user()->roles->pluck('name')->implode(', ') }} </a>
          <span class="text-muted"></span>
          <!-- صلاحيات المستخدم -->
        </div>
      </div>
    
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>my profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>home</p>
                </a>
              </li>
              @if(auth()->user()->hasRole('admin')|| auth()->user()->hasRole('manager'))
                    <li class="nav-item">
                    <a  href="{{ route('sections.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>sections</p>
                    </a>
                  </li>

              <li class="nav-item">
                    <a  href="{{ route('units.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>units</p>
                    </a>
                  </li>
                          <li class="nav-item">
                    <a  href="{{ route('lessons.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>lessons</p>
                    </a>
                  </li>


                   <li class="nav-item">
                      <a  href="{{ route('contents.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>contents</p>
                    </a>
                  </li>
                   <li class="nav-item">
                      <a  href="{{ route('quizzes.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>quizzes</p>
                    </a>
                  </li>
                   <li class="nav-item">
                      <a  href="{{ route('questions.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>questions</p>
                    </a>
                  </li>
                   <li class="nav-item">
                      <a  href="{{ route('answers.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>answers</p>
                    </a>
                  </li>



              
              @endif


              @if(auth()->user()->hasRole('admin'))
                        <li class="nav-item">
                          <a href="./users" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>users</p>
                          </a>
                        </li>
             
                    
                    
               @endif
         
              <li class="nav-item" style="margin-bottom: 10px">
                
                <a class="nav-link"style="margin-bottom: 10px" href="{{ route('logout') }}" 
                    onclick="event.preventDefault(); 
                    document.getElementById('logout-form').submit();">
                  
                    <i class="far fa-circle nav-icon"></i>
                    {{ __('Logout') }} 
                </a>
                 <form id="logout-form" action="{{ route('logout') }}" 
                 method="POST" class="d-none">@csrf
                </form>
              </li>
             
            </ul>
            
          </li>
     
        
       
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>