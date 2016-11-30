<?php
    /**
     * Created by PhpStorm.
     * User: matthes
     * Date: 28.11.16
     * Time: 16:13
     */

    namespace DbAkl\Core;


    use DbAkl\Driver\DbAklConnectionResource;

    interface DbAklDriver
    {


        public function setMetaData ($key, $value);

        public function getMetaData ($key);

        public function isConnected(DbAklConnectionResource $con);

        public function connect(DbAklConnectionResource $con);


        public function escape (DbAklConnectionResource $con, string $input) : string;


        public function load(DbAklConnectionResource $con, $table, array $condition, $castObj=null) : mixed;

        public function insert (DbAklConnectionResource $con, $table, $data);

        public function update (DbAklConnectionResource $con, $table, $data, array $condition);

        public function query(DbAklConnectionResource $con, $sql);

        public function begin (DbAklConnectionResource $con);

        public function commit(DbAklConnectionResource $con);

        public function rollback(DbAklConnectionResource $con);


        public function queryAsync();

    }