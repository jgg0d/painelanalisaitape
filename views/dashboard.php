<!-- Breadcrumbs-->
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#dashboard" onclick="page('dashboard.php')">Dashboard</a>
    </li>
    <!-- <li class="breadcrumb-item active">My Dashboard</li> -->
</ol>
<!-- Icon Cards-->
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card dashboard text-white bg-primary o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-envelope-open"></i>
                </div>
                <div class="mr-5">
                    <h5>26 New Messages!</h5>
                </div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="messages.html">
                <span class="float-left">View Details</span>
                <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card dashboard text-white bg-warning o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-star"></i>
                </div>
                <div class="mr-5">
                    <h5>11 New Reviews!</h5>
                </div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="reviews.html">
                <span class="float-left">View Details</span>
                <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card dashboard text-white bg-success o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-calendar-check-o"></i>
                </div>
                <div class="mr-5">
                    <h5>10 New Courses!</h5>
                </div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="bookings.html">
                <span class="float-left">View Details</span>
                <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card dashboard text-white bg-danger o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-heart"></i>
                </div>
                <div class="mr-5">
                    <h5>10 New Bookmarks!</h5>
                </div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="bookmarks.html">
                <span class="float-left">View Details</span>
                <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
</div>
<!-- /cards -->

<h2></h2>

<!-- Area Chart Example-->
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-area-chart"></i> Area Chart Example
    </div>
    <div class="card-body">
        <canvas id="myAreaChart" width="100%" height="30"></canvas>
    </div>
    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>
<div class="row">
    <div class="col-lg-8">
        <!-- Example Bar Chart Card-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-bar-chart"></i> Bar Chart Example
            </div>
            <div class="card-body">
                <canvas id="myBarChart" width="100" height="50"></canvas>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
    </div>
    <div class="col-lg-4">
        <!-- Example Pie Chart Card-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-pie-chart"></i> Pie Chart Example
            </div>
            <div class="card-body">
                <canvas id="myPieChart" width="100%" height="100"></canvas>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
    </div>
</div>

<script src="vendor/chart.js/Chart.min.js"></script>
<script src="js/admin-charts-all.js"></script>