<div class="card-body">
    <form class="validate-me" action="" method="post" enctype="multipart/form-data">
        <div class="form-group row">
            <div class="col-lg-6">
                <input type="text" name="desc" class="form-control" required="">
                <small class="form-text text-muted"><?php echo setting_api_desc_lang;?></small>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6">
                <input class="form-control" type="text" name="allowip" required="" value="0.0.0.0/0">
                <small class="form-text text-muted"><?php echo setting_api_ip_lang;?></small>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-4 col-form-label"></div>
            <div class="col-lg-6">
                <input type="submit" name="addapi" class="btn btn-primary" value="<?php echo modal_submit_lang;?>">
            </div>
        </div>
    </form>
    <hr>
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="pc-dt-simple">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo setting_api_token_lang;?></th>
                            <th><?php echo setting_api_ip_lang;?></th>
                            <th class="text-center"><?php echo setting_api_renew_token_lang;?></th>
                            <th class="text-center"><?php echo delete_u_act_tb_lang;?></th>
                        </tr>

                        <?php  foreach($data['api'] as $val){
                            $Token=$val['Token'];
                            $Description=$val['Description'];
                            $Allowips=$val['Allowips'];
                            $enable=$val['enable'];
                            ?>
                            <tr>
                                <td>#</td>
                                <td><?php echo $Token;?></td>
                                <td><?php echo $Allowips;?><br><small><?php echo $Description;?></small></td>
                                <td class="text-center">
                                    <a href="Settings&sort=api&renew=<?php echo $Token;?>" class="avtar avtar-xs btn-link-success btn-pc-default">
                                        <i class="ti ti-refresh f-18"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="Settings&sort=api&delete=<?php echo $Token;?>" class="avtar avtar-xs btn-link-success btn-pc-default">
                                        <i class="ti ti-trash f-18"></i>
                                    </a></td>
                            </tr>
                        <?php } ?>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
