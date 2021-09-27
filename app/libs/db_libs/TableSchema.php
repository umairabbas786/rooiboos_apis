<?php


abstract class TableSchema {
    /**
     * @var string
     */
    private string $table_name;

    /**
     * TableSchema constructor.
     * @param string $table_name
     */
    public function __construct(string $table_name)
    {
        $this->table_name = $table_name;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table_name;
    }

    /**
     * @return string
     */
    abstract public function getBlueprint(): string;
}