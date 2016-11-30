<?php
    /**
     * Created by PhpStorm.
     * User: matthes
     * Date: 29.11.16
     * Time: 16:44
     */

    namespace DbAkl\Core;


    class AsyncQueryPool
    {

        private $options = [
            "timeout" => 30,        // Total Timeout for all Queries
            "queryTimeout" => 2,    // Timeout for one Query
            "retry" => 3,           // Times to retry failed or timed out queries
            "hostConnectionLimit" => 5, // Maximum number of connections to each host
            "connectionLimit"   => 15,  // Maximum number of simulanous connections
        ];

        public function __construct(array $opts)
        {
            $this->options = array_merge($this->options, $opts);
        }


        public function spoolQuery ($query) : DbAklResultSet
        {

        }

        public function wait() {

        }


    }