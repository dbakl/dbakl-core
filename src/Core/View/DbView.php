<?php
    /**
     * Created by PhpStorm.
     * User: matthes
     * Date: 30.11.16
     * Time: 14:48
     */

    namespace DbAkl\Core\View;


    class DbView
    {


        public function select (array $condition) : self {


            return $this;
        }

        public function where($query, ...$params) {

        }


    }