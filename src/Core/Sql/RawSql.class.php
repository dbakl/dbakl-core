<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 07.05.15
 * Time: 11:54
 */

	namespace  DbAkl\Sql;



	class RawSql extends Sql
    {

		private $mQuery;

		public function __construct ($rawSqlData)
        {
			if (strtoupper(substr($rawSqlData, 0, 15)) === "SELECT [CACHED]") {
				$this->mIsCachedQuery = TRUE;
				$rawSqlData = "SELECT " . substr ($rawSqlData, 16);
			}
			$this->mQuery = $rawSqlData;
		}

		public function getEscaped (Connection  $con)
        {
			return $this->mQuery;
		}


		public function __toString()
        {
            return $this->mQuery;
        }


    }