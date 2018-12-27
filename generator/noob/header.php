<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $website;?></title>
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/iconfonts/puse-icons-feather/feather.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.11/css/all.css" 
  integrity="sha384-p2jx59pefphTFIpeqCcISO9MdVfIm4pNnsL08A6v5vaQc4owkQqxMV8kg4Yvhaw/" crossorigin="anonymous">

  <link rel="stylesheet" href="css/style.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="shortcut icon" href="<?php echo $favicon;?>">
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row navbar-dark">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a href="#" class="nav-link"><span class="badge badge-primary ml-1"><b><?php echo $website;?></b></span></a>
       
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">

       
         
        <ul class="navbar-nav navbar-nav-right">
       
          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <span class="mr-3">Hello, <?php echo $username; ?></span><img class="img-xs rounded-circle" img src="<?php echo $profile_img; ?>" alt="Profile image">
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
            <a class="dropdown-item mt-2" href="generationhistory.php">
                My Accounts
              </a>
              <a class="dropdown-item" href="freegenerator.php">
                Free Generator
              </a>
              <a class="dropdown-item mt-2" href="generator.php">
                Generator
              </a>
              <a class="dropdown-item" href="my-profile.php">
                Profile
              </a>
              <a class="dropdown-item" href="lib/logout.php">
                Sign Out
              </a>
            </div>
          </li>
        </ul>

      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <div class="theme-setting-wrapper">
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close mdi mdi-close"></i>
          <div class="d-flex align-items-center justify-content-between border-bottom">
            <p class="settings-heading font-weight-bold border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Template Skins</p>
          </div>
          <div class="sidebar-bg-options selected" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
          <div class="sidebar-bg-options" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
          <p class="settings-heading font-weight-bold mt-2">Header Skins</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles primary"></div>
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles pink"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
          </div>
        </div>
      </div>

      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="profile-image"> <img src="<?php echo $profile_img; ?>" alt="image"/> <span class="online-status online"></span> </div>
              <div class="profile-name">
                <p class="name"><?php echo $username; ?></p>
                <p class="designation"><?php echo $level; ?></p>
              </div>
              <div class="notification-panel mt-4">
                <span><a href="my-profile.php"><i class="mdi mdi-settings"></i></a></span>
                <span><a href="communitychat.php"><i class="mdi mdi-bell"></i><span class="count top-right bg-warning"></a></span>
                <span><a href="generator.php"><i class="fas fa-sync"></i></a></span>
              </div>
            </div>
          </li>
          
          <li class="nav-item"> <a class="nav-link" href="index.php"> <img class="menu-icon" src="images/menu_icons/03.png" alt="menu icon"> <span class="menu-title">Dashboard</span></a> </li>
        
          
          	
              <li class="nav-item"> <a class="nav-link" href="purchase.php"> <img class="menu-icon" src="images/menu_icons/07.png" alt="menu icon"> <span class="menu-title">Shop</span> </a> </li>
              <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth"> <img class="menu-icon" src="images/menu_icons/05.png" alt="menu icon"> <span class="menu-title">Tools</span><i class="menu-arrow"></i></a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="generator.php"> Generator </a></li>
                <li class="nav-item"> <a class="nav-link" href="privategenerator.php"> Private Generator</a></li>
                <li class="nav-item"> <a class="nav-link" href="freegenerator.php"> Free Generator</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item"> <a class="nav-link" href="communitychat.php"> <img class="menu-icon" src="images/menu_icons/20.png" alt="menu icon"> <span class="menu-title">Shoutbox</span> </a> </li>
            <li class="nav-item"> <a class="nav-link" href="users.php"> <img class="menu-icon" src="images/menu_icons/17.png" alt="menu icon"> <span class="menu-title">Users</span> </a> </li>
          <li class="nav-item"> <a class="nav-link" href="accounts.php"> <img class="menu-icon" src="images/menu_icons/10.png" alt="menu icon"> <span class="menu-title">Status</span> </a> </li>
          <li class="nav-item"> <a class="nav-link" href="tos.php"> <img class="menu-icon" src="images/menu_icons/16.png" alt="menu icon"> <span class="menu-title">Terms&Conditions</span> </a> </li>

          <?php
if($_SESSION['rank'] == "5"){
echo'
<li class="nav-item"> <a class="nav-link" href="AdminPanel/settings.php"> <img class="menu-icon" src="images/menu_icons/05.png" alt="menu icon"> <span class="menu-title">Admin Panel</span> </a> </li>
              ';
}
?>
          <li class="nav-item">
            <div class="sidebar-sticker">
              <div class="d-flex align-items-center text-primary">
                <h6 class="mb-1">Need Help</h6><i class="mdi ml-2 mdi-bell-ring-outline"></i>
              </div>
              <a class="d-block text-gray my-2" href="https://www.carl0.ml">www.carl0.ml</a>
              
            </div>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-center">
                    <div class="highlight-icon bg-light mr-3">
                      <i class="fas fa-user-astronaut text-success icon-lg"></i>
                    </div>
                    <div class="wrapper">
                      <p class="card-text mb-0"><b>Total Users</b></p>
                      <div class="fluid-container">
                        <h3 class="card-title mb-0"><b><?php echo $totalusers;?></b></h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-center">
                    <div class="highlight-icon bg-light mr-3">
                      <i class="fab fa-bitcoin text-primary icon-lg"></i>
                    </div>
                    <div class="wrapper">
                      <p class="card-text mb-0"><b>Total Paid Users</b></p>
                      <div class="fluid-container">
                        <h3 class="card-title mb-0"><b><?php echo $activesubscriptions;?></b></h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-center">
                    <div class="highlight-icon bg-light mr-3">
                      <i class="fas fa-sync text-danger icon-lg"></i>
                    </div>
                    <div class="wrapper">
                      <p class="card-text mb-0"><b>Total Generated</b></p>
                      <div class="fluid-container">
                        <h3 class="card-title mb-0"><b><?php echo $generated;?></b></a></h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-center">
                    <div class="highlight-icon bg-light mr-3">
                      <i class="fas fa-crosshairs text-info icon-lg"></i>
                    </div>
                    <div class="wrapper">
                      <p class="card-text mb-0"><b>Total Accounts</b></p>
                      <div class="fluid-container">
                        <h3 class="card-title mb-0"><b><?php echo $totalalts;?></b></h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
         
                   <a class="e-widget no-button" href="https://gleam.io/11elZ/carl0ml-accounts-generator" rel="nofollow">Carl0.ml Accounts Generator</a>
<script type="text/javascript" src="https://js.gleam.io/e.js" async="true"></script>