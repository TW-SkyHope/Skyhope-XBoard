<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>系统登录</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "PingFang SC", "Microsoft YaHei", sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }
        
        .login-container {
            width: 900px;
            height: 500px;
            display: flex;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }
        
        .login-image {
            width: 45%;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 0 40px;
        }
        
        .login-image h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        
        .login-image p {
            font-size: 14px;
            line-height: 1.8;
            text-align: center;
        }
        
        .login-form {
            width: 60%;
            background-color: white;
            padding: 50px 60px;
            display: flex;
            flex-direction: column;
        }
        
        .welcome-text {
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-size: 14px;
        }
        
        .form-control {
            width: 100%;
            height: 45px;
            padding: 0 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            border-color: #4facfe;
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        }
        
        .icon-wrapper {
            position: absolute;
            right: 15px;
            top: 38px;
            color: #999;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
            color: #666;
        }
        
        .checkbox-group input[type="checkbox"] {
            margin-right: 10px;
            width: 16px;
            height: 16px;
        }
        
        .forgot-link {
            color: #4facfe;
            text-decoration: none;
            margin-left: auto;
        }
        
        .login-btn {
            width: 100%;
            height: 45px;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: opacity 0.3s;
        }
        
        .login-btn:hover {
            opacity: 0.95;
        }
        
        @media (max-width: 900px) {
            .login-container {
                width: 90%;
                height: auto;
                flex-direction: column;
            }
            
            .login-image, .login-form {
                width: 100%;
            }
            
            .login-image {
                height: 300px;
            }
            
            .login-form {
                padding: 30px 40px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <h1>安全连接，自由访问</h1>
            <p>使用我们的VPN服务，保护您的隐私并访问全球内容。高速稳定的连接，随时随地畅享网络自由。</p>
        </div>
        
        <form class="login-form">
            <h2 class="welcome-text">欢迎回来</h2>
            
            <div class="form-group">
                <label for="username">用户名</label>
                <input type="text" id="username" class="form-control" placeholder="输入您的用户名">
                <span class="icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#999" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                </svg></span>
            </div>
            
            <div class="form-group">
                <label for="password">密码</label>
                <input type="password" id="password" class="form-control" placeholder="输入您的密码">
                <span class="icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#999" viewBox="0 0 16 16">
                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                    <path d="M10 13a1 1 0 0 0 1 1v2a1 1 0 0 0 2 0v-2a1 1 0 0 0-1-1H10z"/>
                </svg></span>
            </div>
            
            <div class="checkbox-group">
                <input type="checkbox" id="remember">
                <label for="remember">记住我</label>
                <a href="#" class="forgot-link">忘记密码?</a>
            </div>
            
            <button type="submit" class="login-btn">登录</button>
        </form>
    </div>
</body>
</html>