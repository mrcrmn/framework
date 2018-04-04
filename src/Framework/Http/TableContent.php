<?php

namespace Framework\Http;

class TableContent
{
    protected $routes = array();
    protected const TABLE = '_tblcontent';

    /**
     * The Constructor of the class
     *
     * @return void
     */
    public function __construct()
    {
        $prepared = db()->prepare("SELECT url, url_handle, status FROM ".self::TABLE." WHERE status >= :status");
        $prepared->execute(array(
            'status' => 2
        ));

        $routes = $prepared->fetchAll();

        dd($routes);
    }
}
