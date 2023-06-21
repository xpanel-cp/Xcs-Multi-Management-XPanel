<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0"><?php echo users_lang; ?></h2>
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
                        <form action="" method="post" enctype="multipart/form-data">

                            <div class="text-end p-4 pb-0">
                                <a href="#" class="btn btn-primary d-inline-flex align-items-center"
                                    <?php if (LANG == 'fa-ir') {
                                        echo 'style="margin-bottom: 5px;"';
                                    } ?> data-bs-toggle="modal" data-bs-target="#customer_add-modal">
                                    <i class="ti ti-plus f-18"></i> <?php echo new_user_lang; ?>
                                </a>

                                <a href="#" class="btn btn-primary d-inline-flex align-items-center"
                                   data-bs-toggle="modal"
                                   data-bs-target="#customer_bulk-modal">
                                    <i class="ti ti-plus f-18"></i> <?php echo multi_user_new_lang; ?>
                                </a>
                                <button type="submit" id="btndl" class="btn btn-danger d-inline-flex align-items-center"
                                        value="delete" name="delete"><?php echo multi_user_bulk_delete_lang;?>
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover" id="pc-dt-simple">
                                    <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <?php if (permis == 'admin') {
                                            echo "<th>" . customer_tb_lang . "</th>";
                                        } ?>
                                        <th><?php echo server_tb_lang; ?></th>
                                        <th><?php echo username_tb_lang; ?></th>
                                        <th><?php echo password_tb_lang; ?></th>
                                        <th><?php echo traffic_tb_lang; ?></th>
                                        <th><?php echo limit_user_tb_lang; ?></th>
                                        <th><?php echo contacts_tb_lang; ?></th>
                                        <th><?php echo date_tb_lang; ?></th>
                                        <th><?php echo status_tb_lang; ?></th>
                                        <th class="text-center"><?php echo action_tb_lang; ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $uid = 0;
                                    foreach ($data['setting'] as $vals) {
                                        $ststus_multiuser = $vals['ststus_multiuser'];
                                    }
                                    foreach ($data['for'] as $datum) {
                                        $uid++;
                                        if ($datum["traffic"] !== "0") {
                                            if (1024 <= $datum["traffic"]) {
                                                $traffic = $datum["traffic"] / 1024 . ' ' . gib_lang;
                                            } else {
                                                $traffic = $datum["traffic"] . ' ' . mib_lang;
                                            }
                                        } else {
                                            $traffic = unlimited_tb_lang;
                                        }

                                        if (1024 < $datum["download"]) {
                                            $dl = round($datum["download"] / 1024, 2) . ' GB';
                                        } else {
                                            $dl = $datum["download"] . ' MB';
                                        }

                                        if (1024 < $datum["upload"]) {
                                            $up = round($datum["upload"] / 1024, 2) . ' GB';
                                        } else {
                                            $up = $datum["upload"] . ' MB';
                                        }

                                        if ($datum["enable"] == "true") {
                                            $status = "<span class='badge bg-light-success rounded-pill f-12'>" . active_tb_lang . "</span>";
                                        }
                                        if ($datum["enable"] == "false") {
                                            $status = "<span class='badge bg-light-danger rounded-pill f-12'>" . deactive_tb_lang . "</span>";
                                        }
                                        if ($datum["enable"] == "expired") {
                                            $status = "<span class='badge bg-light-warning rounded-pill f-12'>" . expired_tb_lang . "</span>";
                                        }
                                        if ($datum["enable"] == "traffic") {
                                            $status = "<span class='badge bg-light-primary rounded-pill f-12'>" . traffic2_tb_lang . "</span>";
                                        }
                                        $duplicate = [];
                                        $m = 1;
                                        $u = 0;
                                        if ($ststus_multiuser == 'on') {
                                            $list = shell_exec("sudo lsof -i :" . PORT . " -n | grep -v root | grep ESTABLISHED");
                                            $onlineuserlist = preg_split("/\r\n|\n|\r/", $list);
                                            $onlineuserlist = preg_split("/\r\n|\n|\r/", $list);
                                            foreach ($onlineuserlist as $user) {
                                                $user = preg_replace("/\\s+/", " ", $user);
                                                if (strpos($user, ":AAAA") !== false) {
                                                    $userarray = explode(":", $user);
                                                } else {
                                                    $userarray = explode(" ", $user);
                                                }
                                                if (strpos($userarray[8], "->") !== false) {
                                                    $userarray[8] = strstr($userarray[8], "->");
                                                    $userarray[8] = str_replace("->", "", $userarray[8]);
                                                    $userip = substr($userarray[8], 0, strpos($userarray[8], ":"));
                                                } else {
                                                    $userip = $userarray[8];
                                                }
                                                $color = "#dc2626";
                                                if (!in_array($userarray[2], $duplicate)) {
                                                    $color = "#269393";
                                                    array_push($duplicate, $userarray[2]);
                                                }
                                                if (!empty($userarray[2]) && $userarray[2] == $datum['username'] && $userarray[2] !== "sshd") {
                                                    $u++;
                                                }
                                            }
                                        }
                                        if (LANG == 'fa-ir') {
                                            if (!empty($datum['startdate'])) {
                                                $startdate = explode('-', $datum['startdate']);
                                                $startdate = gregorian_to_jalali($startdate[0], $startdate[1], $startdate[2]);
                                                if ($startdate[2] >= 10) {
                                                    $startday = $startdate[2];
                                                } else {
                                                    $startday = '0' . $startdate[2];
                                                }
                                                if ($startdate[1] >= 10) {
                                                    $startmon = $startdate[1];
                                                } else {
                                                    $startmon = '0' . $startdate[1];
                                                }
                                                $startdate = $startday . '-' . $startmon . '-' . $startdate[0];
                                            } else {
                                                $startdate = '';
                                            }
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
                                                $finishdate = $finishday . '-' . $finishmon . '-' . $finishdate[0];
                                            } else {
                                                $finishdate = '';
                                            }
                                        } else {
                                            $startdate = $datum['startdate'];
                                            $finishdate = $datum['finishdate'];
                                        }
                                        if (!empty($datum['customer_user'])) {
                                            $customer_user = $datum['customer_user'];
                                        } else {
                                            $customer_user = DB_USER;
                                        }
                                        $dropb_port = "";
                                        $dropb_tls_port = "";
                                        $ssh_tls_port = "";

                                        foreach ($data['for'] as $val) {
                                            if (isset($val['dropb_port'])) {
                                                $dropb_port = $val['dropb_port'];
                                            }
                                            if (empty($dropb_port) || $dropb_port == 'NULL') {
                                                $dropb_port = '222';
                                            }

                                            if (isset($val['dropb_tls_port'])) {
                                                $dropb_tls_port = $val['dropb_tls_port'];
                                            }
                                            if (empty($dropb_tls_port) || $dropb_tls_port == 'NULL') {
                                                $dropb_tls_port = '2083';
                                            }

                                            if (isset($val['ssh_tls_port'])) {
                                                $ssh_tls_port = $val['ssh_tls_port'];
                                            }
                                            if (empty($ssh_tls_port) || $ssh_tls_port == 'NULL') {
                                                $ssh_tls_port = '444';
                                            }


                                        }
                                        ?>
                                        <tr>
                                            <td><input name="usernamed[]" id="checkItem" type="checkbox"
                                                       class="checkItem form-check-input"
                                                       value="<?php echo $datum['username']; ?>"/> <?php echo $uid; ?>
                                            </td>
                                            <?php if (permis == 'admin') {
                                                echo "<td>" . $customer_user . "</td>";
                                            } ?>
                                            <td><?php echo $datum['username']; ?></td>
                                            <td><?php echo $datum['password']; ?></td>
                                            <td><?php echo $traffic; ?>
                                                <br>
                                                <small>
                                                    <span style="background: #fe9e4a; padding: 2px; color: #fff; border-radius: 5px;"><i
                                                                class="ti ti-cloud-upload"></i> <?php echo $up; ?></span>
                                                    &nbsp;<span
                                                            style="background: #4a9afe; padding: 2px; color: #fff; border-radius: 5px;"><i
                                                                class="ti ti-cloud-download"></i> <?php echo $dl; ?></span>
                                                </small></td>
                                            <td><?php echo $datum['multiuser']; ?><br>
                                                <small><?php if ($ststus_multiuser == 'on') {
                                                        echo Connection_tab_lang . " " . $u . " " . userto_tb_lang . " " . $datum['multiuser'] . " " . user_tb_lang;
                                                    } ?></small></td>
                                            <td><?php echo $datum['mobile']; ?><br>
                                                <small><?php echo $datum['email']; ?></small></td>
                                            <td><small>
                                                    <?php echo register_date_tb_lang . ": " . $startdate; ?>
                                                    <br>
                                                    <?php echo expired_date_tb_lang . ": " . $finishdate; ?>
                                                </small></td>
                                            <td><?php echo $status; ?></td>
                                            <td class="text-center">
                                                <ul class="list-inline me-auto mb-0">
                                                    <li class="list-inline-item align-bottom">
                                                        <button class="avtar avtar-xs btn-link-success btn-pc-default"
                                                                style="border:none" type="button"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"><i
                                                                    class="ti ti-adjustments f-18"></i></button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item"
                                                               href="users&active=<?php echo $datum['username']; ?>"><?php echo active_u_act_tb_lang; ?></a>
                                                            <a class="dropdown-item"
                                                               href="users&deactive=<?php echo $datum['username']; ?>"><?php echo deactive_u_act_tb_lang; ?></a>
                                                            <a class="dropdown-item"
                                                               href="users&reset-traffic=<?php echo $datum['username']; ?>"><?php echo reset_u_act_tb_lang; ?></a>
                                                            <a class="dropdown-item"
                                                               href="users&delete=<?php echo $datum['username']; ?>"><?php echo delete_u_act_tb_lang; ?></a>
                                                        </div>
                                                    </li>
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="<?php echo edit_tooltip_tb_lang; ?>">
                                                        <a href="edituser&username=<?php echo $datum['username']; ?>"
                                                           class="avtar avtar-xs btn-link-success btn-pc-default">
                                                            <i class="ti ti-edit-circle f-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="<?php echo multi_user_renewal_lang; ?>">
                                                        <a href="#" data-user="<?php echo $datum['username']; ?>" data-bs-toggle="modal"
                                                           data-bs-target="#renewal-modal"
                                                           class="re_user avtar avtar-xs btn-link-success btn-pc-default">
                                                            <i class="ti ti-calendar-plus f-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item align-bottom">
                                                        <button class="avtar avtar-xs btn-link-success btn-pc-default"
                                                                style="border:none" type="button"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"><i class="ti ti-share f-18"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" style="border:none"
                                                                    data-clipboard="true"
                                                                    data-clipboard-text="Host:<?php echo $_SERVER["SERVER_NAME"]; ?>&nbsp;
