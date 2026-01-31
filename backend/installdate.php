<?php
// 数据库操作文件 - 处理安装过程中的数据表创建和初始化

// 引入MySQL操作类
require_once dirname(__DIR__, 1) . "/library/mysql.php";

// 处理AJAX请求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 确保没有输出任何内容之前设置响应头
    ob_start();

    // 设置响应头为JSON
    header('Content-Type: application/json');

    // 初始化响应数组
    $response = ['success' => false, 'message' => '未知错误'];

    try {
        // 测试数据库连接
        if (isset($_POST['test_connection'])) {
            $dsn = "mysql:host=" . $_POST['db_host'] . ";port=" . $_POST['db_port'];
            if (!empty($_POST['db_name'])) {
                $dsn .= ";dbname=" . $_POST['db_name'];
            }

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $pdo = new PDO($dsn, $_POST['db_username'], $_POST['db_password'], $options);

            // 获取MySQL版本信息
            $stmt = $pdo->query("SELECT VERSION() AS version");
            $version = $stmt->fetchColumn();

            $response = [
                'success' => true,
                'message' => "成功连接到MySQL服务器，版本: " . $version
            ];
        }

        // 保存数据库配置
        if (isset($_POST['save_config'])) {
            // 首先测试数据库连接
            $dsn = "mysql:host=" . $_POST['db_host'] . ";port=" . $_POST['db_port'] . ";dbname=" . $_POST['db_name'];
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $pdo = new PDO($dsn, $_POST['db_username'], $_POST['db_password'], $options);

            // 检查数据库是否已有数据
            $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
            if (!empty($tables)) {
                $hasData = false;
                foreach ($tables as $table) {
                    $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
                    if ($count > 0) {
                        $hasData = true;
                        break;
                    }
                }
                if ($hasData) {
                    throw new Exception("数据库内已有数据，请先删除所有数据后再安装");
                }
            }

            // 生成随机哈希值
            $randomHash = hash('sha256', random_bytes(16));

            // 使用MySQLiPDO类创建表结构
            $sql = new MySQLiPDO($pdo);

            // 创建Setdates表
            $setdatesFields = [
                'name' => [
                    'type' => 'VARCHAR',
                    'length' => 255,
                    'notnull' => true,
                    'comment' => '名称',
                    'primary' => true
                ],
                'value1' => [
                    'type' => 'VARCHAR',
                    'length' => 255,
                    'notnull' => false,
                    'default' => null,
                    'comment' => ' 值1'
                ],
                'value2' => [
                    'type' => 'INT',
                    'length' => 255,
                    'notnull' => false,
                    'comment' => '值2'
                ],
                'time' => [
                    'type' => 'DATETIME',
                    'length' => 6,
                    'notnull' => false,
                    'default' => null,
                    'comment' => '时间'
                ]
            ];
            $setdatesData = [
                ['title', "Skyhope XBoard", null, NULL],
                ['introduce1', '安全连接，自由访问', null, null],
                ['introduce2', '使用我们的VPN服务，保护您的隐私并访问全球内容。高速稳定的连接，随时随地畅享网络自由。', null, null],
                ['login', null, 1, null],
                ['register', null, 1, NULL],
                ['contact', '114514', null, null],
                ['mail', null, 1, null],
                ['ID', $randomHash, null, null]  // 添加随机哈希值
            ];
            if ($sql->createTable('Setdates', $setdatesFields) === false) {
                throw new Exception("创建Setdates表失败: " . $sql->getError());
            }

            // 插入Setdates表数据
            $currentTime = date('Y-m-d H:i:s');

            $inserted = $sql->batchInsert('Setdates', $setdatesData, ['name', 'value1', 'value2', 'time']);
            if ($inserted === false) {
                throw new Exception("插入Setdates数据失败: " . $sql->getError());
            }

            // 创建User表
            $userFields = [
                'id' => [
                    'type' => 'INT',
                    'length' => 50,
                    'notnull' => true,
                    'primary' => true,
                    'auto_increment' => true,
                    'comment' => '用户ID'
                ],
                'name' => [
                    'type' => 'VARCHAR',
                    'length' => 255,
                    'notnull' => true,
                    'comment' => '用户名',
                    'unique' => true
                ],
                'password' => [
                    'type' => 'VARCHAR',
                    'length' => 255,
                    'notnull' => true,
                    'comment' => '密码'
                ],
                'status' => [
                    'type' => 'INT',
                    'length' => 10,
                    'notnull' => true,
                    'default' => 1,
                    'comment' => '状态'
                ],
                'postbox' => [
                    'type' => 'VARCHAR',
                    'length' => 255,
                    'notnull' => true,
                    'comment' => '邮箱'
                ],
                'vip' => [
                    'type' => 'VARCHAR',
                    'length' => 255,
                    'notnull' => true,
                    'default' => '0',
                    'comment' => 'VIP状态'
                ],
                'ip' => [
                    'type' => 'VARCHAR',
                    'length' => 255,
                    'notnull' => false,
                    'comment' => 'IP地址'
                ],
                'viptimestart' => [
                    'type' => 'TIMESTAMP',
                    'length' => 6,
                    'notnull' => false,
                    'default' => null,
                    'comment' => 'VIP开始时间'
                ],
                'viptimeend' => [
                    'type' => 'TIMESTAMP',
                    'length' => 6,
                    'notnull' => false,
                    'default' => null,
                    'comment' => 'VIP结束时间'
                ],
                'flow' => [
                    'type' => 'FLOAT',
                    'notnull' => false,
                    'comment' => '流量'
                ]
            ];

            if ($sql->createTable('User', $userFields) === false) {
                throw new Exception("创建User表失败: " . $sql->getError());
            }

            // 创建Article表
            $articleFields = [
                'name' => [
                    'type' => 'VARCHAR',
                    'length' => 255,
                    'notnull' => true,
                    'comment' => '文章名称',
                    'primary' => true
                ],
                'title' => [
                    'type' => 'VARCHAR',
                    'length' => 255,
                    'notnull' => true,
                    'comment' => '文章标题'
                ],
                'content' => [
                    'type' => 'TEXT',
                    'length' => 10000,
                    'notnull' => true,
                    'comment' => '文章内容'
                ]
            ];

            if ($sql->createTable('Article', $articleFields) === false) {
                throw new Exception("创建Article表失败: " . $sql->getError());
            }

            $userlog1Fields = [
                'username' => [
                    'type' => 'VARCHAR',
                    'length' => 255,
                    'notnull' => true,
                    'comment' => '用户名',
                    'primary' => true
                ],
                'ip' => [
                    'type' => 'VARCHAR',
                    'length' => 255,
                    'notnull' => true,
                    'comment' => 'ip'
                ],
                'time' => [
                    'type' => 'TIME',
                    'notnull' => true,
                    'comment' => '时间'
                ],
                'type' => [
                    'type' => 'INT',
                    'length' => 10,
                    'notnull' => true,
                    'comment' => '登录还是注册'
                ]
            ];

            if ($sql->createTable('userlog1', $userlog1Fields) === false) {
                throw new Exception("创建Article表失败: " . $sql->getError());
            }

            // 生成配置文件内容
            $configContent = "<?php
// 数据库配置文件 - 由项目初始化向导生成
define('DB_HOST', '" . addslashes($_POST['db_host']) . "');
define('DB_PORT', '" . addslashes($_POST['db_port']) . "');
define('DB_NAME', '" . addslashes($_POST['db_name']) . "');
define('DB_USER', '" . addslashes($_POST['db_username']) . "');
define('DB_PASS', '" . addslashes($_POST['db_password']) . "');

// 创建PDO连接
try {
    \$dsn = \"mysql:host=\" . DB_HOST . \";port=\" . DB_PORT . \";dbname=\" . DB_NAME . \";charset=utf8mb4\";
    \$options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    \$pdo = new PDO(\$dsn, DB_USER, DB_PASS, \$options);
} catch (PDOException \$e) {
    die(\"数据库连接失败: \" . \$e->getMessage());
}
?>";

            // 检查文件是否可写
            $filePath = dirname(__DIR__, 1) . "/config/db.php";
            if (file_exists($filePath) && !is_writable($filePath)) {
                throw new Exception("配置文件已存在但不可写，请检查文件权限");
            }

            if (!is_writable(dirname($filePath))) {
                throw new Exception("目录不可写，无法创建配置文件");
            }

            // 写入配置文件
            $result = file_put_contents($filePath, $configContent);

            if ($result === false) {
                throw new Exception("无法写入配置文件");
            }

            // 基于随机哈希值生成新的哈希值
            $folderHash = hash('sha256', $randomHash);
            $folderPath = dirname(__FILE__) . '/' . $folderHash; // 使用当前文件所在目录

            // 创建文件夹
            if (!mkdir($folderPath, 0755, true)) {
                throw new Exception("无法创建文件夹: " . $folderPath);
            }

            // 获取当前目录下所有文件和文件夹
            $currentDir = dirname(__FILE__);
            $filesToMove = glob($currentDir . '/*');

            // 当前脚本文件名
            $currentScript = basename(__FILE__);

            foreach ($filesToMove as $file) {
                $fileName = basename($file);

                // 跳过当前脚本和新创建的文件夹
                if ($fileName === $currentScript || $fileName === $folderHash) {
                    continue;
                }

                // 跳过目录（只移动文件）
                if (is_dir($file)) {
                    continue;
                }

                // 移动文件
                $newPath = $folderPath . '/' . $fileName;
                if (!rename($file, $newPath)) {
                    throw new Exception("无法移动文件: " . $fileName);
                }
            }

            $response = [
                'success' => true,
                'message' => "数据库配置已成功保存并创建了所有必要的表结构",
                'folderName' => $folderHash
            ];
        }
    } catch (PDOException $e) {
        $response = [
            'success' => false,
            'message' => "数据库错误: " . $e->getMessage()
        ];
    } catch (Exception $e) {
        $response = [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }

    // 清除任何可能的输出
    ob_end_clean();

    // 确保只输出JSON数据
    echo json_encode($response);
    exit;
}