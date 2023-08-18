<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow " data-scroll-to-active="true" data-img="{{ asset('theme/app-assets/images/backgrounds/02.jpg') }}">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{ url('/admin') }}">
                    {{-- <img class="brand-logo" alt="Speak2Impact logo" src="{{ asset('theme/app-assets/images/logo/logo.png') }}" /> --}}
                    <img class="brand-logo" />
                    <h3 class="brand-text">Speak2Impact</h3>
                </a>
            </li>
            <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
        </ul>
    </div>
    <div class="navigation-background"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item">
                <a href="{{ route('admin.index') }}">
                    <i class="ft-home"></i><span class="menu-title" data-i18n="">Dashboard</span>
                </a>
            </li>
            {{-- <span class="badge badge badge-info badge-pill float-right mr-2">3</span> --}}
            <li class=" nav-item">
                <a href="{{ route('subscription.list') }}">
                    <i class="ft-book"></i><span class="menu-title" data-i18n="">Subscriptions</span>
                </a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('subscription.list') }}">All Plans</a></li>
                    <li><a class="menu-item" href="{{ route('subscription.add') }}">Add New Plan</a></li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="index.html">
                    <i class="ft-package"></i><span class="menu-title" data-i18n="">Orders</span>
                </a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('subscriptions.orders') }}">Subscriptions</a></li>
                    <li><a class="menu-item" href="{{ route('coach.orders') }}">Booking Credits</a></li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="index.html">
                    <i class="ft-file-plus"></i><span class="menu-title" data-i18n="">Reports</span>
                </a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('user.activity') }}">Users Activity Logs</a></li>
                    <li><a class="menu-item" href="{{ route('user.logs') }}">User Logs</a></li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="index.html">
                    <i class="ft-clock"></i><span class="menu-title" data-i18n="">Webinars</span>
                </a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('webinar.list') }}">All Webinars</a></li>
                    <li><a class="menu-item" href="{{ route('webinar.add') }}">Add New Webinar</a></li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="index.html">
                    <i class="ft-play"></i><span class="menu-title" data-i18n="">Courses</span>
                </a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('instructor.course.list') }}">All Courses</a></li>
                    <li><a class="menu-item" href="{{ route('instructor.course.info') }}">Add New Course</a></li>
                    <li><a class="menu-item" href="{{ route('default_learning_path.edit') }}">Default Learning Path</a></li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="index.html">
                    <i class="ft-grid"></i><span class="menu-title" data-i18n="">Categories</span>
                </a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('admin.categories')}}">All Categories</a></li>
                    <li><a class="menu-item" href="{{ route('admin.categoryForm') }}">Add New Category</a></li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="index.html">
                    <i class="ft-users"></i><span class="menu-title" data-i18n="">Students</span>
                </a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('students.index') }}">All Students</a></li>
                    <li><a class="menu-item" href="{{route('students.create')}}">Add New Student</a></li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="index.html">
                    <i class="ft-settings"></i><span class="menu-title" data-i18n="">Settings</span>
                </a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('showSiteContent') }}">CMS Pages</a></li>
                    <li><a class="menu-item" href="{{ route('settings.index') }}">General Settings</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
