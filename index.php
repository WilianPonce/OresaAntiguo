<?php
    include 'modulo/head.php';
    include 'modulo/menu_top.php';
    include 'modulo/menu_left.php';
    include 'modulo/preloader.php';
?>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor" @click="subirimagenus()">INICIO</h3>
    </div>
    <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">
                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>Fecha Actual</small></h6>
                        <div class="m-t-0 text-info" id="clock">{{moment().locale("es").format('DD [de] MMMM [del] YYYY, h:mm:ssA')}}</div> 
                    </div>
                    <div class="spark-chart mr-3">
                        <i class="fas fa-calendar-alt fa-3x text-themecolor"></i>
                    </div>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10 btncliicked"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
        </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<!-- Row -->
<div class="row">
    <div class="col-md-8 col-xlg-9">
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Product A Sales</h4>
                        <div class="d-flex flex-row">
                            <div class="p-10 b-r">
                                <h6 class="font-light">Montly</h6><b>20.40%</b>
                            </div>
                            <div class="p-10">
                                <h6 class="font-light">Daily</h6><b>5.40%</b>
                            </div>
                        </div>
                    </div>
                    <div id="spark1" class="sparkchart"></div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Product B Sales</h4>
                        <div class="d-flex flex-row">
                            <div class="p-10 b-r">
                                <h6 class="font-light">Montly</h6><b>20.40%</b>
                            </div>
                            <div class="p-10">
                                <h6 class="font-light">Daily</h6><b>5.40%</b>
                            </div>
                        </div>
                    </div>
                    <div id="spark2" class="sparkchart"></div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Product C Sales</h4>
                        <div class="d-flex flex-row">
                            <div class="p-10 b-r">
                                <h6 class="font-light">Montly</h6><b>20.40%</b>
                            </div>
                            <div class="p-10">
                                <h6 class="font-light">Daily</h6><b>5.40%</b>
                            </div>
                        </div>
                    </div>
                    <div id="spark3" class="sparkchart"></div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- Row -->
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex flex-wrap">
                                    <div>
                                        <h3 class="card-title">Sales Overview</h3>
                                        <h6 class="card-subtitle">Ample Admin Vs Pixel Admin</h6> </div>
                                    <div class="ml-auto">
                                        <ul class="list-inline">
                                            <li>
                                                <h6 class="text-muted text-success"><i class="fa fa-circle font-10 m-r-10 "></i>Ample</h6> </li>
                                            <li>
                                                <h6 class="text-muted  text-info"><i class="fa fa-circle font-10 m-r-10"></i>Pixel</h6> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="amp-pxl" style="height: 360px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Product Sales</h3>
                        <div id="visitor" style="height:285px; width:100%;"></div>
                    </div>
                    <div>
                        <hr class="m-t-0 m-b-0">
                    </div>
                    <div class="card-body text-center ">
                        <ul class="list-inline m-b-0">
                            <li>
                                <h6 class="text-muted text-info"><i class="fa fa-circle font-10 m-r-10 "></i>Mobile</h6> </li>
                            <li>
                                <h6 class="text-muted  text-primary"><i class="fa fa-circle font-10 m-r-10"></i>Desktop</h6> </li>
                            <li>
                                <h6 class="text-muted  text-success"><i class="fa fa-circle font-10 m-r-10"></i>Tablet</h6> </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-lg-6 col-md-6">
                <div class="card card-inverse card-success">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="m-r-20 align-self-center">
                                <h1 class="text-white"><i class="icon-cloud-download"></i></h1></div>
                            <div>
                                <h3 class="card-title">Download count</h3>
                                <h6 class="card-subtitle">March  2017</h6> </div>
                        </div>
                        <div class="row">
                            <div class="col-4 align-self-center">
                                <h2 class="font-light text-white">35487</h2>
                            </div>
                            <div class="col-8 p-t-10 p-b-20 text-right">
                                <div class="spark-count" style="height:65px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <img class="" src="static/assets/images/background/weatherbg.jpg" alt="Card image cap">
                    <div class="card-img-overlay" style="height:110px;">
                        <h3 class="card-title text-white m-b-0 dl">New Delhi</h3>
                        <small class="card-text text-white font-light">Sunday 15 march</small>
                    </div>
                    <div class="card-body weather-small">
                        <div class="row">
                            <div class="col-8 b-r align-self-center">
                                <div class="d-flex">
                                    <div class="display-6 text-info"><i class="wi wi-day-rain-wind"></i></div>
                                    <div class="m-l-20">
                                        <h1 class="font-light text-info m-b-0">32<sup>0</sup></h1>
                                        <small>Sunny Rainy day</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <h1 class="font-light m-b-0">25<sup>0</sup></h1>
                                <small>Tonight</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-actions">
                            <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                            <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                            <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                        </div>
                        <h4 class="card-title m-b-0">Product Overview</h4>
                    </div>
                    <div class="card-body collapse show">
                        <div class="table-responsive">
                            <table class="table product-overview">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Photo</th>
                                        <th>Quantity</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Steave Jobs</td>
                                        <td>
                                            <img src="static/assets/images/gallery/chair.jpg" alt="iMac" width="80">
                                        </td>
                                        <td>20</td>
                                        <td>10-7-2017</td>
                                        <td>
                                            <span class="label label-success font-weight-100">Paid</span>
                                        </td>
                                        <td><a href="javascript:void(0)" class="text-inverse p-r-10" data-toggle="tooltip" title="" data-original-title="Edit"><i class="ti-marker-alt"></i></a> <a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>Varun Dhavan</td>
                                        <td>
                                            <img src="static/assets/images/gallery/chair2.jpg" alt="iPhone" width="80">
                                        </td>
                                        <td>25</td>
                                        <td>09-7-2017</td>
                                        <td>
                                            <span class="label label-warning font-weight-100">Pending</span>
                                        </td>
                                        <td><a href="javascript:void(0)" class="text-inverse p-r-10" data-toggle="tooltip" title="" data-original-title="Edit"><i class="ti-marker-alt"></i></a> <a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>Ritesh Desh</td>
                                        <td>
                                            <img src="static/assets/images/gallery/chair3.jpg" alt="apple_watch" width="80">
                                        </td>
                                        <td>12</td>
                                        <td>08-7-2017</td>
                                        <td>
                                            <span class="label label-success font-weight-100">Paid</span>
                                        </td>
                                        <td><a href="javascript:void(0)" class="text-inverse p-r-10" data-toggle="tooltip" title="" data-original-title="Edit"><i class="ti-marker-alt"></i></a> <a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>Hrithik</td>
                                        <td>
                                            <img src="static/assets/images/gallery/chair4.jpg" alt="mac_mouse" width="80">
                                        </td>
                                        <td>18</td>
                                        <td>02-7-2017</td>
                                        <td>
                                            <span class="label label-danger font-weight-100">Failed</span>
                                        </td>
                                        <td><a href="javascript:void(0)" class="text-inverse p-r-10" data-toggle="tooltip" title="" data-original-title="Edit"><i class="ti-marker-alt"></i></a> <a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
    </div>
    <div class="col-md-4 col-xlg-3">
        <!-- Column -->
        <div class="card earning-widget">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                    <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                </div>
                <h4 class="card-title m-b-0">Earning</h4>
            </div>
            <div class="card-body b-t collapse show">
                <table class="table v-middle no-border">
                    <tbody>
                        <tr>
                            <td style="width:40px"><img src="static/assets/images/users/1.jpg" width="50" class="img-circle" alt="logo"></td>
                            <td>Andrew</td>
                            <td align="right"><span class="label label-light-info">$2300</span></td>
                        </tr>
                        <tr>
                            <td><img src="static/assets/images/users/2.jpg" width="50" class="img-circle" alt="logo"></td>
                            <td>Kristeen</td>
                            <td align="right"><span class="label label-light-success">$3300</span></td>
                        </tr>
                        <tr>
                            <td><img src="static/assets/images/users/3.jpg" width="50" class="img-circle" alt="logo"></td>
                            <td>Dany John</td>
                            <td align="right"><span class="label label-light-primary">$4300</span></td>
                        </tr>
                        <tr>
                            <td><img src="static/assets/images/users/4.jpg" width="50" class="img-circle" alt="logo"></td>
                            <td>Chris gyle</td>
                            <td align="right"><span class="label label-light-warning">$5300</span></td>
                        </tr>
                        <tr>
                            <td><img src="static/assets/images/users/5.jpg" width="50" class="img-circle" alt="logo"></td>
                            <td>Prabhas</td>
                            <td align="right"><span class="label label-light-danger">$4567</span></td>
                        </tr>
                        <tr>
                            <td><img src="static/assets/images/users/6.jpg" width="50" class="img-circle" alt="logo"></td>
                            <td>Bahubali</td>
                            <td align="right"><span class="label label-light-megna">$7889</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Column -->
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                    <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                </div>
                <h4 class="card-title m-b-0">Discount</h4>
            </div>
            <div class="card-body collapse show bg-info">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        <div class="carousel-item flex-column active">
                            <i class="fa fa-shopping-cart fa-2x text-white"></i>
                            <p class="text-white">25th Jan</p>
                            <h3 class="text-white font-light">Now Get <span class="font-bold">50% Off</span><br>
                        on buy</h3>
                            <div class="text-white m-t-20">
                                <i>- Ecommerce site</i>
                            </div>
                        </div>
                        <div class="carousel-item flex-column">
                            <i class="fa fa-shopping-cart fa-2x text-white"></i>
                            <p class="text-white">25th Jan</p>
                            <h3 class="text-white font-light">Now Get <span class="font-bold">50% Off</span><br>
                        on buy</h3>
                            <div class="text-white m-t-20">
                                <i>- Ecommerce site</i>
                            </div>
                        </div>
                        <div class="carousel-item flex-column">
                            <i class="fa fa-shopping-cart fa-2x text-white"></i>
                            <p class="text-white">25th Jan</p>
                            <h3 class="text-white font-light">Now Get <span class="font-bold">50% Off</span><br>
                        on buy</h3>
                            <div class="text-white m-t-20">
                                <i>- Ecommerce site</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                    <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                </div>
                <h4 class="card-title m-b-0">Monthly Wineer</h4>
            </div>
            <div class="card-body collapse show b-t">
                <div class="m-t-30 text-center"> <img src="static/assets/images/users/5.jpg" class="img-circle" width="150">
                    <h4 class="card-title m-t-10">Hanna Gover</h4>
                    <h6 class="card-subtitle">Accoubts Manager Amix corp</h6>
                    <div class="row text-center justify-content-md-center">
                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">254</font></a></div>
                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium">54</font></a></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                    <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                </div>
                <h4 class="card-title m-b-0">New items</h4>
            </div>
            <div class="card-body p-0 collapse show text-center">
                <div id="myCarousel2" class="carousel slide" data-ride="carousel">
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        <div class="carousel-item flex-column active">
                            <img src="static/assets/images/gallery/chair.jpg" alt="user">
                            <h4 class="m-b-30">Brand New Chair</h4>
                        </div>
                        <div class="carousel-item flex-column">
                            <img src="static/assets/images/gallery/chair2.jpg" alt="user">
                            <h4 class="m-b-30">Brand New Chair</h4>
                        </div>
                        <div class="carousel-item flex-column">
                            <img src="static/assets/images/gallery/chair3.jpg" alt="user">
                            <h4 class="m-b-30">Brand New Chair</h4>
                        </div>
                        <div class="carousel-item flex-column">
                            <img src="static/assets/images/gallery/chair4.jpg" alt="user">
                            <h4 class="m-b-30">Brand New Chair</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include 'modulo/chat.php';
    include 'modulo/foot.php';