Port:<?php echo PORT; ?>&nbsp;
TLS Port:<?php echo $ssh_tls_port; ?>&nbsp;
Username:<?php echo $datum['username']; ?>&nbsp;
Password:<?php echo $datum['password']; ?>&nbsp;
<?php if (!empty($startdate)) {
                                                                        echo "StartTime:" . $startdate . "&nbsp;";
                                                                    } ?>
<?php if (!empty($finishdate)) {
                                                                        echo "EndTime:" . $finishdate;
                                                                    } ?>"> <?php echo share_copyconfig_tb_lang; ?></a>

                                                            <a href="#" class="dropdown-item" style="border:none"
                                                                    data-clipboard="true"
                                                                    data-clipboard-text="ssh://<?php echo $datum['username']; ?>:<?php echo $datum['password']; ?>@<?php echo $_SERVER["SERVER_NAME"]; ?>:<?php echo PORT; ?>/#<?php echo $datum['username']; ?>">Link SSH
                                                            </a>
                                                            <a href="#" class="dropdown-item" style="border:none"
                                                                    data-clipboard="true"
                                                                    data-clipboard-text="ssh://<?php echo $datum['username']; ?>:<?php echo $datum['password']; ?>@<?php echo $_SERVER["SERVER_NAME"]; ?>:<?php echo $ssh_tls_port; ?>/#<?php echo $datum['username']; ?>">Link SSH TLS
                                                            </a>
                                                            <a href="#" class="qrs dropdown-item"
                                                               data-tls="ssh://<?php echo $datum['username']; ?>:<?php echo $datum['password']; ?>@<?php echo $_SERVER["SERVER_NAME"]; ?>:<?php echo $ssh_tls_port; ?>/#<?php echo $datum['username']; ?>"
                                                               data-id="ssh://<?php echo $datum['username']; ?>:<?php echo $datum['password']; ?>@<?php echo $_SERVER["SERVER_NAME"]; ?>:<?php echo PORT; ?>/#<?php echo $datum['username']; ?>"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#qr-modal">
                                                                QR
                                                            </a>

                                                        </div>
                                                    </li>

                                                </ul>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

