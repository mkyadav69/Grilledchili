<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <!-- Title Page-->
    <title>@yield('title')</title>

    <!-- Fontfaces CSS-->
    <link href="{{asset('css/font-face.css') }}" rel="stylesheet">
    <link href="{{asset('vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">

    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">

    <!-- Bootstrap CSS-->


    <link href="{{asset('vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Vendor CSS-->
    <link href="{{asset('vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/wow/animate.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/slick/slick.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('css/daterangepicker.css')}}" rel="stylesheet" media="all">    
    <link href="{{asset('css/jquery-ui.css')}}" rel="stylesheet" media="all">
    <!-- Main CSS-->
    
    <link href="{{asset('css/theme.css')}}" rel="stylesheet" media="all">
    <!-- Jquery JS-->
    <script src="{{asset('vendor/jquery-3.2.1.min.js')}}"></script>
    <!-- Bootstrap JS-->
    
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-4.1/popper.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
    

</head>
<style>
.navbar-sidebar .navbar__list li a {
    display: block;
    color: #555;
    font-size: 16px;
    padding: 8px 0;
}
.navbar-sidebar {
    padding-left: -1px;
    padding-top: 9px;
    padding-bottom: 0;
}
.col-md-12 {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 131%;
    padding-left: 1px;
    margin-top: -28px;
}
.m-b-30 {
    margin-bottom: 30px;
    margin-top: -16px;
}
.m-b-35 {
    margin-bottom: 16px;
}

table.dataTable {
    border-collapse: separate !important;
    border-spacing: 2px;
}

.table-earning thead th {
	background: #333;
	font-size: 16px;
	color: #fff;
	vertical-align: middle;
	font-weight: 400;
	text-transform: capitalize;
	line-height: 1;
	padding: 9px 3px;
	white-space: nowrap;
}

</style>

<body class="animsition">
    <div class="page-wrapper">
       
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-block">
            <div class="logo">
                <a href="#">
                    <img src="{{asset('images/icon/cropped-web_logo_small-1.png')}}" alt="Cool Admin" />
                </a>
            </div>
            @include('theme.layout.sidebar')
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
            @include('theme.layout.header')
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        @yield('content')
                        <div class="row">
                        @include('theme.layout.footer')
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                @yield('addModal')
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                @yield('editModal')
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                @yield('deleteModal')
            </div>
        </div>

        <div class="modal fade" id="minProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                @yield('minProduct')
            </div>
        </div>


        <div class="modal fade" id="nameQuantity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                @yield('nameQuantity')
            </div>
        </div>

        <div class="modal fade" id="validQuantity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                @yield('validQuantity')
            </div>
        </div>

        <div class="modal fade" id="selectProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                @yield('selectProduct')
            </div>
        </div>

        <div class="modal fade" id="quotation-preview-model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog quote-preview">
                @yield('quotation-preview-model')
            </div>
        </div>

        <div class="modal fade" id="quoteUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                @yield('quoteUpdate')
            </div>
        </div>

        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                @yield('viewModal')
            </div>
        </div>

        <div class="modal fade" id="selectTruck" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                @yield('selectTruck')
            </div>
        </div>
        

        

        
    <!-- Vendor JS       -->
    <script src="{{asset('vendor/slick/slick.min.js')}}"></script>
    <script src="{{asset('vendor/wow/wow.min.js')}}"></script>
    <script src="{{asset('vendor/animsition/animsition.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    
    <script src="{{asset('vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
    <script src="{{asset('vendor/counter-up/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('vendor/counter-up/jquery.counterup.min.js')}}"></script>

    <script src="{{asset('vendor/circle-progress/circle-progress.min.js')}}"></script>
    <script src="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('vendor/chartjs/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('vendor/select2/select2.min.js')}}"></script>

    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Main JS-->
    <script src="{{asset('js/main.js')}}"></script>
    <script>
        $('#addModal').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
        })
    </script>
    <script>
        $(document).ready(function(){
            $('.add_modal').click(function(){
                $('#addModal').modal({
                    backdrop: 'static'
                });
            }); 
        });
    </script>
     @yield('script')


</body>

</html>
<!-- end document-->
