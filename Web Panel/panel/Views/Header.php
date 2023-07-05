<?php
if (isset($_COOKIE["xcskey"])) {
            $key_login = explode(':', $_COOKIE["xcskey"]);
            $Ukey=$key_login[0];
            $Pkey=$key_login[1];
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $query = $conn->prepare("select * from setting where adminuser='" .$Ukey. "' and login_key='" .$_COOKIE["xcskey"]. "'");
    $query->execute();
    $queryCount = $query->rowCount();
    $query_ress = $conn->prepare("select * from admins where username_u='" . $Ukey . "' and login_key='" . $_COOKIE["xcskey"] . "'");
    $query_ress->execute();
    $queryCount_ress = $query_ress->rowCount();
    if ($queryCount >0) {
        define('permis','admin');
    }
    if ($queryCount_ress >0) {
        define('permis','reseller');
        $query = $conn->prepare("select * from admins where username_u='$Ukey'");
        $query->execute();
        $queryres = $query->fetch();
    }


        }

?>
<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->


<head>
    <title>Xcs</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- [Favicon] icon -->
    <link rel="icon" href="<?php echo path ?>assets/images/xcslogo.png" type="image/x-icon">
    <!-- [Font] Family -->
    <link rel="stylesheet" href="<?php echo path ?>assets/fonts/inter/inter.css" id="main-font-link" />

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="<?php echo path ?>assets/fonts/tabler-icons.min.css" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="<?php echo path ?>assets/fonts/feather.css" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="<?php echo path ?>assets/fonts/fontawesome.css" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="<?php echo path ?>assets/fonts/material.css" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="<?php echo path ?>assets/css/style-<?php echo LANG;?>.css" id="main-style-link" />
    <link rel="stylesheet" href="<?php echo path ?>assets/css/style-preset.css" />
    <link rel="stylesheet" href="<?php echo path ?>assets/css/persian-datepicker.css"/>



</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body>
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->
<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="#" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="<?php echo path ?>assets/images/xcslogo.png" alt="Xcs" style="width:50px"/>
                <span class="badge bg-light-success rounded-pill ms-2 theme-version" style="font-size: 13px;"></span>
            </a>
        </div>
        <div class="navbar-content">
            <div class="card pc-user-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="<?php echo path ?>assets/images/user/avatar-1.jpg" alt="user-image" class="user-avtar wid-45 rounded-circle" />
                        </div>
                        <div class="flex-grow-1 ms-3 me-2">
                            <h6 class="mb-0"><?php echo ucfirst($Ukey);?></h6>
                            <?php if(permis=='reseller'){?>
                            <small><?php echo modal_credit_admin_lang;?>: <?php echo number_format($queryres['credit_u']);?></small>
                            <?php } ?>

                        </div>
                        <a class="btn btn-icon btn-link-secondary avtar" data-bs-toggle="collapse" href="#pc_sidebar_userlink">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-sort-outline"></use>
                            </svg>
                        </a>
                    </div>
                    <div class="collapse pc-user-links" id="pc_sidebar_userlink">
                        <div class="pt-3">
                            <a href="Settings">
                                <i class="ti ti-settings"></i>
                                <span><?php echo settings_lang;?></span>
                            </a>
                            <a href="index&logout">
                                <i class="ti ti-power"></i>
                                <span><?php echo logut_lang;?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="pc-navbar">
                <?php if(permis!='reseller') {?>
                <li class="pc-item">
                    <a href="index" class="pc-link">
                        <i data-feather="airplay"></i>
                        <span class="pc-mtext"><?php echo dashboard_lang;?></span>
                    </a>
                </li><?php }?>

                <li class="pc-item">
                    <a href="users" class="pc-link">
                        <i data-feather="users"></i>
                        <span class="pc-mtext"><?php echo users_lang;?></span>
                    </a>
                </li>
                <?php if(permis!='reseller') {?>
                <li class="pc-item pc-caption">
                    <label><?php echo other_more_lang;?></label>
                    <i class="ti ti-chart-arcs"></i>
                </li>
                <li class="pc-item">
                    <a href="checkip" class="pc-link">
                        <i data-feather="target"></i>
                        <span class="pc-mtext"><?php echo filtering_status_lang;?></span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="managers" class="pc-link">
                        <i data-feather="users"></i>
                        <span class="pc-mtext"><?php echo managers_lang;?></span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="packages" class="pc-link">
                        <i data-feather="package"></i>
                        <span class="pc-mtext"><?php echo package_name_lang;?></span>
                    </a>
                </li>
<?php } ?>
                <li class="pc-item">
                    <a href="transaction" class="pc-link">
                        <i data-feather="credit-card"></i>
                        <span class="pc-mtext"><?php echo transaction_name_lang;?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->
<!-- [ Header Topbar ] start -->
<header class="pc-header">
    <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <?php
        $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <a
                            class="pc-head-link dropdown-toggle arrow-none me-0"
                            data-bs-toggle="dropdown"
                            href="#"
                            role="button"
                            aria-haspopup="false"
                            aria-expanded="false"
                    >
                        <svg class="pc-icon">
                            <use xlink:href="#custom-sun-1"></use>
                        </svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="index&layout=dark" class="dropdown-item">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-moon"></use>
                            </svg>
                            <span>Dark</span>
                        </a>
                        <a href="index&layout=light" class="dropdown-item">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-sun-1"></use>
                            </svg>
                            <span>Light</span>
                        </a>
                    </div>
                </li>
                <li class="dropdown pc-h-item">
                    <a
                            class="pc-head-link dropdown-toggle arrow-none me-0"
                            data-bs-toggle="dropdown"
                            href="#"
                            role="button"
                            aria-haspopup="false"
                            aria-expanded="false"
                    >
                        <i class="ti ti-language"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="index&lang=fa" class="dropdown-item">
                            <i class="ti ti-language"></i>
                            <span>FA</span>
                        </a>
                        <a href="index&lang=en" class="dropdown-item">
                            <i class="ti ti-language"></i>
                            <span>EN</span>
                        </a>
                    </div>
                </li>
        </div>
    </div>
</header>
<!-- [ Header ] end -->
