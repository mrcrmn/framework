<?php

namespace Framework\Translation;

use Framework\Support\ParameterBag;


class Translator
{
    /**
     * The table name.
     * 
     * @var string
     */
    const TABLE = 'translations';

    /**
     * Collection of all handles.
     *
     * @var array
     */
    protected $handles = array();

    /**
     * Holds the translation.
     *
     * @var \Framework\Support\ParameterBag
     */
    protected $translations;

    public function __construct()
    {

    }
    
    /**
     * Wraps a given string in another string.
     *
     * @param string $key
     * @param string $wrapper
     * @return void
     */
    protected function wrap($key, $wrapper = '###')
    {
        return $wrapper . $key . $wrapper;
    }

    /**
     * Gets the placeholder for a translation and stores its handle.
     *
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        if (! array_key_exists($key, $this->handles)) {
            $this->handles[] = $key;
        }

        return $this->wrap($key);
    }

    /**
     * Gets the where in parameter for the db query.
     *
     * @return string
     */
    protected function whereIn()
    {
        $wrappedInQuotes = array_map(function($handle) {
            return $this->wrap($handle, '\'');
        }, $this->handles);

        return implode(', ', $wrappedInQuotes);
    }

    /**
     * Gets the rows from the database.
     *
     * @return array
     */
    protected function getRowsFromDatabase()
    {
        $prepared = db()->prepare("SELECT handle, " . app()->getLocale() . " as txt FROM " . self::TABLE . " WHERE handle IN (" . $this->whereIn() . ")");
        $prepared->execute();

        return $prepared->fetchAll();
    }

    /**
     * Replaces the placeholders in the buffer with the translation.
     *
     * @param string $buffer
     * @return void
     */
    public function replace($buffer)
    {
        $rows = $this->getRowsFromDatabase();

        $translations = new ParameterBag();

        foreach ($rows as $row) {
            $translations->add($row['handle'], $row['txt']);
        }

        foreach ($translations->keys() as $handle) {
            $buffer = str_replace(
                $this->wrap($handle),
                $translations->get($handle),
                $buffer
            );
        }

        return $buffer;
    }
}
