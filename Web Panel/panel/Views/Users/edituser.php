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
                            function en_number($number)
                            {
                                if(!is_numeric($number) || empty($number))
                                    //return '۰';
                                    $en = array("0","1","2","3","4","5","6","7","8","9");
                                $fa = array("۰","۱","۲","۳","۴","۵","۶","۷","۸","۹");
                                return str_replace($en,$fa, $number);
                            }
                            foreach ($data['for'] as $datum) {
                                if(LANG=='fa-ir') {
                                    if (!empty($datum['finishdate'])) {
                                        $finishdate = explode('-', $datum['finishdate']);
                                        $finishdate = gregorian_to_jalali($finishdate[0], $finishdate[1], $finishdate[2]);
                                        if ($finishdate[2] >= 10) {
                                            $finishday = $finishdate[2];
                                        } else {
                                            $finishday = '0' . $finishdate[2];
                                        }
                                        if ($finishdate[1] >= 10) {
                                            $finishmon = $finishdate[1];
                                        } else {
                                            $finishmon = '0' . $finishdate[1];
                                        }
                                        $finishdate =en_number($finishdate[0].'/'.$finishmon.'/'. $finishday);
                                    } else {
                                        $finishdate = '';
                                    }
                                }
                                else{
                                    $finishdate = $datum['finishdate'];
                                }


                                ?>
                                <form class="modal-content" action="" method="post" enctype="multipart/form-data" onsubmit="return confirm('<?php echo confirm_ac_lang;?>'');">

                                    <div class="">
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <input type="text" class="form-control" placeholder="<?php echo modal_username_lang;?>" value="<?php echo $datum['username'];?>" disabled="">
                                                        <input type="hidden" name="username" class="form-control" placeholder="<?php echo modal_username_lang;?>" value="<?php echo $datum['username'];?>" >
                                                        <small class="form-text text-muted"><?php echo modal_username_lable_lang;?></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                                            <input type="text" name="password" class="form-control" placeholder="<?php echo modal_pass_lang;?>" required="" value="<?php echo $datum['password'];?>">
                                                        </div>
                                                        <small class="form-text text-muted"><?php echo modal_pass_lable_lang;?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <input type="text" name="email" class="form-control" placeholder="<?php echo modal_email_lang;?>" value="<?php echo $datum['email'];?>">
                                                        <small class="form-text text-muted"><?php echo modal_email_lable_lang;?></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="input-group">
                                                            <input type="text" name="mobile" class="form-control" placeholder="<?php echo modal_phone_lang;?>" value="<?php echo $datum['mobile'];?>">
                                                        </div>
                                                        <small class="form-text text-muted"><?php echo modal_phone_lable_lang;?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <input type="text" name="multiuser" class="form-control" placeholder="<?php echo modal_multiuser_lang;?>" required="" value="<?php echo $datum['multiuser'];?>">
                                                        <small class="form-text text-muted"><?php echo modal_multiuser_lable_lang;?></small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <input type="text" name="traffic" class="form-control"  value="<?php echo $datum['traffic'];?>">
                                                        <br>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" class="form-check-input input-primary" name="type_traffic" value="mb" checked="">
                                                            <label class="form-check-label" for="customCheckinl311"><?php echo mib_lang;?></label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" class="form-check-input input-primary" name="type_traffic" value="gb">
                                                            <label class="form-check-label" for="customCheckinl32"><?php echo gib_lang;?></label>
                                                        </div>
                                                        <small class="form-text text-muted"><?php echo modal_traffic_lable_lang;?></small>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="input-group">
                                                                <?php if(LANG=='fa-ir') { ?>
                                                                    <input type="text" name="expdate" value="<?php echo $finishdate;?>" class="form-control example1" />
                                                                <?php  } else {?>
                                                                    <input type="date" class="form-control" value="<?php echo $finishdate;?>" name="expdate" id="date" data-gtm-form-interact-field-id="0">
                                                                <?php }?>
                                                            </div>
                                                            <small class="form-text text-muted"><?php echo edit_exdate_lang;?></small>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6" >
                                                    <div class="row">
                                                        <div class="col-lg-12" style="margin-right:2%">
                                                            <br>
                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" class="form-check-input input-primary" name="activate" value="true" <?php if($datum['enable']=='true'){echo 'checked="" ';}?>>
                                                                <label class="form-check-label" for="customCheckinl311"><?php echo active_tb_lang;?></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" class="form-check-input input-primary" name="activate" value="false" <?php if($datum['enable']!='true'){echo 'checked="" ';}?>>
                                                                <label class="form-check-label" for="customCheckinl32"><?php echo deactive_tb_lang;?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <label class="form-label"><?php echo modal_desc_lang;?></label>
                                                        <textarea class="form-control" rows="3" name="desc" placeholder="<?php echo modal_desc_lang;?>"><?php echo $datum['info'];?></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-primary" value="submit" name="submit"><?php echo edit_submit_lang;?></button>                        </div>
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
