<?php
    /**
     * Created by PhpStorm.
     * User: matthes
     * Date: 28.11.16
     * Time: 16:20
     */

    namespace DbAkl\Core;


    use DbAkl\Core\Entity\EntityManager;

    class DbCon
    {


        public function setEntityManager(EntityManager $entityManager) {

        }

        public function getEntityManager() : EntityManager {

        }


        public function load ($tableOrClass, $what) {

        }


        public function select($tableOrClass) : FSql {

        }


        public function insert ($entityOrTableName, array $arrayData = null) {

        }

        public function update ($entityOrTableName, array $arrayData=null) {

        }

        public function delete ($entityOrTableName) {

        }


        public function query($query) {

        }

        public function async(array $opts = ["timeout" => 5, "singeQueryTimeout" => 2, "maxConsPerHost" => 5]) : AsyncQueryPool {

        }

        public function queryAsync ($query) {

        }

        public function wait() {

        }

        public function transaction (callable $fn) {

        }

    }