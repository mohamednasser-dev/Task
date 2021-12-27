<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                @if(auth()->guard('web')->check())
                    <li>
                        <a class="waves-effect waves-dark" href="{{route('home')}}" aria-expanded="false"><i class="mdi mdi-home"></i><span
                                class="hide-menu">Dashboard</span></a>
                    </li>
                    <li class="nav-devider"></li>
                    <li>
                        <a class="waves-effect waves-dark" href="{{route('supervisors.index')}}"
                           aria-expanded="false"><i class="mdi mdi-account"></i><span
                                class="hide-menu">supervisors</span></a>
                    </li>
                @elseif(auth()->guard('supervisor')->check())
                    <li>
                        <a class="waves-effect waves-dark" href="{{route('supervisor.home')}}" aria-expanded="false"><i class="mdi mdi-home"></i><span
                                class="hide-menu">Dashboard</span></a>
                    </li>
                    <li class="nav-devider"></li>
                    <li>
                        <a class="waves-effect waves-dark" href="{{route('categories.index')}}" aria-expanded="false"><i
                                class="mdi mdi-widgets"></i><span class="hide-menu">categories</span></a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark" href="{{route('products.index')}}" aria-expanded="false"><i class="mdi mdi-rocket"></i><span
                                class="hide-menu">products</span></a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">

    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
