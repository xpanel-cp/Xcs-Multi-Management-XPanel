<!-- [ Main Content ] start -->
<div class="pc-container">
	<div class="pc-content">
		<!-- [ breadcrumb ] start -->
		<div class="page-header">
			<div class="page-block">
				<div class="row align-items-center">
					<div class="col-md-12">
						<div class="page-header-title">
							<h2 class="mb-0"><?php echo filtering_status_lang;?></h2>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- [ breadcrumb ] end -->


		<!-- [ Main Content ] start -->
		<div class="row">
          
			<div class="col-12">
				<div class="card">

					<div class="card-body">
						<div class="row">
							<div class="col-lg-12 col-xl-12">
								<ul class="list-group list-group-flush">
                                    <?php
                                    $serverip = $_SERVER["SERVER_ADDR"];
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, "https://check-host.net/check-tcp?host=" . $serverip.":".PORT."&max_nodes=50");
                                    curl_setopt($ch, CURLOPT_POST, 1);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $headers = ["Accept: application/json", "Cache-Control: no-cache"];
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                    $response = curl_exec($ch);
                                    curl_close($ch);
                                    $array = json_decode($response, true);
                                    $resultlink = "https://check-host.net/check-result/" . $array["request_id"];
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, $resultlink);
                                    curl_setopt($ch, CURLOPT_POST, 1);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $headers = ["Accept: application/json", "Cache-Control: no-cache"];
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                    sleep(3);
                                    $server_output = curl_exec($ch);
                                    curl_close($ch);
                                    $array2 = json_decode($server_output, true);
                                    foreach ($array2 as $key => $value) {
                                    $flag = str_replace(".node.check-host.net", "", $key);
                                    $flag = preg_replace("/[0-9]+/", "", $flag);
                                    if ($flag == "ir" || $flag == "us" || $flag == "fr" || $flag == "de") {
                                    $img = "<img src='assets/images/flags/" . $flag . ".png' >";
                                    if (is_numeric($value[0]["time"])) {
                                        $status = "Online";
                                    } else {
                                        $status = "فیلتر شده";
                                    }
                                    ?>
									<li class="list-group-item">
										<div class="d-flex align-items-center">
											<div class="flex-shrink-0">
												<div class="avtar avtar-s bg-light-secondary">
                                                <?php echo $img;?>
												</div>
											</div>
											<div class="flex-grow-1 ms-3">
												<div class="row g-1">
													<div class="col-6">
														<?php echo $flag;?>
													</div>
													<div class="col-6 text-end">
													<?php echo $status;?>
                                                    </div>
												</div>
											</div>
										</div>
									</li>
                                    <?php
                                    }
                                    }

                                    ?>
                                </ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- [ Main Content ] end -->
	</div>
</div>
<!-- [ Main Content ] end -->
