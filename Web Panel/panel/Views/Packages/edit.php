<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0"><?php echo package_editname_lang;?></h2>
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
                                $id = htmlentities($_GET['id']);
                                if($datum['multi']=='on')
                                {
                                 $smultion='checked';
                                 $smultioff='';
                                }
                                else
                                {
                                    $smultion='';
                                    $smultioff='checked';
                                }
                                ?>
                                <form class="modal-content" action="" method="post" enctype="multipart/form-data" onsubmit="return confirm('<?php echo confirm_ac_lang;?>');">

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-lg-4">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="hidden" name="id" class="form-control" value="<?php echo $id;?>" required>
                                                                <input type="text" name="title" class="form-control" value="<?php echo $datum['title'];?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="input-group">
                                                                    <input type="text" name="amount" class="form-control"
                                                                           value="<?php echo $datum['amount'];?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="input-group">
                                                                    <input type="text" name="day" class="form-control"
                                                                           value="<?php echo $datum['day'];?>" required>
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
                                                                <input type="radio" name="multi" value="on" class="form-check-input input-primary" <?php echo $smultion;?>>
                                                                <label class="form-check-label" for="customCheckinl311"><?php echo package_multion_lang; ?></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" name="multi" value="off" class="form-check-input input-primary" <?php echo $smultioff;?> >
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

                                                                        <option value="<?php echo $datum['id'];?>"><?php echo $datum['name'];?></option>
                                                                        <optgroup label="<?php echo package_chserver_lang;?>">
                                                                        <?php  foreach($data['server'] as $val){
                                                                            $name=$val['name'];
                                                                            $id=$val['id'];
                                                                            ?>
                                                                            <option value="<?php echo $id;?>"><?php echo $name;?></option>
                                                                        <?php }?>
                                                                        </optgroup>
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
