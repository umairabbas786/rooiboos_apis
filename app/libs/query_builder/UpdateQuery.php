<?php

class UpdateQuery extends WhereApplicableQuery {
    /**
     * UpdateQuery constructor.
     * @param string $table_name
     */
    function __construct(string $table_name) {
        parent::__construct($table_name);
    }

    /**
     * @param array $params
     * @return $this
     */
    public function updateParams(array $params): UpdateQuery {
        parent::appendQuery(QueryType::UPDATE . ' ' . parent::getTableName() . ' SET ');
        for ($i = 0; $i < count($params); $i++) {
            parent::appendQuery($params[$i][0] . '=\'' . $params[$i][1] . '\'' . (count($params) - $i == 1 ? '' : ','));
        }
        return $this;
    }
}