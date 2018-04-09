<?php

namespace Framework\Database\QueryBuilders;

use Exception;
use Framework\Database\Collector;
use Framework\Database\QueryBuilders\BaseQueryBuilder;
use Framework\Database\QueryBuilders\QueryBuilderInterface;

/**
 * Constructs an update query.
 *
 * @package mrcrmn/mysql
 * @author Marco Reimann <marcoreimann@outlook.de>
 */
class UpdateQueryBuilder extends BaseQueryBuilder implements QueryBuilderInterface
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
        if (count($this->collector->wheres) === 0 && ! $this->collector->withForce) {
            throw new Exception('You need to use force mode to execute dangerous queries. ->update($array, $force = true)');
        }
        $this->query = $this->addUpdate();
        $this->query .= $this->addWheres();

        return $this->query;
    }
}
