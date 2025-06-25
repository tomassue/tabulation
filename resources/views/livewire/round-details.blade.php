<section class="section quiz">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Score</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="20%">Question #</th>
                                             <th scope="col" width="20%">ROUND</th>
                                            <th scope="col">Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Mark</td>
                                            <td>Mark</td>
                                            <td>@mdo</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Vertical Form -->
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-4">
                                        <form class="g-3 mt-3">
                                        <div class="mb-3">
                                            <label for="inputNanme4" class="form-label">Question #</label>
                                            <select name="" id="" class="form-select" id="">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputPassword4" class="form-label">Score</label>
                                            <input type="number" class="form-control" id="inputPassword4">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                            <button type="reset" class="btn btn-secondary">Reset</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="container">
        <!-- Header -->
        <div class="header text-center">
            <h1 class="mb-3"><i class="fas fa-table me-2"></i>Fixed First Column Table</h1>
            <p class="lead mb-4">Keep your reference data visible while scrolling through large datasets</p>
            <div class="d-flex justify-content-center">
                <div class="scroll-hint">
                    <i class="fas fa-arrow-right me-2"></i> Scroll horizontally to view all columns
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Table Card -->
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-database me-3"></i>
                        Employee Performance Dashboard
                    </div>
                    <div class="card-body p-0">
                        <div class="table-container">
                            <table class="table table-hover fixed-column-table">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Department</th>
                                        <th>Position</th>
                                        <th>Q1 Projects</th>
                                        <th>Q2 Projects</th>
                                        <th>Completion Rate</th>
                                        <th>Client Rating</th>
                                        <th>Status</th>
                                        <th>Training Hours</th>
                                        <th>Performance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sarah Johnson</td>
                                        <td>Engineering</td>
                                        <td>Senior Developer</td>
                                        <td>8</td>
                                        <td>12</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: 92%"></div>
                                            </div>
                                            <small>92%</small>
                                        </td>
                                        <td>4.8/5.0</td>
                                        <td><span class="status-badge badge-active">Active</span></td>
                                        <td>45</td>
                                        <td>Excellent</td>
                                    </tr>
                                    <tr>
                                        <td>Michael Chen</td>
                                        <td>Marketing</td>
                                        <td>Campaign Manager</td>
                                        <td>5</td>
                                        <td>7</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: 88%"></div>
                                            </div>
                                            <small>88%</small>
                                        </td>
                                        <td>4.6/5.0</td>
                                        <td><span class="status-badge badge-active">Active</span></td>
                                        <td>32</td>
                                        <td>Very Good</td>
                                    </tr>
                                    <tr>
                                        <td>Emma Rodriguez</td>
                                        <td>Sales</td>
                                        <td>Account Executive</td>
                                        <td>15</td>
                                        <td>18</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: 95%"></div>
                                            </div>
                                            <small>95%</small>
                                        </td>
                                        <td>4.9/5.0</td>
                                        <td><span class="status-badge badge-completed">Completed</span></td>
                                        <td>28</td>
                                        <td>Outstanding</td>
                                    </tr>
                                    <tr>
                                        <td>David Kim</td>
                                        <td>HR</td>
                                        <td>Recruitment Lead</td>
                                        <td>6</td>
                                        <td>9</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" style="width: 78%"></div>
                                            </div>
                                            <small>78%</small>
                                        </td>
                                        <td>4.3/5.0</td>
                                        <td><span class="status-badge badge-pending">Pending</span></td>
                                        <td>40</td>
                                        <td>Good</td>
                                    </tr>
                                    <tr>
                                        <td>Olivia Smith</td>
                                        <td>Finance</td>
                                        <td>Financial Analyst</td>
                                        <td>7</td>
                                        <td>10</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: 91%"></div>
                                            </div>
                                            <small>91%</small>
                                        </td>
                                        <td>4.7/5.0</td>
                                        <td><span class="status-badge badge-active">Active</span></td>
                                        <td>36</td>
                                        <td>Excellent</td>
                                    </tr>
                                    <tr>
                                        <td>James Wilson</td>
                                        <td>Engineering</td>
                                        <td>DevOps Engineer</td>
                                        <td>9</td>
                                        <td>14</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: 89%"></div>
                                            </div>
                                            <small>89%</small>
                                        </td>
                                        <td>4.5/5.0</td>
                                        <td><span class="status-badge badge-completed">Completed</span></td>
                                        <td>50</td>
                                        <td>Very Good</td>
                                    </tr>
                                    <tr>
                                        <td>Sophia Martinez</td>
                                        <td>Customer Support</td>
                                        <td>Support Manager</td>
                                        <td>4</td>
                                        <td>6</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" style="width: 75%"></div>
                                            </div>
                                            <small>75%</small>
                                        </td>
                                        <td>4.2/5.0</td>
                                        <td><span class="status-badge badge-pending">Pending</span></td>
                                        <td>25</td>
                                        <td>Good</td>
                                    </tr>
                                    <tr>
                                        <td>Daniel Brown</td>
                                        <td>Product</td>
                                        <td>Product Manager</td>
                                        <td>3</td>
                                        <td>5</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: 84%"></div>
                                            </div>
                                            <small>84%</small>
                                        </td>
                                        <td>4.6/5.0</td>
                                        <td><span class="status-badge badge-active">Active</span></td>
                                        <td>42</td>
                                        <td>Very Good</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Features Section -->
                <div class="features mb-4">
                    <h3 class="mb-4"><i class="fas fa-star me-2"></i>Key Features</h3>
                    <div class="row">
                        <div class="col-md-6 col-lg-12 mb-4">
                            <div class="feature-card">
                                <div class="d-flex align-items-center">
                                    <div class="feature-icon">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5>Fixed First Column</h5>
                                        <p class="mb-0">Key identifier remains visible during horizontal scrolling</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12 mb-4">
                            <div class="feature-card">
                                <div class="d-flex align-items-center">
                                    <div class="feature-icon">
                                        <i class="fas fa-arrows-alt-h"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5>Horizontal Scrolling</h5>
                                        <p class="mb-0">Easily navigate through large datasets</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12 mb-4">
                            <div class="feature-card">
                                <div class="d-flex align-items-center">
                                    <div class="feature-icon">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5>Fully Responsive</h5>
                                        <p class="mb-0">Works on all device sizes</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12">
                            <div class="feature-card">
                                <div class="d-flex align-items-center">
                                    <div class="feature-icon">
                                        <i class="fas fa-paint-brush"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5>Modern Design</h5>
                                        <p class="mb-0">Clean UI with visual indicators</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Instructions -->
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-info-circle me-3"></i>
                        Implementation Guide
                    </div>
                    <div class="card-body">
                        <ol class="mb-0">
                            <li class="mb-2">Create a container with <code>overflow: auto</code></li>
                            <li class="mb-2">Set <code>position: sticky</code> and <code>left: 0</code> for the first column</li>
                            <li class="mb-2">Add <code>z-index</code> to ensure proper layering</li>
                            <li class="mb-2">Use <code>min-width</code> for scrollable columns</li>
                            <li class="mb-2">Add background color for fixed column visibility</li>
                            <li>Include visual feedback for hover states</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p class="mb-0">Fixed First Column Table with Horizontal Scrolling | Built with Bootstrap 5</p>
        </div>
    </div>
