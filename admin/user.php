<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户管理 - Admin Dashboard</title>
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
            --sidebar-collapsed-width: 80px;
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

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 15px;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .filter-btn {
            padding: 8px 15px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            color: var(--text-color);
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-btn:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .filter-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .filter-btn i {
            font-size: 12px;
        }

        .action-btn {
            padding: 8px 15px;
            border-radius: 8px;
            border: none;
            background-color: var(--primary-color);
            color: white;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-btn:hover {
            background-color: var(--primary-light);
        }

        .action-btn i {
            font-size: 12px;
        }

        .users-table-container {
            background-color: var(--card-bg);
            border-radius: 14px;
            padding: 25px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .users-table-container:hover {
            box-shadow: var(--shadow);
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .users-table th {
            text-align: left;
            padding: 12px 15px;
            color: var(--text-light);
            font-weight: 500;
            border-bottom: 1px solid var(--border-color);
        }

        .users-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .users-table tr:last-child td {
            border-bottom: none;
        }

        .users-table tr:hover td {
            background-color: rgba(79, 70, 229, 0.05);
        }

        .user-avatar-small {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
        }

        .user-avatar-small img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-name-cell {
            display: flex;
            flex-direction: column;
        }

        .user-name-main {
            font-weight: 500;
            margin-bottom: 2px;
        }

        .user-email {
            font-size: 12px;
            color: var(--text-light);
        }

        .user-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .status-inactive {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
        }

        .status-pending {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        .user-role {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background-color: rgba(59, 130, 246, 0.1);
            color: var(--accent-color);
        }

        .action-cell {
            display: flex;
            gap: 10px;
        }

        .table-action-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-light);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .table-action-btn:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .table-action-btn i {
            font-size: 12px;
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .pagination-info {
            font-size: 14px;
            color: var(--text-light);
        }

        .pagination-controls {
            display: flex;
            gap: 10px;
        }

        .page-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-light);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .page-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .page-btn:hover:not(.active) {
            background-color: rgba(79, 70, 229, 0.1);
        }

        .page-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .user-detail-card {
            background-color: var(--card-bg);
            border-radius: 14px;
            padding: 25px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .user-detail-card:hover {
            box-shadow: var(--shadow);
        }

        .user-detail-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .user-detail-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-color);
        }

        .user-detail-main {
            display: flex;
            gap: 25px;
        }

        .user-detail-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }

        .user-detail-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-detail-info {
            flex: 1;
        }

        .user-detail-name {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .user-detail-email {
            font-size: 16px;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .user-detail-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .user-detail-stats {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .user-stat-item {
            display: flex;
            flex-direction: column;
        }

        .user-stat-label {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 5px;
        }

        .user-stat-value {
            font-size: 18px;
            font-weight: 600;
        }

        .user-detail-tabs {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }

        .user-detail-tab {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-light);
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .user-detail-tab.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .user-detail-tab:hover:not(.active) {
            color: var(--text-color);
        }

        .user-detail-content {
            min-height: 200px;
        }

        /* 响应式设计 */
        @media (max-width: 1200px) {
            .user-detail-main {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .search-bar {
                width: 100%;
            }

            .toolbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-group {
                flex-wrap: wrap;
            }

            .users-table th, 
            .users-table td {
                padding: 8px 10px;
            }

            .action-cell {
                flex-direction: column;
                gap: 5px;
            }

            .pagination {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 20px 15px;
            }

            .user-detail-header {
                flex-direction: column;
                gap: 15px;
            }

            .user-detail-tabs {
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
    <!-- 嵌入侧边栏 -->
    <?php echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/admin/sidebar.html"); ?>

    <div class="main-content">
        <div class="header">
            <h1 class="header-title">用户管理</h1>
            <div class="header-actions">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="搜索用户...">
                </div>
                <div class="user-menu">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <div class="user-profile">
                        <div class="user-avatar">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="用户头像">
                        </div>
                        <div class="user-name">John Doe</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="toolbar">
            <div class="filter-group">
                <button class="filter-btn active">
                    <i class="fas fa-users"></i> 全部用户
                </button>
                <button class="filter-btn">
                    <i class="fas fa-user-check"></i> 活跃用户
                </button>
                <button class="filter-btn">
                    <i class="fas fa-user-clock"></i> 待审核
                </button>
                <button class="filter-btn">
                    <i class="fas fa-user-slash"></i> 已禁用
                </button>
                <button class="filter-btn">
                    <i class="fas fa-crown"></i> 管理员
                </button>
            </div>
            <button class="action-btn" id="addUserBtn">
                <i class="fas fa-plus"></i> 添加用户
            </button>
        </div>

        <div class="users-table-container">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>用户</th>
                        <th>注册时间</th>
                        <th>状态</th>
                        <th>角色</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar-small">
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="用户头像">
                                </div>
                                <div class="user-name-cell">
                                    <span class="user-name-main">Sarah Johnson</span>
                                    <span class="user-email">sarah@example.com</span>
                                </div>
                            </div>
                        </td>
                        <td>2023-05-12</td>
                        <td><span class="user-status status-active">活跃</span></td>
                        <td><span class="user-role">管理员</span></td>
                        <td>
                            <div class="action-cell">
                                <button class="table-action-btn" title="编辑">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="table-action-btn" title="禁用">
                                    <i class="fas fa-ban"></i>
                                </button>
                                <button class="table-action-btn" title="删除">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar-small">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="用户头像">
                                </div>
                                <div class="user-name-cell">
                                    <span class="user-name-main">Michael Brown</span>
                                    <span class="user-email">michael@example.com</span>
                                </div>
                            </div>
                        </td>
                        <td>2023-06-01</td>
                        <td><span class="user-status status-active">活跃</span></td>
                        <td><span class="user-role">编辑</span></td>
                        <td>
                            <div class="action-cell">
                                <button class="table-action-btn" title="编辑">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="table-action-btn" title="禁用">
                                    <i class="fas fa-ban"></i>
                                </button>
                                <button class="table-action-btn" title="删除">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar-small">
                                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="用户头像">
                                </div>
                                <div class="user-name-cell">
                                    <span class="user-name-main">Emily Davis</span>
                                    <span class="user-email">emily@example.com</span>
                                </div>
                            </div>
                        </td>
                        <td>2023-06-15</td>
                        <td><span class="user-status status-pending">待审核</span></td>
                        <td><span class="user-role">用户</span></td>
                        <td>
                            <div class="action-cell">
                                <button class="table-action-btn" title="编辑">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="table-action-btn" title="审核">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="table-action-btn" title="删除">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar-small">
                                    <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="用户头像">
                                </div>
                                <div class="user-name-cell">
                                    <span class="user-name-main">Robert Wilson</span>
                                    <span class="user-email">robert@example.com</span>
                                </div>
                            </div>
                        </td>
                        <td>2023-04-22</td>
                        <td><span class="user-status status-inactive">已禁用</span></td>
                        <td><span class="user-role">用户</span></td>
                        <td>
                            <div class="action-cell">
                                <button class="table-action-btn" title="编辑">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="table-action-btn" title="启用">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                                <button class="table-action-btn" title="删除">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar-small">
                                    <img src="https://randomuser.me/api/portraits/women/25.jpg" alt="用户头像">
                                </div>
                                <div class="user-name-cell">
                                    <span class="user-name-main">Jennifer Lee</span>
                                    <span class="user-email">jennifer@example.com</span>
                                </div>
                            </div>
                        </td>
                        <td>2023-06-10</td>
                        <td><span class="user-status status-active">活跃</span></td>
                        <td><span class="user-role">用户</span></td>
                        <td>
                            <div class="action-cell">
                                <button class="table-action-btn" title="编辑">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="table-action-btn" title="禁用">
                                    <i class="fas fa-ban"></i>
                                </button>
                                <button class="table-action-btn" title="删除">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="pagination">
                <div class="pagination-info">
                    显示 1-5 条，共 124 条
                </div>
                <div class="pagination-controls">
                    <button class="page-btn disabled">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <button class="page-btn">4</button>
                    <button class="page-btn">5</button>
                    <button class="page-btn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="user-detail-card">
            <div class="user-detail-header">
                <h2 class="user-detail-title">用户详情</h2>
                <div>
                    <button class="action-btn">
                        <i class="fas fa-edit"></i> 编辑
                    </button>
                </div>
            </div>

            <div class="user-detail-main">
                <div class="user-detail-avatar">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="用户头像">
                </div>
                <div class="user-detail-info">
                    <h3 class="user-detail-name">Sarah Johnson</h3>
                    <div class="user-detail-email">sarah@example.com</div>
                    <div>
                        <span class="user-detail-badge status-active">活跃</span>
                        <span class="user-detail-badge user-role">管理员</span>
                    </div>
                    <div class="user-detail-stats">
                        <div class="user-stat-item">
                            <span class="user-stat-label">注册时间</span>
                            <span class="user-stat-value">2023-05-12</span>
                        </div>
                        <div class="user-stat-item">
                            <span class="user-stat-label">最后登录</span>
                            <span class="user-stat-value">2023-06-18 14:30</span>
                        </div>
                        <div class="user-stat-item">
                            <span class="user-stat-label">订单数</span>
                            <span class="user-stat-value">24</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="user-detail-tabs">
                <div class="user-detail-tab active">基本信息</div>
                <div class="user-detail-tab">订单记录</div>
                <div class="user-detail-tab">活动日志</div>
                <div class="user-detail-tab">权限设置</div>
            </div>

            <div class="user-detail-content">
                <!-- 这里放置用户详情内容 -->
                <p>用户详情内容将在后续版本中实现</p>
            </div>
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

            // 添加用户按钮点击事件
            const addUserBtn = document.getElementById('addUserBtn');
            addUserBtn.addEventListener('click', function() {
                alert('添加用户功能将在后续版本中实现');
            });

            // 筛选按钮点击事件
            const filterBtns = document.querySelectorAll('.filter-btn');
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    alert('筛选功能将在后续版本中实现');
                });
            });

            // 表格操作按钮点击事件
            const tableActionBtns = document.querySelectorAll('.table-action-btn');
            tableActionBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const icon = this.querySelector('i').className;
                    if (icon.includes('edit')) {
                        alert('编辑用户功能将在后续版本中实现');
                    } else if (icon.includes('ban')) {
                        alert('禁用用户功能将在后续版本中实现');
                    } else if (icon.includes('check')) {
                        alert('审核用户功能将在后续版本中实现');
                    } else if (icon.includes('check-circle')) {
                        alert('启用用户功能将在后续版本中实现');
                    } else if (icon.includes('trash')) {
                        if (confirm('确定要删除此用户吗？')) {
                            alert('删除用户功能将在后续版本中实现');
                        }
                    }
                });
            });

            // 分页按钮点击事件
            const pageBtns = document.querySelectorAll('.page-btn:not(.disabled)');
            pageBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    if (!this.classList.contains('active')) {
                        document.querySelector('.page-btn.active').classList.remove('active');
                        this.classList.add('active');
                        alert('分页功能将在后续版本中实现');
                    }
                });
            });

            // 用户详情标签页点击事件
            const userDetailTabs = document.querySelectorAll('.user-detail-tab');
            userDetailTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    userDetailTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    alert('标签页切换功能将在后续版本中实现');
                });
            });
        });
    </script>
</body>
</html>