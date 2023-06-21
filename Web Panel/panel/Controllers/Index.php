<?php
include_once("Models/Index_Model.php");

class Index extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Index_Model();
        $this->index();
    }

    public function index()
    {
        if(isset($_GET['logout'])) {
            setcookie("xpkey", "", time()-86400);
            header("location: login");

        }
        if(isset($_GET['lang'])) {
            if (!empty($_GET["lang"])) {
                $lang = htmlentities($_GET['lang']);
                if($lang=='fa')
                {
                    file_put_contents("/var/www/html/cp/Config/database.php", str_replace("\$lang = \"".LANG."\"", "\$lang = \"fa-ir\"", file_get_contents("/var/www/html/cp/Config/database.php")));
                    clearstatcache();
                    sleep(2);
                    header("location: index");
                }
                if($lang=='en')
                {
                    file_put_contents("/var/www/html/cp/Config/database.php", str_replace("\$lang = \"".LANG."\"", "\$lang = \"en-us\"", file_get_contents("/var/www/html/cp/Config/database.php")));
                    clearstatcache();
                    sleep(2);
                    header("location: index");
                }
            }
        }
        if (isset($_GET['layout'])) {
            $layout = htmlentities($_GET['layout']);
            if($layout=='dark')
            {
                file_put_contents("/var/www/html/cp/assets/js/config.js", str_replace("var dark_layout = 'false'", "var dark_layout = 'true'", file_get_contents("/var/www/html/cp/assets/js/config.js")));
                clearstatcache();
                sleep(2);
            }
            if($layout=='light')
            {
                file_put_contents("/var/www/html/cp/assets/js/config.js", str_replace("var dark_layout = 'true'", "var dark_layout = 'false'", file_get_contents("/var/www/html/cp/assets/js/config.js")));
                clearstatcache();
                sleep(2);
            }
        }
        $list = shell_exec("sudo lsof -i :" . PORT . " -n | grep -v root | grep ESTABLISHED");
        $free = shell_exec("free");
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem, function ($value) {
            return $value !== NULL && $value !== false && $value !== "";
        });
        $mem = array_merge($mem);
        $memtotal = round($mem[1] / 1000000, 2);
        $memused = round($mem[2] / 1000000, 2);
        $memfree = round($mem[3] / 1000000, 2);
        $memtotal = str_replace(" GB", "", $memtotal);
        $memused = str_replace(" GB", "", $memused);
        $memfree = str_replace(" GB", "", $memfree);
        $memtotal = str_replace(" MB", "", $memtotal);
        $memused = str_replace(" MB", "", $memused);
        $memfree = str_replace(" MB", "", $memfree);
        $usedperc = 100 / $memtotal * $memused;
        $exec_loads = sys_getloadavg();
        $exec_cores = trim(shell_exec("grep -P '^processor' /proc/cpuinfo|wc -l"));
        $cpu = round($exec_loads[1] / ($exec_cores + 1) * 100, 0);
        $diskfree = round(disk_free_space(".") / 1000000000);
        $disktotal = round(disk_total_space(".") / 1000000000);
        $diskused = round($disktotal - $diskfree);
        $diskusage = round($diskused / $disktotal * 100);
        $traffic_rx = shell_exec("netstat -e -n -i |  grep \"RX packets\" | grep -v \"RX packets 0\" | grep -v \" B)\"");
        $traffic_tx = shell_exec("netstat -e -n -i |  grep \"TX packets\" | grep -v \"TX packets 0\" | grep -v \" B)\"");
        $res = preg_split("/\r\n|\n|\r/", $traffic_rx);
        $upload="0"; $download="0";
        foreach ($res as $resline) {
            $resarray = explode(" ", $resline);
            if (!isset($resarray[13])) {
                $resarray[13] = null;
            }
            if (is_numeric($resarray[13])) {
                $download += $resarray[13];
            }

        }

        $res = preg_split("/\r\n|\n|\r/", $traffic_tx);
        foreach ($res as $resline) {
            $resarray = explode(" ", $resline);
            if (!isset($resarray[13])) {
                $resarray[13] = null;
            }
            $upload += $resarray[13];
        }
        function formatBytes($bytes)
        {
            if ($bytes > 0) {
                $i = floor(log($bytes) / log(1024));
                $sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
                return sprintf('%.02F', round($bytes / pow(1024, $i), 1)) * 1 . ' ' . @$sizes[$i];
            } else {
                return 0;
            }
        }

        $total = $download;
        $total = formatBytes($total);
        $cpu_free = round($cpu);
        $ram_free = round($usedperc);
        $disk_free = round($diskusage);
        $all_user = $this->model->all_user();
        $active_user = $this->model->active_user();
        $deactive_user = $this->model->deactive_user();
        $users_band = $this->model->user_band();
        $traffic_total = formatBytes(($this->model->traffic_user()*1024)*1024);

        $data = array(
            "single" => array(
                'all_user' => $all_user,
                'active_user' => $active_user,
                'deactive_user' => $deactive_user,
                'online_user' => $list,
                'cpu_free' => $cpu_free,
                'ram_free' => $ram_free,
                'disk_free' => $disk_free,
                'total' => $total,
                'traffic_total' => $traffic_total
            ),

            "for" => $users_band
        );
        $this->view->render("Index/index", $data);
    }


}