</section>
@assets
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --dark-text: #212529;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: var(--dark-text);
            min-height: 100vh;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .header {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
        
        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            border: none;
            margin-bottom: 30px;
        }
        
        .card-header {
            background: linear-gradient(90deg, var(--secondary-color), #560bad);
            color: white;
            padding: 20px;
            font-weight: 600;
            font-size: 1.4rem;
        }
        
        .table-container {
            position: relative;
            overflow: auto;
            max-height: 600px;
        }
        
        .fixed-column-table {
            min-width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .fixed-column-table th,
        .fixed-column-table td {
            padding: 16px 20px;
            vertical-align: middle;
            border-top: 1px solid #e0e0e0;
        }
        
        .fixed-column-table thead th {
            background: linear-gradient(to bottom, #4a6fc5, #1a2a6c);
            color: white;
            position: sticky;
            top: 0;
            z-index: 10;
            font-weight: 600;
            border: none;
        }
        
        .fixed-column-table tbody tr:nth-child(even) {
            background-color: rgba(67, 97, 238, 0.03);
        }
        
        .fixed-column-table tbody tr:hover {
            background-color: rgba(76, 201, 240, 0.08);
            transition: background-color 0.3s;
        }
        
        /* Fixed first column */
        .fixed-column-table th:first-child,
        .fixed-column-table td:first-child {
            position: sticky;
            left: 0;
            z-index: 5;
            background: linear-gradient(to right, #3f37c9, #4361ee);
            color: white;
            min-width: 180px;
            font-weight: 600;
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
        }
        
        .fixed-column-table td:first-child {
            background: #4a6fc5;
        }
        
        /* Scrollable columns */
        .fixed-column-table th:not(:first-child),
        .fixed-column-table td:not(:first-child) {
            min-width: 200px;
        }
        
        /* Status badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .badge-active {
            background: linear-gradient(90deg, #4ade80, #22c55e);
            color: white;
        }
        
        .badge-pending {
            background: linear-gradient(90deg, #fcd34d, #f59e0b);
            color: white;
        }
        
        .badge-completed {
            background: linear-gradient(90deg, #60a5fa, #3b82f6);
            color: white;
        }
        
        .progress {
            height: 10px;
            border-radius: 5px;
        }
        
        .scroll-hint {
            background: var(--primary-color);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            margin-top: 15px;
            font-size: 0.9rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 0.8; }
            50% { opacity: 1; }
            100% { opacity: 0.8; }
        }
        
        .features {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }
        
        .feature-card {
            transition: transform 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .footer {
            text-align: center;
            padding: 25px;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .fixed-column-table th,
            .fixed-column-table td {
                padding: 12px 15px;
                font-size: 0.9rem;
            }
            
            .fixed-column-table th:first-child,
            .fixed-column-table td:first-child {
                min-width: 150px;
            }
            
            .header h1 {
                font-size: 1.8rem;
            }
        }
    </style>
@endassets