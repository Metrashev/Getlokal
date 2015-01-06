<?php
class DbConnection
{
    private $_connection;
    private static $instance;

    private function __construct($host, $username, $password, $database)
    {
        $this->_connection = mysqli_connect($host, $username, $password, $database);
        if (mysqli_connect_errno())
            throw new Exception("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    public static function getInstance($host, $username, $password, $database)
    {
        if(empty(self::$instance))
            self::$instance = new DbConnection($host, $username, $password, $database);

        return self::$instance;
    }

    public function setCharset($charset)
    {
        $query = "SET CHARACTER_SET_RESULTS = '{$charset}';";
        if(!$this->_connection->query($query))
            throw new Exception("DbConnection::setCharset Failed: " . $this->_connection->error);

        $query = "SET NAMES '{$charset}';";
        if(!$this->_connection->query($query))
            throw new Exception("DbConnection::setCharset Failed: " . $this->_connection->error);
    }

    public function setGroupConcatLen($len)
    {
        $query = "SET SESSION group_concat_max_len = {$len};";
        if(!$this->_connection->query($query))
            throw new Exception("DbConnection::setGroupConcatLen Failed: " . $this->_connection->error);
    }

    public function query($query)
    {
        $result = $this->_connection->query($query);
        if(!$result)
            throw new Exception("DbConnection::query Failed: " . $this->_connection->error);

        return $result;
    }

    function __destruct()
    {
        if(isset($this->_connection))
            mysqli_close($this->_connection);
    }

    public function getConnection()
    {
        return $this->_connection;
    }
}
?>