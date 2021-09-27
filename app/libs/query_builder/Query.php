<?php

class Query {
    /**
     * @var string
     */
    private string $query = "";

    /**
     * @var string
     */
    private string $table_name;

    /**
     * Query constructor.
     * @param string $table_name
     */
    function __construct(string $table_name) {
        $this->table_name = $table_name;
    }

    /**
     * @return string
     */
    public function getTableName(): string {
        return $this->table_name;
    }

    /**
     * @param string $query
     */
    public function appendQuery(string $query) {
        $this->query .= $query;
    }

    /**
     * @return string
     */
    public function generate(): string {
        return $this->query;
    }
}