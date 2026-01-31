<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VPN 服务 - 登录/注册</title>
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
            --shadow: 0 10px 30px rgba(26, 35, 126, 0.2);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light-bg);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .auth-container {
            width: 1000px;
            min-height: 600px;
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
            display: flex;
        }
        
        .auth-illustration {
            flex: 1.2;
            background: var(--gradient);
            padding: 60px;
            color: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .auth-illustration h2 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .auth-illustration p {
            font-size: 16px;
            opacity: 0.9;
            text-align: center;
            margin-bottom: 40px;
            max-width: 80%;
            line-height: 1.6;
        }
        
        .auth-form-container {
            flex: 1;
            padding: 70px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .auth-tabs {
            display: flex;
            margin-bottom: 40px;
            border-bottom: 1px solid rgba(26, 35, 126, 0.1);
        }
        
        .auth-tab {
            padding: 15px 25px;
            cursor: pointer;
            font-weight: 600;
            color: var(--text-light);
            position: relative;
            font-size: 18px;
        }
        
        .auth-tab.active {
            color: var(--primary);
        }
        
        .auth-tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary);
        }
        
        .auth-form {
            display: none;
        }
        
        .auth-form.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-title {
            font-size: 28px;
            margin-bottom: 30px;
            font-weight: 600;
        }
        
        .input-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .input-group input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 1px solid rgba(26, 35, 126, 0.2);
            border-radius: 8px;
            font-size: 15px;
            background-color: rgba(26, 35, 126, 0.03);
        }
        
        .input-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 35, 126, 0.1);
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 43px;
            color: var(--primary);
            font-size: 18px;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 14px;
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
            padding: 16px;
            background: var(--gradient);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
        
        .submit-btn:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
        }
        
        .switch-text {
            text-align: center;
            margin-top: 30px;
            font-size: 15px;
            color: var(--text-light);
        }
        
        .switch-text a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 992px) {
            .auth-container {
                width: 90%;
                max-width: 800px;
                min-height: 500px;
            }

            .auth-illustration {
                padding: 40px;
            }

            .auth-form-container {
                padding: 50px 40px;
            }
        }

        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
                width: 90%;
                max-width: 500px;
                min-height: auto;
            }
            
            .auth-illustration {
                display: none;
            }
            
            .auth-form-container {
                padding: 50px 40px;
            }

            .form-title {
                font-size: 24px;
                margin-bottom: 25px;
            }

            .auth-tab {
                padding: 12px 20px;
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .auth-form-container {
                padding: 40px 30px;
            }

            .auth-tabs {
                margin-bottom: 30px;
            }

            .input-group input {
                padding: 12px 12px 12px 40px;
            }

            .input-icon {
                top: 38px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-illustration">
            <h2>安全连接，自由访问</h2>
            <p>使用我们的VPN服务，保护您的隐私并访问全球内容。高速稳定的连接，随时随地畅享网络自由。</p>
        </div>
        
        <div class="auth-form-container">
            <div class="auth-tabs">
                <div class="auth-tab active" data-tab="login">登录</div>
                <div class="auth-tab" data-tab="register">注册</div>
            </div>
            
            <form id="login-form" class="auth-form active" method="POST" action="">
                <h2 class="form-title">欢迎回来</h2>
                
                <div class="input-group">
                    <label for="login-username">用户名</label>
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" id="login-username" name="username" placeholder="输入您的用户名" required>
                </div>
                
                <div class="input-group">
                    <label for="login-password">密码</label>
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="login-password" name="password" placeholder="输入您的密码" required>
                </div>
                
                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember-me" name="remember">
                        <label for="remember-me">记住我</label>
                    </div>
                    <a href="#" class="forgot-password">忘记密码?</a>
                </div>
                
                <button type="submit" class="submit-btn" name="login">登录</button>
                
                <p class="switch-text">还没有账号? <a href="#" data-tab="register">立即注册</a></p>
            </form>
            
            <form id="register-form" class="auth-form" method="POST" action="">
                <h2 class="form-title">创建新账户</h2>
                
                <div class="input-group">
                    <label for="register-username">用户名</label>
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" id="register-username" name="username" placeholder="输入用户名" required>
                </div>
                
                <div class="input-group">
                    <label for="register-email">电子邮箱</label>
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" id="register-email" name="email" placeholder="输入电子邮箱" required>
                </div>
                
                <div class="input-group">
                    <label for="register-password">密码</label>
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="register-password" name="password" placeholder="输入密码 (至少8位)" required minlength="8">
                </div>
                
                <div class="input-group">
                    <label for="register-confirm-password">确认密码</label>
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="register-confirm-password" name="confirm_password" placeholder="再次输入密码" required>
                </div>
                
                <button type="submit" class="submit-btn" name="register">注册</button>
                
                <p class="switch-text">已有账号? <a href="#" data-tab="login">立即登录</a></p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 切换标签
        const tabs = document.querySelectorAll('.auth-tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                document.querySelectorAll('.auth-form').forEach(form => form.classList.remove('active'));
                document.getElementById(`${tabId}-form`).classList.add('active');
            });
        });
        
        // 切换表单链接
        const switchLinks = document.querySelectorAll('.switch-text a');
        switchLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const tabId = this.getAttribute('data-tab');
                
                tabs.forEach(t => t.classList.remove('active'));
                document.querySelector(`.auth-tab[data-tab="${tabId}"]`).classList.add('active');
                
                document.querySelectorAll('.auth-form').forEach(form => form.classList.remove('active'));
                document.getElementById(`${tabId}-form`).classList.add('active');
            });
        });

        // 密码验证
        const registerForm = document.getElementById('register-form');
        registerForm.addEventListener('submit', function(e) {
            const password = document.getElementById('register-password').value;
            const confirmPassword = document.getElementById('register-confirm-password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                Swal.fire('错误', '两次输入的密码不一致', 'error');
                return false;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                Swal.fire('错误', '密码长度至少需要8位', 'error');
                return false;
            }
        });
    </script>

    <?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/sql/db.php");

    if (isset($_POST['login'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $remember = isset($_POST['remember']) ? true : false;
        
        if (!empty($username) && !empty($password)) {
            $password_md5 = strtoupper(md5($password));
            
            try {
                $stmt = $pdo->prepare("SELECT * FROM userdate WHERE username = ? AND password = ?");
                $stmt->execute([$username, $password_md5]);
                
                if ($stmt->rowCount() > 0) {
                    $cookie_value = json_encode([
                        'username' => $username,
                        'password_md5' => $password_md5
                    ]);
                    
                    setcookie('vpn_auth', $cookie_value, [
                        'expires' => $remember ? time() + 86400 * 30 : 0,
                        'path' => '/',
                        'domain' => $_SERVER['HTTP_HOST'],
                        'secure' => true,
                        'httponly' => true,
                        'samesite' => 'Strict'
                    ]);
                    
                    echo "<script>
                        Swal.fire({
                            title: '登录成功',
                            text: '正在跳转到仪表盘...',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '/dashboard.php';
                        });
                    </script>";
                    exit;
                } else {
                    echo "<script>
                        Swal.fire('登录失败', '用户名或密码错误', 'error').then(() => {
                            document.getElementById('login-username').value = '';
                            document.getElementById('login-password').value = '';
                        });
                    </script>";
                }
            } catch (PDOException $e) {
                echo "<script>Swal.fire('错误', '数据库查询失败', 'error');</script>";
            }
        } else {
            echo "<script>Swal.fire('错误', '请输入用户名和密码', 'error');</script>";
        }
    }
    
    if (isset($_POST['register'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        
        if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
            echo "<script>Swal.fire('错误', '请填写所有字段', 'error');</script>";
        } elseif ($password !== $confirm_password) {
            echo "<script>
                Swal.fire('错误', '两次输入的密码不一致', 'error').then(() => {
                    document.getElementById('register-password').value = '';
                    document.getElementById('register-confirm-password').value = '';
                });
            </script>";
        } elseif (strlen($password) < 8) {
            echo "<script>Swal.fire('错误', '密码长度至少需要8位', 'error');</script>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>Swal.fire('错误', '请输入有效的电子邮箱地址', 'error');</script>";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT id FROM userdate WHERE username = ? OR email = ?");
                $stmt->execute([$username, $email]);
                
                if ($stmt->rowCount() > 0) {
                    echo "<script>Swal.fire('错误', '用户名或电子邮箱已被注册', 'error');</script>";
                } else {
                    $password_md5 = strtoupper(md5($password));
                    
                    $stmt = $pdo->prepare("INSERT INTO userdate (username, email, password) VALUES (?, ?, ?)");
                    
                    if ($stmt->execute([$username, $email, $password_md5])) {
                        echo "<script>
                            Swal.fire('注册成功', '现在可以登录您的账户了', 'success').then(() => {
                                document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
                                document.querySelector('.auth-tab[data-tab=\"login\"]').classList.add('active');
                                
                                document.querySelectorAll('.auth-form').forEach(form => form.classList.remove('active'));
                                document.getElementById('login-form').classList.add('active');
                                
                                document.getElementById('login-username').value = '" . addslashes($username) . "';
                            });
                        </script>";
                    } else {
                        echo "<script>Swal.fire('错误', '注册失败，请稍后再试', 'error');</script>";
                    }
                }
            } catch (PDOException $e) {
                echo "<script>Swal.fire('错误', '数据库操作失败', 'error');</script>";
            }
        }
    }
    ?>
</body>
</html>