<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>套餐管理 - VPN 仪表盘</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            color: #333;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
        }

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

        /* 套餐页面样式 */
        .plan-container {
            padding: 20px;
        }

        /* 标签切换样式 */
        .plan-tabs-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .plan-tabs {
            display: inline-flex;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,123,255,0.1);
            overflow: hidden;
        }

        .plan-tab {
            padding: 14px 40px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            font-size: 15px;
            margin: 0 5px;
        }

        .plan-tab.active {
            background: rgba(0,123,255,0.05);
            border-bottom: 3px solid #007bff;
            color: #007bff;
            font-weight: 500;
        }

        .plan-tab:hover {
            background: rgba(0,123,255,0.05);
        }

        .plan-content {
            display: none;
        }

        .plan-content.active {
            display: block;
        }

        /* 当前套餐卡片 */
        .current-plan-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,123,255,0.1);
            padding: 30px;
            margin-bottom: 20px;
        }

        .current-plan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0,123,255,0.1);
        }

        .plan-name {
            font-size: 20px;
            color: #2c3e50;
            font-weight: 600;
        }

        .plan-status {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            background: rgba(40,167,69,0.1);
            color: #28a745;
        }

        .plan-details {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .plan-section {
            padding: 20px;
            background: rgba(0,123,255,0.03);
            border-radius: 8px;
            border-left: 3px solid #007bff;
        }

        .plan-section-title {
            font-size: 16px;
            color: #007bff;
            font-weight: 500;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .plan-section-title i {
            font-size: 18px;
        }

        .plan-detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .plan-detail-item {
            margin-bottom: 12px;
        }

        .plan-detail-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .plan-detail-value {
            font-size: 16px;
            color: #495057;
            font-weight: 500;
        }

        .progress-container {
            margin-top: 10px;
        }

        .progress-bar {
            height: 10px;
            background: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 5px;
        }

        .progress {
            height: 100%;
            background: linear-gradient(90deg, #007bff, #00b4ff);
            border-radius: 5px;
            width: 65%;
        }

        .progress-text {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #6c757d;
        }

        .plan-actions {
            display: flex;
            gap: 15px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(0,123,255,0.1);
        }

        .btn {
            background: linear-gradient(135deg, #007bff, #0062cc);
            color: #fff;
            border: none;
            padding: 12px 25px;
            font-size: 15px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn:hover {
            background: linear-gradient(135deg, #0062cc, #0056b3);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #007bff;
            color: #007bff;
        }

        .btn-outline:hover {
            background: rgba(0,123,255,0.1);
        }

        /* 套餐历史记录 */
        .plan-history {
            margin-top: 40px;
        }

        .plan-history-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .plan-history-table {
            width: 100%;
            border-collapse: collapse;
        }

        .plan-history-table th {
            padding: 12px 15px;
            text-align: left;
            font-weight: 500;
            font-size: 14px;
            color: #6c757d;
            background: rgba(0,123,255,0.05);
        }

        .plan-history-table td {
            padding: 12px 15px;
            border-bottom: 1px solid rgba(0,123,255,0.1);
            font-size: 14px;
            color: #495057;
        }

        .plan-history-table tr:last-child td {
            border-bottom: none;
        }

        /* 套餐购买卡片 */
        .plan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .plan-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,123,255,0.1);
            padding: 30px;
            min-height: 420px;
            display: flex;
            flex-direction: column;
        }

        .plan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,123,255,0.1);
        }

        .plan-card.recommended {
            border: 1px solid #007bff;
            position: relative;
        }

        .plan-card.recommended:before {
            content: "推荐";
            position: absolute;
            top: -10px;
            right: 20px;
            background: #007bff;
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .plan-card-header {
            margin-bottom: 20px;
        }

        .plan-card-name {
            font-size: 20px;
            color: #007bff;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .plan-card-price {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .plan-card-price span {
            font-size: 14px;
            color: #6c757d;
            font-weight: 400;
        }

        .plan-card-features {
            margin-bottom: 25px;
            flex-grow: 1;
        }

        .plan-card-feature {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            color: #495057;
            font-size: 15px;
        }

        .plan-card-feature i {
            color: #007bff;
            font-size: 12px;
        }

        .plan-card-footer {
            text-align: center;
        }
    </style>
</head>
<body>
<?php include dirname(__DIR__,2).'/src/component/sidebar.php'; ?>
    
    <div class="dashboard">
        <header class="header">
            <h1><i class="fas fa-crown"></i> 套餐管理</h1>
        </header>
        
        <div class="plan-container">
            <!-- 套餐标签切换 -->
            <div class="plan-tabs-container">
                <div class="plan-tabs">
                    <div class="plan-tab active" data-target="plan-settings">
                        <i class="fas fa-cog"></i> 使用套餐
                    </div>
                    <div class="plan-tab" data-target="plan-purchase">
                        <i class="fas fa-shopping-cart"></i> 套餐购买
                    </div>
                </div>
            </div>
            
            <!-- 当前套餐信息 -->
            <div id="plan-settings" class="plan-content active">
                <div class="current-plan-card">
                    <div class="current-plan-header">
                        <div class="plan-name">标准套餐</div>
                        <div class="plan-status">生效中</div>
                    </div>
                    
                    <div class="plan-details">
                        <!-- 基本信息 -->
                        <div class="plan-section">
                            <div class="plan-section-title">
                                <i class="fas fa-info-circle"></i>
                                <span>套餐基本信息</span>
                            </div>
                            <div class="plan-detail-grid">
                                <div class="plan-detail-item">
                                    <div class="plan-detail-label">套餐类型</div>
                                    <div class="plan-detail-value">标准套餐</div>
                                </div>
                                <div class="plan-detail-item">
                                    <div class="plan-detail-label">购买日期</div>
                                    <div class="plan-detail-value">2023-01-01</div>
                                </div>
                                <div class="plan-detail-item">
                                    <div class="plan-detail-label">到期时间</div>
                                    <div class="plan-detail-value">2023-12-31</div>
                                </div>
                                <div class="plan-detail-item">
                                    <div class="plan-detail-label">剩余天数</div>
                                    <div class="plan-detail-value">183天</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 流量使用 -->
                        <div class="plan-section">
                            <div class="plan-section-title">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>流量使用情况</span>
                            </div>
                            <div class="plan-detail-item">
                                <div class="plan-detail-label">已用流量 / 总流量</div>
                                <div class="plan-detail-value">65.2 GB / 100 GB</div>
                                <div class="progress-container">
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 65%;"></div>
                                    </div>
                                    <div class="progress-text">
                                        <span>已用65.2GB</span>
                                        <span>剩余34.8GB</span>
                                    </div>
                                </div>
                            </div>
                            <div class="plan-detail-item" style="margin-top: 15px;">
                                <div class="plan-detail-label">日均流量</div>
                                <div class="plan-detail-value">0.35 GB/天</div>
                            </div>
                        </div>
                        
                        <!-- 节点信息 -->
                        <div class="plan-section">
                            <div class="plan-section-title">
                                <i class="fas fa-server"></i>
                                <span>节点与线路</span>
                            </div>
                            <div class="plan-detail-grid">
                                <div class="plan-detail-item">
                                    <div class="plan-detail-label">可用节点</div>
                                    <div class="plan-detail-value">全球50+节点</div>
                                </div>
                                <div class="plan-detail-item">
                                    <div class="plan-detail-label">线路质量</div>
                                    <div class="plan-detail-value">优先线路</div>
                                </div>
                                <div class="plan-detail-item">
                                    <div class="plan-detail-label">最快节点</div>
                                    <div class="plan-detail-value">香港 #3 (32ms)</div>
                                </div>
                                <div class="plan-detail-item">
                                    <div class="plan-detail-label">专属功能</div>
                                    <div class="plan-detail-value">广告拦截</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="plan-actions">
                        <button class="btn btn-outline">
                            <i class="fas fa-sync-alt"></i> 自动续费
                        </button>
                        <button class="btn">
                            <i class="fas fa-crown"></i> 升级套餐
                        </button>
                        <button class="btn btn-outline">
                            <i class="fas fa-file-invoice"></i> 查看账单
                        </button>
                    </div>
                </div>
                
                <div class="plan-history">
                    <div class="plan-history-title">
                        <i class="fas fa-history"></i>
                        <span>套餐使用记录</span>
                    </div>
                    <table class="plan-history-table">
                        <thead>
                            <tr>
                                <th>时间</th>
                                <th>套餐类型</th>
                                <th>有效期</th>
                                <th>状态</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2023-01-01</td>
                                <td>标准套餐</td>
                                <td>2023-01-01 至 2023-12-31</td>
                                <td style="color: #28a745;">生效中</td>
                            </tr>
                            <tr>
                                <td>2022-06-01</td>
                                <td>基础套餐</td>
                                <td>2022-06-01 至 2022-12-31</td>
                                <td style="color: #6c757d;">已过期</td>
                            </tr>
                            <tr>
                                <td>2022-01-01</td>
                                <td>基础套餐</td>
                                <td>2022-01-01 至 2022-06-01</td>
                                <td style="color: #6c757d;">已过期</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- 套餐购买 -->
            <div id="plan-purchase" class="plan-content">
                <div class="plan-grid">
                    <!-- 基础套餐 -->
                    <div class="plan-card">
                        <div class="plan-card-header">
                            <div class="plan-card-name">基础套餐</div>
                            <div class="plan-card-price">¥29 <span>/月</span></div>
                        </div>
                        <div class="plan-card-features">
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>50GB 月流量</span>
                            </div>
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>3台设备同时在线</span>
                            </div>
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>全球30+节点</span>
                            </div>
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>基础技术支持</span>
                            </div>
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>普通线路质量</span>
                            </div>
                        </div>
                        <div class="plan-card-footer">
                            <button class="btn btn-outline" style="width: 100%;">
                                <i class="fas fa-shopping-cart"></i> 立即购买
                            </button>
                        </div>
                    </div>
                    
                    <!-- 标准套餐 -->
                    <div class="plan-card recommended">
                        <div class="plan-card-header">
                            <div class="plan-card-name">标准套餐</div>
                            <div class="plan-card-price">¥59 <span>/月</span></div>
                        </div>
                        <div class="plan-card-features">
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>100GB 月流量</span>
                            </div>
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>5台设备同时在线</span>
                            </div>
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>全球50+节点</span>
                            </div>
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>优先技术支持</span>
                            </div>
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>广告拦截功能</span>
                            </div>
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>优先线路质量</span>
                            </div>
                        </div>
                        <div class="plan-card-footer">
                            <button class="btn" style="width: 100%;">
                                <i class="fas fa-shopping-cart"></i> 立即购买
                            </button>
                        </div>
                    </div>
                    
                    <!-- 高级套餐 -->
                    <div class="plan-card">
                        <div class="plan-card-header">
                            <div class="plan-card-name">高级套餐</div>
                            <div class="plan-card-price">¥99 <span>/月</span></div>
                        </div>
                        <div class="plan-card-features">
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>无限流量</span>
                            </div>
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>10台设备同时在线</span>
                            </div>
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>全球80+节点</span>
                            </div>
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>24/7专属支持</span>
                            </div>
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>广告拦截功能</span>
                            </div>
                            <div class="plan-card-feature">
                                <i class="fas fa-check"></i>
                                <span>专属高速线路</span>
                            </div>
                        </div>
                        <div class="plan-card-footer">
                            <button class="btn btn-outline" style="width: 100%;">
                                <i class="fas fa-shopping-cart"></i> 立即购买
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 侧边栏交互
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
        
        // 套餐标签切换
        const planTabs = document.querySelectorAll('.plan-tab');
        const planContents = document.querySelectorAll('.plan-content');
        
        planTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // 更新标签活动状态
                planTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // 显示对应的内容
                const target = this.getAttribute('data-target');
                planContents.forEach(content => {
                    content.classList.remove('active');
                    if(content.id === target) {
                        content.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>
</html>
