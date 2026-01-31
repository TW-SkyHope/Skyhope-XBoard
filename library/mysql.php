<?php
/**
 * MySQL数据库操作类（基于PDO）- 完全封装版
 * 
 * 功能特点：
 * 1. 无需编写SQL语句，所有操作通过PHP数据类型完成
 * 2. 支持链式操作和事务处理
 * 3. 自动参数绑定防止SQL注入
 * 4. 支持多种数据格式输入（关联数组、索引数组、对象）
 * 5. 提供表结构操作和批量操作
 * 
 * 使用示例：
 * $db = new MySQLiPDO([
 *     'host' => 'localhost',
 *     'dbname' => 'test',
 *     'username' => 'root',
 *     'password' => '123456'
 * ]);
 * 
 * // 查询示例
 * $user = $db->findOne('users', ['id' => 1], ['name', 'email']);
 * 
 * // 插入示例
 * $id = $db->insert('users', ['name' => 'John', 'email' => 'john@example.com']);
 */
class MySQLiPDO {
    /** @var PDO PDO实例 */
    public $pdo;
    
    /** @var string 最后错误信息 */
    private $error;

    /**
     * 构造函数
     * 
     * @param array|PDO $connection 数据库配置数组或PDO实例
     * @throws InvalidArgumentException 当参数无效时抛出
     * @throws RuntimeException 当连接失败时抛出
     * 
     * 配置数组格式：
     * [
     *     'host' => 'localhost',    // 数据库主机
     *     'port' => 3306,           // 端口号，默认3306
     *     'dbname' => 'test',       // 数据库名
     *     'username' => 'root',     // 用户名
     *     'password' => '123456'    // 密码
     * ]
     */
    public function __construct($connection) {
        if ($connection instanceof PDO) {
            $this->pdo = $connection;
            return;
        }

        if (!is_array($connection)) {
            throw new InvalidArgumentException("构造参数必须是PDO实例或配置数组");
        }
        
        $config = $this->validateConnectionConfig($connection);
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset=utf8mb4";
        
        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => false
            ]);
        } catch (PDOException $e) {
            $this->error = "数据库连接失败: " . $e->getMessage();
            throw new RuntimeException($this->error);
        }
    }

    /**
     * 验证并标准化连接配置
     * 
     * @param array $config 原始配置数组
     * @return array 标准化后的配置数组
     */
    private function validateConnectionConfig($config) {
        return [
            'host' => $config['host'] ?? 'localhost',
            'port' => isset($config['port']) ? (int)$config['port'] : 3306,
            'dbname' => $config['dbname'] ?? '',
            'username' => $config['username'] ?? '',
            'password' => $config['password'] ?? ''
        ];
    }

    // ==================== 查询操作 ====================

    /**
     * 查询单条记录
     * 
     * @param string $table 表名
     * @param array $conditions 条件数组 ['字段名' => '值']
     * @param array|string $fields 要查询的字段(默认全部)
     * @return array|null 单条记录或null(无结果时)
     * 
     * 示例：
     * $user = $db->findOne('users', ['id' => 1], ['name', 'email']);
     */
    public function findOne($table, $conditions = [], $fields = ['*']) {
        $where = $this->buildWhereClause($conditions, $params);
        $fieldList = $this->buildFieldList($fields);
        
        $sql = "SELECT {$fieldList} FROM `{$table}` {$where} LIMIT 1";
        $result = $this->query($sql, $params);
        
        return $result ? $result[0] : null;
    }

    /**
     * 查询多条记录
     * 
     * @param string $table 表名
     * @param array $conditions 条件数组
     * @param array $options 查询选项 [
     *     'fields' => [],    // 要查询的字段
     *     'order' => '',     // 排序条件 如: 'id DESC'
     *     'limit' => 10,     // 限制数量
     *     'offset' => 0      // 偏移量
     * ]
     * @return array 结果数组
     * 
     * 示例：
     * $users = $db->findAll('users', ['status' => 1], [
     *     'fields' => ['id', 'name'],
     *     'order' => 'id DESC',
     *     'limit' => 10
     * ]);
     */
    public function findAll($table, $conditions = [], $options = []) {
        $where = $this->buildWhereClause($conditions, $params);
        $fields = $this->buildFieldList($options['fields'] ?? ['*']);
        
        $order = isset($options['order']) ? "ORDER BY {$options['order']}" : '';
        $limit = isset($options['limit']) ? "LIMIT {$options['limit']}" : '';
        $offset = isset($options['offset']) ? "OFFSET {$options['offset']}" : '';
        
        $sql = "SELECT {$fields} FROM `{$table}` {$where} {$order} {$limit} {$offset}";
        return $this->query($sql, $params);
    }

    /**
     * 统计记录数量
     * 
     * @param string $table 表名
     * @param array $conditions 条件数组
     * @return int 记录数量
     * 
     * 示例：
     * $count = $db->count('users', ['status' => 1]);
     */
    public function count($table, $conditions = []) {
        $where = $this->buildWhereClause($conditions, $params);
        $sql = "SELECT COUNT(*) AS count FROM `{$table}` {$where}";
        
        $result = $this->query($sql, $params);
        return $result ? (int)$result[0]['count'] : 0;
    }

    // ==================== 增删改操作 ====================

    /**
     * 插入单条数据
     * 
     * @param string $table 表名
     * @param array|object $data 数据(支持关联数组/对象/索引数组)
     * @param array $columns 可选字段名(当$data为索引数组时使用)
     * @return int|false 成功返回插入ID，失败返回false
     * 
     * 示例：
     * // 关联数组方式
     * $id = $db->insert('users', ['name' => 'John', 'email' => 'john@example.com']);
     * 
     * // 索引数组方式
     * $id = $db->insert('users', ['John', 'john@example.com'], ['name', 'email']);
     */
    public function insert($table, $data, $columns = []) {
        $data = $this->normalizeData($data, $columns);
        if (empty($data)) {
            throw new InvalidArgumentException("插入数据不能为空");
        }

        $columns = implode('`, `', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO `{$table}` (`{$columns}`) VALUES ({$placeholders})";
        
        try {
            $this->execute($sql, $data);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            $this->error = "插入失败: " . $e->getMessage();
            return false;
        }
    }

    /**
     * 批量插入数据
     * 
     * @param string $table 表名
     * @param array $dataList 数据列表
     * @param array $columns 可选字段名(当$dataList包含索引数组时使用)
     * @return int|false 成功返回影响行数，失败返回false
     * 
     * 示例：
     * $rows = $db->batchInsert('users', [
     *     ['name' => 'John', 'email' => 'john@example.com'],
     *     ['name' => 'Jane', 'email' => 'jane@example.com']
     * ]);
     */
    public function batchInsert($table, $dataList, $columns = []) {
        if (empty($dataList)) return 0;
        
        // 标准化首行数据并确定列顺序
        $firstData = $this->normalizeData($dataList[0], $columns);
        $columnOrder = array_keys($firstData);
        $columnStr = implode('`, `', $columnOrder);
        
        $placeholders = [];
        $params = [];
        $placeholderRow = '(' . implode(', ', array_fill(0, count($columnOrder), '?')) . ')';
        
        // 使用事务提高批量插入性能
        $this->beginTransaction();
        try {
            foreach ($dataList as $row) {
                $rowData = $this->normalizeData($row, $columnOrder);
                $placeholders[] = $placeholderRow;
                foreach ($columnOrder as $col) {
                    $params[] = $rowData[$col] ?? null;
                }
            }
            
            $sql = "INSERT INTO `{$table}` (`{$columnStr}`) VALUES " . implode(', ', $placeholders);
            $result = $this->execute($sql, $params);
            
            $this->commit();
            return $result;
        } catch (PDOException $e) {
            $this->rollBack();
            $this->error = "批量插入失败: " . $e->getMessage();
            return false;
        }
    }

    /**
     * 更新记录
     * 
     * @param string $table 表名
     * @param array|object $data 更新数据
     * @param array $conditions 条件数组
     * @return int|false 成功返回影响行数，失败返回false
     * 
     * 示例：
     * $rows = $db->update('users', 
     *     ['name' => 'John Doe'], 
     *     ['id' => 1]
     * );
     */
    public function update($table, $data, $conditions = []) {
        $data = $this->normalizeData($data);
        if (empty($data)) {
            throw new InvalidArgumentException("更新数据不能为空");
        }

        $setParts = [];
        $setParams = [];
        foreach ($data as $key => $value) {
            $paramKey = ':set_' . $key;
            $setParts[] = "`{$key}` = {$paramKey}";
            $setParams[$paramKey] = $value;
        }
        
        $where = $this->buildWhereClause($conditions, $whereParams);
        $sql = "UPDATE `{$table}` SET " . implode(', ', $setParts) . " {$where}";
        
        try {
            return $this->execute($sql, array_merge($setParams, $whereParams));
        } catch (PDOException $e) {
            $this->error = "更新失败: " . $e->getMessage();
            return false;
        }
    }

    /**
     * 删除记录
     * 
     * @param string $table 表名
     * @param array $conditions 条件数组
     * @return int|false 成功返回影响行数，失败返回false
     * 
     * 示例：
     * $rows = $db->delete('users', ['id' => 1]);
     */
    public function delete($table, $conditions = []) {
        $where = $this->buildWhereClause($conditions, $params);
        $sql = "DELETE FROM `{$table}` {$where}";
        
        try {
            return $this->execute($sql, $params);
        } catch (PDOException $e) {
            $this->error = "删除失败: " . $e->getMessage();
            return false;
        }
    }

    // ==================== 表结构操作 ====================

    /**
     * 获取表结构
     * 
     * @param string $table 表名
     * @return array 表结构数组
     * 
     * 示例：
     * $structure = $db->getTableStructure('users');
     */
    public function getTableStructure($table) {
        return $this->query("DESCRIBE `{$table}`");
    }

    /**
     * 创建表
     * 
     * @param string $table 表名
     * @param array $fields 字段定义数组
     * @param array $options 表选项 [
     *     'engine' => 'InnoDB',  // 存储引擎
     *     'charset' => 'utf8mb4', // 字符集
     *     'collate' => 'utf8mb4_general_ci' // 排序规则
     * ]
     * @return bool 是否成功
     * 
     * 示例：
     * $db->createTable('users', [
     *     'id' => [
     *         'type' => 'INT',
     *         'length' => 11,
     *         'unsigned' => true,
     *         'auto_increment' => true,
     *         'primary' => true
     *     ],
     *     'name' => [
     *         'type' => 'VARCHAR',
     *         'length' => 255,
     *         'notnull' => true
     *     ]
     * ], [
     *     'engine' => 'InnoDB',
     *     'charset' => 'utf8mb4'
     * ]);
     */
    public function createTable($table, $fields, $options = []) {
        $fieldDefinitions = [];
        $primaryKeys = [];
        
        foreach ($fields as $name => $definition) {
            if ($name === 'PRIMARY KEY') continue;
            
            if (is_string($definition)) {
                $fieldDefinitions[] = "`{$name}` {$definition}";
                if (strpos(strtoupper($definition), 'PRIMARY KEY') !== false) {
                    $primaryKeys[] = $name;
                }
            } elseif (is_array($definition)) {
                $fieldDefinitions[] = $this->buildColumnDefinition($name, $definition);
                if (!empty($definition['primary'])) {
                    $primaryKeys[] = $name;
                }
            }
        }
        
        if (isset($fields['PRIMARY KEY'])) {
            $pkDef = $fields['PRIMARY KEY'];
            $primaryKeys = is_array($pkDef) ? $pkDef : [trim($pkDef, '()')];
        }
        
        $engine = $options['engine'] ?? 'InnoDB';
        $charset = $options['charset'] ?? 'utf8mb4';
        $collate = $options['collate'] ?? 'utf8mb4_general_ci';
        
        $sql = "CREATE TABLE IF NOT EXISTS `{$table}` (" . 
               implode(', ', $fieldDefinitions);
        
        if (!empty($primaryKeys)) {
            $pkColumns = is_array($primaryKeys) ? 
                        '`' . implode('`, `', $primaryKeys) . '`' : 
                        $primaryKeys;
            $sql .= ", PRIMARY KEY ({$pkColumns})";
        }
        
        $sql .= ") ENGINE={$engine} DEFAULT CHARSET={$charset} COLLATE={$collate}";
        
        try {
            return $this->execute($sql) !== false;
        } catch (PDOException $e) {
            $this->error = "创建表失败: " . $e->getMessage();
            return false;
        }
    }

    /**
     * 修改表结构
     * 
     * @param string $table 表名
     * @param array $alter 修改操作数组 [
     *     [
     *         'type' => 'ADD',           // 操作类型(ADD/MODIFY/CHANGE/DROP)
     *         'field' => 'new_column',   // 字段名
     *         'definition' => 'INT',     // 字段定义
     *         'after' => 'id'            // 可选，指定字段位置
     *     ]
     * ]
     * @return bool 是否成功
     * 
     * 示例：
     * $db->alterTable('users', [
     *     [
     *         'type' => 'ADD',
     *         'field' => 'age',
     *         'definition' => 'INT UNSIGNED',
     *         'after' => 'name'
     *     ]
     * ]);
     */
    public function alterTable($table, $alter) {
        $alterParts = [];
        foreach ($alter as $action) {
            if (!isset($action['type']) || !isset($action['field'])) {
                throw new InvalidArgumentException("ALTER操作必须包含type和field属性");
            }
            
            $part = "{$action['type']} `{$action['field']}`";
            if (isset($action['definition'])) {
                $part .= " {$action['definition']}";
            }
            if (isset($action['after'])) {
                $part .= " AFTER `{$action['after']}`";
            }
            $alterParts[] = $part;
        }
        
        $sql = "ALTER TABLE `{$table}` " . implode(', ', $alterParts);
        
        try {
            return $this->execute($sql) !== false;
        } catch (PDOException $e) {
            $this->error = "修改表结构失败: " . $e->getMessage();
            return false;
        }
    }

    // ==================== 事务处理 ====================

    /**
     * 开始事务
     */
    public function beginTransaction() {
        $this->pdo->beginTransaction();
    }

    /**
     * 提交事务
     */
    public function commit() {
        $this->pdo->commit();
    }

    /**
     * 回滚事务
     */
    public function rollBack() {
        $this->pdo->rollBack();
    }

    // ==================== 辅助方法 ====================

    /**
     * 构建WHERE子句
     * 
     * @param array $conditions 条件数组
     * @param array &$params 引用参数数组
     * @return string WHERE子句
     */
    private function buildWhereClause($conditions, &$params = []) {
        $params = [];
        if (empty($conditions)) return '';
        
        $whereParts = [];
        foreach ($conditions as $field => $value) {
            $paramKey = ':where_' . $field;
            $whereParts[] = "`{$field}` = {$paramKey}";
            $params[$paramKey] = $value;
        }
        
        return 'WHERE ' . implode(' AND ', $whereParts);
    }

    /**
     * 构建字段列表
     * 
     * @param array|string $fields 字段数组或字符串
     * @return string 字段列表字符串
     */
    private function buildFieldList($fields) {
        if (is_string($fields)) return $fields;
        return implode(', ', array_map(function($field) {
            return $field === '*' ? '*' : "`{$field}`";
        }, $fields));
    }

    /**
     * 标准化数据格式
     * 
     * @param array|object $data 原始数据
     * @param array $columns 字段名数组(用于索引数组转换)
     * @return array 标准化后的关联数组
     * @throws InvalidArgumentException 当数据无效时抛出
     */
private function normalizeData($data, $columns = []) {
    if (is_object($data)) {
        $data = (array)$data;
    }

    // 处理索引数组
    if (isset($data[0])) {
        if (empty($columns)) {
            throw new InvalidArgumentException("索引数组必须提供字段名（columns参数）");
        }

        $assocData = [];
        foreach ($columns as $index => $column) {
            // 确保即使值为 null，也保留列顺序
            $assocData[$column] = $data[$index] ?? null;
        }
        return $assocData;
    }

    return $data;
}

    /**
     * 构建列定义
     * 
     * @param string $name 字段名
     * @param array $field 字段定义数组
     * @return string 列定义SQL片段
     * @throws InvalidArgumentException 当定义无效时抛出
     */
    private function buildColumnDefinition($name, $field) {
        $type = $field['type'] ?? '';
        if (empty($type)) {
            throw new InvalidArgumentException("字段定义必须包含type属性");
        }
        
        $definition = "`{$name}` {$type}";

        // 处理长度定义
        if (isset($field['length'])) {
            $length = is_array($field['length']) ? 
                     implode(',', $field['length']) : 
                     $field['length'];
            $definition .= "({$length})";
        }

        // 处理无符号
        if (!empty($field['unsigned'])) {
            $definition .= ' UNSIGNED';
        }

        // 处理非空约束
        if (isset($field['notnull'])) {
            $definition .= $field['notnull'] ? ' NOT NULL' : ' NULL';
        } elseif (!isset($field['default'])) {
            $definition .= ' NULL';
        }

        // 处理默认值
        if (array_key_exists('default', $field)) {
            if ($field['default'] === null) {
                $definition .= ' DEFAULT NULL';
            } elseif (strtoupper($field['default']) === 'CURRENT_TIMESTAMP') {
                $definition .= ' DEFAULT CURRENT_TIMESTAMP';
            } else {
                $defaultValue = is_numeric($field['default']) ? 
                               $field['default'] : 
                               "'" . str_replace("'", "''", $field['default']) . "'";
                $definition .= " DEFAULT {$defaultValue}";
            }
        }

        // 处理自增
        if (!empty($field['auto_increment'])) {
            $definition .= ' AUTO_INCREMENT';
        }

        // 处理注释
        if (isset($field['comment'])) {
            $definition .= " COMMENT '" . str_replace("'", "''", $field['comment']) . "'";
        }

        return $definition;
    }

    // ==================== 核心数据库方法 ====================

    /**
     * 执行查询语句
     * 
     * @param string $sql SQL语句
     * @param array $params 参数数组
     * @return array|false 成功返回结果数组，失败返回false
     */
    private function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->error = "查询失败: " . $e->getMessage();
            return false;
        }
    }

    /**
     * 执行非查询语句
     * 
     * @param string $sql SQL语句
     * @param array $params 参数数组
     * @return int|false 成功返回影响行数，失败返回false
     */
    private function execute($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $this->error = "执行失败: " . $e->getMessage();
            return false;
        }
    }

    /**
     * 获取最后错误信息
     * 
     * @return string 错误信息
     */
    public function getError() {
        return $this->error;
    }
}
