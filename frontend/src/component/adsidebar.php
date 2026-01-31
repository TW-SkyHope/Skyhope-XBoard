<?php
/**
 * 管理员侧边栏组件
 * 包含所有管理功能导航链接
 */
?>
<div class="admin-sidebar">
    <div class="sidebar-header">
        <div class="admin-logo">
            <i class="fas fa-shield-alt"></i>
            <span>Admin Panel</span>
        </div>
        <div class="admin-profile">
            <div class="profile-avatar">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Admin Avatar">
            </div>
            <div class="profile-info">
                <span class="admin-name">Admin User</span>
                <span class="admin-role">Super Admin</span>
            </div>
        </div>
    </div>
    
    <nav class="sidebar-nav">
        <ul class="nav-menu">
            <li class="nav-item active">
                <a href="admindashboard.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>控制面板</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="users.php">
                    <i class="fas fa-users"></i>
                    <span>用户管理</span>
                    <span class="badge">24</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="servers.php">
                    <i class="fas fa-server"></i>
                    <span>服务器管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="nodes.php">
                    <i class="fas fa-network-wired"></i>
                    <span>节点管理</span>
                    <span class="badge badge-warning">3</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="subscriptions.php">
                    <i class="fas fa-crown"></i>
                    <span>订阅管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="payments.php">
                    <i class="fas fa-credit-card"></i>
                    <span>支付记录</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="tickets.php">
                    <i class="fas fa-ticket-alt"></i>
                    <span>工单系统</span>
                    <span class="badge badge-danger">5</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="logs.php">
                    <i class="fas fa-clipboard-list"></i>
                    <span>系统日志</span>
                </a>
            </li>
            <li class="nav-item has-submenu">
                <a href="#">
                    <i class="fas fa-cog"></i>
                    <span>系统设置</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="settings-general.php"><i class="fas fa-sliders-h"></i> 常规设置</a></li>
                    <li><a href="settings-security.php"><i class="fas fa-lock"></i> 安全设置</a></li>
                    <li><a href="settings-email.php"><i class="fas fa-envelope"></i> 邮件设置</a></li>
                    <li><a href="settings-api.php"><i class="fas fa-code"></i> API设置</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    
    <div class="sidebar-footer">
        <a href="#" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>退出登录</span>
        </a>
    </div>
</div>