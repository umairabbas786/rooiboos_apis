<?php

class WhereApplicableQuery extends Query {
    /**
     * WhereApplicableQuery constructor.
     * @param string $table_name
     */
    function __construct(string $table_name) {
        parent::__construct($table_name);
    }

    /**
     * @param array $params
     * @return $this
     */
    public function whereParams(array $params): WhereApplicableQuery {
        parent::appendQuery(' WHERE ');
        foreach ($params as $param) {
            if (count($param) === 3) {
                parent::appendQuery($param[0] . $param[1] . '\'' . $param[2] . '\'');
            } else {
                parent::appendQuery(' ' . $param[0] . ' ');
            }
        }
        return $this;
    }
}