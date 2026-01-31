<?php
/**
 * 管理员后台仪表盘主界面
 */
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员仪表盘 | VPN管理系统</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        <?php include dirname(__dir__,2)."/src/css/admin1.css"; ?>
  </style>
</head>
<body>
    <?php include dirname(__dir__,2)."/src/component/adsidebar.php"; ?>
    
    <div class="admin-main">
        <header class="admin-header">
            <div class="header-left">
                <button class="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1><i class="fas fa-tachometer-alt"></i> 控制面板</h1>
            </div>
            <div class="header-right">
                <div class="notifications">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </button>
                    <div class="notification-dropdown">
                        <div class="notification-header">
                            <h3>通知中心</h3>
                            <a href="#" class="mark-all-read">全部标记为已读</a>
                        </div>
                        <div class="notification-list">
                            <a href="#" class="notification-item unread">
                                <div class="notification-icon">
                                    <i class="fas fa-exclamation-circle text-danger"></i>
                                </div>
                                <div class="notification-content">
                                    <p>服务器节点HK-01负载过高</p>
                                    <span>2分钟前</span>
                                </div>
                            </a>
                            <a href="#" class="notification-item unread">
                                <div class="notification-icon">
                                    <i class="fas fa-ticket-alt text-warning"></i>
                                </div>
                                <div class="notification-content">
                                    <p>新工单 #2456: 连接问题</p>
                                    <span>15分钟前</span>
                                </div>
                            </a>
                            <a href="#" class="notification-item">
                                <div class="notification-icon">
                                    <i class="fas fa-user-plus text-success"></i>
                                </div>
                                <div class="notification-content">
                                    <p>5个新用户注册</p>
                                    <span>1小时前</span>
                                </div>
                            </a>
                        </div>
                        <div class="notification-footer">
                            <a href="notifications.php">查看所有通知</a>
                        </div>
                    </div>
                </div>
                <div class="admin-tools">
                    <button class="fullscreen-btn">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="theme-toggle">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>
            </div>
        </header>
        
        <div class="admin-content">
            <div class="stats-cards">
                <div class="stats-card">
                    <div class="stats-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-info">
                        <h3>总用户数</h3>
                        <p>1,245</p>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> 5.2%
                        </span>
                    </div>
                </div>
                <div class="stats-card">
                    <div class="stats-icon bg-success">
                        <i class="fas fa-server"></i>
                    </div>
                    <div class="stats-info">
                        <h3>在线服务器</h3>
                        <p>12/15</p>
                        <span class="stats-change down">
                            <i class="fas fa-arrow-down"></i> 2.1%
                        </span>
                    </div>
                </div>
                <div class="stats-card">
                    <div class="stats-icon bg-warning">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stats-info">
                        <h3>今日流量</h3>
                        <p>1.2 TB</p>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> 15.7%
                        </span>
                    </div>
                </div>
                <div class="stats-card">
                    <div class="stats-icon bg-danger">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stats-info">
                        <h3>今日收入</h3>
                        <p>$2,458</p>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> 8.3%
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-row">
                <div class="dashboard-col">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h2><i class="fas fa-chart-bar"></i> 流量统计</h2>
                            <div class="card-actions">
                                <select class="time-select">
                                    <option>今日</option>
                                    <option>本周</option>
                                    <option selected>本月</option>
                                    <option>今年</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="trafficChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dashboard-col">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h2><i class="fas fa-globe"></i> 节点分布</h2>
                            <div class="card-actions">
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-sync-alt"></i> 刷新
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="map-container">
                                <div class="world-map">
                                    <div class="node-marker" style="top: 30%; left: 15%;" data-node="US-01">
                                        <div class="marker-dot bg-success"></div>
                                        <div class="marker-info">
                                            <h4>US-01</h4>
                                            <p>在线</p>
                                        </div>
                                    </div>
                                    <div class="node-marker" style="top: 35%; left: 50%;" data-node="EU-01">
                                        <div class="marker-dot bg-success"></div>
                                        <div class="marker-info">
                                            <h4>EU-01</h4>
                                            <p>在线</p>
                                        </div>
                                    </div>
                                    <div class="node-marker" style="top: 25%; left: 75%;" data-node="HK-01">
                                        <div class="marker-dot bg-danger"></div>
                                        <div class="marker-info">
                                            <h4>HK-01</h4>
                                            <p>高负载</p>
                                        </div>
                                    </div>
                                    <div class="node-marker" style="top: 60%; left: 80%;" data-node="JP-01">
                                        <div class="marker-dot bg-success"></div>
                                        <div class="marker-info">
                                            <h4>JP-01</h4>
                                            <p>在线</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-row">
                <div class="dashboard-col">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h2><i class="fas fa-user-plus"></i> 最近注册用户</h2>
                            <div class="card-actions">
                                <a href="users.php" class="btn btn-sm btn-outline">
                                    查看全部 <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>用户名</th>
                                            <th>注册时间</th>
                                            <th>订阅计划</th>
                                            <th>状态</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="user-cell">
                                                    <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="User">
                                                    <span>john_doe</span>
                                                </div>
                                            </td>
                                            <td>2023-11-15 14:32</td>
                                            <td><span class="badge bg-primary">高级版</span></td>
                                            <td><span class="badge bg-success">活跃</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline">
                                                    <i class="fas fa-eye"></i> 查看
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="user-cell">
                                                    <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="User">
                                                    <span>jane_smith</span>
                                                </div>
                                            </td>
                                            <td>2023-11-15 12:45</td>
                                            <td><span class="badge bg-secondary">免费版</span></td>
                                            <td><span class="badge bg-warning">未激活</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline">
                                                    <i class="fas fa-eye"></i> 查看
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="user-cell">
                                                    <img src="https://randomuser.me/api/portraits/men/3.jpg" alt="User">
                                                    <span>mike_johnson</span>
                                                </div>
                                            </td>
                                            <td>2023-11-15 10:21</td>
                                            <td><span class="badge bg-primary">高级版</span></td>
                                            <td><span class="badge bg-success">活跃</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline">
                                                    <i class="fas fa-eye"></i> 查看
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="user-cell">
                                                    <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="User">
                                                    <span>sarah_williams</span>
                                                </div>
                                            </td>
                                            <td>2023-11-14 18:05</td>
                                            <td><span class="badge bg-danger">企业版</span></td>
                                            <td><span class="badge bg-success">活跃</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline">
                                                    <i class="fas fa-eye"></i> 查看
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="user-cell">
                                                    <img src="https://randomuser.me/api/portraits/men/5.jpg" alt="User">
                                                    <span>david_brown</span>
                                                </div>
                                            </td>
                                            <td>2023-11-14 16:32</td>
                                            <td><span class="badge bg-secondary">免费版</span></td>
                                            <td><span class="badge bg-success">活跃</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline">
                                                    <i class="fas fa-eye"></i> 查看
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dashboard-col">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h2><i class="fas fa-ticket-alt"></i> 最新工单</h2>
                            <div class="card-actions">
                                <a href="tickets.php" class="btn btn-sm btn-outline">
                                    查看全部 <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="ticket-list">
                                <div class="ticket-item">
                                    <div class="ticket-priority high"></div>
                                    <div class="ticket-content">
                                        <h4>无法连接到服务器</h4>
                                        <p>用户报告无法连接到HK节点...</p>
                                        <div class="ticket-meta">
                                            <span class="ticket-user">
                                                <img src="https://randomuser.me/api/portraits/men/6.jpg" alt="User">
                                                Robert Johnson
                                            </span>
                                            <span class="ticket-time">15分钟前</span>
                                        </div>
                                    </div>
                                    <div class="ticket-status">
                                        <span class="badge bg-warning">处理中</span>
                                    </div>
                                </div>
                                <div class="ticket-item">
                                    <div class="ticket-priority medium"></div>
                                    <div class="ticket-content">
                                        <h4>订阅续费问题</h4>
                                        <p>支付成功但订阅未自动续期...</p>
                                        <div class="ticket-meta">
                                            <span class="ticket-user">
                                                <img src="https://randomuser.me/api/portraits/women/7.jpg" alt="User">
                                                Emily Davis
                                            </span>
                                            <span class="ticket-time">1小时前</span>
                                        </div>
                                    </div>
                                    <div class="ticket-status">
                                        <span class="badge bg-primary">待回复</span>
                                    </div>
                                </div>
                                <div class="ticket-item">
                                    <div class="ticket-priority low"></div>
                                    <div class="ticket-content">
                                        <h4>速度慢的问题</h4>
                                        <p>JP节点速度比平时慢很多...</p>
                                        <div class="ticket-meta">
                                            <span class="ticket-user">
                                                <img src="https://randomuser.me/api/portraits/men/8.jpg" alt="User">
                                                Michael Wilson
                                            </span>
                                            <span class="ticket-time">2小时前</span>
                                        </div>
                                    </div>
                                    <div class="ticket-status">
                                        <span class="badge bg-success">已解决</span>
                                    </div>
                                </div>
                                <div class="ticket-item">
                                    <div class="ticket-priority high"></div>
                                    <div class="ticket-content">
                                        <h4>账户安全问题</h4>
                                        <p>账户可能被他人登录...</p>
                                        <div class="ticket-meta">
                                            <span class="ticket-user">
                                                <img src="https://randomuser.me/api/portraits/women/9.jpg" alt="User">
                                                Sarah Miller
                                            </span>
                                            <span class="ticket-time">3小时前</span>
                                        </div>
                                    </div>
                                    <div class="ticket-status">
                                        <span class="badge bg-danger">紧急</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // 侧边栏折叠功能
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.admin-main').classList.toggle('sidebar-collapsed');
        });
        
        // 主题切换
        document.querySelector('.theme-toggle').addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            const icon = this.querySelector('i');
            if (document.body.classList.contains('dark-mode')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        });
        
        // 流量统计图表
        const trafficCtx = document.getElementById('trafficChart').getContext('2d');
        const trafficChart = new Chart(trafficCtx, {
            type: 'line',
            data: {
                labels: ['1日', '5日', '10日', '15日', '20日', '25日', '30日'],
                datasets: [
                    {
                        label: '入站流量 (GB)',
                        data: [120, 190, 170, 220, 240, 280, 320],
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: '出站流量 (GB)',
                        data: [80, 120, 140, 180, 200, 240, 280],
                        borderColor: '#1cc88a',
                        backgroundColor: 'rgba(28, 200, 138, 0.05)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>