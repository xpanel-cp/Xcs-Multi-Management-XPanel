<div class="card-body">
    <form class="validate-me" id="validate-me" data-validate="" novalidate="true">
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
                    <div class="col-lg-4 col-form-label"></div>
                    <div class="col-lg-6">
                      <input type="submit" class="btn btn-primary" value="<?php echo modal_submit_lang;?>">
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
          										<th><?php echo setting_multiserver_iptb_lang;?></th>
          										<th><?php echo username_tb_lang;?></th>
          										<th><?php echo password_tb_lang;?></th>
          										<th class="text-center"><?php echo action_tb_lang;?></th>
          									</tr>
          								</thead>
          								<tbody>
          									
          									</tbody>
          							</table>
          						</div>
          					</div>
          				</div>
          			</div>

              </div>
