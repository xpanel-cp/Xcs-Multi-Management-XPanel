<?php
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
require_once("../panel/Config/database.php");
include_once("../panel/Libs/jdf.php");

if (LANG == 'fa-ir') {
    require_once("../panel/Libs/lang/fa-ir.php");
} else {
    require_once("../panel/Libs/lang/en-us.php");
}
try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
if (isset($_GET['ac'])) {
    if (!empty($_GET["ac"])) {
        $error='';
        $account = htmlentities($_GET['ac']);
        $account = explode('_', $account);
        $username = $account[0];
        $password = $account[1];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username=:user and password=:pass");
        $stmt->execute(['user' => $username, 'pass' => $password]);
        $queryCount = $stmt->rowCount();

        if ($queryCount > 0) {

            $user = $stmt->fetch();
            $traffic = $conn->prepare("SELECT * FROM Traffic WHERE user=:user");
            $traffic->execute(['user' => $username]);
            $traffic = $traffic->fetch();
            $traffic = $traffic['total'];
            if (1024 < $traffic) {
                $traffic = round($traffic / 1024, 3) . ' ' . gib_lang;
            } else {
                $traffic = $traffic . ' ' . mib_lang;
            }
            $server = $conn->prepare("SELECT * FROM servers WHERE id=:id");
            $server->execute(['id' => $user['server']]);
            $server = $server->fetch();
            $link = explode(':', $server['link']);
            $link = explode('//', $link[1]);
            $link = $link[1];

            if ($user["traffic"] !== "0") {
                if (1024 <= $user["traffic"]) {
                    $traffic_user = $user["traffic"] / 1024 . ' ' . gib_lang;
                } else {
                    $traffic_user = $user["traffic"] . ' ' . mib_lang;
                }
            } else {
                $traffic_user = unlimited_tb_lang;
            }

            if ($user['enable'] == 'true') {
                $condition = "<span class='text-white p-1 text-xs bg-green-500 rounded-full py-1 px-3'>" . detail_active_lang . "</span>";
            } elseif ($user['enable'] == 'false') {
                $condition = "<span class='text-white p-1 text-xs bg-red-500 rounded-full py-1 px-3'>" . detail_deactive_lang . "</span>";
            } elseif ($user['enable'] == 'expired') {
                $condition = "<span class='text-white p-1 text-xs bg-yellow-500 rounded-full py-1 px-3'>" . detail_deactive_lang . "</span>";
            } elseif ($user['enable'] == 'traffic') {
                $condition = "<span class='text-white p-1 text-xs bg-yellow-500 rounded-full py-1 px-3'>" . detail_deactive_lang . "</span>";
            }

            if (LANG == 'fa-ir') {
                if (!empty($user['finishdate'])) {
                    $finishdate = explode('-', $user['finishdate']);
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
                $finishdate = $user['finishdate'];
            }

            if(isset($_POST['change_server']))
            {

                $checkuser = $conn->prepare("SELECT * FROM users WHERE username=:username");
                $checkuser->execute(['username' => $username]);
                $checkuser = $checkuser->fetch();
                if($checkuser['enable']='true')
                {
                $old_server = $conn->prepare("SELECT * FROM servers WHERE id=:id");
                $old_server->execute(['id' => $user['server']]);
                $old_server = $old_server->fetch();

                $id_server = htmlentities($_POST['server']);
                $server = $conn->prepare("SELECT * FROM servers WHERE id=:id");
                $server->execute(['id' => $id_server]);
                $server = $server->fetch();
                if (1024 < $user['traffic']) {
                        $type_traffic ='gb';
                    } else {
                        $type_traffic ='mb';
                    }
                $post = [
                    'username' => $user['username']
                ];

                $ch = curl_init($old_server['link'] . '/api&key=' . $old_server['token'] . '&method=deleteuser');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);
                if ($response['data']=='User Deleted') {
                    // set post fields
                    $post = [
                        'username' => $user['username'],
                        'password' => $user['password'],
                        'multiuser' => $user['multiuser'],
                        'traffic' => $user['traffic'],
                        'type_traffic' => $type_traffic,
                        'expdate' => $user['finishdate']
                    ];

                    $ch = curl_init($server['link'] . '/api&key=' . $server['token'] . '&method=adduser');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    $response = curl_exec($ch);
                    $response = json_decode($response, true);
                    curl_close($ch);
                    if ($response['data'] == 'User Created') {
                        $sql = "UPDATE users SET server=? WHERE username=?";
                        $conn->prepare($sql)->execute([$id_server, $username]);
                        header("Refresh:0");
                    } else {
                        $error = user_change_server_rep_lang;
                    }
                }
                }
            }
        } else {
            require_once("403.php");
            exit();
        }


    } else {
        require_once("403.php");
        exit();
    }
} else {
    require_once("403.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="Robots" Content="No Index , No Follow" />
    <title>Xcs-User Detail</title>

    <link rel='stylesheet' href='style.css'>
    <link rel="icon" href="xcslogo.png" type="image/x-icon">

</head>
<body <?php if (LANG == 'fa-ir') {
    echo "dir='rtl'";
} else {
    echo "dir='ltr'";
} ?>>
<!-- partial:index.partial.html -->
<div class="flex flex-col items-center justify-center min-h-screen bg-center bg-cover">
    <div class="absolute bg-black opacity-80 inset-0 z-0"></div>
    <!-- defualt theme -->
    <div class="max-w-3xl w-full mx-auto z-10" style="text-align: -webkit-center;">
        <div class="flex flex-col">
            <div class="bg-white shadow-lg  rounded-3xl p-4 m-4">
                <div style="text-align: -webkit-center;">
                    <div class=" relative h-32 w-32   sm:mb-0 mb-3">
                        <img src="xcslogo.png" alt="Xcs" class=" w-32 h-32 object-cover rounded-2xl">
                        <div class="absolute -right-2 bottom-2 -mr-3  text-white text-xs rounded-full">
                            <?php echo $condition; ?>
                        </div>
                    </div>
                    <small>Xcs Multi Management For XPanel</small>
                </div>
                <div class="flex-none sm:flex">
                    <div class="flex-auto sm:ml-5 justify-evenly">
                        <div class="flex items-center justify-between sm:mt-2" style="justify-content: center;">
                            <div class="flex items-center">
                                <div class="flex flex-col" style="border: 1px solid #bec8d0; padding: 5px 0px 2px 9px; border-radius: 9px;">
                                    <div class="flex-auto text-gray-500 my-1">
                                        <span class="mr-3 "><?php echo detail_usernme_lang; ?>: <?php echo $username; ?></span><span
                                                class="mr-3 border-r-2 border-gray-200  max-h-0"></span><span><?php echo detail_password_lang; ?>: <?php echo $password; ?></span>
                                        <span class="mr-3 border-r-2 border-gray-200  max-h-0"></span><span><?php echo detail_sshport_lang; ?>: <?php echo $server['port_connection']; ?></span>
                                        <span class="mr-3 border-r-2 border-gray-200  max-h-0"></span><span><?php echo detail_sshport_tls_lang; ?>: <?php echo $server['port_connection_tls']; ?></span>&nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row items-center mt-2" style="justify-content: center;">
                            <div class="flex">
                                &nbsp;<span
                                        class="text-white p-1 text-xs bg-blue-400 rounded-full py-2 px-5"><?php echo detail_servername_lang; ?>: <?php echo $server['name']; ?></span>
                                &nbsp;
                                <span style="margin-right: 5px;margin-left: 5px"
                                      class="text-white p-1 text-xs bg-blue-400 rounded-full py-2 px-5"><?php echo detail_serverlink_lang; ?>: <?php echo $link; ?></span>&nbsp;
                            </div>

                        </div>

                        <div class="flex flex-row items-center mt-2" style="justify-content: center;">
                            <div class="flex">
                                <div>
                                    SSH-Direct
                                    <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl= ssh://<?php echo $username; ?>:<?php echo $password; ?>@<?php echo $link; ?>:<?php echo $server['port_connection']; ?>/#<?php echo $username; ?>&choe=UTF-8"
                                         title=" <?php echo $username; ?>"/>
                                </div>

                                <div>
                                    SSH-TLS
                                    <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl= ssh://<?php echo $username; ?>:<?php echo $password; ?>@<?php echo $link; ?>:<?php echo $server['port_connection_tls']; ?>/#<?php echo $username; ?>&choe=UTF-8"
                                         title=" <?php echo $username; ?>"/>
                                </div>

                            </div>

                        </div>
                        <div class="flex flex-row items-center pt-2  text-sm text-gray-500"
                             style="justify-content: center;">
                            <div class="flex">
                                <p style="margin: 5px" class="text-white p-1 text-xs bg-gray-400 rounded-full py-2 px-5" ><?php echo detail_traffic_lang; ?>
                                    : <?php echo $traffic_user; ?></p>
                                <p style="margin: 5px" class="text-white p-1 text-xs bg-gray-400 rounded-full py-2 px-5"><?php echo detail_traffic_usage_lang; ?>
                                    : <?php echo $traffic; ?></p>
                                <p style="margin: 5px" class="text-white p-1 text-xs bg-gray-400 rounded-full py-2 px-5"><?php echo detail_expdate_lang; ?>
                                    : <?php echo $finishdate; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php if($user['change_server']=='true'){?>
    <div class="max-w-3xl w-full mx-auto z-10" style="text-align: -webkit-center;">
        <div class="flex flex-col">
            <div class="bg-white shadow-lg  rounded-3xl p-4 m-4">
                <h4><?php echo detail_change_server_lang; ?></h4>
<?php if(!empty($error)) {?>
    <div style="color:red"><?php echo user_change_server_rep_lang;?></div>
                <?php } ?>
                <div class="flex flex-row items-center pt-2  text-sm text-gray-500"
                     style="justify-content: center;">
                    <form class="flex" action="" method="post" enctype="multipart/form-data" style="width: -webkit-fill-available;">

                        <select name="server" class="form-select">
                            <option value=""><?php echo select_lang; ?></option>
                            <?php
                            $server = $conn->prepare("SELECT * FROM servers where id!=:id");
                            $server->execute(['id' => $user['server']]);
                            $server = $server->fetchAll();
                            foreach ($server as $val) {
                                $name = $val['name'];
                                $id = $val['id'];
                                ?>
                                <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" style="width: 150px;margin-left: 5px;margin-right: 5px;" class="flex-no-shrink bg-green-400 hover:bg-green-500 px-5 ml-4 py-2 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-green-300 hover:border-green-500 text-white rounded-full transition ease-in duration-300" value="submit" name="change_server"><?php echo detail_success_lang; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
</div>
<!-- partial -->

</body>
</html>
