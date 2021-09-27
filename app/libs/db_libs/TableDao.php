<?php


abstract class TableDao {
    /**
     * @var mysqli
     */
    private mysqli $connection;

    /**
     * TableDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { $this->connection = $connection; }

    /**
     * @return mysqli
     */
    public function getConnection(): mysqli {
        return $this->connection;
    }

    /**
     * @param string $string
     * @return string
     */
    public function escape_string(string $string): string {
        return mysqli_real_escape_string($this->getConnection(), $string);
    }

    /**
     * @return int|string
     */
    public function inserted_id(): int {
        return mysqli_insert_id($this->connection);
    }

    public function wrapBool(bool $bool): string {
        return $bool ? '1' : '0';
    }
}