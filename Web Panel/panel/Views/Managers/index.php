<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0"><?php echo managers_lang;?></h2>
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
                <div class="card table-card">
                    <div class="card-body">
                        <div class="text-end p-4 pb-0">
                            <a href="#" class="btn btn-primary d-inline-flex align-items-center"
                               style="margin-bottom: 5px;" data-bs-toggle="modal" data-bs-target="#customer_add-modal">
                                <i class="ti ti-plus f-18"></i><?php echo manager_newuser_lang;?>
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="pc-dt-simple">
                                <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th><?php echo username_tb_lang;?></th>
                                    <th><?php echo password_tb_lang;?></th>
                                    <th><?php echo status_tb_lang;?></th>
                                    <th class="text-center"><?php echo action_tb_lang;?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $uid=0;
                                foreach ($data['for'] as $datum) {
                                    $uid++;
                                    if ($datum["condition_u"] == "active") {
                                        $status = "<span class='badge bg-light-success rounded-pill f-12'>".active_tb_lang."</span>";
                                    }
                                    if ($datum["condition_u"] == "deactive") {
                                        $status = "<span class='badge bg-light-danger rounded-pill f-12'>".deactive_tb_lang."</span>";
                                    }


                                    ?>
                                    <tr>
                                        <td><?php echo $uid; ?></td>
                                        <td><?php echo $datum['username_u']; ?></td>
                                        <td><?php echo $datum['password_u']; ?></td>

                                        <td><?php echo $status; ?></td>

                                        <td class="text-center">
                                            <ul class="list-inline me-auto mb-0">
                                                <li class="list-inline-item align-bottom" >
                                                        <button class="avtar avtar-xs btn-link-success btn-pc-default" style="border:none" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti ti-adjustments f-18"></i></button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="managers&active=<?php echo $datum['username_u']; ?>"><?php echo active_u_act_tb_lang;?></a>
                                                            <a class="dropdown-item" href="managers&deactive=<?php echo $datum['username_u']; ?>"><?php echo deactive_u_act_tb_lang;?></a>
                                                            <a class="dropdown-item" href="managers&delete=<?php echo $datum['username_u']; ?>"><?php echo delete_u_act_tb_lang;?></a>
                                                        </div>
                                                </li>
                                                
                                            </ul>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<div class="modal fade" id="customer_add-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" action="" method="post" enctype="multipart/form-data" onsubmit="return confirm('<?php echo confirm_ac_lang;?>');">

            <div class="modal-header">
                <h5 class="mb-0"><?php echo manager_newuser_lang;?></h5>
                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="modal">
                    <i class="ti ti-x f-20"></i>
                </a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" name="username" class="form-control"
                                               placeholder="<?php echo modal_username_lang;?>" required>
                                        <small class="form-text text-muted"><?php echo modal_username_lable_lang;?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                            <input type="text" name="password" class="form-control"
                                                   placeholder="<?php echo modal_pass_lang;?>" required>
                                        </div>
                                        <small class="form-text text-muted"><?php echo modal_pass_lable_lang;?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="flex-grow-1 text-end">
                    <button type="button" class="btn btn-link-danger btn-pc-default" data-bs-dismiss="modal"><?php echo modal_cancell_lang;?>
                    </button>
                    <button type="submit" class="btn btn-primary" value="submit" name="submit"><?php echo modal_submit_lang;?></button>
                </div>
            </div>
            </form>
    </div>
</div>

<!-- [ Main Content ] end -->
