<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
      <a href="{{url('/')}}" class="app-brand-link">
        <span class="app-brand-logo demo">
          @include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])
        </span>
        <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span>
      </a>
  
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>
  
    <div class="menu-inner-shadow"></div>
  
    <ul class="menu-inner py-1">
       {{-- Need to show all the book header --}}

    </ul>
  
  </aside>
  