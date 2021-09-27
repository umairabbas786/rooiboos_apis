QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(Table::ROOM)
            ->columns(['col1', 'col2', 'col3'])
            ->values(['abc', 'def', 'ghi'])
            ->generate();

QueryBuilder::withQueryType(QueryType::SELECT)->withTableName(Table::ROOM)
            ->columns(['*'])
            ->whereParams(array(['id', '=', '1'], ['AND'], ['name', '=', 'khan']))
            ->generate();

QueryBuilder::withQueryType(QueryType::UPDATE)->withTableName(Table::ROOM)
            ->updateParams([['col1', 'abc'], ['col2', 'bbc'], ['col3', 'ccc']])
            ->whereParams(array(['id', '=', '1'], ['AND'], ['name', '=', 'khan']))
            ->generate();

QueryBuilder::withQueryType(QueryType::DELETE)->withTableName(Table::ROOM)
            ->whereParams(array(['id', '=', '1'], ['AND'], ['name', '=', 'khan']))
            ->generate();