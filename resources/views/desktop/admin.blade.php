<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin</title>
    <!-- Bootstrap Core CSS -->
    <link href="/bower/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="/bower/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="/bower/morrisjs/morris.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="/bower/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="/bower/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/bower_backup/startbootstrap-sb-admin-2/dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="/bower/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">Bitpacman Admin</a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                @include('admin.widgets.messages_menu')
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/auth/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="/admin/">Dashboard</a>
                            <h4 style="padding:10px;font-size:14px;color:#777;font-weight:bold;">Traffic</h4>
                            <a href="/admin/transactions">Transactions</a>
                            <a href="/admin/address">Address</a>
                            <a href="/admin/extra-awards">Extra Awards</a>
                            <a href="/admin/messages">Messages</a>
                            <h4 style="padding:10px;font-size:14px;color:#777;font-weight:bold;">Security</h4>
                            <a href="/admin/bans">Banned</a>
                            <a href="/admin/banned-ranges">Banned ASN/Ranges</a>
                            <a href="/admin/search-asns">Search Asns</a>
                            <a href="/admin/whois">Whois</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        	@yield('content')
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="/bower/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap Core JavaScript -->
    <script src="/bower/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="/bower/metisMenu/dist/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="/bower_backup/startbootstrap-sb-admin-2/dist/js/sb-admin-2.js"></script>
    <!-- DataTables JavaScript -->
    <script src="/bower/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/bower/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <!-- Morris charts -->
    <script src="/bower/raphael/raphael.min.js"></script>
    <script src="/bower/morrisjs/morris.min.js"></script>
    @yield('js')
    </body>
</html>
