<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0"><?php echo settings_lang;?></h2>
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
                    <div class="card-body border-bottom pb-0">
                        <ul class="nav nav-tabs analytics-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="Settings&sort=chengepass" class="nav-link <?php $sort= sort; if(empty($sort)){echo 'active';} if($sort=='chengepass'){echo 'active';}?>" type="button" role="tab"  aria-selected="true"><?php echo setting_pass_title_lang;?></a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a href="Settings&sort=multiserver" class="nav-link <?php if($sort=='multiserver'){echo 'active';}?>" type="button" role="tab" aria-selected="false" tabindex="-1"><?php echo setting_multiserver_lang;?></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="Settings&sort=backup" class="nav-link <?php if($sort=='backup'){echo 'active';}?>" type="button" role="tab" aria-selected="false" tabindex="-1"><?php echo setting_backup_lang;?></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="Settings&sort=api" class="nav-link <?php if($sort=='api'){echo 'active';}?>" type="button" role="tab" aria-selected="false" tabindex="-1">API</a>
                            </li>
                           </ul>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <?php
                        foreach($data['for'] as $val)
                        {
                            $adminuser=$val['adminuser'];
                            $adminpassword=$val['adminpassword'];
                            $multiuser=$val['multiuser'];
                            $ststus_multiuser=$val['ststus_multiuser'];
                            $tgtoken=$val['tgtoken'];
                            $tgid=$val['tgid'];
                            $dropb_port=$val['dropb_port'];
                            if(empty($dropb_port) || $dropb_port=='NULL'){$dropb_port='222';}
                            $dropb_tls_port=$val['dropb_tls_port'];
                            if(empty($dropb_tls_port) || $dropb_tls_port=='NULL'){$dropb_tls_port='2083';}
                            $ssh_tls_port=$val['ssh_tls_port'];
                            if(empty($ssh_tls_port) || $ssh_tls_port=='NULL'){$ssh_tls_port='444';}
                        }


                        $sort= sort;
                        if($sort=='chengepass') {include("chengepass.php");}
                        if($sort=='port') {require("sshport.php");}
                        if($sort=='user') {require("user.php");}
                        if($sort=='telegram') {require("telegram.php");}
                        if($sort=='multiserver') {require("multiserver.php");}
                        if($sort=='backup') {require("backup.php");}
                        if($sort=='api') {require("api.php");}
                        if($sort=='block') {require("block.php");}
                        if($sort=='fakeaddress') {require("fakeaddress.php");}
                        if($sort=='wordpress') {require("wordpress.php");}

                        ?>
                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- [ Main Content ] end -->
