<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">
        <div class="help-bt">
            <a href="tel:108" class="d-flex align-items-center">
                <div class="bg-danger rounded10 h-50 w-50 l-h-50 text-center me-15">
                    <i data-feather="mic"></i>
                </div>
                <h4 class="mb-0">Emergency<br>help</h4>
            </a>
        </div>
        <div class="multinav">
            <div class="multinav-scroll" style="height: 100%;">
                <!-- sidebar menu-->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="treeview @yield('dashboard')">
                        <a href="#">
                            <i data-feather="monitor"></i>
                            <span>Admin Panel</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@yield('dashboard.home')"><a href="{{ route('dashboard') }}"><i
                                            class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Dashboard</a></li>
                            <li class="@yield('dashboard.feedback')"><a href="{{ route('dashboard.user-feedback') }}"><i
                                            class="icon-Commit"><span class="path1"></span><span
                                                class="path2"></span></i>User Feedback</a></li>
                        </ul>
                    </li>
                    <li class="@yield('support_groups')">
                        <a href="{{ route('support_groups.index') }}">
                            <i data-feather="help-circle"></i>
                            <span>Support Groups</span>
                        </a>
                    </li>
                    <li class="treeview @yield('patient')">
                        <a href="#">
                            <i data-feather="users"></i>
                            <span>Patients</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@yield('patient.all')"><a href="{{ route('patient.index') }}"><i
                                        class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>List All</a></li>
                            {{-- <li><a href="patient_details.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Patient Details</a></li> --}}
                        </ul>
                    </li>
                    <li class="treeview @yield('medical')">
                        <a href="#">
                            <i data-feather="activity"></i>
                            <span>Medical Professionals</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@yield('medical.all')"><a href="{{ route('medical.index') }}"><i
                                        class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>List All</a></li>
                            <li class="@yield('medical.verify')"><a href="{{ route('medical.verify') }}"><i
                                        class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Verification Requests</a></li>
                        </ul>
                    </li>
                    <li class="@yield('appointments')">
                        <a href="{{ route('appointments.index') }}">
                            <i data-feather="calendar"></i>
                            <span>Appointments</span>
                        </a>
                    </li>
                    <li class="treeview @yield('dynamic')">
                        <a href="#">
                            <i data-feather="align-justify"></i>
                            <span>Dynamic Fields</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@yield('dynamic.title')"><a href="{{ route('dynamic.title') }}"><i
                                        class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Professionals Titles</a></li>
                            <li class="@yield('dynamic.category')"><a href="{{ route('dynamic.category') }}"><i
                                        class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Professionals Category</a></li>
                            <li class="@yield('dynamic.rank')"><a href="{{ route('dynamic.rank') }}"><i
                                        class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Professionals Ranks</a></li>
                            <li class="@yield('dynamic.professional_docs')"><a href="{{ route('dynamic.professional_docs') }}"><i
                                        class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Professionals Docs</a></li>
                            <li class="@yield('dynamic.article_category')"><a href="{{ route('dynamic.article_category') }}"><i
                                        class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Article Category</a></li>
                            <li class="@yield('dynamic.clinical_notes')"><a href="{{ route('dynamic.clinical_notes') }}"><i
                                        class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Clinical Notes</a></li>
                            <li class="@yield('dynamic.consultation_summary')"><a href="{{ route('dynamic.consultation_summary') }}"><i
                                        class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Consultation Summary</a></li>
                        </ul>
                    </li>
                    <li class="treeview @yield('payments')">
                        <a href="#">
                            <i data-feather="credit-card"></i>
                            <span>Payments</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@yield('payments.trans')"><a href="{{ route('payments.transactions') }}"><i
                                        class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Transactions</a></li>
                            <li class="@yield('payments.payouts')"><a href="{{ route('payments.payouts') }}"><i
                                        class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Payouts</a></li>
                        </ul>
                    </li>
                    <li class="@yield('refund_history')">
                        <a href="{{ route('refund_history') }}">
                            <i data-feather="credit-card"></i>
                            <span>Refund History</span>
                        </a>
                    </li>
                    <li class="treeview @yield('emergencyhelp')">
                        <a href="#">
                            <i data-feather="phone-call"></i>
                            <span>Emergency Help</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@yield('emergencyhelp.simple')"><a href="{{ route('emergencyhelp.simple') }}"><i
                                        class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Emergency Help</a></li>
                            <li class="@yield('emergencyhelp.midnight')"><a href="{{ route('emergencyhelp.midnight') }}"><i
                                        class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Mid Night Emergency Help</a></li>
                        </ul>
                    </li>
                    <li class="@yield('article')">
                        <a href="{{ route('articles.admin.index') }}">
                            <i data-feather="align-center"></i>
                            <span>Articles</span>
                        </a>
                    </li>
                    @if(auth()->user()->hasRole('admin'))
                    <li class="@yield('user')">
                        <a href="{{route('user.index')}}">
                            <i data-feather="user"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    @endif
                    <li class="@yield('reminder')">
                        <a href="{{ route('reminder.index') }}">
                            <i data-feather="bell"></i>
                            <span>Reminders</span>
                        </a>
                    </li>
                    <li class="@yield('tweek')">
                        <a href="{{ route('tweek.index') }}">
                            <i data-feather="sliders"></i>
                            <span>Tweeks</span>
                        </a>
                    </li>
                    <li class="@yield('description')">
                        <a href="{{ route('description.index') }}">
                            <i data-feather="inbox"></i>
                            <span>Meta Description</span>
                        </a>
                    </li>
                </ul>

                <div class="sidebar-widgets">
                    <div class="mx-25 mb-30 pb-20 side-bx bg-primary-light rounded20">
                        <div class="text-center">
                            <img src="{{ asset('dashboard/images/svg-icon/color-svg/custom-17.svg') }}"
                                class="sideimg p-5" alt="">
                            <h4 class="title-bx text-primary">Make an Appointments</h4>
                            <a href="#" class="py-10 fs-14 mb-0 text-primary">
                                Best Helth Care here <i class="mdi mdi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="copyright text-center m-25">
                        <p><strong class="d-block">Deluxe hospital Admin Dashboard</strong> ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> All Rights Reserved
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
