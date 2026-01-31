<style>
    .sidebar {
        width: 80px;
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: white;
        height: 100vh;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        position: fixed;
        left: 0;
        top: 0;
        z-index: 100;
        overflow: hidden; /* 改为hidden防止滚动条 */
        transition: width 0.3s ease;
    }

    .sidebar-header {
        padding: 25px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(255, 255, 255, 0.1);
        height: 80px;
        box-sizing: border-box;
        position: relative;
    }

    .sidebar-header h2 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 600;
        color: #fff;
        position: absolute;
        left: 60px;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.3s ease 0.1s; /* 添加延迟解决抖动 */
    }

    .sidebar:hover .sidebar-header h2 {
        opacity: 1;
    }

    .sidebar-header button {
        background: none;
        border: none;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        min-width: 40px;
    }

    .sidebar-menu {
        list-style-type: none;
        padding: 20px 0;
        margin: 0;
        height: calc(100vh - 80px); /* 计算剩余高度 */
        overflow: hidden; /* 防止内部滚动 */
    }

    .sidebar-menu li {
        padding: 22px 20px;
        transition: background 0.3s ease;
        height: 70px;
        box-sizing: border-box;
        margin-bottom: 8px;
    }

    .sidebar-menu li:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .sidebar-menu li a {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        font-size: 1.2rem;
        height: 100%;
        position: relative;
    }

    .sidebar-menu li a i {
        margin-right: 15px;
        font-size: 1.8rem;
        min-width: 30px;
        text-align: center;
    }

    .sidebar-menu li a span {
        opacity: 0;
        transition: opacity 0.3s ease 0.1s; /* 添加延迟解决抖动 */
        white-space: nowrap;
    }

    .sidebar:hover .sidebar-menu li a span {
        opacity: 1;
    }

    .sidebar-menu li .vector-icon {
        position: absolute;
        left: 28px;
        top: 50%;
        transform: translateY(-50%);
        width: 28px;
        height: 28px;
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        opacity: 0.9;
        transition: opacity 0.2s ease;
    }

    .sidebar:hover .sidebar-menu li .vector-icon {
        opacity: 0;
    }
</style>
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h2>VPN管理</h2>
        <button id="toggleSidebar">&#9776;</button>
    </div>
    <ul class="sidebar-menu">
        <li>
            <a href="/index">
                <i class="fas fa-home"></i>
                <span>仪表盘</span>
                <div class="vector-icon"></div>
            </a>
        </li>
        <li>
            <a href="/package">
                <i class="fas fa-server"></i>&thinsp;
                <span> 套餐</span>
                <div class="vector-icon"></div>
            </a>
        </li>
        <li>
            <a href="/list">
                <i class="fas fa-cog"></i>
                <span>服务器列表</span>
                <div class="vector-icon"></div>
            </a>
        </li>
        <li>
            <a href="/stats">
                <i class="fas fa-chart-line"></i>
                <span>统计</span>
                <div class="vector-icon"></div>
            </a>
        </li>
        <li>
            <a href="/help">
                <i class="fas fa-question-circle"></i>
                <span>帮助</span>
                <div class="vector-icon"></div>
            </a>
        </li>
                <li>
            <a href="/user">
                <i class="fas fa-user"></i>
                <span>用户</span>
                <div class="vector-icon"></div>
            </a>
        </li>
    </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const dashboard = document.querySelector('.dashboard');

        function handleSidebarHover(isHover) {
            if (sidebar && dashboard) {
                sidebar.style.width = isHover ? '250px' : '80px';
                dashboard.style.marginLeft = isHover ? '250px' : '80px';
            }
        }

        if (sidebar) {
            sidebar.addEventListener('mouseenter', () => handleSidebarHover(true));
            sidebar.addEventListener('mouseleave', () => handleSidebarHover(false));
        }
    });
</script>
