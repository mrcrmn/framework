<?php

namespace Framework\Database\QueryBuilders;

use Framework\Database\Collector;
use Framework\Database\QueryBuilders\BaseQueryBuilder;
use Framework\Database\QueryBuilders\QueryBuilderInterface;

/**
 * Constructs an insert query.
 *
 * @package mrcrmn/mysql
 * @author Marco Reimann <marcoreimann@outlook.de>
 */
class InsertQueryBuilder extends BaseQueryBuilder implements QueryBuilderInterface
{
    /**
     * The connection instance.
     *
     * @var \Framework\Database\Collector
     */
    protected $collector;

    /**
     * The query.
     *
     * @var string
     */
    public $query;

    /**
     * The constructor needs all parameters which have been collected by the public API.
     *
     * @param Collector $collector
     */
    public function __construct(Collector $collector)
    {
        $this->collector = $collector;
    }

    public function build()
    {
        $this->query = $this->addInsert();

        return $this->query;
    }
}
