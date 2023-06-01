<?php

namespace core;

use PDO;

class Query
{
    protected PDO $db;
    protected string $table;
    protected string $field = '*';
    protected int $limit = 10;
    protected array $opt = [];

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function field(string $field = '*'): self
    {
        $this->field = $field;
        return $this;
    }

    public function limit(int $num = 10): self
    {
        $this->limit = $num;
        $this->opt['limit'] = ' LIMIT ' . $num;
        return $this;
    }

    public function page(int $num = 1): self
    {
        $this->opt['offset'] = ' OFFSET ' . ($num - 1) * $this->limit;
        return $this;
    }

    public function order(string $field, string $order = 'ASC'): self
    {
        $this->opt['order'] = " ORDER BY $field $order ";
        return $this;
    }

    public function where(string $where): self
    {
        $this->opt['where'] = " WHERE $where ";
        return $this;
    }

    public function select(): array
    {
        $sql = 'SELECT ' . $this->field . ' FROM `' . $this->table . '`';
        $sql .= $this->opt['order'] ?? null;
        $sql .= $this->opt['limit'] ?? null;
        $sql .= $this->opt['offset'] ?? null;
        $sql .= ' ;';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(): array
    {
        $sql = 'SELECT ' . $this->field . ' FROM `' . $this->table . '`';
        $sql .= $this->opt['where'] ?? null;
        $sql .= ' ;';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert(array $data): string
    {
        $k = '';
        $v = '';
        foreach ($data as $key => $value) {
            $k .= "$key,";
            $v .= "'$value',";
        }
        $k = rtrim($k, ',');
        $v = rtrim($v, ',');
        $sql = 'INSERT INTO `' . $this->table . "` ({$k}) VALUES ({$v}) ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function update(array $data): string
    {
        $str = '';
        foreach ($data as $key => $value) {
            $str .= "$key=$value,";
        }
        $str = rtrim($str, ',');
        $sql = 'UPDATE `' . $this->table . "`  SET $str";
        $sql .= $this->opt['where'] ?? die('condition cannot be empty');
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

}