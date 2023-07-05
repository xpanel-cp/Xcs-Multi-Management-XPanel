<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0"><?php echo package_name_lang;?></h2>
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
                                <i class="ti ti-plus f-18"></i><?php echo package_packageadd_lang;?>
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="pc-dt-simple">
                                <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th><?php echo package_title_lang;?></th>
                                    <th><?php echo package_amount_lang;?></th>
                                    <th><?php echo package_expday_lang;?></th>
                                    <th><?php echo package_server_lang;?></th>
                                    <th><?php echo package_multiserver_lang;?></th>
                                    <th><?php echo package_traffic_lang;?></th>
                                    <th><?php echo package_multiuser_lang;?></th>
                                    <th class="text-center"><?php echo action_tb_lang;?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $uid=0;
                                foreach ($data['for'] as $datum) {
                                    $uid++;
                                    if ($datum["multi"] == "on") {
                                        $multi = "<span class='badge bg-light-success rounded-pill f-12'>".package_multion_lang."</span>";
                                    }
                                    else{
                                        $multi= "<span class='badge bg-light-danger rounded-pill f-12'>".package_multioff_lang."</span>";
                                    }
                                    if ($datum["traffic"] !== "0") {

                                            $traffic = $datum["traffic"]. ' ' . gib_lang;

                                    } else {
                                        $traffic = unlimited_tb_lang;
                                    }

                                    ?>
                                    <tr>
                                        <td><?php echo $uid; ?></td>
                                        <td><?php echo $datum['title']; ?></td>
                                        <td><?php echo number_format($datum["amount"]); ?></td>
                                        <td><?php echo $datum["day"]; ?></td>
                                        <td><?php echo $datum["name"]; ?></td>
                                        <td><?php echo $multi; ?></td>
                                        <td><?php echo $traffic; ?></td>
                                        <td><?php echo $datum["multiuser"]; ?></td>

                                        <td class="text-center">
                                            <ul class="list-inline me-auto mb-0">
                                                <li class="list-inline-item align-bottom" >
                                                        <button class="avtar avtar-xs btn-link-success btn-pc-default" style="border:none" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti ti-adjustments f-18"></i></button>
                                                        <div class="dropdown-menu">
                                                           <a class="dropdown-item" href="packages&delete=<?php echo $datum['id']; ?>"><?php echo delete_u_act_tb_lang;?></a>
                                                        </div>
                                                </li>
                                                <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                    title="<?php echo edit_tooltip_tb_lang; ?>">
                                                    <a href="editpackage&id=<?php echo $datum['id']; ?>"  class="re_user avtar avtar-xs btn-link-success btn-pc-default">
                                                        <i class="ti ti-edit f-18"></i>
                                                    </a>
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
                <h5 class="mb-0"><?php echo package_packageadd_lang;?></h5>
                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="modal">
                    <i class="ti ti-x f-20"></i>
                </a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" name="title" class="form-control"
                                               placeholder="<?php echo package_title_lang;?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input type="text" name="amount" class="form-control"
                                                   placeholder="<?php echo package_amount_lang;?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input type="text" name="day" class="form-control"
                                                   placeholder="<?php echo package_expday_lang;?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <small><?php echo package_multiserver_lang;?></small>
                                <div class="input-group">

                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="multi" value="on" class="form-check-input input-primary" checked>
                                        <label class="form-check-label" for="customCheckinl311"><?php echo package_multion_lang; ?></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="multi" value="off" class="form-check-input input-primary" >
                                        <label class="form-check-label" for="customCheckinl311"><?php echo package_multioff_lang; ?></label>
                                    </div>

                                </div>
                                <small><?php echo package_multiondesc_lang;?></small>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <select name="server" class="form-select">
                                                <option value=""><?php echo select_lang;?></option>
                                                <?php  foreach($data['server'] as $val){
                                                    $name=$val['name'];
                                                    $id=$val['id'];
                                                    ?>
                                                    <option value="<?php echo $id;?>"><?php echo $name;?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <small class="form-text text-muted"><?php echo package_server_lang;?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" name="multiuser" class="form-control" value="1"
                                               placeholder="<?php echo modal_multiuser_lang; ?>" required>
                                        <small class="form-text text-muted"><?php echo modal_multiuser_lable_lang; ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" name="traffic" class="form-control" value="0">
                                        <small class="form-text text-muted"><?php echo package_traffic_gig_lang; ?></small>
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
