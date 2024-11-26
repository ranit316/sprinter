<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <?php
    $appinfo = \App\Models\AppInfo::first();
    ?>
    <div class="app-sidebar-logo d-block text-center" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{ route('dashboard') }}" class="text-center">
            <img alt="Logo"
                src="{{ $appinfo->dark_logo != '' ? asset($appinfo->dark_logo) : asset('assets/media/logos/default-dark.svg') }}"
                class="h-80px app-sidebar-logo-default" />
            <img alt="Logo"
                src="{{ $appinfo->logo != '' ? asset($appinfo->logo) : asset('assets/media/logos/default-small.svg') }}"
                class="h-30px pt-2 app-sidebar-logo-minimize" />
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <!--begin::Minimized sidebar setup:
if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") {
1. "src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state.
2. Set data-kt-app-sidebar-minimize="on" attribute for body tag.
3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id.
4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id.
}
-->
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    @if (Auth::check())
        <!--end::Logo-->
        <!--begin::sidebar menu-->
        <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
            <!--begin::Menu wrapper-->
            <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
                <!--begin::Scroll wrapper-->
                <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true"
                    data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                    data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                    data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                    data-kt-scroll-save-state="true">
                    <!--begin::Menu-->
                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                        id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="{{ route('dashboard') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-element-11 fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Dashboard</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->

                        @php
                            $user = Auth::user();

                        @endphp
                        @if (
                            $user->hasRole('Admin') ||
                                $user->can('role-list') ||
                                $user->can('role-create') ||
                                $user->can('role-edit') ||
                                $user->can('role-delete') ||
                                $user->can('permission-list') ||
                                $user->can('permission-create') ||
                                $user->can('permission-edit') ||
                                $user->can('permission-delete') ||
                                $user->can('customer-list') ||
                                $user->can('customer-create') ||
                                $user->can('customer-edit') ||
                                $user->can('customer-delete'))
                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="click"
                                class="menu-item  {{ \Request::route()->getName() == 'users.index' || \Request::route()->getName() == 'users.edit' || \Request::route()->getName() == 'users.create' || \Request::route()->getName() == 'users.show' || \Request::route()->getName() == 'roles.index' || \Request::route()->getName() == 'roles.edit' || \Request::route()->getName() == 'roles.show' || \Request::route()->getName() == 'roles.create' || \Request::route()->getName() == 'permissions.index' || \Request::route()->getName() == 'permissions.edit' || \Request::route()->getName() == 'permissions.show' || \Request::route()->getName() == 'permissions.create' ? 'here show' : '' }} menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-address-book fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">User and role</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    @if ($user->hasRole('Admin'))
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link  {{ \Request::route()->getName() == 'users.index' || \Request::route()->getName() == 'users.edit' || \Request::route()->getName() == 'users.create' || \Request::route()->getName() == 'users.show' ? 'active' : '' }}"
                                                href="{{ route('users.index') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Users</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endif

                                    <!--begin:Menu sub-->
                                    <div class="menu-item <?php if ($user->can('role-list') || $user->can('role-create') || $user->can('role-edit') || $user->can('role-delete') || $user->can('permission-list') || $user->can('permission-create') || $user->can('permission-edit') || $user->can('permission-delete')) {
                                        echo 'd-block';
                                    } ?> ">
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="click"
                                            class="menu-item menu-accordion {{ \Request::route()->getName() == 'roles.index' || \Request::route()->getName() == 'roles.edit' || \Request::route()->getName() == 'roles.show' || \Request::route()->getName() == 'roles.create' || \Request::route()->getName() == 'permissions.index' || \Request::route()->getName() == 'permissions.edit' || \Request::route()->getName() == 'permissions.show' || \Request::route()->getName() == 'permissions.create' ? 'hover show' : '' }}">
                                            <!--begin:Menu link-->
                                            <span class="menu-link">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Role Management</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <!--end:Menu link-->
                                            <!--begin:Menu sub-->
                                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                                @if ($user->can('role-list') || $user->can('role-create') || $user->can('role-edit') || $user->can('role-delete'))
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <a class="menu-link  {{ \Request::route()->getName() == 'roles.index' || \Request::route()->getName() == 'roles.edit' || \Request::route()->getName() == 'roles.show' || \Request::route()->getName() == 'roles.create' ? 'active' : '' }}"
                                                            href="{{ route('roles.index') }}">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Roles</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                @endif
                                                @if (
                                                    $user->can('permission-list') ||
                                                        $user->can('permission-create') ||
                                                        $user->can('permission-edit') ||
                                                        $user->can('permission-delete'))
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <a class="menu-link  {{ \Request::route()->getName() == 'permissions.index' || \Request::route()->getName() == 'permissions.edit' || \Request::route()->getName() == 'permissions.show' || \Request::route()->getName() == 'permissions.create' ? 'active' : '' }}"
                                                            href="{{ route('permissions.index') }}">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Permissions</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                @endif


                                            </div>
                                            <!--end:Menu sub-->
                                        </div>
                                        <!--end:Menu item-->


                                    </div>
                                    <!--end:Menu sub-->



                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Menu item-->
                        @endif

                        @if (
                            $user->can('customer-list') ||
                                $user->can('customer-create') ||
                                $user->can('customer-edit') ||
                                $user->can('customer-delete'))
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ \Request::route()->getName() == 'customers.index' || \Request::route()->getName() == 'customers.edit' || \Request::route()->getName() == 'customers.create' || \Request::route()->getName() == 'customers.show' ? 'active' : '' }}"
                                    href="{{ route('customers.index') }}">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-abstract-38 fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Customers</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        @endif


                        {{-- @if (
                            $user->can('category-list') ||
                                $user->can('category-create') ||
                                $user->can('category-edit') ||
                                $user->can('category-delete'))
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ \Request::route()->getName() == 'categories.index' || \Request::route()->getName() == 'categories.edit' ? 'active' : '' }}"
                                    href="{{ route('categories.index') }}">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-color-swatch fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Category</span>
                                </a>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Menu item-->
                        @endif --}}

                        @if (
                            $user->can('platform-list') ||
                                $user->can('platform-create') ||
                                $user->can('platform-edit') ||
                                $user->can('platform-delete') ||
                                $user->can('contest-list') ||
                                $user->can('contest-create') ||
                                $user->can('contest-edit') ||
                                $user->can('contest-delete') ||
                                $user->can('event-list') ||
                                $user->can('event-create') ||
                                $user->can('event-edit') ||
                                $user->can('event-delete'))
                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="click"
                                class="menu-item  {{ \Request::route()->getName() == 'platforms.index' || \Request::route()->getName() == 'platforms.edit' || \Request::route()->getName() == 'contests.index' || \Request::route()->getName() == 'contests.edit' || \Request::route()->getName() == 'events.index' || \Request::route()->getName() == 'events.edit' ? 'here show' : '' }} menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-text-align-center fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Catalogue</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    @if (
                                        $user->can('platform-list') ||
                                            $user->can('platform-create') ||
                                            $user->can('platform-edit') ||
                                            $user->can('platform-delete'))
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link  {{ \Request::route()->getName() == 'platforms.index' || \Request::route()->getName() == 'platforms.edit' ? 'active' : '' }}"
                                                href="{{ route('platforms.index') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Platforms</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endif

                                    @if (
                                        $user->can('contest-list') ||
                                            $user->can('contest-create') ||
                                            $user->can('contest-edit') ||
                                            $user->can('contest-delete'))
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ \Request::route()->getName() == 'contests.index' || \Request::route()->getName() == 'contests.edit' ? 'active' : '' }}"
                                                href="{{ route('contests.index') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Contests</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endif

                                    @if ($user->can('event-list') || $user->can('event-create') || $user->can('event-edit') || $user->can('event-delete'))
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ \Request::route()->getName() == 'events.index' || \Request::route()->getName() == 'events.edit' ? 'active' : '' }}"
                                                href="{{ route('events.index') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Events</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endif

                                    @if (
                                        $user->can('category-list') ||
                                            $user->can('category-create') ||
                                            $user->can('category-edit') ||
                                            $user->can('category-delete'))
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ \Request::route()->getName() == 'categories.index' || \Request::route()->getName() == 'categories.edit' ? 'active' : '' }}"
                                                href="{{ route('categories.index') }}">
                                                <span class="menu-icon">
                                                    <i class="ki-duotone ki-color-swatch fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                                <span class="menu-title">Categories</span>
                                            </a>
                                            <!--end:Menu sub-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endif

                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Menu item-->
                        @endif


                        @if (
                            $user->can('offer-list') ||
                                $user->can('offer-create') ||
                                $user->can('offer-edit') ||
                                $user->can('offer-delete') 
                               )
                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="click"
                                class="menu-item  {{ \Request::route()->getName() == 'offers.index' || \Request::route()->getName() == 'offers.edit' ? 'here show' : '' }} menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-chart-simple text-abstract-900 fs-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Marketing</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">

                                    @if ($user->can('offer-list') || $user->can('offer-create') || $user->can('offer-edit') || $user->can('offer-delete'))
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ \Request::route()->getName() == 'offers.index' || \Request::route()->getName() == 'offers.edit' ? 'active' : '' }}"
                                                href="{{ route('offers.index') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Offers</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endif

                                    {{-- @if (
                                        $user->can('review-list') ||
                                            $user->can('review-create') ||
                                            $user->can('review-edit') ||
                                            $user->can('review-delete'))
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ \Request::route()->getName() == 'reviews.index' || \Request::route()->getName() == 'reviews.edit' ? 'active' : '' }}"
                                                href="{{ route('reviews.index') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Reviews</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endif --}}



                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Menu item-->
                        @endif


                        @if (
                             $user->can('review-list') ||
                                $user->can('review-create') ||
                                $user->can('review-edit') ||
                                $user->can('review-delete'))
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ \Request::route()->getName() == 'reviews.index' || \Request::route()->getName() == 'reviews.edit' ? 'active' : '' }}"
                                    href="{{ route('reviews.index') }}">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-abstract-39 fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Reviews</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        @endif


                        {{-- @if ($user->hasRole('Admin'))
                         
                            <div data-kt-menu-trigger="click"
                                class="menu-item  menu-accordion">
                               
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-abstract-46 fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Utility</span>
                                    <span class="menu-arrow"></span>
                                </span>
                               
                                <div class="menu-sub menu-sub-accordion">  
                                        <div class="menu-item">
                                            <a class="menu-link"
                                                href="#">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Activity Log</span>
                                            </a>
                                        </div>
                                     
                                        <div class="menu-item">                                       
                                            <a class="menu-link"
                                                href="#">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Email Log</span>
                                            </a>
                                        </div>
                                       
                                        <div class="menu-item">
                                           
                                            <a class="menu-link"
                                                href="#">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Send Bulk Notification</span>
                                            </a>
                                           
                                        </div>
                                </div>   
                            </div> 
                        @endif --}}


                        {{-- @if (
                            $user->can('review-list') ||
                               $user->can('review-create') ||
                               $user->can('review-edit') ||
                               $user->can('review-delete')) --}}
                           <!--begin:Menu item-->
                           @if ($user->hasRole('Admin'))
                           <div class="menu-item">
                               <!--begin:Menu link-->
                               {{-- <a class="menu-link"
                                   href="#">
                                   <span class="menu-icon">
                                       <i class="ki-outline ki-graph-up text-gray-200 fs-2">
                                           
                                       </i>
                                   </span>
                                   <span class="menu-title">Reports</span>
                               </a> --}}
                               <!--end:Menu link-->
                           </div>
                           <!--end:Menu item-->
                        @endif 


                       @if (
                            $user->hasRole('Admin') ||
                                $user->can('faq-category-create') ||
                                $user->can('faq-category-edit') ||
                                $user->can('faq-category-delete') ||
                                $user->can('faq-category-list') ||
                                $user->can('faq-list') ||
                                $user->can('faq-create') ||
                                $user->can('faq-edit') ||
                                $user->can('faq-delete'))
                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="click"
                                class="menu-item  {{ \Request::route()->getName() == 'faq_category.index' || \Request::route()->getName() == 'faq_category.edit' || \Request::route()->getName() == 'faq_category.create' || \Request::route()->getName() == 'faq_category.show' || \Request::route()->getName() == 'faqs.index' || \Request::route()->getName() == 'faqs.edit' || \Request::route()->getName() == 'faqs.show' || \Request::route()->getName() == 'faqs.create' ? 'here show' : '' }} menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-abstract-29 fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">CMS</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <div class="menu-item <?php if ($user->can('faq-list') || $user->can('faq-create') || $user->can('faq-edit') || $user->can('faq-delete') || $user->can('faq-category-list') || $user->can('faq-category-create') || $user->can('faq-category-edit') || $user->can('faq-category-delete')) {
                                        echo 'd-block';
                                    } ?> ">
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="click"
                                            class="menu-item menu-accordion {{ \Request::route()->getName() == 'faq_category.index' || \Request::route()->getName() == 'faq_category.edit' || \Request::route()->getName() == 'faq_category.show' || \Request::route()->getName() == 'faq_category.create' || \Request::route()->getName() == 'faqs.index' || \Request::route()->getName() == 'faqs.edit' || \Request::route()->getName() == 'faqs.show' || \Request::route()->getName() == 'faqs.create' ? 'hover show' : '' }}">
                                            <!--begin:Menu link-->
                                            <span class="menu-link">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">FAQs</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <!--end:Menu link-->
                                            <!--begin:Menu sub-->
                                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                                @if ($user->can('faq-category-list') || $user->can('faq-category-create') || $user->can('faq-category-edit') || $user->can('faq-category-delete'))
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <a class="menu-link  {{ \Request::route()->getName() == 'faq_category.index' || \Request::route()->getName() == 'faq_category.edit' || \Request::route()->getName() == 'faq_category.show' || \Request::route()->getName() == 'faq_category.create' ? 'active' : '' }}"
                                                            href="{{ route('faq_category.index') }}">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">FAQ Category</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                @endif
                                                @if (
                                                    $user->can('faq-list') ||
                                                        $user->can('faq-create') ||
                                                        $user->can('faq-edit') ||
                                                        $user->can('faq-delete'))
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <a class="menu-link  {{ \Request::route()->getName() == 'faqs.index' || \Request::route()->getName() == 'faqs.edit' || \Request::route()->getName() == 'faqs.show' || \Request::route()->getName() == 'faqs.create' ? 'active' : '' }}"
                                                            href="{{ route('faqs.index') }}">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">FAQs</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                @endif

                                                {{-- @if (
                                                    $user->can('faq-list') ||
                                                        $user->can('faq-create') ||
                                                        $user->can('faq-edit') ||
                                                        $user->can('faq-delete')) --}}
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <a class="menu-link"
                                                            href="{{ route('faq_types.index') }}">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">FAQ Type</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                {{-- @endif --}}


                                            </div>
                                            <!--end:Menu sub-->
                                        </div>
                                        <!--end:Menu item-->


                                    </div>

                                    <!--begin:Menu sub-->
                                    <div class="menu-item">
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="click"
                                            class="menu-item menu-accordion">
                                            <!--begin:Menu link-->
                                            {{-- <span class="menu-link">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Pages</span>
                                                <span class="menu-arrow"></span>
                                            </span> --}}
                                            <!--end:Menu link-->
                                            <!--begin:Menu sub-->
                                            <div class="menu-active-bg">
                                                {{-- @if ($user->can('role-list') || $user->can('role-create') || $user->can('role-edit') || $user->can('role-delete')) --}}
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <a class="menu-link"
                                                            href="{{ route('cms_pages.index') }}">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">CMS Page</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                {{-- @endif --}}
                                                {{-- @if (
                                                    $user->can('permission-list') ||
                                                        $user->can('permission-create') ||
                                                        $user->can('permission-edit') ||
                                                        $user->can('permission-delete')) --}}
                                                    <!--begin:Menu item-->
                                                 
                                                    <!--end:Menu item-->
                                                @endif


                                            </div>
                                            <!--end:Menu sub-->
                                        </div>
                                        <!--end:Menu item-->


                                    </div>
                                    <!--end:Menu sub-->



                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Menu item-->
                        @endif


                        @if ($user->hasRole('Admin'))
                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="click"
                                class="menu-item  {{ \Request::route()->getName() == 'appinfo.index' ? 'here show' : '' }} menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-abstract-13 fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Settings</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    @if (
                                        $user->can('faq-list') ||
                                            $user->can('faq-create') ||
                                            $user->can('faq-edit') ||
                                            $user->can('faq-delete') ||
                                            $user->can('faq-category-list') ||
                                            $user->can('faq-category-create') ||
                                            $user->can('faq-category-edit') ||
                                            $user->can('faq-category-delete'))
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link  {{ \Request::route()->getName() == 'appinfo.index' ? 'active' : '' }}"
                                                href="{{ route('appinfo.index') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Software</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->

                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link"
                                                href="{{route('support-whatsapp.index')}}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Support</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->

                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link"
                                                href="#">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Miscellaneous</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endif





                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Menu item-->
                        @endif





                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Scroll wrapper-->
            </div>
            <!--end::Menu wrapper-->
        </div>
    <!--end::sidebar menu-->

</div>
