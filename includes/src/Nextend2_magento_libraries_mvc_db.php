<?php

class N2DBConnector extends N2DBConnectorAbstract
{

    /**
     * @var Magento_Db_Adapter_Pdo_Mysql
     */
    private $read, $write, $prefix;

    /**
     * Primary key name in table
     *
     * @var string
     */
    public $primaryKeyColumn = "id";

    public function __construct($class) {
        $this->_prefix = Mage::getConfig()->getTablePrefix();

        $resource    = Mage::getSingleton('core/resource');
        $this->read  = $resource->getConnection('core_read');
        $this->write = $resource->getConnection('core_write');

        $this->setTableName($class);
    }

    public function query($query, $attributes = false) {
        if ($attributes) {
            foreach ($attributes as $key => $value) {
                $replaceTo = is_numeric($value) ? $value : $this->db->quote($value);
                $query     = str_replace($key, $replaceTo, $query);
            }
        }
        return $this->write->query($query);
    }

    /**
     * @param mixed $primaryKey primary key value
     *
     * @return mixed
     */
    public function findByPk($primaryKey) {

        $query = $this->read->select();

        $query->from($this->tableName);
        $query->where($this->quoteName($this->primaryKeyColumn) . ' = ' . (is_numeric($primaryKey) ? $primaryKey : $this->db->quote($primaryKey)));

        return $this->read->fetchRow($query);
    }

    public function findByAttributes(array $attributes, $fields = false, $order = false) {

        $query = $this->read->select();

        if ($fields) {
            $query->columns($this->quoteName($fields));
        }

        $query->from($this->tableName);
        foreach ($attributes as $key => $val) {
            $query->where($this->quoteName($key) . ' = ' . (is_numeric($val) ? $val : $this->quote($val)));
        }

        if ($order) {
            $query->order($order);
        }

        return $this->read->fetchRow($query);
    }

    /**
     * @param string|bool $order
     *
     * @return mixed
     */
    public function findAll($order = false) {
        $query = $this->read->select();
        $query->from($this->tableName);

        if ($order) {
            $query->order($order);
        }

        return $this->read->fetchAll($query);
    }

    /**
     * Return with all row by attributes
     *
     * @param array       $attributes
     * @param bool|array  $fields
     * @param bool|string $order
     *
     * @return mixed
     */
    public function findAllByAttributes(array $attributes, $fields = false, $order = false) {

        $query = $this->read->select();

        $query->from($this->tableName);

        if ($fields) {
            $query->columns($fields);
        }

        foreach ($attributes as $key => $val) {
            $query->where($key . ' = ' . (is_numeric($val) ? $val : $this->quote($val)));
        }

        if ($order) {
            $query->order($order);
        }

        return $this->read->fetchAll($query);
    }

    /**
     * Return with one row by query string
     *
     * @param string     $query
     * @param array|bool $attributes for parameter binding
     *
     * @return mixed
     */
    public function queryRow($query, $attributes = false) {
        if ($attributes) {
            foreach ($attributes as $key => $value) {
                $replaceTo = is_numeric($value) ? $value : $this->db->quote($value);
                $query     = str_replace($key, $replaceTo, $query);
            }
        }
        return $this->read->fetchRow($query);
    }

    public function queryAll($query, $attributes = false, $type = "assoc", $key = null) {
        if ($attributes) {
            foreach ($attributes as $key => $value) {
                $replaceTo = is_numeric($value) ? $value : $this->db->quote($value);
                $query     = str_replace($key, $replaceTo, $query);
            }
        }

        $rs = $this->read->fetchAll($query);
        if (!$key) return $rs;

        $re = array();
        foreach ($rs AS $r) {
            $re[$r[$key]] = $r;
        }
        return $re;
    }

    /**
     * Insert new row
     *
     * @param array $attributes
     *
     * @return bool|mixed|void
     */
    public function insert(array $attributes) {
        $this->write->insert($this->tableName, $attributes);
    }

    public function insertId() {
        return $this->write->lastInsertId();
    }

    /**
     * Update row(s) by param(s)
     *
     * @param array $attributes
     * @param array $conditions
     *
     * @return mixed
     */
    public function update(array $attributes, array $conditions) {
        $where = array();
        foreach ($conditions as $key => $val) {
            $where[] = $key . ' = ' . (is_numeric($val) ? $val : $this->quote($val));
        }
        return $this->write->update($this->tableName, $attributes, $where);
    }

    /**
     * Update one row by primary key with $attributes
     *
     * @param mixed $primaryKey
     * @param array $attributes
     *
     * @return mixed
     */
    public function updateByPk($primaryKey, array $attributes) {

        $conditions = $this->primaryKeyColumn . ' = ' . (is_numeric($primaryKey) ? $primaryKey : $this->quote($primaryKey));
        return $this->write->update($this->tableName, $attributes, $conditions);
    }

    /**
     * Delete one with by primary key
     *
     * @param mixed $primaryKey
     *
     * @return mixed
     */
    public function deleteByPk($primaryKey) {

        $conditions = array($this->primaryKeyColumn . ' = ' . (is_numeric($primaryKey) ? $primaryKey : $this->quote($primaryKey)));

        return $this->write->delete($this->tableName, $conditions);
    }

    /**
     * Delete all rows by attributes
     *
     * @param array $conditions
     *
     * @return mixed
     */
    public function deleteByAttributes(array $conditions) {
        $where = array();
        foreach ($conditions as $key => $val) {
            $where[] = $key . ' = ' . (is_numeric($val) ? $val : $this->quote($val));
        }

        return $this->write->delete($this->tableName, $where);
    }

    /**
     * @param string $text
     * @param bool   $escape
     *
     * @return string
     */
    public function quote($text, $escape = true) {
        return $this->write->quote($text);
    }

    /**
     * @param string $name
     * @param null   $as
     *
     * @return mixed
     */
    public function quoteName($name, $as = null) {
        if ($as) {
            return $this->write->quoteColumnAs($name, $as);
        }
        return $this->write->quoteIdentifier($name, $as);
    }
}