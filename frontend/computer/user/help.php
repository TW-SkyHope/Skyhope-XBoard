<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>帮助中心 - VPN 仪表盘</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        /* 主内容区 */
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
        
        /* 帮助中心内容 */
        .help-container {
            padding: 20px;
        }
        
        .help-layout {
            display: flex;
            gap: 20px;
        }
        
        .help-left {
            flex: 1;
        }
        
        .help-right {
            width: 350px;
        }
        
        /* 文档部分 */
        .documentation-section {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,123,255,0.1);
            padding: 30px;
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 20px;
            color: #007bff;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .documentation-item {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0,123,255,0.1);
        }
        
        .documentation-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .documentation-title {
            font-size: 18px;
            color: #007bff;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .documentation-content {
            color: #495057;
            line-height: 1.6;
        }
        
        .documentation-content p {
            margin-bottom: 10px;
        }
        
        /* 下载部分 */
        .download-section {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,123,255,0.1);
            padding: 30px;
            position: sticky;
            top: 20px;
        }
        
        .download-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .download-card {
            background: rgba(0,123,255,0.03);
            border-radius: 8px;
            padding: 15px;
            border-left: 3px solid #007bff;
            transition: all 0.3s;
        }
        
        .download-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,123,255,0.1);
        }
        
        .download-title {
            font-size: 16px;
            color: #007bff;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .download-meta {
            display: flex;
            justify-content: space-between;
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 12px;
        }
        
        .download-button {
            background: linear-gradient(135deg, #007bff, #0062cc);
            color: #fff;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            justify-content: center;
        }
        
        .download-button:hover {
            background: linear-gradient(135deg, #0062cc, #0056b3);
        }
        
        /* 桌面端悬停效果 */
        .sidebar:hover {
            width: 250px;
        }
        
        .sidebar:hover .sidebar-header h2,
        .sidebar:hover .sidebar-menu li a span {
            transform: translateX(0);
            opacity: 1;
        }
        
        .sidebar:hover ~ .dashboard {
            margin-left: 250px;
        }
    </style>
</head>
<body>
    <?php include dirname(__DIR__,2).'/src/component/sidebar.php'; ?>
    <!-- 主内容区 -->
    <div class="dashboard">
        <header class="header">
            <h1><i class="fas fa-question-circle"></i> 帮助中心</h1>
        </header>
        
        <div class="help-container">
            <div class="help-layout">
                <!-- 左侧 - 使用文档 -->
                <div class="help-left">
                    <div class="documentation-section">
                        <h2 class="section-title">
                            <i class="fas fa-file-alt"></i> 使用文档
                        </h2>
                        
                        <div class="documentation-item">
                            <h3 class="documentation-title">
                                <i class="fas fa-plug"></i> 连接VPN服务器
                            </h3>
                            <div class="documentation-content">
                                <p>1. 在服务器列表页面选择您想要连接的服务器</p>
                                <p>2. 点击"连接"按钮</p>
                                <p>3. 系统会自动下载配置文件或提供连接参数</p>
                                <p>4. 在您的VPN客户端中导入配置或手动输入参数</p>
                            </div>
                        </div>
                        
                        <div class="documentation-item">
                            <h3 class="documentation-title">
                                <i class="fas fa-cog"></i> 客户端配置指南
                            </h3>
                            <div class="documentation-content">
                                <p><strong>Windows用户：</strong></p>
                                <p>• 下载OpenVPN客户端并安装</p>
                                <p>• 将配置文件放入OpenVPN的config目录</p>
                                <p>• 右键点击系统托盘图标选择连接</p>
                                
                                <p><strong>Mac用户：</strong></p>
                                <p>• 使用Tunnelblick或Viscosity客户端</p>
                                <p>• 导入下载的.ovpn配置文件</p>
                                <p>• 点击连接按钮</p>
                                
                                <p><strong>Linux用户：</strong></p>
                                <p>• 安装OpenVPN客户端</p>
                                <p>• 将配置文件放入/etc/openvpn/</p>
                                <p>• 使用systemctl启动服务</p>
                            </div>
                        </div>
                        
                        <div class="documentation-item">
                            <h3 class="documentation-title">
                                <i class="fas fa-tachometer-alt"></i> 流量使用与套餐
                            </h3>
                            <div class="documentation-content">
                                <p>• 您可以在"套餐管理"页面查看剩余流量</p>
                                <p>• 系统会在流量使用达到80%时发送提醒</p>
                                <p>• 流量每月重置，未使用流量不累积</p>
                                <p>• 如需更多流量，可以升级套餐</p>
                            </div>
                        </div>
                        
                        <div class="documentation-item">
                            <h3 class="documentation-title">
                                <i class="fas fa-shield-alt"></i> 安全注意事项
                            </h3>
                            <div class="documentation-content">
                                <p>• 请勿与他人共享您的VPN账号</p>
                                <p>• 定期更换您的账户密码</p>
                                <p>• 使用完毕后请及时断开VPN连接</p>
                                <p>• 避免在公共WiFi下访问敏感信息</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- 右侧 - 文件下载 -->
                <div class="help-right">
                    <div class="download-section">
                        <h2 class="section-title">
                            <i class="fas fa-download"></i> 文件下载
                        </h2>
                        
                        <div class="download-list">
                            <div class="download-card">
                                <h4 class="download-title">
                                    <i class="fab fa-windows"></i> Windows客户端
                                </h4>
                                <div class="download-meta">
                                    <span>版本: 2.5.6</span>
                                    <span>大小: 18.7 MB</span>
                                </div>
                                <button class="download-button">
                                    <i class="fas fa-download"></i> 下载
                                </button>
                            </div>
                            
                            <div class="download-card">
                                <h4 class="download-title">
                                    <i class="fab fa-apple"></i> Mac客户端
                                </h4>
                                <div class="download-meta">
                                    <span>版本: 3.2.1</span>
                                    <span>大小: 25.3 MB</span>
                                </div>
                                <button class="download-button">
                                    <i class="fas fa-download"></i> 下载
                                </button>
                            </div>
                            
                            <div class="download-card">
                                <h4 class="download-title">
                                    <i class="fab fa-linux"></i> Linux客户端
                                </h4>
                                <div class="download-meta">
                                    <span>版本: 2.4.9</span>
                                    <span>大小: 12.1 MB</span>
                                </div>
                                <button class="download-button">
                                    <i class="fas fa-download"></i> 下载
                                </button>
                            </div>
                            
                            <div class="download-card">
                                <h4 class="download-title">
                                    <i class="fas fa-file-code"></i> 配置文件包
                                </h4>
                                <div class="download-meta">
                                    <span>版本: 最新</span>
                                    <span>大小: 0.5 MB</span>
                                </div>
                                <button class="download-button">
                                    <i class="fas fa-download"></i> 下载
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // 侧边栏交互
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const dashboard = document.querySelector('.dashboard');
        
        // 桌面端悬停效果
        sidebar.addEventListener('mouseenter', function() {
            this.style.width = '250px';
            dashboard.style.marginLeft = '250px';
        });
        
        sidebar.addEventListener('mouseleave', function() {
            this.style.width = '80px';
            dashboard.style.marginLeft = '80px';
        });
        
        // 窗口大小改变时调整布局
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
                dashboard.style.marginLeft = '80px';
            } else {
                dashboard.style.marginLeft = '0';
            }
        });
    </script>
</body>
</html>
