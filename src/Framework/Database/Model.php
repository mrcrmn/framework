<?php

namespace Framework\Database;

use Framework\Support\ParameterBag;

abstract class Model
{
    /**
     * The data for this model instance.
     *
     * @var \Framework\Support\ParameterBag
     */
    protected $data;

    /**
     * The connection Instance.
     *
     * @var \Framework\Database\Database
     */
    protected static $connection;

    /**
     * The static Instance.
     *
     * @var self
     */
    protected static $instance;

    /**
     * Hydrates the model with data.
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        if (! empty($data)) {
            $this->hydrate($data);
        }
    }

    /**
     * Creates a new ParameterBag which stores the models data.
     *
     * @param array $data
     * @return void
     */
    protected function hydrate($data = array())
    {
        $this->data = new ParameterBag($data);
    }

    /**
     * The magic function which proxies static calls to this model to the database query builder.
     *
     * @param string $method
     * @param array $args
     * @return void
     */
    public static function __callStatic($method, $args)
    {
        self::instanciate();

        call_user_func_array(
            array(db(), $method), $args
        );

        return self::$instance;
    }

    /**
     * Instanciates the model
     *
     * @return void
     */
    protected static function instanciate()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
            db()->select()->from(self::getTable());
        }
    }

    /**
     * Gets the models table.
     *
     * @return void
     */
    protected static function getTable()
    {
        return self::$instance->table;
    }

    /**
     * Gets an arry of new models.
     *
     * @return array
     */
    public static function get()
    {
        self::$instance = null;

        $models = array();
        foreach (db()->get() as $model) {
            $models[] = new static($model);
        }

        return $models;
    }

    /**
     * Gets a single model instance.
     *
     * @return static
     */
    public static function first()
    {
        $result = db()->first();

        self::$instance = null;

        return new static($result);
    }

    /**
     * Returns the whole table.
     *
     * @return array
     */
    public static function all()
    {
        self::instanciate();

        return self::get();
    }

    /**
     * Gets an attribute from the data bag.
     *
     * @param string $parameter
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->data->get($attribute);
    }

    /**
     * Sets an attribute in the data bag.
     *
     * @param string $attribute
     * @param mixed $value
     */
    public function __set($attribute, $value)
    {
        $this->data->add($attribute, $value);
    }
}