<!-- qr -->
<div class="modal fade" id="qr-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="display: -webkit-inline-box; text-align: center;width: 600px;">
            <div><br>
                SSH DIRECT<br><span id="idHolderSSH"></span>
            </div>
            <div><br>
                SSH TLS<br><span id="idHolderTLS"></span>
            </div>
        </div>
    </div>
</div>
<!-- renewal -->
<div class="modal fade" id="renewal-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content" action="" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="mb-0"><?php echo multi_user_renewal_lang; ?></h5>
                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="modal">
                    <i class="ti ti-x f-20"></i>
                </a>
            </div>
            <div class="modal-body" >
                <div class="form-group row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <input type="text" name="day_date" class="form-control" placeholder="30">
                                    <input type="hidden" name="username_re" id="input_user" value="" class="input_user form-control" placeholder="30">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <p><?php echo multi_user_renewal_desc_lang;?></p>
                                <div class="input-group">

                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="re_date" value="yes" class="form-check-input input-primary" checked>
                                        <label class="form-check-label" for="customCheckinl311"><?php echo multi_user_renewal_yes_lang; ?></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="re_date" value="no" class="form-check-input input-primary" >
                                        <label class="form-check-label" for="customCheckinl311"><?php echo multi_user_renewal_no_lang; ?></label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="flex-grow-1 text-end">
                    <button type="button" class="btn btn-link-danger btn-pc-default"
                            data-bs-dismiss="modal"><?php echo modal_cancell_lang; ?>
                    </button>
                    <button type="submit" class="btn btn-primary" value="submit"
                            name="renewal_date"><?php echo register_date_tb_lang; ?></button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="customer_add-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content" action="" method="post" enctype="multipart/form-data"
              onsubmit="return confirm('<?php echo confirm_ac_lang; ?>');">

            <div class="modal-header">
                <h5 class="mb-0"><?php echo new_user_lang; ?></h5>
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
                                               placeholder="<?php echo modal_username_lang; ?>" autocomplete="off"
                                               onkeyup="if (/[^|a-z0-9]+/g.test(this.value)) this.value = this.value.replace(/[^|a-z0-9]+/g,'')"
                                               required>
                                        <small class="form-text text-muted"><?php echo modal_username_lable_lang; ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                            <input type="text" name="password" class="form-control"
                                                   placeholder="<?php echo modal_pass_lang; ?>" autocomplete="off"
                                                   value="<?php echo $data['password']; ?>" required>
                                        </div>
                                        <small class="form-text text-muted"><?php echo modal_pass_lable_lang; ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" name="email" class="form-control"
                                               placeholder="<?php echo modal_email_lang; ?>">
                                        <small class="form-text text-muted"><?php echo modal_email_lable_lang; ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input type="text" name="mobile" class="form-control"
                                                   placeholder="<?php echo modal_phone_lang; ?>">
                                        </div>
                                        <small class="form-text text-muted"><?php echo modal_phone_lable_lang; ?></small>
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
                                        <div class="input-group">
                                            <input type="text" name="connection_start" class="form-control"
                                                   placeholder="30">
                                        </div>
                                        <small class="form-text text-muted"><?php echo modal_expdate_lang; ?></small>
                                        <small style="color:red"><?php echo modal_expdate_lable_lang; ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <select name="server" class="form-select">
                                            <option value=""><?php echo select_lang;?></option>
                                            <option>Complicated</option>
                                            <option>Single</option>
                                            <option>Relationship</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" name="traffic" class="form-control" value="0">
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input input-primary"
                                                   name="type_traffic" value="mb" checked="">
                                            <label class="form-check-label"
                                                   for="customCheckinl311"><?php echo mib_lang; ?></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input input-primary"
                                                   name="type_traffic" value="gb">
                                            <label class="form-check-label"
                                                   for="customCheckinl32"><?php echo gib_lang; ?></label>
                                        </div>
                                        <small class="form-text text-muted"><?php echo modal_traffic_lable_lang; ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-calendar-time"></i></span>
                                            <?php if (LANG == 'fa-ir') { ?>
                                                <input type="text" name="expdate" class="form-control example1"/>
                                            <?php } else { ?>
                                                <input type="date" class="form-control" name="expdate" id="date"
                                                       data-gtm-form-interact-field-id="0">
                                            <?php } ?>
                                        </div>
                                        <small class="form-text text-muted"><?php echo modal_expdate2_lang; ?></small>
                                        <small style="color:red"><?php echo modal_expdate2_lable_lang; ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?php echo modal_desc_lang; ?></label>
                            <textarea class="form-control" rows="3" name="desc"
                                      placeholder="<?php echo modal_desc_lang; ?>"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="flex-grow-1 text-end">
                    <button type="button" class="btn btn-link-danger btn-pc-default"
                            data-bs-dismiss="modal"><?php echo modal_cancell_lang; ?>
                    </button>
                    <button type="submit" class="btn btn-primary" value="submit"
                            name="submit"><?php echo modal_submit_lang; ?></button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bulk -->
