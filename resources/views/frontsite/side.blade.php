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
  
    <div class="row mt-3 ml-3">
      <h5 class="card-title text-primary">Book today!</h5>
      @foreach($books as $book)
        <h6 class="mb-3">{{$book->short_title}}</h6>      
      @endforeach 
    </div>

    <div class="row mt-3 ml-3 mt-5">
      <h5 class="card-title text-primary">Hit Author!</h5>
      @foreach($authors as $author)
      <h6 class="mb-3">{{$author->name}}</h6>      
    @endforeach
    </div>
  
  </aside>
  