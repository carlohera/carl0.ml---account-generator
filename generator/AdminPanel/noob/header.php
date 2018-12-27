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
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a href="#" class="nav-link"><span class="badge badge-primary ml-1"><b><?php echo $website;?></b></span></a>
       
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
       
         
        <ul class="navbar-nav navbar-nav-right">
       
          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <span class="mr-3">Hello, <?php echo $username; ?> !</span><img class="img-xs rounded-circle" img src="<?php echo $profile_img; ?>" alt="Profile image">
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
            <a class="dropdown-item mt-2" href="../support.php">
                Support
              </a>
              <a class="dropdown-item" href="../freegenerator.php">
                Free Generator
              </a>
              <a class="dropdown-item mt-2" href="../generator.php">
                Generator
              </a>
              <a class="dropdown-item" href="../my-generator.php">
                Profile
              </a>
              <a class="dropdown-item" href="../lib/logout.php">
                Sign Out
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
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
      <div id="right-sidebar" class="settings-panel">
        <i class="settings-close mdi mdi-close"></i>
        <div class="d-flex align-items-center justify-content-between border-bottom">
          <p class="settings-heading font-weight-bold border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
        </div>
        <ul class="chat-list">
          <li class="list active">
            <div class="profile"><img src="images/faces/face1.jpg" alt="image"><span class="online"></span></div>
            <div class="info">
              <p>Thomas Douglas</p>
              <p>Available</p>
            </div>
            <small class="text-muted my-auto">19 min</small>
          </li>
          <li class="list">
            <div class="profile"><img src="images/faces/face2.jpg" alt="image"><span class="offline"></span></div>
            <div class="info">
              <div class="wrapper d-flex">
                <p>Catherine</p>
              </div>
              <p>Away</p>
            </div>
            <div class="badge badge-success badge-pill my-auto mx-2">4</div>
            <small class="text-muted my-auto">23 min</small>
          </li>
          <li class="list">
            <div class="profile"><img src="images/faces/face3.jpg" alt="image"><span class="online"></span></div>
            <div class="info">
              <p>Daniel Russell</p>
              <p>Available</p>
            </div>
            <small class="text-muted my-auto">14 min</small>
          </li>
          <li class="list">
            <div class="profile"><img src="images/faces/face4.jpg" alt="image"><span class="offline"></span></div>
            <div class="info">
              <p>James Richardson</p>
              <p>Away</p>
            </div>
            <small class="text-muted my-auto">2 min</small>
          </li>
          <li class="list">
            <div class="profile"><img src="images/faces/face5.jpg" alt="image"><span class="online"></span></div>
            <div class="info">
              <p>Madeline Kennedy</p>
              <p>Available</p>
            </div>
            <small class="text-muted my-auto">5 min</small>
          </li>
          <li class="list">
            <div class="profile"><img src="images/faces/face6.jpg" alt="image"><span class="online"></span></div>
            <div class="info">
              <p>Sarah Graves</p>
              <p>Available</p>
            </div>
            <small class="text-muted my-auto">47 min</small>
          </li>
        </ul>
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
                <span><a href="../my-profile.php"><i class="mdi mdi-settings"></i></a></span>
                <span><a href="../support.php"><i class="mdi mdi-bell"></i><span class="count top-right bg-warning"></a></span>
                <span><a href="../generator.php"><i class="fas fa-sync"></i></a></span>
              </div>
            </div>
          </li>
          <li class="nav-item"> <a class="nav-link" href="../index.php"> <img class="menu-icon" src="images/menu_icons/03.png" alt="menu icon"> <span class="menu-title">Dashboard</span></a> </li>
        
          <li class="nav-item"> <a class="nav-link" href="settings.php"> <img class="menu-icon" src="images/menu_icons/07.png" alt="menu icon"> <span class="menu-title">Settings</span> </a> </li>
          	<li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth"> <img class="menu-icon" src="images/menu_icons/01.png" alt="menu icon"> <span class="menu-title">Generator History</span><i class="menu-arrow"></i></a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="manage-statistics.php"> Generator History </a></li>
                <li class="nav-item"> <a class="nav-link" href="../loginlogs.php"> Login Logs </a></li>
                <li class="nav-item"> <a class="nav-link" href="priv-statistics.php"> Priv Generator History</a></li>
                <li class="nav-item"> <a class="nav-link" href="view-applications.php"> View Donations</a></li>
               <li class="nav-item"> <a class="nav-link" href="usergenerationstats.php"> User Statistics</a></li>
                <li class="nav-item"> <a class="nav-link" href="lib/logout.php"> Logout </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item"> <a class="nav-link" href="add-generator.php"> <img class="menu-icon" src="images/menu_icons/05.png" alt="menu icon"> <span class="menu-title">Manage Generators</span> </a> </li>
            <li class="nav-item"> <a class="nav-link" href="admin-news.php"> <img class="menu-icon" src="images/menu_icons/05.png" alt="menu icon"> <span class="menu-title">Manage News</span> </a> </li>
          <li class="nav-item"> <a class="nav-link" href="managefaq.php"> <img class="menu-icon" src="images/menu_icons/05.png" alt="menu icon"> <span class="menu-title">Manage Faq</span> </a> </li>
          <li class="nav-item"> <a class="nav-link" href="add-priv-generator.php"> <img class="menu-icon" src="images/menu_icons/05.png" alt="menu icon"> <span class="menu-title">Manage Priv Generators</span> </a> </li>
          <li class="nav-item"> <a class="nav-link" href="add-package.php" target="blank"> <img class="menu-icon" src="images/menu_icons/05.png" alt="menu icon"> <span class="menu-title">Manage Packages</span> </a> </li>
          <li class="nav-item"> <a class="nav-link" href="manage-freegen.php" target="blank"> <img class="menu-icon" src="images/menu_icons/05.png" alt="menu icon"> <span class="menu-title">Manage Free Gen</span> </a> </li>
          
            <li class="nav-item"> <a class="nav-link" href="manage-users.php" target="blank"> <img class="menu-icon" src="images/menu_icons/05.png" alt="menu icon"> <span class="menu-title">Manage Users</span> </a> </li>
            
              <li class="nav-item"> <a class="nav-link" href="manage-subscriptions.php" target="blank"> <img class="menu-icon" src="images/menu_icons/05.png" alt="menu icon"> <span class="menu-title">Manage Subscriptions</span> </a> </li>
               <li class="nav-item"> <a class="nav-link" href="manage-support.php" target="blank"> <img class="menu-icon" src="images/menu_icons/13.png" alt="menu icon"> <span class="menu-title">Manage Support</span> </a> </li>
              
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