<?php
    /**
     * Created by PhpStorm.
     * User: matthes
     * Date: 29.11.16
     * Time: 10:37
     */

    namespace DbAkl\Driver;

    use DbAkl\Core\Meta\DbAklMetaBag;

    class DbAklConnectionResource
    {
        use DbAklMetaBag;




        /**
         * The link to the system layer connection
         *
         * @var resource
         */
        public $link = null;
    }