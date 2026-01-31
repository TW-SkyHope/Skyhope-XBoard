<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>服务器列表 - VPN 仪表盘</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            color: #333;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
        }

        .dashboard {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 80px;
            transition: margin-left 0.3s;
        }

        .header {
            background: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border-bottom: 1px solid rgba(0,123,255,0.1);
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #007bff;
            font-weight: 600;
        }

        .server-container {
            padding: 20px;
        }

        .server-tabs-wrapper {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-bottom: 20px;
        }

        .server-tabs {
            display: inline-flex;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,123,255,0.1);
            overflow: hidden;
        }

        .server-tab {
            padding: 14px 40px;
            cursor: pointer;
            transition: all 0.3s;
            border-bottom: 3px solid transparent;
            font-size: 15px;
            margin: 0 5px;
        }

        .server-tab.active {
            background: rgba(0,123,255,0.05);
            border-bottom: 3px solid #007bff;
            color: #007bff;
            font-weight: 500;
        }

        .server-tab:hover {
            background: rgba(0,123,255,0.05);
        }

        .server-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .server-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: 1px solid rgba(0,123,255,0.1);
            overflow: hidden;
        }

        .server-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,123,255,0.1);
        }

        .server-card-header {
            padding: 15px 20px;
            background: linear-gradient(135deg, rgba(0,123,255,0.03), rgba(0,123,255,0.05));
            border-bottom: 1px solid rgba(0,123,255,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .server-name {
            font-weight: 500;
            color: #007bff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .server-status {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-online {
            background: rgba(40,167,69,0.1);
            color: #28a745;
        }

        .status-offline {
            background: rgba(220,53,69,0.1);
            color: #dc3545;
        }

        .server-card-body {
            padding: 20px;
        }

        .server-info {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .server-info-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .server-info-icon {
            color: #007bff;
            width: 20px;
            text-align: center;
        }

        .server-info-label {
            color: #6c757d;
            min-width: 80px;
        }

        .server-info-value {
            color: #495057;
            font-weight: 400;
        }

        .server-card-footer {
            padding: 15px 20px;
            border-top: 1px solid rgba(0,123,255,0.1);
            display: flex;
            justify-content: flex-end;
        }

        .connect-button {
            background: linear-gradient(135deg, #007bff, #0062cc);
            color: #fff;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .connect-button:hover {
            background: linear-gradient(135deg, #0062cc, #0056b3);
        }

        .connect-button.disabled {
            background: #6c757d;
            cursor: not-allowed;
            opacity: 0.7;
        }
    </style>
</head>
<body>
<?php include dirname(__DIR__,2).'/src/component/sidebar.php'; ?>
    
    <div class="dashboard">
        <header class="header">
            <h1><i class="fas fa-server"></i> 服务器列表</h1>
        </header>
        
        <div class="server-container">
            <div class="server-tabs-wrapper">
                <div class="server-tabs">
                    <div class="server-tab active">全部服务器</div>
                    <div class="server-tab">亚洲</div>
                    <div class="server-tab">欧洲</div>
                    <div class="server-tab">美洲</div>
                    <div class="server-tab">收藏</div>
                </div>
            </div>
            
            <div class="server-grid">
                <?php
                $servers = [
                    [
                        'name' => '香港节点 #1',
                        'region' => '亚洲',
                        'location' => '香港',
                        'latency' => '32ms',
                        'load' => '低 (25%)',
                        'protocols' => 'WireGuard, OpenVPN',
                        'line' => 'BGP多线',
                        'status' => 'online',
                        'favorite' => false
                    ],
                    [
                        'name' => '日本东京 #2',
                        'region' => '亚洲',
                        'location' => '日本东京',
                        'latency' => '56ms',
                        'load' => '中 (45%)',
                        'protocols' => 'WireGuard, OpenVPN',
                        'line' => 'IIJ线路',
                        'status' => 'online',
                        'favorite' => true
                    ],
                    [
                        'name' => '美国洛杉矶 #1',
                        'region' => '美洲',
                        'location' => '美国洛杉矶',
                        'latency' => '158ms',
                        'load' => '高 (75%)',
                        'protocols' => 'WireGuard, OpenVPN',
                        'line' => 'CN2 GIA',
                        'status' => 'online',
                        'favorite' => false
                    ],
                    [
                        'name' => '德国法兰克福 #3',
                        'region' => '欧洲',
                        'location' => '德国法兰克福',
                        'latency' => '-',
                        'load' => '-',
                        'protocols' => 'WireGuard, OpenVPN',
                        'line' => '普通线路',
                        'status' => 'offline',
                        'favorite' => false
                    ],
                    [
                        'name' => '新加坡 #1',
                        'region' => '亚洲',
                        'location' => '新加坡',
                        'latency' => '68ms',
                        'load' => '低 (30%)',
                        'protocols' => 'WireGuard, OpenVPN',
                        'line' => 'CN2线路',
                        'status' => 'online',
                        'favorite' => true
                    ],
                    [
                        'name' => '英国伦敦 #2',
                        'region' => '欧洲',
                        'location' => '英国伦敦',
                        'latency' => '142ms',
                        'load' => '中 (50%)',
                        'protocols' => 'WireGuard, OpenVPN',
                        'line' => '普通线路',
                        'status' => 'online',
                        'favorite' => false
                    ]
                ];
                
                foreach ($servers as $server) {
                    $statusClass = $server['status'] === 'online' ? 'status-online' : 'status-offline';
                    $statusText = $server['status'] === 'online' ? '在线' : '维护中';
                    $disabled = $server['status'] !== 'online' ? 'disabled' : '';
                ?>
                <div class="server-card" data-region="<?php echo $server['region']; ?>">
                    <div class="server-card-header">
                        <div class="server-name">
                            <i class="fas fa-server"></i>
                            <span><?php echo $server['name']; ?></span>
                        </div>
                        <div class="server-status <?php echo $statusClass; ?>"><?php echo $statusText; ?></div>
                    </div>
                    <div class="server-card-body">
                        <div class="server-info">
                            <div class="server-info-item">
                                <div class="server-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <div class="server-info-label">位置:</div>
                                <div class="server-info-value"><?php echo $server['location']; ?></div>
                            </div>
                            <div class="server-info-item">
                                <div class="server-info-icon"><i class="fas fa-tachometer-alt"></i></div>
                                <div class="server-info-label">延迟:</div>
                                <div class="server-info-value"><?php echo $server['latency']; ?></div>
                            </div>
                            <div class="server-info-item">
                                <div class="server-info-icon"><i class="fas fa-chart-line"></i></div>
                                <div class="server-info-label">负载:</div>
                                <div class="server-info-value"><?php echo $server['load']; ?></div>
                            </div>
                            <div class="server-info-item">
                                <div class="server-info-icon"><i class="fas fa-plug"></i></div>
                                <div class="server-info-label">协议:</div>
                                <div class="server-info-value"><?php echo $server['protocols']; ?></div>
                            </div>
                            <div class="server-info-item">
                                <div class="server-info-icon"><i class="fas fa-network-wired"></i></div>
                                <div class="server-info-label">线路:</div>
                                <div class="server-info-value"><?php echo $server['line']; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="server-card-footer">
                        <button class="connect-button <?php echo $disabled; ?>" <?php echo $disabled; ?>>
                            <i class="fas fa-plug"></i> <?php echo $server['status'] === 'online' ? '连接' : '不可用'; ?>
                        </button>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script>
        // 侧边栏交互
        const sidebar = document.getElementById('sidebar');
        const dashboard = document.querySelector('.dashboard');
        
        sidebar.addEventListener('mouseenter', function() {
            this.style.width = '250px';
            dashboard.style.marginLeft = '250px';
        });
        
        sidebar.addEventListener('mouseleave', function() {
            this.style.width = '80px';
            dashboard.style.marginLeft = '80px';
        });
        
        // 标签切换功能
        const tabs = document.querySelectorAll('.server-tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                const region = this.textContent.trim();
                filterServersByRegion(region);
            });
        });
        
        function filterServersByRegion(region) {
            const serverCards = document.querySelectorAll('.server-card');
            
            serverCards.forEach(card => {
                const serverRegion = card.getAttribute('data-region');
                
                const show = region === '全部服务器' || serverRegion === region;
                card.style.display = show ? 'block' : 'none';
            });
        }
    </script>
</body>
</html>
