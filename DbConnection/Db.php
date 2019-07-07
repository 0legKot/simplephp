<?php
    function getConnection()
    {
        $params = array(
            'host' => 'localhost',
            'dbname' => 'db_films',
            'user' => 'root',
            'password' => 'root',
        );
        return new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']);;
    }
    ?>