?> 
</div>
</div>
<script src="static/assets/plugins/jquery/jquery.min.js"></script>
<script src="static/assets/plugins/popper/popper.min.js"></script>
<script src="static/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="static/js/jquery.slimscroll.js"></script>
<script src="static/js/waves.js"></script>
<script src="static/js/sidebarmenu.js"></script>
<script src="static/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="static/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="static/js/custom.min.js"></script>
<script src="static/assets/plugins/chartist-js/dist/chartist.min.js"></script>
<script src="static/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
<script src="static/assets/plugins/d3/d3.min.js"></script>
<script src="static/assets/plugins/c3-master/c3.min.js"></script>
<script src="static/js/dashboard6.js"></script>
<script src="static/js/jasny-bootstrap.js"></script>
<script src="static/assets/plugins/toast-master/js/jquery.toast.js"></script>
<script src="static/assets/plugins/peity/jquery.peity.min.js"></script>
<script src="static/assets/plugins/peity/jquery.peity.init.js"></script>
<script src="static/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
<script src="static/assets/plugins/sweetalert/sweetalert.min.js"></script>
<script src="static/js/moment.js"></script>
<script src="static/js/vue.js"></script>
<script src="static/js/axios.js"></script>
<script src="https://unpkg.com/jspdf@1.5.3/dist/jspdf.min.js"></script>
<script src="https://unpkg.com/jspdf-autotable@3.1.1/dist/jspdf.plugin.autotable.js"></script>
<script src="static/js/cerrarsesion.js"></script>
<script src="static/js/alertify.min.js"></script>
<script src="static/js/timetime.js"></script>
<script src="static/js/vueinicio.js"></script>
</div>
</body>
</html>