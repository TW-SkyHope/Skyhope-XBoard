<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>VPN 服务 - 登录</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #1a237e;
            --primary-dark: #0d47a1;
            --primary-light: #3949ab;
            --gradient: linear-gradient(135deg, #2884c6 0%, #0d47a1 100%);
            --white: #fff;
            --text-dark: #212121;
            --text-light: #757575;
            --light-bg: #f5f5f5;
            --shadow: 0 4px 12px rgba(26, 35, 126, 0.15);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: var(--light-bg);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .auth-container {
            width: 100%;
            max-width: 420px;
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        
        .auth-header {
            background: var(--gradient);
            color: var(--white);
            padding: 30px 20px;
            text-align: center;
        }
        
        .auth-header h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .auth-header p {
            font-size: 14px;
            opacity: 0.9;
            line-height: 1.5;
        }
        
        .auth-form-container {
            padding: 30px 25px;
        }
        
        .form-title {
            font-size: 20px;
            margin-bottom: 25px;
            font-weight: 600;
            text-align: center;
            color: var(--primary);
        }
        
        .input-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .input-group input {
            width: 100%;
            padding: 14px 14px 14px 42px;
            border: 1px solid rgba(26, 35, 126, 0.2);
            border-radius: 8px;
            font-size: 15px;
            background-color: rgba(26, 35, 126, 0.03);
            -webkit-appearance: none;
        }
        
        .input-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(26, 35, 126, 0.1);
        }
        
        .input-icon {
            position: absolute;
            left: 14px;
            top: 38px;
            color: var(--primary);
            font-size: 16px;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 13px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input {
            margin-right: 8px;
            accent-color: var(--primary);
        }
        
        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .submit-btn {
            width: 100%;
            padding: 14px;
            background: var(--gradient);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }
        
        .submit-btn:active {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
            transform: scale(0.98);
        }
        
        /* 移动端优化 */
        @media (max-height: 700px) {
            .auth-header {
                padding: 20px 15px;
            }
            
            .auth-form-container {
                padding: 20px 15px;
            }
            
            .input-group {
                margin-bottom: 15px;
            }
        }
        
        /* 防止iOS缩放 */
        input[type="text"],
        input[type="password"] {
            font-size: 16px !important;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h2>安全连接，自由访问</h2>
            <p>使用VPN服务保护隐私并访问全球内容</p>
        </div>
        
        <div class="auth-form-container">
            <form id="login-form" method="POST" action="">
                <h2 class="form-title">用户登录</h2>
                
                <div class="input-group">
                    <label for="login-username">用户名</label>
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" id="login-username" name="username" placeholder="输入用户名" required>
                </div>
                
                <div class="input-group">
                    <label for="login-password">密码</label>
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="login-password" name="password" placeholder="输入密码" required>
                </div>
                
                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember-me" name="remember">
                        <label for="remember-me">记住我</label>
                    </div>
                    <a href="#" class="forgot-password">忘记密码?</a>
                </div>
                
                <button type="submit" class="submit-btn" name="login">登 录</button>
            </form>
        </div>
    </div>
</body>
</html>