<?php
//Login
define('username_lang','Username');
define('password_lang','Password');
define('login_lang','Login');
//confirm
define('confirm_ac_lang','Are you sure you want to perform this operation?');
define('confirm_re_user_lang','Username is already taken');
define('confirm_success_lang','Operation performed successfully');
define('confirm_sql_lang','Only SQL file is supported');
define('confirm_dev_lang','Design and Development');
define('confirm_last_version_lang','A new version is available');

//menu
define('dashboard_lang','Dashboard');
define('users_lang','Users');
define('online_users_lang','Online Users');
define('filtering_status_lang','Filtering Status');
define('managers_lang','Managers');
define('settings_lang','Settings');
define('logut_lang','Logout');
define('admin_lang','Admin');
define('other_more_lang','Other More');

//dashboard
define('cpu_usage_lang','CPU Usage');
define('ram_usage_lang','RAM Usage');
define('disk_usage_lang','Disk Usage');
define('bandwidth_usage_lang','Bandwidth Usage');
define('active_user_lang','Active');
define('deactive_user_lang','Inactive');
define('online_user_lang','Online');
define('all_users_lang','All Users');
define('high_consumption_lang','High Consumption Users');
define('expiration_lang','Expiration Date');
define('gib_lang','GB');
define('mib_lang','MB');

//users
define('new_user_lang','New User');
define('multi_user_new_lang','Bulk User');
define('multi_user_bulk_delete_lang','Delete');
define('multi_user_renewal_lang','Renewal');
define('multi_user_renewal_desc_lang','The registration date should be registered from today');
define('multi_user_renewal_yes_lang','Yes');
define('multi_user_renewal_no_lang','No');
define('customer_tb_lang','Agent');
define('server_tb_lang','Server');
define('select_lang','Select');
define('username_tb_lang','Username');
define('password_tb_lang','Password');
define('traffic_tb_lang','Traffic');
define('limit_user_tb_lang','User Limit');
define('contacts_tb_lang','Contact Information');
define('date_tb_lang','Date');
define('status_tb_lang','Status');
define('action_tb_lang','Action');
define('unlimited_tb_lang','Unlimited');
define('active_tb_lang','Active');
define('deactive_tb_lang','Inactive');
define('expired_tb_lang','Expired');
define('traffic2_tb_lang','Traffic Exhausted');
define('traffic_usage_lang','Traffic Usage');
define('Connection_tab_lang','Connection');
define('userto_tb_lang','User from');
define('user_tb_lang','User');
define('register_date_tb_lang','Registration');
define('expired_date_tb_lang','Expiration');
define('active_u_act_tb_lang','Activate');
define('deactive_u_act_tb_lang','Deactivate');
define('reset_u_act_tb_lang','Reset Traffic');
define('delete_u_act_tb_lang','Delete');
define('edit_tooltip_tb_lang','Edit');
define('share_tooltip_tb_lang','Share');
define('share_copyconfig_tb_lang','Copy Detail');
define('share_copynetmod_tb_lang','Netmod');
define('share_copynv_tb_lang','NV');
define('modal_username_lang','Username');
define('modal_username_lable_lang','Enter username');
define('modal_pass_lang','Password');
define('modal_pass_lable_lang','Enter password');
define('modal_email_lang','Email');
define('modal_email_lable_lang','Enter email');
define('modal_phone_lang','Phone Number');
define('modal_phone_lable_lang','Enter phone number');
define('modal_multiuser_lang','Concurrent Users');
define('modal_multiuser_lable_lang','Enter number of concurrent users');
define('modal_expdate_lang','Expiration Date (on first connection)');
define('modal_expdate_lable_lang','If you want to set the expiration date on the first connection, enter the number of validity days in the field above');
define('modal_traffic_lable_lang','Enter traffic');
define('modal_expdate2_lang','Expiration Date');
define('modal_expdate2_lable_lang','Leave this field empty if you set the expiration date automatically');
define('modal_desc_lang','Description');
define('modal_cancell_lang','Cancel');
define('modal_submit_lang','Add');
define('modal_b_count_lang','Number of user builds');
define('modal_b_count_lable_lang','Enter the number of user builds');
define('modal_b_one_a_lang','Initial phrase of username');
define('modal_b_one_a_lable_lang','Enter the initial phrase of the username');
define('modal_b_starting_number_lang','Starting number');
define('modal_b_starting_number_lable_lang','This number is placed after the beginning of the username');
define('modal_b_password_lang','password');
define('modal_b_password_lable_lang','If you want the password to be lang, leave the above field blank');
define('modal_b_combination_numbers_lang','Combination of numbers');
define('modal_b_combination_letters_numbers_lang','Combination of letters and numbers');
define('modal_b_char_pass_lang','Number of password characters');
define('modal_b_char_pass_lable_lang','Enter the number of characters of the password');
define('modal_b_multi_user_lang','Simultaneous user');
define('modal_b_multi_user_lable_lang','Enter the number of simultaneous users');
define('modal_b_alert_lang','Note that if the user is already registered, the system will not allow the registration');

