<?php

class Micro_Dao
{
    protected $db;
    protected $table;
    // only one connection permitted
    protected static $mysqli;

    public function __construct()
    {
        if (is_null($this->db)) {
            $this->db = Micro::$id;
        }
        if (is_null($this->table)) {
            $class_name_lower = strtolower(get_class($this));
            $this->table = str_replace(Micro::$id . '_dao_', '', $class_name_lower);
        }
        if (is_null(self::$mysqli)) {
            self::$mysqli = new mysqli(Micro::$db_hostname,
                                       Micro::$db_user,
                                       Micro::$db_password,
                                       Micro::$db_dbname);
        }
    }

    public function delete($params)
    {
        if ( ! array_key_exists('where', $params)) {
            error_log("## Error : 'where' must be specified.");
            return false;
        }
        $where = $this->_parseWhere($params['where']);

        $query = 'DELETE FROM `' . $this->table . '` WHERE ' . $where;

        return $this->_query($query, $this->db);
    }


    public function update($params)
    {
        if ( ! array_key_exists('where', $params)) {
            error_log("## Error : 'where' must be specified.");
            return false;
        }
        $where = $this->_parseWhere($params['where']);

        $query = 'UPDATE `' . $this->table . '` SET ';

        foreach ($params['target'] as $k => $v) {
            $escaped_val = $this->escape($v);
            if (strpos($escaped_val, 'FUNCTION::') === 0) {
                $escaped_val = str_replace('FUNCTION::', '', $escaped_val);
            } else {
                $escaped_val = '"' . $escaped_val . '"';
            }
            $query .= '`' . $k .'` = ' . $escaped_val . ', ';
        }
        $query = substr($query, 0, -2);

        $query .= ' WHERE ' . $where;

        return $this->_query($query, $this->db);
    }


    public function insert($params)
    {
        $keys = array_keys($params);
        $vals = array_values($params);

        $escaped_keys = array();
        foreach ($keys as $key) {
            $escaped_keys[] = $this->escape($key);
        }

        $escaped_vals = array();
        foreach ($vals as $val) {
            $escaped_val = $this->escape($val);
            if (strpos($escaped_val, 'FUNCTION::') === 0) {
                $escaped_val = str_replace('FUNCTION::', '', $escaped_val);
            } else {
                $escaped_val = '"' . $escaped_val . '"';
            }
            $escaped_vals[] = $escaped_val;
        }

        $query = 'INSERT INTO `' . $this->table . '` (`';

        $query .= implode('`, `', $escaped_keys);

        $query .= '`) VALUES (';

        $query .= implode(', ', $escaped_vals);

        $query .= ')';

        return $this->_query($query, $this->db);
    }


    public function select($select, $params = array())
    {
        // Generate query
        $query = 'SELECT '. $select . ' FROM `' . $this->table . '`';
        
        if (isset($params['where'])) {
            $where = $this->_parseWhere($params['where']);
            $query .= " WHERE $where";
        }
        if (isset($params['order by'])) {
            $order_by = $this->escape($params['order by']);
            $query .= " ORDER BY $order_by";
        }
        if (isset($params['group by'])) {
            $group_by = $this->escape($params['group by']);
            $query .= " GROUP BY $group_by";
        }
        if (isset($params['limit'])) {
            $limit = $this->escape($params['limit']);
            if (isset($params['offset'])) {
                $offset = $this->escape($params['offset']);
                $query .= " LIMIT $offset, $limit";
            } else {
                $query .= " LIMIT $limit";
            }
        }

        return $this->_query($query, $this->db);
    }

    /*-- private method --*/

    private function escape($str) {
        return self::$mysqli->real_escape_string($str);
    }

    private function _query($query, $db) {

        // Send query
        $result = self::$mysqli->query($query);
        //error_log("## query : $query");
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            error_log("## Error : Query failed. $message");
            return null;
        }

        if (is_bool($result)) {
            return $result;
        } else {
            // Fetch results
            $results = array();
            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }
            return $results;
        }
    }

    private function _parseWhere($params)
    {
        $where = '';

        foreach ($params as $param) {
            if (is_array($param)) {
                $count_param = count($param);
                if ($count_param == 3) {
                    $key = $param[0];
                    $operator = $param[1];
                    $value = $param[2];

                    if ($operator == 'IN') {
                        $values_escaped = array();
                        foreach ($value as $k => $v) {
                            $values_escaped[] = $this->escape($v);
                        }
                        $value = "('". implode("', '" , $values_escaped) . "')";
                    }
                    else {
                        $value = "'" . $this->escape($param[2]) . "'";
                    }

                    $where .= "`$key` $operator $value";
                }
                else if ($count_param == 2) {
                    $key = $param[0];
                    $operator = $param[1];
                    $where .= "`$key` $operator";
                }
                else {
                    error_log("## Error : opereator needed.");
                    return null;
                }
            }
            else {
                if ($param == 'AND' || $param == 'OR') {
                    $where .= " $param ";
                }
                else {
                    error_log("## Error : Invalid param => $param.");
                    return null;
                }
            }
        }

        return $where;
    }
}