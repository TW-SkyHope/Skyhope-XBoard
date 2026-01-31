<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VPN套餐管理 - 后台管理系统</title>
    <!-- 使用Google Fonts加载Inter字体 -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome图标库 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* 基础样式和变量定义 */
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
        }

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
            font-size: 16px;
            transition: all 0.3s ease;
        }

        /* 侧边栏状态 */
        body.sidebar-collapsed {
            padding-left: 160px; /* 最小宽度，移动设备上的最小侧边栏宽度 */
        }
        body:not(.sidebar-collapsed) {
            padding-left: var(--sidebar); /* 使用侧边栏CSS变量定义的宽度 */
        }

        /* 主内容区域 */
        .main-content {
            padding: 30px;
            transition: all 0.3s ease;
        }

        /* 顶部导航栏 */
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
        }
        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* 搜索框 */
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

        /* 用户菜单 */
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

        /* VPN套餐管理区域 */
        .vpn-plans-section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text-color);
        }
        
        /* 套餐卡片网格 */
        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        /* 套餐卡片样式 */
        .plan-card {
            background-color: var(--card-bg);
            border-radius: 14px;
            padding: 25px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .plan-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
        }
        .plan-card.popular {
            border: 2px solid var(--secondary-color);
        }
        .plan-card.featured {
            border: 2px solid var(--primary-color);
        }
        
        .plan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .plan-name {
            font-size: 18px;
            font-weight: 600;
        }
        .plan-price {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
        }
        .plan-price span {
            font-size: 14px;
            font-weight: 400;
        }
        
        .plan-features {
            margin-bottom: 20px;
        }
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .feature-icon {
            width: 20px;
            height: 20px;
            background-color: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 12px;
        }
        .feature-text {
            font-size: 14px;
            color: var(--text-light);
        }
        
        .plan-actions {
            display: flex;
            gap: 10px;
        }
        .plan-btn {
            flex: 1;
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            border: none;
        }
        .plan-btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        .plan-btn-primary:hover {
            background-color: var(--primary-light);
        }
        .plan-btn-secondary {
            background-color: var(--bg-color);
            color: var(--primary-color);
            border: 1px solid var(--border-color);
        }
        .plan-btn-secondary:hover {
            background-color: rgba(79, 70, 229, 0.05);
        }

        /* 订阅用户统计 - 已移除 */

        /* 最近交易 - 新样式 */
        .recent-transactions {
            margin-bottom: 30px;
        }
        .transactions-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .transactions-title {
            font-size: 22px;
            font-weight: 600;
        }
        .transactions-pagination {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .page-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .page-btn:hover {
            background-color: rgba(79, 70, 229, 0.05);
        }
        .page-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        .page-info {
            font-size: 14px;
            color: var(--text-light);
        }

        .transactions-card {
            background-color: var(--card-bg);
            border-radius: 14px;
            padding: 20px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
        }
        .transaction-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
        }
        .transaction-item:last-child {
            border-bottom: none;
        }
        .transaction-info {
            flex: 1;
        }
        .transaction-id {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 5px;
        }
        .transaction-details {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .transaction-user {
            font-weight: 500;
        }
        .transaction-plan {
            font-size: 14px;
            color: var(--text-light);
        }
        .transaction-amount {
            font-weight: 600;
            color: var(--primary-color);
        }
        .transaction-date {
            font-size: 14px;
            color: var(--text-light);
        }
        .transaction-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        .status-completed {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }
        .status-pending {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }
        .status-failed {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
        }

        /* 快速操作按钮 */
        .quick-action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        .quick-action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .quick-action-btn.primary {
            background-color: var(--primary-color);
        }
        .quick-action-btn.primary:hover {
            background-color: var(--primary-light);
        }
        .quick-action-btn.success {
            background-color: var(--secondary-color);
        }
        .quick-action-btn.success:hover {
            background-color: rgba(16, 185, 129, 0.9);
        }
        .quick-action-btn.warning {
            background-color: var(--warning-color);
        }
        .quick-action-btn.warning:hover {
            background-color: rgba(245, 158, 11, 0.9);
        }
        .quick-action-btn.danger {
            background-color: var(--error-color);
        }
        .quick-action-btn.danger:hover {
            background-color: rgba(239, 68, 68, 0.9);
        }
        .quick-action-btn i {
            margin-right: 8px;
        }

        /* 添加新套餐按钮 - 改进样式 */
        .add-plan-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .add-plan-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }
        .add-plan-btn:hover {
            background-color: var(--primary-light);
            box-shadow: var(--shadow);
        }
        .add-plan-btn i {
            margin-right: 8px;
        }

        /* 响应式设计 */
        @media (max-width: 1200px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .search-bar {
                width: 100%;
            }
            .plans-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 20px 15px;
            }
            .plans-grid {
                grid-template-columns: 1fr;
            }
            .quick-action-buttons {
                grid-template-columns: repeat(2, 1fr);
            }
            .transactions-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            .transactions-pagination {
                width: 100%;
                justify-content: space-between;
            }
        }

        @media (max-width: 576px) {
            .quick-action-buttons {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- 侧边栏通过PHP引入 -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/admin/sidebar.html"; ?>

    <div class="main-content">
        <div class="header">
            <h1 class="header-title">VPN套餐管理</h1>
            <div class="header-actions">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="搜索套餐...">
                </div>
                <div class="user-menu">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <div class="user-profile">
                        <div class="user-avatar">
                            <img src="/images/admin-avatar.jpg" alt="管理员头像">
                        </div>
                        <div class="user-name">管理员</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- VPN套餐管理区域 -->
        <div class="vpn-plans-section">
            <h2 class="section-title">VPN套餐列表</h2>
            
            <!-- 改进后的添加新套餐按钮 -->
            <div class="add-plan-btn-container">
                <button class="add-plan-btn">
                    <i class="fas fa-plus"></i> 添加新套餐
                </button>
            </div>
            
            <div class="plans-grid">
                <!-- 基础套餐 -->
                <div class="plan-card">
                    <div class="plan-header">
                        <div class="plan-name">基础套餐</div>
                        <div class="plan-price">$4.99 <span>/月</span></div>
                    </div>
                    <div class="plan-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="feature-text">1设备同时连接</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="feature-text">基础加密</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="feature-text">5个地点</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="feature-text">无专用IP</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="feature-text">无P2P支持</div>
                        </div>
                    </div>
                    <div class="plan-actions">
                        <button class="plan-btn plan-btn-primary">编辑</button>
                        <button class="plan-btn plan-btn-secondary">删除</button>
                    </div>
                </div>
                
                <!-- 高级套餐 -->
                <div class="plan-card popular">
                    <div class="plan-header">
                        <div class="plan-name">高级套餐</div>
                        <div class="plan-price">$9.99 <span>/月</span></div>
                    </div>
                    <div class="plan-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="feature-text">5设备同时连接</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="feature-text">高级加密</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="feature-text">20个地点</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="feature-text">专用IP(可选)</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="feature-text">无P2P支持</div>
                        </div>
                    </div>
                    <div class="plan-actions">
                        <button class="plan-btn plan-btn-primary">编辑</button>
                        <button class="plan-btn plan-btn-secondary">删除</button>
                    </div>
                </div>
                
                <!-- 专业套餐 -->
                <div class="plan-card featured">
                    <div class="plan-header">
                        <div class="plan-name">专业套餐</div>
                        <div class="plan-price">$19.99 <span>/月</span></div>
                    </div>
                    <div class="plan-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="feature-text">无限设备连接</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="feature-text">军事级加密</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="feature-text">50个地点</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="feature-text">专用IP</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="feature-text">P2P支持</div>
                        </div>
                    </div>
                    <div class="plan-actions">
                        <button class="plan-btn plan-btn-primary">编辑</button>
                        <button class="plan-btn plan-btn-secondary">删除</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 最近交易 - 新样式 -->
        <div class="recent-transactions">
            <div class="transactions-header">
                <h2 class="transactions-title">最近交易</h2>
                <div class="transactions-pagination">
                    <button class="page-btn" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <button class="page-btn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            
            <div class="transactions-card">
                <div class="transaction-item">
                    <div class="transaction-info">
                        <div class="transaction-id">#TXN12345</div>
                        <div class="transaction-details">
                            <div class="transaction-user">张三</div>
                            <div class="transaction-plan">高级套餐</div>
                        </div>
                    </div>
                    <div class="transaction-amount">$9.99</div>
                </div>
                <div class="transaction-item">
                    <div class="transaction-info">
                        <div class="transaction-id">#TXN12344</div>
                        <div class="transaction-details">
                            <div class="transaction-user">李四</div>
                            <div class="transaction-plan">基础套餐</div>
                        </div>
                    </div>
                    <div class="transaction-amount">$4.99</div>
                </div>
                <div class="transaction-item">
                    <div class="transaction-info">
                        <div class="transaction-id">#TXN12343</div>
                        <div class="transaction-details">
                            <div class="transaction-user">王五</div>
                            <div class="transaction-plan">专业套餐</div>
                        </div>
                    </div>
                    <div class="transaction-amount">$19.99</div>
                </div>
                <div class="transaction-item">
                    <div class="transaction-info">
                        <div class="transaction-id">#TXN12342</div>
                        <div class="transaction-details">
                            <div class="transaction-user">赵六</div>
                            <div class="transaction-plan">高级套餐</div>
                        </div>
                    </div>
                    <div class="transaction-amount">$9.99</div>
                </div>
                <div class="transaction-item">
                    <div class="transaction-info">
                        <div class="transaction-id">#TXN12341</div>
                        <div class="transaction-details">
                            <div class="transaction-user">钱七</div>
                            <div class="transaction-plan">基础套餐</div>
                        </div>
                    </div>
                    <div class="transaction-amount">$4.99</div>
                </div>
            </div>
            
            <!-- 交易状态标签 - 替代原来的表格状态列 -->
            <div style="margin-top: 15px; display: flex; gap: 10px;">
                <span class="transaction-status status-completed">已完成: 3</span>
                <span class="transaction-status status-pending">处理中: 1</span>
                <span class="transaction-status status-failed">失败: 0</span>
            </div>
        </div>

        <!-- 快速操作按钮 -->
        <div class="quick-action-buttons">
            <button class="quick-action-btn primary">
                <i class="fas fa-sync-alt"></i> 同步订阅状态
            </button>
            <button class="quick-action-btn success">
                <i class="fas fa-file-export"></i> 导出账单
            </button>
            <button class="quick-action-btn warning">
                <i class="fas fa-users-cog"></i> 用户管理
            </button>
            <button class="quick-action-btn danger">
                <i class="fas fa-user-minus"></i> 取消订阅
            </button>
        </div>
    </div>

    <script>
        // 页面加载完成后执行
        document.addEventListener('DOMContentLoaded', function() {
            // 侧边栏切换功能
            window.addEventListener('message', function(e) {
                if (e.data === 'toggleSidebar') {
                    document.body.classList.toggle('sidebar-collapsed');
                }
            });

            // 通知按钮点击事件
            document.querySelector('.notification-btn').addEventListener('click', function() {
                console.log('通知按钮被点击');
                alert('您有3条未读通知');
            });

            // 用户菜单点击事件
            document.querySelector('.user-profile').addEventListener('click', function() {
                console.log('用户菜单被点击');
                // 这里可以添加用户菜单的下拉功能
            });

            // 添加新套餐按钮
            document.querySelector('.add-plan-btn').addEventListener('click', function() {
                console.log('添加新套餐按钮被点击');
                // 这里可以打开添加套餐的模态框
                alert('打开添加VPN套餐表单');
            });

            // 套餐操作按钮
            document.querySelectorAll('.plan-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const text = this.textContent.trim();
                    console.log('套餐操作按钮被点击:', text);
                    
                    if (text === '编辑') {
                        // 编辑套餐功能
                        const planCard = this.closest('.plan-card');
                        const planName = planCard.querySelector('.plan-name').textContent;
                        alert(`编辑套餐: ${planName}`);
                    } else if (text === '删除') {
                        // 删除套餐功能
                        const planCard = this.closest('.plan-card');
                        const planName = planCard.querySelector('.plan-name').textContent;
                        if (confirm(`确定要删除套餐: ${planName} 吗?`)) {
                            alert(`已删除套餐: ${planName}`);
                        }
                    }
                });
            });

            // 翻页按钮功能
            document.querySelectorAll('.page-btn').forEach(function(btn) {
                if (!btn.disabled) {
                    btn.addEventListener('click', function() {
                        // 移除所有活动状态
                        document.querySelectorAll('.page-btn').forEach(b => b.classList.remove('active'));
                        // 添加活动状态到当前按钮
                        this.classList.add('active');
                        console.log('切换到页面:', this.textContent);
                        // 这里可以添加加载对应页面数据的逻辑
                    });
                }
            });

            // 快速操作按钮
            document.querySelectorAll('.quick-action-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const text = this.textContent.trim();
                    console.log('快速操作按钮被点击:', text);
                    
                    if (text.includes('同步订阅状态')) {
                        // 同步订阅状态功能
                        alert('正在同步订阅状态...');
                    } else if (text.includes('导出账单')) {
                        // 导出账单功能
                        alert('正在导出账单数据...');
                    } else if (text.includes('用户管理')) {
                        // 用户管理功能
                        alert('打开用户管理页面');
                    } else if (text.includes('取消订阅')) {
                        // 取消订阅功能
                        if (confirm('确定要批量取消订阅吗? 此操作不可撤销。')) {
                            alert('已开始批量取消订阅流程');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>