<?php

class DeleteQuery extends WhereApplicableQuery {
    /**
     * DeleteQuery constructor.
     * @param string $table_name
     */
    function __construct(string $table_name) {
        parent::__construct($table_name);
        parent::appendQuery(QueryType::DELETE . " FROM " . parent::getTableName());
    }
}