<!-- leftbar-tab-menu -->
        <div class="startbar d-print-none">
            <!--start brand-->
            <div class="brand">
                <a href="index.html" class="logo">
                    <span>
                        <img src="assets/images/logo-sm.png" alt="logo-small" class="logo-sm">
                    </span>
                    <span class="">
                        <img src="assets/images/logo-light.png" alt="logo-large" class="logo-lg logo-light">
                        <img src="assets/images/logo-dark.png" alt="logo-large" class="logo-lg logo-dark">
                    </span>
                </a>
            </div>
            <!--end brand-->
            
            <!--start startbar-menu-->
            <div class="startbar-menu" >
                <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
                    <div class="d-flex align-items-start flex-column w-100">
                        <!-- Navigation -->
                        <ul class="navbar-nav mb-auto w-100">
                            <li class="menu-label mt-2">
                                <span>Navigation</span>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="index.html">
                                    <i class="iconoir-report-columns menu-icon"></i>
                                    <span>Dashboard</span>
                                    <!-- <span class="badge text-bg-warning ms-auto">08</span> -->
                                </a>
                            </li><!--end nav-item-->

                            <li class="nav-item">
                                <a class="nav-link" href="#sidebarEcommerce" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarEcommerce"> 
                                    <i class="fab fa-earlybirds menu-icon"></i>                                        
                                    <span>Admin</span>
                                </a>
                                <div class="collapse " id="sidebarEcommerce">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            @can('admin.view')
                                                <a class="nav-link" href="{{ route('admin.all') }}">Admin Management</a>
                                            @endcan
                                        </li><!--end nav-item-->
                                        <li class="nav-item">
                                            @can('dep.view')
                                                <a class="nav-link" href="{{ route('add.dep') }}">Department</a>
                                            @endcan
                                        </li><!--end nav-item-->
                                    </ul><!--end nav-->
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#sidebarAdvancedUI" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarAdvancedUI">
                                    <i class="iconoir-peace-hand menu-icon"></i>
                                    <span>Lead Management</span>
                                </a>
                                <div class="collapse " id="sidebarAdvancedUI">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                           @can('lead.view')
                                            <a class="nav-link" href="{{ route('lead.statuses.sources') }}">Lead</a>
                                           @endcan  
                                        </li>
                                    </ul>
                                </div>
                            </li>

                             <li class="nav-item">
                                <a class="nav-link" href="#sidebarElements" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarElements">
                                    <i class="iconoir-compact-disc menu-icon"></i>
                                    <span>Settings</span>
                                </a>
                                <div class="collapse " id="sidebarElements">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('profile.page') }}">Profile Settings</a>
                                        </li>
                                    </ul><!--end nav-->
                                </div><!--end startbarElements-->
                            </li>

                            <li class="nav-item">
                                <form id="logoutForm" method="POST" action="{{ url('admin/logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link text-danger" style="border:none; background:none;">
                                        <i class="las la-power-off fs-18 me-1 align-text-bottom"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </li><!--end nav-item-->
                        </ul><!--end navbar-nav--->
                    </div>
                </div><!--end startbar-collapse-->
            </div><!--end startbar-menu-->
            
            
        </div><!--end startbar-->
        <div class="startbar-overlay d-print-none"></div>
        <!-- end leftbar-tab-menu-->