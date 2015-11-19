<!DOCTYPE html>
<html lang="en">
  @include('shell::partials.head')
  <body>
    <div class="row">
      @include('shell::components.navigation.menu')
      <div class="container-fluid">
          <div class="side-body">
            <div class="row">
              <div class="col-sm-12">
                <h1 class="page-header">
                    @section('title')@show
                    @include('shell::components.navigation.breadcrumbs')
                </h1>
                @include('appkit::errors')
                @include('appkit::flash')
                @yield('content')
              </div>
            </div>
          </div>
      </div>
    </div>
    @include('shell::partials.scripts')
  </body>
</html>