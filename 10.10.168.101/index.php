<?php 
session_start();

include('includes/db_connect.php');
include('includes/config.php');
date_default_timezone_set('Africa/Nairobi');
if(!isset($_SESSION['admin_id']))
{
    header('location:login.php');
}
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>POS + INVENTORY SYSTEM</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="brandimages/codei.png">
    <link rel="shortcut icon" href="brandimages/codei.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

</head>

<body>
    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="index.php"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>

                    <li>
                        <a href="category.php"> <i class="menu-icon fa fa-list-alt"></i>Category</a>
                    </li>

                    <li>
                        <a href="products.php"> <i class="menu-icon fa fa-product-hunt"></i>Products </a>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon ti-list"></i>Logs</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-bars"></i><a href="stocklogs.php">Stock logs</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-file"></i>Sales report</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-file"></i><a href="dailysales.php">Daily</a></li>
                            <li><i class="menu-icon fa fa-file"></i><a href="salesreport.php">Detailed</a></li>
                            <li><i class="menu-icon fa fa-file"></i><a href="bestsales.php">Best sales</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="tracksale.php"> <i class="menu-icon fa fa-book"></i>Track sale </a>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-group"></i>Manage Users</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-user-plus"></i><a href="users.php">Add User</a></li>
                            <li><i class="menu-icon fa fa-edit"></i><a href="users.php">Edit User</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Account</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-lock"></i><a href="#">Change Password</a></li>
                            <li><i class="menu-icon fa fa-sign-out"></i><a href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./"><img src="brandimages/poslogo.png" alt="Logo"></a>
                    <a class="navbar-brand hidden" href="./"><img src="brandimages/poslogo.png" alt="Logo"></a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">

                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="brandimages/admin.jpg" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa- user"></i>My Profile</a>

                            <!-- <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a> -->

                            <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a>

                            <a class="nav-link" href="logout.php"><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>

                </div>
            </div>
        </header>
        <!-- /#header -->
        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-1">
                                        <i class="pe-7s-cash"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <?php
                                            $today = date("Y-m-d");
                                            $week = date('Y-m-d', strtotime('-7 days'));
                                             $query_revenue = $connect->query("SELECT qty,price FROM transaction WHERE time BETWEEN '$week' AND '$today'");
                                             $revenue = 0;
                                             foreach ($query_revenue as $ans) {
                                                 $revenue += $ans['qty']*$ans['price'];
                                             }
                                            ?>
                                            <div class="stat-text">ksh<span class="count"><?=number_format($revenue,2)?></span></div>
                                            <div class="stat-heading">Weekly Revenue</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-2">
                                        <i class="fa fa-bars"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <?php
                                             $cat = $db->get('category');
                                             $num = $db->count;
                                            ?>
                                            <div class="stat-text"><span class="count"><?=$num?></span></div>
                                            <div class="stat-heading">Categories</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-3">
                                        <i class="pe-7s-browser"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <?php
                                             $p = $db->get('product');
                                             $p_num = $db->count;
                                            ?>
                                            <div class="stat-text"><span class="count"><?=$p_num?></span></div>
                                            <div class="stat-heading">Products</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-4">
                                        <i class="pe-7s-users"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <?php
                                             $users = $db->get('users');
                                             $number = $db->count;
                                            ?>
                                            <div class="stat-text"><span class="count"><?=$number?></span></div>
                                            <div class="stat-heading">Users</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Widgets -->
                <!-- chart -->
                <div class="row">

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mb-3">Weekly Sales </h4>
                                <canvas id="sales-chart"></canvas>
                            </div>
                        </div>
                    </div><!-- /# column -->

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                              <table class="table">
                                <thead>
                                    <tr>
                                       <th>Product Code</th>
                                       <th>Name</th>
                                       <th>Qty sold</th>
                                       <th>Profit(ksh)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $today = date("Y-m-d");
                                    $week = date('Y-m-d', strtotime('-7 days'));
                                    $query = "SELECT transaction.code,SUM(transaction.qty) as qty,product.name,product.sp,product.bp,product.id FROM transaction INNER JOIN product ON transaction.code = product.code WHERE transaction.time BETWEEN '$week' AND '$today' GROUP BY transaction.code";
                                    $res = $connect->query($query);
                                    $total = 0;
                                    foreach ($res as $row)
                                    {
                                        $sp = $row['qty']*$row['sp'];
                                        $bp = $row['qty']*$row['bp'];
                                        $profit = $sp-$bp;
                                        $total += $profit;
                                     ?>
                                     <tr>
                                        <td><?=$row['id']?></td>
                                        <td><?=$row['name']?></td>
                                        <td><?=$row['qty']?></td>
                                        <td><?=number_format($profit)?></td>
                                     </tr>
                                     <?php
                                    }
                                    ?>
                                    <tr>
                                      <td><b>TOTAL</b></td>
                                      <td><?php echo ''; ?></td>
                                      <td><?php echo ''; ?></td>
                                      <td><b><?php echo number_format($total); ?></b></td>
                                    </tr>
                                </tbody>
                              </table>
                            </div>
                        </div>
                    </div><!-- /# column -->

                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mb-3"> Products running low on stock </h4>
                                <canvas id="singelBarChart"></canvas>
                            </div>
                        </div>
                    </div><!-- /# column -->
                    
                     <div class="col-lg-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mb-3"> Product's Name </h4>
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th scope="col">Code</th>
                                      <th scope="col">Name</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                     $sql = "SELECT id,name,quantity,item_quantity,unit FROM product ORDER BY quantity ASC LIMIT 20";
                                     $result = $connect->query($sql);
                                     foreach ($result as $row) 
                                     {
                                       ?>
                                       <tr>
                                          <td><?=$row['id']?></td>
                                          <td><?php echo $row['name'].'('.$row['item_quantity'].$row['unit'].')'; ?></td>  
                                       </tr>
                                       <?php
                                     }
                                    ?>
                                  </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /# column -->



                </div>
                <!-- /chart -->
                <div class="clearfix"></div>
            </div>
            <!-- .animated -->
        </div>
        <!-- /.content -->
        <div class="clearfix"></div>
        <!-- Footer -->
        <footer class="site-footer">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-6">
                        Copyright &copy; 2019 <a href="https://codeisystems.co.ke/" target="_blank">Codei</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- /.site-footer -->
    </div>
    <!-- /#right-panel -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>
    <!--  Chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js"></script>
    <script src="assets/js/init/chartjs-init.js"></script>
    <!--Flot Chart-->
    <script src="https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js"></script>

</body>
</html>
