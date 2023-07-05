<?php

class Fixer_Model extends Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function cronexp()
    {
        $query = $this->db->prepare("select * from users");
        $query->execute();
        $queryCount = $query->fetchAll();
        foreach ($queryCount as $us) {
            if (!empty($us["finishdate"])) {
                $expiredate = strtotime(date("Y-m-d", strtotime($us["finishdate"])));
                if ($expiredate < strtotime(date("Y-m-d")) || $expiredate == strtotime(date("Y-m-d"))) {
                    $query = $this->db->prepare("select * from users where username='".$us["username"]."'");
                    $query->execute();
                    $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
                    $query = $this->db->prepare("select * from servers where id=" . $queryCount[0]['server']);
                    $query->execute();
                    $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
                    $post = [
                        'username' => $us["username"]
                    ];

                    $ch = curl_init($queryCount[0]['link'] . '/api&key=' . $queryCount[0]['token'] . '&method=deleteuser');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    $response = curl_exec($ch);
                    $response = json_decode($response, true);
                    curl_close($ch);
                    if ($response['data']=='User Deleted')
                    {
                        $sql = "UPDATE users SET enable=? WHERE username=?";
                        $this->db->prepare($sql)->execute(['expired', $us["username"]]);
                    }
                }
            }
        }
        foreach ($queryCount as $us) {

            $stmt = $this->db->prepare("SELECT * FROM Traffic WHERE user=:user");
            $stmt->execute(['user' => $us['username']]);
            $user = $stmt->fetchAll();
            foreach ($user as $usernamet)
            {
                $total=$usernamet["download"];
                echo $total."-".$us['username']."<br>";
                if ($us["traffic"] < $total && !empty($us["traffic"])) {
                    $query = $this->db->prepare("select * from users where username='".$us["username"]."'");
                    $query->execute();
                    $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
                    $query = $this->db->prepare("select * from servers where id=" . $queryCount[0]['server']);
                    $query->execute();
                    $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
                    $post = [
                        'username' => $us["username"]
                    ];

                    $ch = curl_init($queryCount[0]['link'] . '/api&key=' . $queryCount[0]['token'] . '&method=deleteuser');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    $response = curl_exec($ch);
                    $response = json_decode($response, true);
                    curl_close($ch);
                    if ($response['data']=='User Deleted')
                    {
                        $sql = "UPDATE users SET enable=? WHERE username=?";
                        $this->db->prepare($sql)->execute(['traffic', $us["username"]]);
                    }
                }
            }

        }
        return $queryCount;
    }

    public function synstraffic()
    {
        $query = $this->db->prepare("select * from users");
        $query->execute();
        $queryCount = $query->fetchAll();
        foreach ($queryCount as $us) {
            $query = $this->db->prepare("select * from users where username='".$us["username"]."'");
            $query->execute();
            $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
            $query = $this->db->prepare("select * from servers where id=" . $queryCount[0]['server']);
            $query->execute();
            $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
            $post = [
                'username' => $us["username"]
            ];

            $ch = curl_init($queryCount[0]['link'] . '/api&key=' . $queryCount[0]['token'] . '&method=user&username='.$us["username"]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            curl_close($ch);
            $query_traffic = $this->db->prepare("select * from Traffic where user='".$us["username"]."'");
            $query_traffic->execute();
            $query_traffic = $query_traffic->rowCount();
            $sum_total=$query_traffic['total']+$response['data'][0]['traffic_usage'];
            $sql = "UPDATE Traffic SET total=? WHERE user=?";
            $this->db->prepare($sql)->execute([$sum_total, $us["username"]]);

        }
    }
}
