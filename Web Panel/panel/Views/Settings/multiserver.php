<div class="card-body">
    <form class="validate-me" action="" method="post" enctype="multipart/form-data">
        <div class="form-group row">
                    <div class="col-lg-6">
                      <input type="text" name="link" id="confirm-password"  class="form-control" required="">
                      <small class="form-text text-muted"><?php echo setting_multiserver_ip_lang;?></small>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-lg-6">
                      <input class="form-control" type="text" name="token" required="">
                      <small class="form-text text-muted"><?php echo setting_multiserver_uname_lang;?></small>
                    </div>
                  </div>

        <div class="form-group row">
            <div class="col-lg-6">
                <input class="form-control" type="text" name="name" required="">
                <small class="form-text text-muted"><?php echo setting_multiserver_pass_lang;?></small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <input class="form-control" type="text" name="port" required="">
                <small class="form-text text-muted"><?php echo setting_multiserver_port_lang;?></small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <input class="form-control" type="text" name="port_tls" required="">
                <small class="form-text text-muted"><?php echo setting_multiserver_port_tls_lang;?></small>
            </div>
        </div>

                  <div class="form-group row">
                    <div class="col-lg-4 col-form-label"></div>
                    <div class="col-lg-6">
                        <input type="submit" class="btn btn-primary" name="addserver" value="<?php echo register_date_tb_lang;?>">
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
          										<th><?php echo setting_multiserver_pass_lang;?></th>
          										<th><?php echo setting_multiserver_ip_lang;?></th>
          										<th><?php echo setting_multiserver_port_lang;?></th>
          										<th><?php echo setting_multiserver_port_tls_lang;?></th>
          										<th><?php echo setting_multiserver_uname_lang;?></th>
          										<th class="text-center"><?php echo action_tb_lang;?></th>
          									</tr>
          								</thead>
          								<tbody>
                                        <?php  foreach($data['server'] as $val){
                                        $id=$val['id'];
                                        $link=$val['link'];
                                        $token=$val['token'];
                                        $name=$val['name'];
                                        $port=$val['port_connection'];
                                        $port_tls=$val['port_connection_tls'];
                                        ?>
                                        <tr>
                                            <td>#</td>
                                            <td><?php echo $name;?></td>
                                            <td><?php echo $link;?></td>
                                            <td><?php echo $port;?></td>
                                            <td><?php echo $port_tls;?></td>
                                            <td><?php echo $token;?></td>
                                            <td class="text-center"><ul class="list-inline me-auto mb-0">
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" aria-label="حذف" data-bs-original-title="حذف">
                                                        <a href="Settings&sort=multiserver&delete=<?php echo $id;?>" class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                            <i class="ti ti-trash f-18"></i>
                                                        </a>
                                                    </li>
                                                </ul></td>
                                        </tr>
                                        <?php } ?>
          									</tbody>
          							</table>
          						</div>
          					</div>
          				</div>
          			</div>

              </div>
