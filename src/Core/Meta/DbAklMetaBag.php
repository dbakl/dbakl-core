<?php

    /**
     * Created by PhpStorm.
     * User: matthes
     * Date: 30.11.16
     * Time: 11:11
     */
    namespace DbAkl\Core\Meta;

    trait DbAklMetaBag
    {

        private $mMetaData = [];

        /**
         * @param $key
         * @param $val
         */
        public function setMetaData(string $key, mixed $val) : void {
            $this->mMetaData[$key] = $val;
        }

        /**
         * @param $key
         * @return mixed|null
         */
        public function getMetaData(string $key) : mixed {
            if (isset ($this->mMetaData[$key]))
                return $this->mMetaData[$key];
            return null;
        }

    }