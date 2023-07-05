<?php

class Packages_Model extends Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        if (isset($_COOKIE["xcskey"])) {
            $key_login = explode(':', $_COOKIE["xcskey"]);
            $Ukey=$key_login[0];
            $Pkey=$key_login[1];
            $query = $this->db->prepare("select * from setting where adminuser='" .$Ukey. "' and login_key='" .$_COOKIE["xcskey"]. "'");
            $query->execute();
            $queryCount = $query->rowCount();
            $query_ress = $this->db->prepare("select * from admins where username_u='" . $Ukey . "' and login_key='" . $_COOKIE["xcskey"] . "'");
            $query_ress->execute();
            $queryCount_ress = $query_ress->rowCount();
            if ($queryCount == 0 && $queryCount_ress == 0) {
                header("location: login");
            }
        } else {
            header("location: login");
        }
    }

    public function index()
    {
        $query = $this->db->prepare("select package.*,servers.name from package,servers where package.server=servers.id ORDER BY id DESC");
        $query->execute();
        $queryCount = $query->fetchAll();
        return $queryCount;
    }
    public function index_server()
    {
        $query = $this->db->prepare("select * from servers");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        return $queryCount;
    }
    public function edit_package($data_sybmit)
    {
        $id=$data_sybmit['id'];
        $query = $this->db->prepare("select package.*,servers.id,servers.name from package,servers where package.id='$id' and package.server=servers.id ");
        $query->execute();
        $queryCount = $query->fetchAll();
        return $queryCount;
    }

    public function submit_update($data_sybmit)
    {

        $data = [
            'id' => $data_sybmit['id'],
            'title' => $data_sybmit['title'],
            'amount' => $data_sybmit['amount'],
            'day' => $data_sybmit['day'],
            'multi' => $data_sybmit['multi'],
            'server' => $data_sybmit['server'],
            'traffic' => $data_sybmit['traffic'],
            'multiuser' => $data_sybmit['multiuser']
        ];

        $sql = "UPDATE package SET title=:title, amount=:amount , day=:day , multi=:multi , server=:server, traffic=:traffic, multiuser=:multiuser WHERE id=:id ";

        $statement = $this->db->prepare($sql);
        $statement->execute($data);
        header("location: packages");
    }

    public function submit_index($data_sybmit)
    {
            $sql = "INSERT INTO `package` (`title`, `amount`, `day`, `multi`,`server`,`traffic`,`multiuser`) VALUES (?,?,?,?,?,?,?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($data_sybmit['title'], $data_sybmit['amount'], $data_sybmit['day'], $data_sybmit['multi'], $data_sybmit['server'], $data_sybmit['traffic'], $data_sybmit['multiuser']));
            if ($stmt) {
                header("Location: packages");
                return true;
            } else {
                return false;
            }

    }

    public function delete_pack($data_sybmit)
    {
        $id=$data_sybmit['id'];
        $query = $this->db->prepare("DELETE FROM package WHERE id=?")->execute([$id]);
        if($query)
        {
            header("Location: packages");
        }
    }
}
