<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

    <head>
        @include('inc.head')
    </head>

    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-fixed-left" role="navigation">
                @include('inc.sidebar')
            </nav>

            <div id="page-wrapper">

                <div class="container-fluid">
                    
                    <!-- Page Heading -->
                    <div class="row" id="main" >
                        <div class="col-sm-12 col-md-12 well" id="content">
                            @yield('content')
                        </div>
                    </div>

                </div> <!-- Container -->

            </div> <!-- Page-wrapper -->

        </div> <!-- Wrapper -->

        @yield('script')
    </body>

</html>