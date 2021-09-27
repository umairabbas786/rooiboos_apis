<?php

class SelectQuery extends WhereApplicableQuery {
    /**
     * SelectQuery constructor.
     * @param string $table_name
     */
    function __construct(string $table_name) {
        parent::__construct($table_name);
    }

    /**
     * @param array $cols
     * @return $this
     */
    public function columns(array $cols): SelectQuery {
        parent::appendQuery(QueryType::SELECT . ' ');
        for ($i = 0; $i < count($cols); $i++) {
            parent::appendQuery($cols[$i] . (count($cols) - $i == 1 ? '' : ','));
        }
        parent::appendQuery(' FROM ' . parent::getTableName());
        return $this;
    }
}