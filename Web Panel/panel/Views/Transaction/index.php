<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0"><?php echo transaction_name_lang;?></h2>
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

                        <div class="table-responsive">
                            <table class="table table-hover" id="pc-dt-simple">
                                <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th><?php echo transaction_desc_lang;?></th>
                                    <th><?php echo transaction_amount_lang;?></th>
                                    <th><?php echo transaction_date_lang;?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $uid=0;
                                foreach ($data['for'] as $datum) {
                                    $uid++;
                                    if (LANG == 'fa-ir') {
                                            $date_time = explode('-', $datum['date_time']);
                                            $date_time = gregorian_to_jalali($date_time[0], $date_time[1], $date_time[2]);
                                            if ($date_time[2] >= 10) {
                                                $date_timeday = $date_time[2];
                                            } else {
                                                $date_timeday = '0' . $date_time[2];
                                            }
                                            if ($date_time[1] >= 10) {
                                                $date_timemon = $date_time[1];
                                            } else {
                                                $date_timemon = '0' . $date_time[1];
                                            }
                                            $date_time = $date_time[0] . '-' . $date_timemon . '-' .$date_timeday;

                                    } else {
                                        $date_time = $datum['date_time'];
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $uid; ?></td>
                                        <td><?php echo $datum['desc_trans'].' '.customer_tb_lang.' '.$datum['username_trans']; ?></td>
                                        <td><?php echo number_format($datum["amount_trans"]); ?></td>
                                        <td><?php echo $date_time ?></td>
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
