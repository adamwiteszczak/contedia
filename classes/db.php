<?php
namespace Classes;

use mysqli;

class Db
{
    /**
     * NOTE:: the connection details would not normally be stored here, but would be held outside the
     * normal structure for security and read-in when needed. However, for the sake of time, I have put them here
     * ~~Adam~~
     */

    /**
     * @var string
     */
    private $host = 'localhost';

    /**
     * @var string
     */
    private $username = 'root';

    /**
     * @var string
     */
    private $password = '';

    /**
     * @var int
     */
    private $port = 3308;

    /**
     * @var string
     */
    private $db_name = 'contedia';

    /**
     * @var string
     */
    private $charset = 'utf8mb4';

    /**
     * @var mysqli
     */
    private $mysqli;

    /**
     * @var pdo
     */
    private $pdo;


    /**
     * Db constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->db_name;charset=$this->charset";
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new \PDO($dsn, $this->username, $this->password, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function raw($query)
    {
        return $this->pdo->query($query);
    }

    public function query($sql, $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function insert($sql, $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $this->pdo->lastInsertId();
    }
}