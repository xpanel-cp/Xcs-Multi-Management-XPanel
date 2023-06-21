
<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>Login | XPanel</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- [Favicon] icon -->
  <link rel="icon" href="<?php echo path ?>assets/images/xlogo.png" type="image/x-icon">
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

  <div class="auth-main">
    <div class="auth-wrapper v1">
      <div class="auth-form">
        <div class="card my-5">
          <div class="card-body">
              <form action="" method="post" enctype="multipart/form-data" >
              <div class="text-center">
              <a href="#"><img src="<?php echo path ?>assets/images/xlogo.png" alt="XPanel" style="width: 60px; margin-bottom: 30px;"></a>

            </div>
            <div class="form-group mb-3">
              <input type="text" class="form-control" name="username" placeholder="<?php echo username_lang;?>">
            </div>
            <div class="form-group mb-3">
              <input type="password" class="form-control" name="password" placeholder="<?php echo password_lang;?>">
            </div>
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary" value="submit" name="submit"><?php echo login_lang;?></button>
            </div>
              </form>

          </div>
            <div class="text-center">
                <a href="login&lang=en">English</a> / <a href="login&lang=fa">Persian</a>
        </div>
        </div>
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <!-- Required Js -->
  <script src="<?php echo path ?>assets/js/plugins/popper.min.js"></script>
  <script src="<?php echo path ?>assets/js/plugins/simplebar.min.js"></script>
  <script src="<?php echo path ?>assets/js/plugins/bootstrap.min.js"></script>
  <script src="<?php echo path ?>assets/js/fonts/custom-font.js"></script>
  <script src="<?php echo path ?>assets/js/config.js"></script>
  <script src="<?php echo path ?>assets/js/pcoded.js"></script>
  <script src="<?php echo path ?>assets/js/plugins/feather.min.js"></script>
</body>
<!-- [Body] end -->

</html>
