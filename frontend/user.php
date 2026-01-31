<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>设置 - VPN 客户端</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* 主内容区样式 - 与仪表盘保持一致 */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        .dashboard {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 80px;
            transition: margin-left 0.3s ease;
            min-width: 0;
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

        /* 设置页面特定样式 */
        .settings-container {
            padding: 20px;
            max-width: 100%;
            box-sizing: border-box;
        }

        .settings-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 123, 255, 0.1);
            padding: 25px;
            margin-bottom: 20px;
            box-sizing: border-box;
            overflow: hidden;
        }

        .settings-card h2 {
            margin: 0 0 20px;
            font-size: 18px;
            color: #007bff;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(0, 123, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .settings-card h2 i {
            font-size: 1.2em;
        }

        .form-group {
            margin-bottom: 20px;
            width: 100%;
            box-sizing: border-box;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #495057;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            max-width: 100%;
            padding: 10px 15px;
            border: 1px solid rgba(0, 123, 255, 0.2);
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .form-text {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }

        .btn {
            background: linear-gradient(135deg, #007bff 0%, #0062cc 100%);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            font-weight: 500;
            letter-spacing: 0.3px;
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.2);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn:hover {
            background: linear-gradient(135deg, #0062cc 0%, #0056b3 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .verification-code {
            display: flex;
            gap: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        .verification-code input {
            flex: 1;
            min-width: 0;
        }

        .verification-code button {
            width: 140px;
            flex-shrink: 0;
        }

        .login-history {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            table-layout: fixed;
        }

        .login-history th {
            background-color: rgba(0, 123, 255, 0.05);
            padding: 10px;
            text-align: left;
        }

        .login-history td {
            padding: 10px;
            border-bottom: 1px solid rgba(0, 123, 255, 0.1);
            word-wrap: break-word;
        }

        .login-history tr:last-child td {
            border-bottom: none;
        }

        .form-check {
            display: inline-block;
            margin-right: 20px;
        }

        /* 响应式调整 */
        @media (max-width: 768px) {
            .verification-code {
                flex-direction: column;
            }
            
            .verification-code button {
                width: 100%;
            }
            
            .login-history {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const dashboard = document.querySelector('.dashboard');
    
    // 侧边栏展开/收起
    sidebar.addEventListener('mouseenter', function() {
        this.style.width = '250px';
        dashboard.style.marginLeft = '250px';
    });
    
    sidebar.addEventListener('mouseleave', function() {
        this.style.width = '80px';
        dashboard.style.marginLeft = '80px';
    });
    
    // 获取验证码按钮点击事件
    const getCodeBtn = document.getElementById('getCodeBtn');
    if (getCodeBtn) {
        getCodeBtn.addEventListener('click', function() {
            let countdown = 60;
            const originalText = this.textContent;
            
            this.disabled = true;
            this.textContent = `${countdown}秒后重新获取`;
            
            const timer = setInterval(() => {
                countdown--;
                this.textContent = `${countdown}秒后重新获取`;
                
                if (countdown <= 0) {
                    clearInterval(timer);
                    this.textContent = originalText;
                    this.disabled = false;
                }
            }, 1000);
        });
    }
});
</script>
<body>
<?php echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/frontend/component/sidebar.html"); ?>
    <!-- 主内容区 -->
    <div class="dashboard">
        <header class="header">
            <h1><i class="fas fa-cog"></i> 设置</h1>
        </header>
        
        <div class="settings-container">
            <!-- 账户信息 -->
            <div class="settings-card">
                <h2><i class="fas fa-user"></i> 账户信息</h2>
                <form>
                    <div class="form-group">
                        <label class="form-label">用户名</label>
                        <input type="text" class="form-control" value="admin" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">注册时间</label>
                        <input type="text" class="form-control" value="2023-01-15 14:30:22" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">最后登录</label>
                        <input type="text" class="form-control" value="2023-06-10 09:15:43" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">最后登录IP</label>
                        <input type="text" class="form-control" value="192.168.1.100" readonly>
                    </div>
                </form>
            </div>
            
            <!-- 修改密码 -->
            <div class="settings-card">
                <h2><i class="fas fa-key"></i> 修改密码</h2>
                <form>
                    <div class="form-group">
                        <label class="form-label">当前密码</label>
                        <input type="password" class="form-control" placeholder="请输入当前密码">
                    </div>
                    <div class="form-group">
                        <label class="form-label">新密码</label>
                        <input type="password" class="form-control" placeholder="请输入新密码">
                        <div class="form-text">密码长度至少8位，包含字母和数字</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">确认新密码</label>
                        <input type="password" class="form-control" placeholder="请再次输入新密码">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> 保存更改
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- 绑定邮箱 -->
            <div class="settings-card">
                <h2><i class="fas fa-envelope"></i> 绑定邮箱</h2>
                <form>
                    <div class="form-group">
                        <label class="form-label">当前邮箱</label>
                        <input type="email" class="form-control" value="admin@example.com" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">新邮箱地址</label>
                        <input type="email" class="form-control" placeholder="请输入新的邮箱地址">
                    </div>
                    <div class="form-group">
                        <label class="form-label">验证码</label>
                        <div class="verification-code">
                            <input type="text" class="form-control" placeholder="请输入验证码">
                            <button type="button" id="getCodeBtn" class="btn btn-secondary">
                                <i class="fas fa-paper-plane"></i> 获取验证码
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> 更新邮箱
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- 安全设置 -->
            <div class="settings-card">
                <h2><i class="fas fa-shield-alt"></i> 安全设置</h2>
                <form>
                    <div class="form-group">
                        <label class="form-label">双重验证</label>
                        <div>
                            <div class="form-check">
                                <input type="radio" id="2fa-on" name="2fa" checked>
                                <label for="2fa-on">启用</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="2fa-off" name="2fa">
                                <label for="2fa-off">禁用</label>
                            </div>
                        </div>
                        <div class="form-text">启用双重验证可提高账户安全性</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">验证方式</label>
                        <select class="form-control">
                            <option>Google Authenticator</option>
                            <option>短信验证</option>
                            <option>邮箱验证</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> 保存设置
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- 登录历史 -->
            <div class="settings-card">
                <h2><i class="fas fa-history"></i> 登录历史</h2>
                <table class="login-history">
                    <thead>
                        <tr>
                            <th style="width: 25%">时间</th>
                            <th style="width: 20%">IP地址</th>
                            <th style="width: 25%">位置</th>
                            <th style="width: 30%">设备</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2023-06-10 09:15:43</td>
                            <td>192.168.1.100</td>
                            <td>中国 上海</td>
                            <td>Windows Chrome</td>
                        </tr>
                        <tr>
                            <td>2023-06-09 22:30:12</td>
                            <td>192.168.1.100</td>
                            <td>中国 上海</td>
                            <td>Android App</td>
                        </tr>
                        <tr>
                            <td>2023-06-08 14:05:27</td>
                            <td>120.204.17.66</td>
                            <td>中国 北京</td>
                            <td>Mac Safari</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- 通知设置 -->
            <div class="settings-card">
                <h2><i class="fas fa-bell"></i> 通知设置</h2>
                <form>
                    <div class="form-group">
                        <label class="form-label">邮件通知</label>
                        <div>
                            <div class="form-check">
                                <input type="checkbox" id="notify-email-news" checked>
                                <label for="notify-email-news">产品新闻和更新</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="notify-email-security" checked>
                                <label for="notify-email-security">安全通知</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">系统通知</label>
                        <div>
                            <div class="form-check">
                                <input type="checkbox" id="notify-system-maintenance" checked>
                                <label for="notify-system-maintenance">维护通知</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="notify-system-promo">
                                <label for="notify-system-promo">促销活动</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> 保存设置
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>