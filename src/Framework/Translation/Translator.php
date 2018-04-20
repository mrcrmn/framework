<?php

namespace Framework\Translation;

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
        $wrappedInQuotes = array();

        foreach ($this->handles as $handle) {
            $wrappedInQuotes[] = $this->wrap($handle, '\'');
        }

        return implode(', ', $wrappedInQuotes);
    }

    /**
     * Gets the rows from the database.
     *
     * @return array
     */
    protected function getRowsFromDatabase()
    {
        return db() ->select('handle', app()->getLocale() . ' as txt')
                    ->from(self::TABLE)
                    ->whereIn('handle', $this->handles)
                    ->get();
    }

    /**
     * Replaces the placeholders in the buffer with the translation.
     *
     * @param string $buffer
     * @return void
     */
    public function replace($buffer)
    {
        if (count($this->handles) > 0) {
            $rows = $this->getRowsFromDatabase();
    
            foreach ($rows as $row) {
                $buffer = str_replace(
                    $this->wrap($row['handle']),
                    $row['txt'],
                    $buffer
                );
            }
        }

        return $buffer;
    }
}
