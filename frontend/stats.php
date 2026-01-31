<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VPN 数据统计</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.css">
    <style>
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
            background: white;
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

        .stats-header {
            background: white;
            padding: 25px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,123,255,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stats-header h2 {
            margin: 0;
            font-size: 20px;
            color: #2c3e50;
            font-weight: 500;
        }

        .time-filter {
            display: flex;
            gap: 10px;
        }

        .time-filter button {
            background: rgba(0,123,255,0.1);
            color: #007bff;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .time-filter button.active {
            background: linear-gradient(135deg, #007bff 0%, #0062cc 100%);
            color: white;
        }

        .time-filter button:hover {
            background: rgba(0,123,255,0.2);
        }

        .main-content {
            flex: 1;
            padding: 15px 25px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: 1px solid rgba(0,123,255,0.1);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,123,255,0.1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #007bff 0%, #0062cc 100%);
        }

        .stat-card h3 {
            margin: 0 0 15px;
            font-size: 16px;
            color: #6c757d;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-card h3 i {
            font-size: 1.2em;
            color: #007bff;
        }

        .stat-card .value {
            font-size: 28px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 10px;
        }

        .stat-card .change {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }

        .stat-card .change.positive {
            color: #28a745;
        }

        .stat-card .change.negative {
            color: #dc3545;
        }

        .charts-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .chart-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: 1px solid rgba(0,123,255,0.1);
            min-width: 0;
        }

        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,123,255,0.1);
        }

        .chart-card h2 {
            margin: 0 0 20px;
            font-size: 18px;
            color: #007bff;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(0,123,255,0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .chart-card h2 i {
            font-size: 1.2em;
            color: #007bff;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
            min-width: 0;
        }

        .data-table-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: 1px solid rgba(0,123,255,0.1);
        }

        .data-table-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,123,255,0.1);
        }

        .data-table-card h2 {
            margin: 0 0 20px;
            font-size: 18px;
            color: #007bff;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(0,123,255,0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .data-table-card h2 i {
            font-size: 1.2em;
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: rgba(0,123,255,0.05);
            color: #007bff;
            font-weight: 500;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid rgba(0,123,255,0.1);
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid rgba(0,123,255,0.05);
            color: #495057;
        }

        tr:hover td {
            background-color: rgba(0,123,255,0.03);
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-badge.active {
            background-color: rgba(40,167,69,0.1);
            color: #28a745;
        }

        .status-badge.inactive {
            background-color: rgba(220,53,69,0.1);
            color: #dc3545;
        }

        .status-badge.warning {
            background-color: rgba(255,193,7,0.1);
            color: #ffc107;
        }

        .footer {
            padding: 0 25px 25px;
        }
        
        .copyright-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,123,255,0.1);
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .copyright-card a {
            color: #007bff;
            text-decoration: none;
            transition: all 0.3s;
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
        
        .copyright-links a {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
</head>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const dashboard = document.querySelector('.dashboard');
    const chartsContainer = document.querySelector('.charts-container');
    
    sidebar.addEventListener('mouseenter', function() {
        this.style.width = '250px';
        dashboard.style.marginLeft = '250px';
        chartsContainer.style.gridTemplateColumns = '1.2fr 0.8fr';
    });
    
    sidebar.addEventListener('mouseleave', function() {
        this.style.width = '80px';
        dashboard.style.marginLeft = '80px';
        chartsContainer.style.gridTemplateColumns = '1fr 1fr';
    });
    
    // 时间筛选按钮
    const timeButtons = document.querySelectorAll('.time-filter button');
    timeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            timeButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // 默认选中"本月"
    document.querySelector('.time-filter button:nth-child(3)').classList.add('active');
});
</script>
<body>
<?php echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/frontend/component/sidebar.html"); ?>
    <div class="dashboard">
        <header class="header">
            <h1><i class="fas fa-chart-bar"></i> VPN 数据统计</h1>
        </header>
        <div class="stats-header">
            <h2>数据概览</h2>
            <div class="time-filter">
                <button>今日</button>
                <button>本周</button>
                <button>本月</button>
                <button>全年</button>
                <button>自定义</button>
            </div>
        </div>
        <main class="main-content">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3><i class="fas fa-users"></i> 活跃用户</h3>
                    <div class="value">1,248</div>
                    <div class="change positive">
                        <i class="fas fa-arrow-up"></i> 12.5% 较上月
                    </div>
                </div>
                <div class="stat-card">
                    <h3><i class="fas fa-server"></i> 在线服务器</h3>
                    <div class="value">28</div>
                    <div class="value">
                        <span style="font-size: 16px; color: #6c757d;">负载: </span>
                        <span style="color: #28a745;">62%</span>
                    </div>
                </div>
                <div class="stat-card">
                    <h3><i class="fas fa-network-wired"></i> 总流量</h3>
                    <div class="value">4.2 TB</div>
                    <div class="change positive">
                        <i class="fas fa-arrow-up"></i> 23.8% 较上月
                    </div>
                </div>
                <div class="stat-card">
                    <h3><i class="fas fa-shield-alt"></i> 拦截攻击</h3>
                    <div class="value">1,842</div>
                    <div class="change negative">
                        <i class="fas fa-arrow-down"></i> 8.3% 较上月
                    </div>
                </div>
            </div>
            
            <div class="charts-container">
                <div class="chart-card">
                    <h2><i class="fas fa-chart-line"></i> 流量趋势</h2>
                    <div class="chart-container">
                        <canvas id="trafficChart"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <h2><i class="fas fa-chart-pie"></i> 流量分布</h2>
                    <div class="chart-container">
                        <canvas id="trafficDistributionChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="data-table-card">
                <h2><i class="fas fa-list-ol"></i> 服务器状态</h2>
                <table>
                    <thead>
                        <tr>
                            <th>服务器名称</th>
                            <th>位置</th>
                            <th>状态</th>
                            <th>在线用户</th>
                            <th>流量</th>
                            <th>负载</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>US-NY-01</td>
                            <td>纽约, 美国</td>
                            <td><span class="status-badge active">运行中</span></td>
                            <td>142</td>
                            <td>324 GB</td>
                            <td>58%</td>
                        </tr>
                        <tr>
                            <td>UK-LN-01</td>
                            <td>伦敦, 英国</td>
                            <td><span class="status-badge active">运行中</span></td>
                            <td>98</td>
                            <td>278 GB</td>
                            <td>45%</td>
                        </tr>
                        <tr>
                            <td>JP-TK-01</td>
                            <td>东京, 日本</td>
                            <td><span class="status-badge active">运行中</span></td>
                            <td>87</td>
                            <td>196 GB</td>
                            <td>52%</td>
                        </tr>
                        <tr>
                            <td>DE-FR-01</td>
                            <td>法兰克福, 德国</td>
                            <td><span class="status-badge warning">维护中</span></td>
                            <td>0</td>
                            <td>0 GB</td>
                            <td>0%</td>
                        </tr>
                        <tr>
                            <td>SG-SG-01</td>
                            <td>新加坡</td>
                            <td><span class="status-badge active">运行中</span></td>
                            <td>76</td>
                            <td>215 GB</td>
                            <td>68%</td>
                        </tr>
                    </tbody>
                </table>
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
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script>
    // 流量趋势图
    const trafficChart = new Chart(
        document.getElementById('trafficChart').getContext('2d'),
        {
            type: 'line',
            data: {
                labels: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                datasets: [
                    {
                        label: '流入流量 (TB)',
                        data: [1.2, 1.5, 1.8, 2.1, 2.3, 2.6, 2.9, 3.2, 3.5, 3.8, 4.1, 4.2],
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: '流出流量 (TB)',
                        data: [0.8, 1.0, 1.2, 1.4, 1.6, 1.8, 2.0, 2.2, 2.4, 2.6, 2.8, 3.0],
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        }
    );
    
    // 流量分布图
    const distributionChart = new Chart(
        document.getElementById('trafficDistributionChart').getContext('2d'),
        {
            type: 'doughnut',
            data: {
                labels: ['美国', '英国', '日本', '德国', '新加坡', '其他'],
                datasets: [{
                    data: [35, 20, 15, 12, 10, 8],
                    backgroundColor: [
                        '#007bff',
                        '#28a745',
                        '#ffc107',
                        '#dc3545',
                        '#17a2b8',
                        '#6c757d'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        }
    );

    // 窗口大小变化时重绘图表
    window.addEventListener('resize', function() {
        trafficChart.resize();
        distributionChart.resize();
    });
    </script>
</body>
</html>
