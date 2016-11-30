<?php
    /**
     * Created by PhpStorm.
     * User: matthes
     * Date: 29.11.16
     * Time: 13:07
     */

    namespace DbAkl\Core\Entity;


    interface EntityPack
    {

        public function getName() : string;

        public function install ();
        public function uninstall ();
        public function upgrade ();

        public function getEntitySchema ();

        public function buildMinorVersion();

        public function buildMajorVersion();

    }