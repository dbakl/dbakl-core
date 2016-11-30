<?php
    /**
     * Created by PhpStorm.
     * User: matthes
     * Date: 28.11.16
     * Time: 16:13
     */

    namespace DbAkl\Core;


    interface DbAklDriver
    {


        public function setMetaData ($key, $value);

        public function getMetaData ($key);

        public function isConnected();

        public function connect();


        public function escape (string $input) : string;


        public function begin ();

        public function commit();

        public function rollback();

        public function query();

        public function queryAsync();

    }