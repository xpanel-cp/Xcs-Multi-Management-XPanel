<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0"><?php echo edit_user_lang;?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->


        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <?php

                            foreach ($data['for'] as $datum) {
                                ?>
                                <form class="modal-content" action="" method="post" enctype="multipart/form-data" onsubmit="return confirm('<?php echo confirm_ac_lang;?>');">

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-lg-4">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control" value="<?php echo $datum['username_u'];?>" disabled>
                                                                <input type="hidden" name="username" class="form-control" value="<?php echo $datum['username_u'];?>" >
                                                                <small class="form-text text-muted"><?php echo modal_username_lable_lang;?></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="input-group">
                                                                    <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                                                    <input type="text" name="password" class="form-control"
                                                                           value="<?php echo $datum['password_u'];?>" required>
                                                                </div>
                                                                <small class="form-text text-muted"><?php echo modal_pass_lable_lang;?></small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="input-group">
                                                                    <input type="text" name="credit" class="form-control"
                                                                           value="<?php echo $datum['credit_u'];?>" required>
                                                                </div>
                                                                <small class="form-text text-muted"><?php echo modal_credit_admin_lang;?></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <div class="flex-grow-1 text-start">
                                            <button type="submit" class="btn btn-primary" value="submit" name="submit"><?php echo edit_submit_lang;?></button>
                                        </div>
                                    </div>
                                </form>

                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

<!-- [ Main Content ] end -->
