<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <?php require_once ($_SERVER['DOCUMENT_ROOT'] . "/sql/db.php");
        require ($_SERVER['DOCUMENT_ROOT'] . "/backend/library/php/mysql.php");
        $sql = new MySQLiPDO($pdo); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #333;
            min-height: 100vh;
            display: flex;
        }

        .dashboard {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 80px;
            transition: margin-left 0.3s ease;
        }

        .header {
            background-color: #ffffff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(0, 123, 255, 0.1);
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #007bff;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .welcome-message {
            background-color: #ffffff;
            padding: 25px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 123, 255, 0.1);
        }

        .welcome-message h2 {
            margin: 0;
            font-size: 20px;
            color: #2c3e50;
        }

        .welcome-message p {
            margin: 10px 0 0;
            color: #6c757d;
        }

        .subscription-card {
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.03) 0%, rgba(0, 123, 255, 0.05) 100%);
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            border: 1px solid rgba(0, 123, 255, 0.1);
        }

        .subscription-card h3 {
            margin: 0 0 10px;
            font-size: 18px;
            color: #007bff;
        }

        .subscription-card p {
            margin: 0 0 10px;
            color: #6c757d;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background-color: rgba(0, 123, 255, 0.1);
            border-radius: 4px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            background: linear-gradient(90deg, #007bff 0%, #0062cc 100%);
            border-radius: 4px;
            width: 30%;
            transition: width 0.6s ease;
        }

        .subscribe-button {
            background: linear-gradient(135deg, #007bff 0%, #0062cc 100%);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.2);
        }

        .subscribe-button:hover {
            background: linear-gradient(135deg, #0062cc 0%, #0056b3 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }

        .main-content {
            flex: 1;
            padding: 15px 25px;
            display: flex;
            gap: 20px;
        }

        .left-column, .right-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .card {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 123, 255, 0.1);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 123, 255, 0.1);
        }

        .card h2 {
            margin: 0 0 20px;
            font-size: 18px;
            color: #007bff;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(0, 123, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .card li {
            margin-bottom: 12px;
            position: relative;
            padding-left: 18px;
            transition: all 0.3s ease;
        }

        .card li:before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            background-color: #007bff;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .card li:hover {
            padding-left: 22px;
        }

        .card li:hover:before {
            width: 8px;
            height: 8px;
            background-color: #0056b3;
        }

        .card a {
            color: #495057;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            padding: 10px 0;
            gap: 12px;
        }

        .card a:hover {
            color: #007bff;
        }

        .announcement-card {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 123, 255, 0.1);
        }

        .announcement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 123, 255, 0.1);
        }

        .announcement-item {
            padding: 18px;
            margin-bottom: 18px;
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.03) 0%, rgba(0, 123, 255, 0.05) 100%);
            border-radius: 8px;
            transition: all 0.3s ease;
            border-left: 3px solid #007bff;
        }

        .announcement-item:hover {
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.05) 0%, rgba(0, 123, 255, 0.08) 100%);
            transform: translateX(8px);
        }

        .announcement-item h3 {
            margin: 0 0 10px;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .announcement-item p {
            margin: 0;
            color: #6c757d;
            font-size: 14px;
            line-height: 1.6;
        }

        .date {
            color: #adb5bd;
            font-size: 12px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .footer {
            padding: 0 25px 25px;
        }
        
        .copyright-card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 123, 255, 0.1);
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        
        .copyright-card a {
            color: #007bff;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .copyright-card a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        
        .copyright-links {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        /* 响应式设计 */
        @media (max-width: 992px) {
            .main-content {
                flex-direction: column;
            }
            
            .left-column, .right-column {
                width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .dashboard {
                margin-left: 0;
            }
            
            .header {
                padding: 15px;
            }
            
            .header h1 {
                font-size: 20px;
            }
            
            .welcome-message {
                margin: 10px;
                padding: 15px;
            }
            
            .main-content {
                padding: 10px;
            }
            
            .copyright-links {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <?php echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/frontend/component/sidebar.html"); ?>
    
    <div class="dashboard">
        <header class="header">
            <h1><i class="fas fa-shield-alt"></i> VPN 仪表盘</h1>
        </header>
        
        <div class="welcome-message">
            <h2>欢迎回来！</h2>
            <p>您当前有 12 个在线隧道，总流量为 1.2 GB。</p>
            
            <div class="subscription-card">
                <h3><i class="fas fa-crown"></i> 我的订阅</h3>
                <p>当前订阅：基础版</p>
                <div class="progress-bar">
                    <div class="progress"></div>
                </div>
                <p>已使用流量：300 MB / 1000 MB</p>
                <button class="subscribe-button"><i class="fas fa-arrow-circle-up"></i> 一键订阅</button>
            </div>
        </div>
        
        <main class="main-content">
            <div class="left-column">
                <div class="card">
                    <h2><i class="fas fa-book"></i> 使用文档</h2>
                    <ul>
                        <li>
                            <a href="#">
                                <i class="fas fa-rocket"></i>
                                <span>快速入门指南</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-question-circle"></i>
                                <span>常见问题解答</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-cog"></i>
                                <span>高级配置手册</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-video"></i>
                                <span>视频教程</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="card">
                    <h2><i class="fas fa-comment-dots"></i> 问题反馈</h2>
                    <ul>
                        <li>
                            <a href="#">
                                <i class="fas fa-ticket-alt"></i>
                                <span>提交技术支持工单</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-headset"></i>
                                <span>24小时在线客服</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-bug"></i>
                                <span>报告系统错误</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-lightbulb"></i>
                                <span>功能建议</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="right-column">
                <div class="card announcement-card">
                    <h2><i class="fas fa-bullhorn"></i> 系统公告</h2>
                    
                    <div class="announcement-item">
                        <h3><i class="fas fa-exclamation-circle"></i> 系统维护通知</h3>
                        <p>为了提升服务质量，我们将在本周六凌晨2:00-4:00进行系统维护，期间服务可能短暂中断。</p>
                        <div class="date"><i class="far fa-clock"></i> 2023-11-15</div>
                    </div>
                    
                    <div class="announcement-item">
                        <h3><i class="fas fa-star"></i> 新功能上线</h3>
                        <p>新增多设备同时连接功能，现在支持最多5台设备同时使用VPN服务。</p>
                        <div class="date"><i class="far fa-clock"></i> 2023-11-10</div>
                    </div>
                    
                    <div class="announcement-item">
                        <h3><i class="fas fa-tag"></i> 双十一优惠活动</h3>
                        <p>双十一期间，所有套餐享受7折优惠，年付用户额外赠送1个月服务期。</p>
                        <div class="date"><i class="far fa-clock"></i> 2023-11-01</div>
                    </div>
                    
                    <div class="announcement-item">
                        <h3><i class="fas fa-shield-alt"></i> 安全升级公告</h3>
                        <p>我们已升级加密协议至最新标准，建议所有用户更新客户端至最新版本。</p>
                        <div class="date"><i class="far fa-clock"></i> 2023-10-28</div>
                    </div>
                </div>
            </div>
        </main>
        
        <div class="footer">
            <div class="copyright-card">
                <p>© 2023 VPN服务提供商 版权所有</p>
                <p>本产品仅供合法用途使用，任何违法行为将由使用者自行承担法律责任</p>
                <div class="copyright-links">
                    <a href="#"><i class="fas fa-file-alt"></i> 服务条款</a>
                    <a href="#"><i class="fas fa-lock"></i> 隐私政策</a>
                    <a href="#"><i class="fas fa-envelope"></i> 联系我们</a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const dashboard = document.querySelector('.dashboard');
        
        if (sidebar && dashboard) {
            sidebar.addEventListener('mouseenter', function() {
                this.style.width = '250px';
                dashboard.style.marginLeft = '250px';
            });
            
            sidebar.addEventListener('mouseleave', function() {
                this.style.width = '80px';
                dashboard.style.marginLeft = '80px';
            });
        }
    });
    </script>
</body>
</html>