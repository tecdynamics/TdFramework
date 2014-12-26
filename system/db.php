<?php

/*
 * Description of Class config
 * Copyright (c) 2013 - 2014 Tec-Dynamics
 *
 * This Framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * @category   PHP
 * @package    Framework
 * @copyright  Copyright (c) 2013 - 2014 Tec-Dynamics L.T.D. (http://www.tec-dynamics.co.uk/webphp)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    0.1.5, 2014-12-22
 */

class db {

    /** Orm Database representation
     * @example description mixed $debug = false Enable debugging queries, true for error_log($query), callback($query, $parameters) otherwise
     * @example description bool $freeze = false Disable persistence
     * @example description $rowClass = 'NotORM_Row' Class used for created objects
     * @example descriptionbool $jsonAsArray = false Use array instead of object in Result JSON serialization
     * @example description $transaction Assign 'BEGIN', 'COMMIT' or 'ROLLBACK' to start or stop transaction
     * @example description Get table data to use as $db->table[1]
     * @example description Get Spesific id $this->orm->application[1];
     * @description If you Need more please check all the test functions in the /application/helpers/orm/tests/
     */
    public $orm;

    /**
     *
     * @var type
     */
    private $conn;

    /**
     *
     * @var type 
     */
    private $pdo;

    public function __construct() {
        global $config;
        try {
            $this->conn = new PDO($config['db_type'] . ':host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';charset=utf8', $config['db_username'], $config['db_password'], array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ));
        } catch (Exception $e) {

            error::apendMsg('Tec-Dynamics');
            error::apendMsg('PDO Error');
            throw new exception($e);
        }
        try {
            $this->orm = new NotORM($this->conn);
            $this->orm->debug = true;
        } catch (Exception $e) {
            error::apendMsg('Tec-Dynamics');
            error::apendMsg('ORM Error');
            throw new exception($e);
        }
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.2.0)<br/>
     * Executes an SQL statement, returning a result set as a PDOStatement object
     * @link http://php.net/manual/en/pdo.query.php
     * @param string $statement <p>
     * The SQL statement to prepare and execute.
     * </p>
     * <p>
     * Data inside the query should be properly escaped.
     * </p>
     * @return PDOStatement <b>PDO::query</b> returns a PDOStatement object, or <b>FALSE</b>
     * on failure.
     */
    public function query($query) {
        $this->pdo = $this->conn->prepare($query);
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 1.0.0)<br/>
     * Binds a value to a parameter
     * @link http://php.net/manual/en/pdostatement.bindvalue.php
     * @param mixed $parameter <p>
     * Parameter identifier. For a prepared statement using named
     * placeholders, this will be a parameter name of the form
     * :name. For a prepared statement using
     * question mark placeholders, this will be the 1-indexed position of
     * the parameter.
     * </p>
     * @param mixed $value <p>
     * The value to bind to the parameter.
     * </p>
     * @param int $data_type [optional] <p>
     * Explicit data type for the parameter using the PDO::PARAM_*
     * constants.
     * </p>
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->pdo->bindValue($param, $value, $type);
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.2.1)<br/>
     * Quotes a string for use in a query.
     * @link http://php.net/manual/en/pdo.quote.php
     * @param string $string <p>
     * The string to be quoted.
     * </p>
     * @param int $parameter_type [optional] <p>
     * Provides a data type hint for drivers that have alternate quoting styles.
     * </p>
     * @return string a quoted string that is theoretically safe to pass into an
     * SQL statement. Returns <b>FALSE</b> if the driver does not support quoting in
     * this way.
     */
    public function quote($string, $parameter_type = 'PDO::PARAM_STR') {
        return $this->pdo->quote($string, $parameter_type = 'PDO::PARAM_STR');
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.1.0)<br/>
     * Executes a prepared statement
     * @link http://php.net/manual/en/pdostatement.execute.php
     * @param array $input_parameters [optional] <p>
     * An array of values with as many elements as there are bound
     * parameters in the SQL statement being executed.
     * All values are treated as <b>PDO::PARAM_STR</b>.
     * </p>
     * <p>
     * You cannot bind multiple values to a single parameter; for example,
     * you cannot bind two values to a single named parameter in an IN()
     * clause.
     * </p>
     * <p>
     * You cannot bind more values than specified; if more keys exist in
     * <i>input_parameters</i> than in the SQL specified
     * in the <b>PDO::prepare</b>, then the statement will
     * fail and an error is emitted.
     * </p>
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public function execute() {
        return $this->pdo->execute();
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.1.0)<br/>
     * Returns an array containing all of the result set rows
     * @link http://php.net/manual/en/pdostatement.fetchall.php
     * @param int $fetch_style [optional] <p>
     * Controls the contents of the returned array as documented in
     * <b>PDOStatement::fetch</b>.
     * Defaults to value of <b>PDO::ATTR_DEFAULT_FETCH_MODE</b>
     * (which defaults to <b>PDO::FETCH_BOTH</b>)
     * </p>
     * <p>
     * To return an array consisting of all values of a single column from
     * the result set, specify <b>PDO::FETCH_COLUMN</b>. You
     * can specify which column you want with the
     * <i>column-index</i> parameter.
     * </p>
     * <p>
     * To fetch only the unique values of a single column from the result set,
     * bitwise-OR <b>PDO::FETCH_COLUMN</b> with
     * <b>PDO::FETCH_UNIQUE</b>.
     * </p>
     * <p>
     * To return an associative array grouped by the values of a specified
     * column, bitwise-OR <b>PDO::FETCH_COLUMN</b> with
     * <b>PDO::FETCH_GROUP</b>.
     * </p>
     * @param mixed $fetch_argument [optional] <p>
     * This argument have a different meaning depending on the value of
     * the <i>fetch_style</i> parameter:
     * <p>
     * <b>PDO::FETCH_COLUMN</b>: Returns the indicated 0-indexed
     * column.
     * </p>
     * @param array $ctor_args [optional] <p>
     * Arguments of custom class constructor when the <i>fetch_style</i>
     * parameter is <b>PDO::FETCH_CLASS</b>.
     * </p>
     * @return array <b>PDOStatement::fetchAll</b> returns an array containing
     * all of the remaining rows in the result set. The array represents each
     * row as either an array of column values or an object with properties
     * corresponding to each column name. An empty array is returned if there
     * are zero results to fetch, or <b>FALSE</b> on failure.
     * </p>
     * <p>
     * Using this method to fetch large result sets will result in a heavy
     * demand on system and possibly network resources. Rather than retrieving
     * all of the data and manipulating it in PHP, consider using the database
     * server to manipulate the result sets. For example, use the WHERE and
     * ORDER BY clauses in SQL to restrict results before retrieving and
     * processing them with PHP.
     */
    public function GetAll() {
        $this->execute();
        return $this->pdo->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.1.0)<br/>
     * Fetches the next row from a result set
     * @link http://php.net/manual/en/pdostatement.fetch.php
     * @param int $fetch_style [optional] <p>
     * Controls how the next row will be returned to the caller. This value
     * must be one of the PDO::FETCH_* constants,
     * defaulting to value of PDO::ATTR_DEFAULT_FETCH_MODE
     * (which defaults to PDO::FETCH_BOTH).
     * <p>
     * PDO::FETCH_ASSOC: returns an array indexed by column
     * name as returned in your result set
     * </p>
     * @param int $cursor_orientation [optional] <p>
     * For a PDOStatement object representing a scrollable cursor, this
     * value determines which row will be returned to the caller. This value
     * must be one of the PDO::FETCH_ORI_* constants,
     * defaulting to PDO::FETCH_ORI_NEXT. To request a
     * scrollable cursor for your PDOStatement object, you must set the
     * PDO::ATTR_CURSOR attribute to
     * PDO::CURSOR_SCROLL when you prepare the SQL
     * statement with <b>PDO::prepare</b>.
     * </p>
     * @param int $cursor_offset [optional]
     * @return mixed The return value of this function on success depends on the fetch type. In
     * all cases, <b>FALSE</b> is returned on failure.
     */
    public function GetOne() {
        $this->execute();
        return $this->pdo->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.1.0)<br/>
     * Returns the number of rows affected by the last SQL statement
     * @link http://php.net/manual/en/pdostatement.rowcount.php
     * @return int the number of rows.
     */
    public function rowCount() {
        return $this->pdo->rowCount();
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.1.0)<br/>
     * Returns the ID of the last inserted row or sequence value
     * @link http://php.net/manual/en/pdo.lastinsertid.php
     * @param string $name [optional] <p>
     * Name of the sequence object from which the ID should be returned.
     * </p>
     * @return string If a sequence name was not specified for the <i>name</i>
     * parameter, <b>PDO::lastInsertId</b> returns a
     * string representing the row ID of the last row that was inserted into
     * the database.
     * </p>
     * <p>
     * If a sequence name was specified for the <i>name</i>
     * parameter, <b>PDO::lastInsertId</b> returns a
     * string representing the last value retrieved from the specified sequence
     * object.
     * </p>
     * <p>
     * If the PDO driver does not support this capability,
     * <b>PDO::lastInsertId</b> triggers an
     * IM001 SQLSTATE.
     */
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.1.0)<br/>
     * Initiates a transaction
     * @link http://php.net/manual/en/pdo.begintransaction.php
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public function beginTransaction() {
        return $this->conn->beginTransaction();
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.1.0)<br/>
     * Commits a transaction
     * @link http://php.net/manual/en/pdo.commit.php
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public function endTransaction() {
        return $this->conn->commit();
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.1.0)<br/>
     * Rolls back a transaction
     * @link http://php.net/manual/en/pdo.rollback.php
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public function cancelTransaction() {
        return $this->conn->rollBack();
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.9.0)<br/>
     * Dump an SQL prepared command
     * @link http://php.net/manual/en/pdostatement.debugdumpparams.php
     * @return void No value is returned.
     */
    public function debugDumpParams() {
        return $this->conn->debugDumpParams();
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.1.0)<br/>
     * Set an attribute
     * @link http://php.net/manual/en/pdo.setattribute.php
     * @param int $attribute
     * @param mixed $value
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public function setAttribute($attribute, $value) {
        return $this->conn->setAttribute($attribute, $value);
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.2.0)<br/>
     * Retrieve a database connection attribute
     * @link http://php.net/manual/en/pdo.getattribute.php
     * @param int $attribute <p>
     * One of the PDO::ATTR_* constants. The constants that
     * apply to database connections are as follows:
     * PDO::ATTR_AUTOCOMMIT
     * PDO::ATTR_CASE
     * PDO::ATTR_CLIENT_VERSION
     * PDO::ATTR_CONNECTION_STATUS
     * PDO::ATTR_DRIVER_NAME
     * PDO::ATTR_ERRMODE
     * PDO::ATTR_ORACLE_NULLS
     * PDO::ATTR_PERSISTENT
     * PDO::ATTR_PREFETCH
     * PDO::ATTR_SERVER_INFO
     * PDO::ATTR_SERVER_VERSION
     * PDO::ATTR_TIMEOUT
     * </p>
     * @return mixed A successful call returns the value of the requested PDO attribute.
     * An unsuccessful call returns null.
     */
    public function getAttribute($attribute) {
        return $this->conn->getAttribute($attribute);
    }

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.2.0)<br/>
     * Returns the number of columns in the result set
     * @link http://php.net/manual/en/pdostatement.columncount.php
     * @return int the number of columns in the result set represented by the
     * PDOStatement object. If there is no result set,
     * <b>PDOStatement::columnCount</b> returns 0.
     */
    public function GetcolumnCount() {
        return $this->conn->columnCount();
    }

}
