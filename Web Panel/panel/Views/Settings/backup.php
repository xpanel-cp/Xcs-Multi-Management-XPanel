<div class="card-body">
    <form class="validate-me" action="" method="post" enctype="multipart/form-data">
        <div class="form-group row">
            <div class="col-lg-6">
                <input type="submit" name="savebackup" class="btn btn-primary" value="<?php echo setting_backup_make_lang;?>">
            </div>
        </div>
    </form>
    <form class="validate-me" action="" method="post" enctype="multipart/form-data">

        <div class="form-group row">
            <div class="col-lg-6">
                <div class="UppyInput form"><div class="uppy-Root uppy-FileInput-container">
                        <input class="uppy-FileInput-input form-control" type="file" name="fileToUpload" multiple="" style="">
                        <small class="form-text text-muted"><?php echo setting_backup_make_lable_lang;?></small>
                        <br>
                        <input type="submit" name="upbackup" class="btn btn-primary" value="<?php echo setting_backup_up_lang;?>">

                    </div>
                </div>
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

                            <th><?php echo setting_backup_name_lang;?></th>
                            <th class="text-center"><?php echo action_tb_lang;?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $output = shell_exec("ls /var/www/html/cp/storage/backup");
                        $backuplist = preg_split("/\r\n|\n|\r/", $output);
                        foreach ($backuplist as $backup) {
                            if(!empty($backup))
                            {
                                ?>
                                <tr>
                                    <td><?php echo $backup;?></td>
                                    <td class="text-center">
                                        <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="<?php echo setting_backup_dl_lang;?>">
                                                <a href="/storage/backup/<?php echo $backup;?>" class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                    <i class="ti ti-download f-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="<?php echo setting_backup_res_lang;?>">
                                                <a href="Settings&sort=backup&run=<?php echo $backup;?>" class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                    <i class="ti ti-refresh f-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="<?php echo delete_u_act_tb_lang;?>">
                                                <a href="Settings&sort=backup&delete-backup=<?php echo $backup;?>" class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                    <i class="ti ti-trash f-18"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