//edit user
define('edit_user_lang','Edit user');
define('edit_exdate_lang','Expiration date');
define('edit_submit_lang','Save');

//manager
define('manager_newuser_lang','New manager');

//settings
define('setting_pass_title_lang','Change password');
define('setting_port_ssh_lang','SSH port');
define('setting_multi_user_lang','User limit');
define('setting_botteg_lang','Telegram bot');
define('setting_multiserver_lang','Multiserver');
define('setting_backup_lang','Backup and restore');
define('setting_blockip_lang','Block IP');
define('setting_fakeaddress_lang','Fake address');
define('setting_wordpress_lang','Wordpress');
define('setting_new_lang','New');

//settings api
define('setting_api_alert_lang','API is not available, the user of this case is to start the robot or management system apart from XPanel');
define('setting_api_desc_lang','Description');
define('setting_api_ip_lang','Allowed IPs');
define('setting_api_token_lang','Token');
define('setting_api_renew_token_lang','Renew token');

//settings backup
define('setting_backup_make_lang','Make backup');
define('setting_backup_make_lable_lang','Select SQL file');
define('setting_backup_up_lang','Upload');
define('setting_backup_name_lang','Name');
define('setting_backup_dl_lang','Download');
define('setting_backup_res_lang','Restore');

//settings block
define('setting_block_dec1_lang','In this section you can limit your customers access to Iranian sites.');
define('setting_block_dec2_lang','To do this restriction, first download the GEOIP database using the following command on your server, then activate it through the panel.');
define('setting_block_dec3_lang','If the access to the server and panel is interrupted after completing all the steps, reboot the server once through the site where you provided the server to reset the settings. In this case, the applied restrictions will also be reset. became.');

//settings change pass
define('setting_pass_alert_lang','After changing the password, you will encounter error 500. The error will be fixed by refreshing the page once.');

//settings fake address
define('setting_fakeadd_alert_lang','Attention, by activating the fake address, it will be deleted if you have installed WordPress.');
define('setting_fake_address_lang','Fake address');
define('setting_fakeadd_web_lang','Website address');

//multiserver settings
define('setting_multiserver_alert_lang','This section is unavailable until the correct connection method is prepared and the servers are analyzed');
define('setting_multiserver_ip_lang','Enter XPanel link with port (http://domain:port)');
define('setting_multiserver_uname_lang','Enter the API token');
define('setting_multiserver_pass_lang','Server name');
define('setting_multiserver_iptb_lang','Server IP');

//settings sshport
define('setting_sshport_alert_lang','After changing the port, the server will reboot');
define('setting_sshport_desc_lang','Never use duplicate ports for fields. Also, port 443 and 80 cannot be used');
define('setting_sshport_lable_lang','Change server port');
define('setting_sshtlsport_lable_lang','Change SSH/TLS port');
define('setting_dropbearport_lable_lang','Change Dropbear port');
define('setting_dropbeartlsport_lable_lang','Change Dropbear/TLS port');

//settings telegram
define('setting_telegram_alert_lang','This item is temporarily unavailable until the token communication problem is fixed');
define('setting_telegram_desc1_lang','1- Connect your active domain without filter to server IP');
define('setting_telegram_desc2_lang','2- Use GitHub command to install SSL');
define('setting_telegram_desc3_lang','3- Put the created robot token and the numerical ID of the Telegram account in the following fields');
define('setting_telegram_ssl_lang','Github link to provide SSL');
define('setting_telegram_token_lable_lang','Put the robot token in the field');
define('setting_telegram_id_lable_lang','Enter the numeric ID of the Telegram account in the field');

// settings wordpress
define('setting_wordpress_desc1_lang','Attention, the fake address will be deleted after installing WordPress.');
define('setting_wordpress_desc2_lang','After installing WordPress, when your domain address is entered in the browser without the login panel port, the WordPress website you installed will be loaded.');
define('setting_wordpress_desc3_lang','To install WordPress, first create the database through the command below, then install WordPress with the database specifications.');
define('setting_wordpress_desc4_lang','The Database Name step will be the name of your WordPress database');
define('setting_wordpress_desc5_lang','The Database Username step will be your WordPress database username');
define('setting_wordpress_desc6_lang','Password User step will be your WordPress database password');
define('setting_wordpress_desc7_lang','In the Enter password step, you must enter the root password of the server to create the database');
define('setting_wordpress_desc8_lang','After completing the above steps, start installing WordPress. To install, just enter the link below and proceed with the installation steps');
define('setting_wordpress_install_lang','Start installing WordPress');

//multiuser settings
define('setting_multiuser_dec_lang','Due to slowness in the loading page, the option to display the number of connected users on the users page is selected');
