<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-light: #6366f1;
            --secondary-color: #10b981;
            --accent-color: #3b82f6;
            --text-color: #374151;
            --text-light: #6b7280;
            --bg-color: #f9fafb;
            --card-bg: #ffffff;
            --border-color: #e5e7eb;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --error-color: #ef4444;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --sidebar-width: 13.5vw; /* 匹配侧边栏的15%宽度 */
            --sidebar-collapsed-width: 280px;
        }

        /* 仅修改主内容区域部分 */
        .main-content {
            margin-left: var(--sidebar-width); /* 使用与侧边栏相同的宽度变量 */
            padding: 30px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body.sidebar-collapsed .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* 响应式调整 - 仅修改主内容区域部分 */
        @media (max-width: 1200px) {
            :root {
                --sidebar-width: 240px; /* 匹配侧边栏的响应式宽度 */
            }
        }

        @media (max-width: 992px) {
            :root {
                --sidebar-width: 200px; /* 匹配侧边栏的响应式宽度 */
            }
        }

        @media (max-width: 768px) {
            :root {
                --sidebar-width: 180px; /* 匹配侧边栏的响应式宽度 */
            }
            
            /* 在小屏幕上主内容区域占满全宽 */
            body:not(.sidebar-collapsed) .main-content {
                margin-left: 0;
            }
        }

        @media (max-width: 576px) {
            :root {
                --sidebar-width: 160px; /* 匹配侧边栏的响应式宽度 */
            }
            
            .main-content {
                padding: 20px 15px;
            }
        }

        /* 以下是原有未修改的CSS代码 */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            line-height: 1.5;
            overflow-x: hidden;
            font-size: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .header-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-color);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-bar {
            position: relative;
            width: 300px;
        }

        .search-bar input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .search-bar input:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .search-bar i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .notification-btn {
            position: relative;
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .notification-btn:hover {
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background-color: var(--error-color);
            color: white;
            font-size: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-name {
            font-weight: 500;
            font-size: 15px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: var(--card-bg);
            border-radius: 14px;
            padding: 25px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background-color: var(--primary-color);
        }

        .stat-card.blue::before {
            background-color: var(--accent-color);
        }

        .stat-card.green::before {
            background-color: var(--secondary-color);
        }

        .stat-card.purple::before {
            background-color: var(--primary-color);
        }

        .stat-card.orange::before {
            background-color: var(--warning-color);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .stat-icon.blue {
            background-color: var(--accent-color);
        }

        .stat-icon.green {
            background-color: var(--secondary-color);
        }

        .stat-icon.purple {
            background-color: var(--primary-color);
        }

        .stat-icon.orange {
            background-color: var(--warning-color);
        }

        .stat-title {
            font-size: 14px;
            color: var(--text-light);
            font-weight: 500;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            margin: 10px 0;
            color: var(--text-color);
        }

        .stat-change {
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .stat-change.positive {
            color: var(--success-color);
        }

        .stat-change.negative {
            color: var(--error-color);
        }

        .stat-change i {
            margin-right: 5px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        @media (max-width: 1200px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        .chart-card {
            background-color: var(--card-bg);
            border-radius: 14px;
            padding: 25px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .chart-card:hover {
            box-shadow: var(--shadow);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-color);
        }

        .card-actions {
            display: flex;
            gap: 10px;
        }

        .card-btn {
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 5px;
            border-radius: 5px;
        }

        .card-btn:hover {
            color: var(--primary-color);
            background-color: rgba(79, 70, 229, 0.1);
        }

        .chart-container {
            height: 300px;
            width: 100%;
            position: relative;
        }

        .recent-orders {
            background-color: var(--card-bg);
            border-radius: 14px;
            padding: 25px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .recent-orders:hover {
            box-shadow: var(--shadow);
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .orders-table th {
            text-align: left;
            padding: 12px 15px;
            color: var(--text-light);
            font-weight: 500;
            border-bottom: 1px solid var(--border-color);
        }

        .orders-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .orders-table tr:last-child td {
            border-bottom: none;
        }

        .order-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        .status-completed {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .status-cancelled {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
        }

        .view-all {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--primary-color);
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .view-all:hover {
            color: var(--primary-light);
        }

        .activity-feed {
            background-color: var(--card-bg);
            border-radius: 14px;
            padding: 25px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .activity-feed:hover {
            box-shadow: var(--shadow);
        }

        .activity-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
            flex-shrink: 0;
        }

        .activity-icon.blue {
            background-color: var(--accent-color);
        }

        .activity-icon.green {
            background-color: var(--secondary-color);
        }

        .activity-icon.purple {
            background-color: var(--primary-color);
        }

        .activity-icon.orange {
            background-color: var(--warning-color);
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            margin-bottom: 5px;
            color: var(--text-color);
        }

        .activity-description {
            font-size: 13px;
            color: var(--text-light);
            margin-bottom: 5px;
        }

        .activity-time {
            font-size: 12px;
            color: var(--text-light);
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: var(--card-bg);
            border-radius: 14px;
            padding: 25px 15px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: var(--text-color);
        }

        .action-btn:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
            background-color: var(--primary-color);
            color: white;
        }

        .action-btn:hover .action-icon {
            background-color: white;
            color: var(--primary-color);
        }

        .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 15px;
            background-color: var(--primary-color);
            color: white;
            transition: all 0.3s ease;
        }

        .action-title {
            font-weight: 500;
            text-align: center;
        }


        @media (max-width: 1200px) {
             { --sidebar: 240px; }
        }
        /* 响应式设计 */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .search-bar {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
            
            /* 在小屏幕上，侧边栏可能被隐藏或折叠，主内容区域应占满全宽 */
            body:not(.sidebar-collapsed) .main-content {
                margin-left: 0;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 20px 15px;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- 嵌入侧边栏 -->
    <?php echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/admin/sidebar.html"); ?>

    <div class="main-content">
        <div class="header">
            <h1 class="header-title">控制面板</h1>
            <div class="header-actions">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="搜索...">
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card green">
                <div class="stat-header">
                    <div class="stat-title">总销售额</div>
                    <div class="stat-icon green">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
                <div class="stat-value">$24,780</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 12.5% 较上月
                </div>
            </div>
            <div class="stat-card blue">
                <div class="stat-header">
                    <div class="stat-title">总订单数</div>
                    <div class="stat-icon blue">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
                <div class="stat-value">1,245</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 8.3% 较上月
                </div>
            </div>
            <div class="stat-card purple">
                <div class="stat-header">
                    <div class="stat-title">总用户数</div>
                    <div class="stat-icon purple">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-value">8,752</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 5.2% 较上月
                </div>
            </div>
            <div class="stat-card orange">
                <div class="stat-header">
                    <div class="stat-title">转化率</div>
                    <div class="stat-icon orange">
                        <i class="fas fa-percentage"></i>
                    </div>
                </div>
                <div class="stat-value">3.42%</div>
                <div class="stat-change negative">
                    <i class="fas fa-arrow-down"></i> 1.1% 较上月
                </div>
            </div>
        </div>

        <div class="content-grid">
            <div class="chart-card">
                <div class="card-header">
                    <h2 class="card-title">销售趋势</h2>
                    <div class="card-actions">
                        <button class="card-btn">
                            <i class="fas fa-calendar-alt"></i>
                        </button>
                        <button class="card-btn">
                            <i class="fas fa-download"></i>
                        </button>
                        <button class="card-btn">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>
                </div>
                <div class="chart-container">
                    <!-- 这里放置图表 -->
                    <img src="https://via.placeholder.com/800x300?text=Sales+Chart" alt="销售图表" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                </div>
            </div>
            <div class="activity-feed">
                <div class="card-header">
                    <h2 class="card-title">最近活动</h2>
                    <div class="card-actions">
                        <button class="card-btn">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon blue">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">新用户注册</div>
                            <div class="activity-description">John Smith 注册了新账户</div>
                            <div class="activity-time">10分钟前</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon green">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">新订单</div>
                            <div class="activity-description">订单 #1254 已创建</div>
                            <div class="activity-time">25分钟前</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon purple">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">产品更新</div>
                            <div class="activity-description">产品 "Premium Widget" 已更新</div>
                            <div class="activity-time">1小时前</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon orange">
                            <i class="fas fa-comment-alt"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">新评论</div>
                            <div class="activity-description">Sarah Johnson 在产品上留下了评论</div>
                            <div class="activity-time">2小时前</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="quick-actions">
            <a href="#" class="action-btn">
                <div class="action-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <div class="action-title">添加产品</div>
            </a>
            <a href="#" class="action-btn">
                <div class="action-icon">
                    <i class="fas fa-user-cog"></i>
                </div>
                <div class="action-title">用户管理</div>
            </a>
            <a href="#" class="action-btn">
                <div class="action-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="action-title">查看报告</div>
            </a>
            <a href="#" class="action-btn">
                <div class="action-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="action-title">系统设置</div>
            </a>
        </div>

        <div class="recent-orders">
            <div class="card-header">
                <h2 class="card-title">最近订单</h2>
                <div class="card-actions">
                    <button class="card-btn">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>
            </div>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>订单ID</th>
                        <th>客户</th>
                        <th>日期</th>
                        <th>金额</th>
                        <th>状态</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#1254</td>
                        <td>John Smith</td>
                        <td>2023-06-15</td>
                        <td>$245.00</td>
                        <td><span class="order-status status-completed">已完成</span></td>
                    </tr>
                    <tr>
                        <td>#1253</td>
                        <td>Sarah Johnson</td>
                        <td>2023-06-14</td>
                        <td>$189.50</td>
                        <td><span class="order-status status-pending">处理中</span></td>
                    </tr>
                    <tr>
                        <td>#1252</td>
                        <td>Michael Brown</td>
                        <td>2023-06-13</td>
                        <td>$320.75</td>
                        <td><span class="order-status status-completed">已完成</span></td>
                    </tr>
                    <tr>
                        <td>#1251</td>
                        <td>Emily Davis</td>
                        <td>2023-06-12</td>
                        <td>$275.00</td>
                        <td><span class="order-status status-cancelled">已取消</span></td>
                    </tr>
                    <tr>
                        <td>#1250</td>
                        <td>Robert Wilson</td>
                        <td>2023-06-11</td>
                        <td>$420.25</td>
                        <td><span class="order-status status-completed">已完成</span></td>
                    </tr>
                </tbody>
            </table>
            <a href="#" class="view-all">查看全部订单 →</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 监听侧边栏iframe的消息
            window.addEventListener('message', function(e) {
                if (e.data === 'toggleSidebar') {
                    document.body.classList.toggle('sidebar-collapsed');
                }
            });

            // 通知按钮点击事件
            const notificationBtn = document.querySelector('.notification-btn');
            notificationBtn.addEventListener('click', function() {
                alert('通知功能将在后续版本中实现');
            });

            // 用户菜单点击事件
            const userProfile = document.querySelector('.user-profile');
            userProfile.addEventListener('click', function() {
                alert('用户菜单将在后续版本中实现');
            });

            // 快速操作按钮点击事件
            const actionBtns = document.querySelectorAll('.action-btn');
            actionBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const action = this.querySelector('.action-title').textContent;
                    alert(`即将跳转到: ${action}`);
                });
            });

            // 查看全部订单点击事件
            const viewAllOrders = document.querySelector('.view-all');
            viewAllOrders.addEventListener('click', function(e) {
                e.preventDefault();
                alert('即将跳转到订单管理页面');
            });

            // 卡片操作按钮点击事件
            const cardBtns = document.querySelectorAll('.card-btn');
            cardBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const icon = this.querySelector('i').className;
                    if (icon.includes('ellipsis-h')) {
                        alert('更多选项将在后续版本中实现');
                    } else if (icon.includes('download')) {
                        alert('下载功能将在后续版本中实现');
                    } else if (icon.includes('calendar-alt')) {
                        alert('日期选择器将在后续版本中实现');
                    }
                });
            });
        });
    </script>
</body>
</html>