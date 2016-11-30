<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 04.09.14
 * Time: 15:24
 */


    namespace  DbAkl\Sql;


    use gis\core\exception\GisException;
    use gis\db\core\Connection;

    class Sql {

        private $mStmt;
        private $mVals;


        protected $mIsCachedQuery = false;

        /**
         * Return true if the Stmt started with
         *
         * "SELECT [CACHED]..."
         *
         * @return bool
         */
        public function isCachedQuery () {
           return $this->mIsCachedQuery;
        }


        /**
         * Build an sql statement
         *
         * Behaviour:
         *
         * Use "SELECT [CACHED]" to enable Redis-Query-Caching (if available) for this query)
         *
         * Placeholders: (Replacement)
         *      ?   -> 'escaped(?)'
         *     ??   -> Create List of Array Elements
         *     !!   -> `escaped(?)`  (Used for TableName, OrderBy etc)
         *
         * Parameter 1 can be:
         *      Array or basic Value
         *
         *
         * @param $stmt
         * @param null $param1
         * @param null $param2
         */
        public function __construct ($stmt, $param1=NULL, $param2=NULL) {
            if (strtoupper(substr($stmt, 0, 15)) === "SELECT [CACHED]") {
                $this->mIsCachedQuery = TRUE;
                $stmt = "SELECT " . substr ($stmt, 16);
            }
            $this->mStmt = (string)$stmt;

            if (is_array($param1)) {
                if (func_num_args() > 2)
                    throw new \InvalidArgumentException("Constructor expects exactly two parameters if second parameter is array");
                $this->mVals = $param1;
                return;
            }
            $vals = func_get_args();
            array_shift($vals); // Shift off $stmt
            $this->mVals = $vals;
        }

        /******* SECURITY RELATED STUFF ********
         *
         * This is the central SQL Escaping method and the only code protecting your
         * application from SQL-Injection attacks.
         *
         * Think twice before editing anything in here
         *
         * *** SECURITY *** *** SECURITY ***
         *
         * @param Connection $con
         * @return mixed
         * @throws \InvalidArgumentException
         */
        public function getEscaped (Connection $con) {
            $stmt = $this->mStmt;
            $mode = false;
            if (preg_match ("/(\\?|!!|{})/", $stmt)) {
                if (preg_match ("/\\'\\s*\\?/", $stmt))
                    throw new \InvalidArgumentException("Double string starting - Just use ? instead of '?'");
                $mode = "serial";
            }
            if (preg_match ("/\\:[a-zA-Z0-9\\_]+/", $stmt)) {
                if ($mode == "serial")
                    throw new \InvalidArgumentException("Query can either contain serial tokens (?) or named tokens (:tokenName)");
                if (preg_match ("/\\'\\s*\\:[a-zA-Z0-9\\_]+/", $stmt))
                    throw new \InvalidArgumentException("Double string starting - Just use :name instead of ':name'");
                $mode = "named";
            }
            if ($mode == "serial") {
                $i = 0;
                $stmt = preg_replace_callback(
                        "/(\\?\\?|\\?|!!|{})/",
                        function ($match) use (&$i, $con) {
                            if ( count ($this->mVals) < $i )
                                throw new \InvalidArgumentException("Missing parameter value (Trying to find value index $i): Statement: '{$this->mStmt}'");

                            if ($match[0] == "??") {
                                if ( ! is_array($this->mVals[$i]))
                                    throw new GisException("Double ?? fields require array value: (Trying to find valid index $i): Found: " . var_export($this->mVals[$i], TRUE));
                                $arrData = [];
                                foreach ($this->mVals[$i] as $curVal) {
                                    $arrData[] = "'" . $con->escape($curVal) . "'";
                                }
                                $i++;
                                return implode (",", $arrData);
                            }
                            if ($match[0] == "?") {
                                $str = "'" . $con->escape($this->mVals[$i]) . "'";
                                if ($this->mVals[$i] === NULL)
                                    $str = "NULL";
                                $i++;
                                return $str;
                            }
                            if ($match[0] == "!!") {
                                return "`" . $con->escape($this->mVals[$i++]) . "`";
                            }
                            if ($match[0] == "{}")
                                return $con->escape($this->mVals[$i++]);
                            throw new \Exception("Invalid placeholder: '{$match[0]}'");
                        },
                        $stmt
                );
                if ($i < count ($this->mVals))
                    throw new \InvalidArgumentException("Too many parameter values (Query replaced $i tokens but parameter count is ". count ($this->mVals));
            } else if ($mode == "named") {
                foreach ($this->mVals as $key => $val) {
                    // Well, is token name expected as :tokenName: or just :tokenName ???
                    $stmt = str_replace(":{$key}:", "'".$con->escape($this->mVals[$key])."'", $stmt);
                    $stmt = str_replace("!{$key}!", "`".$con->escape($this->mVals[$key])."`", $stmt);
                }
            }
            return $stmt;
        }


        public function __toString()
        {
            return $this->getEscaped();
        }


    }