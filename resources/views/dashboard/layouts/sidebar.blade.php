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
                    <li class="@yield('dashboard')">
                        <a href="{{ route('dashboard') }}">
                            <i data-feather="monitor"></i>
                            <span>Dashboard</span>
                        </a>
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