<div class="modal fade" id="customer_bulk-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content" action="" method="post" enctype="multipart/form-data"
              onsubmit="return confirm('<?php echo confirm_ac_lang; ?>');">

            <div class="modal-header">
                <h5 class="mb-0"><?php echo multi_user_new_lang; ?></h5>
                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="modal">
                    <i class="ti ti-x f-20"></i>
                </a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" name="count_user" class="form-control" value="5"
                                               placeholder="<?php echo modal_b_count_lang; ?>" required>
                                        <small class="form-text text-muted"><?php echo modal_b_count_lable_lang; ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" name="start_user" class="form-control" value="xpuser"
                                               placeholder="<?php echo modal_b_one_a_lang; ?>" required>
                                        <small class="form-text text-muted"><?php echo modal_b_one_a_lable_lang; ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" name="start_number" class="form-control" value="100"
                                               placeholder="<?php echo modal_b_starting_number_lang; ?>" required>
                                        <small class="form-text text-muted"><?php echo modal_b_starting_number_lable_lang; ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                            <input type="text" name="password" class="form-control"
                                                   placeholder="<?php echo modal_b_password_lang; ?>">
                                        </div>
                                        <small class="form-text text-muted"><?php echo modal_b_password_lable_lang; ?></small>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input input-primary"
                                                   name="pass_random" value="number" checked="">
                                            <label class="form-check-label"
                                                   for="customCheckinl311"><?php echo modal_b_combination_numbers_lang; ?></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input input-primary"
                                                   name="pass_random" value="nmuber_az">
                                            <label class="form-check-label"
                                                   for="customCheckinl311"><?php echo modal_b_combination_letters_numbers_lang; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input type="text" name="char_pass" class="form-control" value="6"
                                                   placeholder="<?php echo modal_b_char_pass_lang; ?>" required>
                                        </div>
                                        <small class="form-text text-muted"><?php echo modal_b_char_pass_lable_lang; ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" name="multiuser" class="form-control" value="1"
                                               placeholder="<?php echo modal_b_multi_user_lang; ?>" required>
                                        <small class="form-text text-muted"><?php echo modal_b_multi_user_lable_lang; ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input type="text" name="connection_start" class="form-control"
                                                   value="30" placeholder="30" required>
                                        </div>
                                        <small class="form-text text-muted"><?php echo modal_expdate_lang; ?></small>
                                        <small style="color:red"><?php echo modal_expdate_lable_lang; ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" name="traffic" class="form-control" value="0" required>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input input-primary"
                                                   name="type_traffic" value="mb" checked="">
                                            <label class="form-check-label"
                                                   for="customCheckinl311"><?php echo mib_lang; ?></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input input-primary"
                                                   name="type_traffic" value="gb">
                                            <label class="form-check-label"
                                                   for="customCheckinl32"><?php echo gib_lang; ?></label>
                                        </div>
                                        <small class="form-text text-muted"><?php echo modal_traffic_lable_lang; ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="alert alert-warning" role="alert">
                                            <?php echo modal_b_alert_lang; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="flex-grow-1 text-end">
                    <button type="button" class="btn btn-link-danger btn-pc-default"
                            data-bs-dismiss="modal"><?php echo modal_cancell_lang; ?>
                    </button>
                    <button type="submit" class="btn btn-primary" value="bulk"
                            name="bulk"><?php echo modal_submit_lang; ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery.min.js"></script>

<!-- [ Main Content ] end -->
<script type="text/javascript">
    $(document).on("click", ".qrs", function () {
        var eventId = $(this).data('id');
        var eventIdtls = $(this).data('tls');
        var qr = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" + eventId + "&choe=UTF-8\" title=" + eventId + " />";
        var qrtls = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" + eventIdtls + "&choe=UTF-8\" title=" + eventIdtls + " />";
        $('#idHolderSSH').html(qr);
        $('#idHolderTLS').html(qrtls);
    });
</script>
<script type="text/javascript">
    $(document).on("click", ".re_user", function () {
        var username = $(this).data('user');
        $('input[name=username_re]').val(username);

    });
</script>
<script>
    $(document).ready(function () {
        document.getElementById("btndl").disabled = true;
    });
    $(document).on("click", ".checkItem", function () {

        document.getElementById("btndl").disabled = false;

    });
</script>