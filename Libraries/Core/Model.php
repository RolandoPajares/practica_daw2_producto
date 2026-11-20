<?php

class Model extends Conexion
{
    protected string $table = '';
    protected string $primaryKey = 'id';
    protected string $select = '*';
    protected array $joins = [];
    protected array $whereBuilder = [];
    protected array $bindings = [];
    protected string $orderBy = '';
    protected string $limit = '';

    public function all(): array
    {
        return $this->execute("SELECT * FROM {$this->table}")->fetchAll();
    }

    public function find(int $id): ?array
    {
        $statement = $this->execute("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id", ['id' => $id]);
        return $statement->fetch() ?: null;
    }

    public function insert(array $data): string|false
    {
        $columns = implode(', ', array_keys($data));
        $params = ':' . implode(', :', array_keys($data));
        $statement = $this->execute("INSERT INTO {$this->table} ({$columns}) VALUES ({$params})", $data);
        return $statement->rowCount() > 0 ? (string) $this->connect()->lastInsertId() : false;
    }

    public function update(int $id, array $data): bool
    {
        $set = [];
        foreach (array_keys($data) as $column) {
            $set[] = "{$column} = :{$column}";
        }
        $data['__primary_key'] = $id;
        $this->execute("UPDATE {$this->table} SET " . implode(', ', $set) . " WHERE {$this->primaryKey} = :__primary_key", $data);
        return true;
    }

    /** ORM: elimina físicamente un registro. La práctica usa update() para eliminación lógica. */
    public function delete(int $id): bool
    {
        $this->execute("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id", ['id' => $id]);
        return true;
    }

    public function select(string $fields): self { $this->select = $fields; return $this; }

    public function join(string $table, string $condition, string $type = 'INNER'): self
    {
        $type = in_array(strtoupper($type), ['INNER', 'LEFT', 'RIGHT'], true) ? strtoupper($type) : 'INNER';
        $this->joins[] = "{$type} JOIN {$table} ON {$condition}";
        return $this;
    }

    public function where(array|string $conditions, array $bindings = []): self
    {
        $this->whereBuilder = array_merge($this->whereBuilder, (array) $conditions);
        $this->bindings = array_merge($this->bindings, $bindings);
        return $this;
    }

    public function orderBy(string $field, string $direction = 'ASC'): self
    {
        $this->orderBy = 'ORDER BY ' . $field . (strtoupper($direction) === 'DESC' ? ' DESC' : ' ASC');
        return $this;
    }

    public function limit(int $limit): self { $this->limit = 'LIMIT ' . max(0, $limit); return $this; }

    public function get(): array
    {
        $sql = "SELECT {$this->select} FROM {$this->table}";
        if ($this->joins) $sql .= ' ' . implode(' ', $this->joins);
        if ($this->whereBuilder) $sql .= ' WHERE ' . implode(' AND ', $this->whereBuilder);
        if ($this->orderBy) $sql .= ' ' . $this->orderBy;
        if ($this->limit) $sql .= ' ' . $this->limit;
        $result = $this->execute($sql, $this->bindings)->fetchAll();
        $this->resetQuery();
        return $result;
    }

    public function first(): ?array { return $this->limit(1)->get()[0] ?? null; }

    public function resetQuery(): void
    {
        $this->select = '*'; $this->joins = []; $this->whereBuilder = [];
        $this->bindings = []; $this->orderBy = ''; $this->limit = '';
    }

    private function execute(string $sql, array $bindings = []): PDOStatement
    {
        $statement = $this->connect()->prepare($sql);
        foreach ($bindings as $key => $value) {
            $parameter = is_string($key) && str_starts_with($key, ':') ? $key : ':' . $key;
            $statement->bindValue($parameter, $value);
        }
        $statement->execute();
        return $statement;
    }
}
