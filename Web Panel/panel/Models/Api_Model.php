<?php

class Api_Model extends Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function check_token($data)
    {
        $ipremote= $_SERVER['REMOTE_ADDR'];
        $query = $this->db->prepare("select * from ApiToken where Token='$data' and enable='true'");
        $query->execute();
        $queryCount = $query->rowCount();
        if($queryCount>0)
        {
            $access='allowed';
        }
        else{
            $access='illegal';
        }
        return $access;
    }
    public function list_user()
    {
        $query = $this->db->prepare("select users.*,Traffic.total,servers.port_connection,servers.port_connection_tls,servers.name from users,Traffic,servers where users.username=Traffic.user");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        return $queryCount;
    }
    public function status_user($data)
    {
        $query = $this->db->prepare("select users.*,Traffic.total,servers.port_connection,servers.port_connection_tls,servers.name from users,Traffic,servers where users.username=Traffic.user and users.enable='$data'");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        return $queryCount;
    }
    public function show_user($data)
    {
        $query = $this->db->prepare("select users.*,Traffic.total,servers.port_connection,servers.port_connection_tls,servers.name from users,Traffic,servers where users.username='$data' and Traffic.user='$data'");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        return $queryCount;
    }


}
