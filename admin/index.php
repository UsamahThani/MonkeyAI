<?php
    session_start();
    require "../dbconnect.php";
    
    // Check if admin_id is set in session
    if (isset($_SESSION['user_id'])) {
        $admin_id = $_SESSION['user_id'];

        // Prepare query to fetch admin_name and admin_image based on admin_id
        $query = "SELECT admin_name, admin_img FROM admin WHERE admin_id = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $admin_name = $row['admin_name'];
            $admin_image = "../images/profile_img/" . $row['admin_img'];
        } else {
            // Handle case where admin is not found
            $admin_name = "Admin not found";
            $admin_image = "../images/profile_img/default_proImg.jpg"; // Default image path
        }
    } else {
        // Handle case where admin ID is not set in session
        $admin_name = "Admin ID not set in session";
        $admin_image = "../images/profile_img/default_proImg.jpg"; // Default image path
    }

	// Count the number of reports
	$query_reports = "SELECT COUNT(*) as count FROM report";
	$result_reports = $connect->query($query_reports);
	$row_reports = $result_reports->fetch_assoc();
	$count_reports = $row_reports['count'];

	// Count the number of users
	$query_users = "SELECT COUNT(*) as count FROM user";
	$result_users = $connect->query($query_users);
	$row_users = $result_users->fetch_assoc();
	$count_users = $row_users['count'];

	// Count the number of admins
	$query_admins = "SELECT COUNT(*) as count FROM admin";
	$result_admins = $connect->query($query_admins);
	$row_admins = $result_admins->fetch_assoc();
	$count_admins = $row_admins['count'];

	// Query to count reports per date
	$query_reports_per_date = "SELECT report_date, COUNT(*) as count FROM report GROUP BY report_date ORDER BY report_date";
	$result_reports_per_date = $connect->query($query_reports_per_date);

	// Prepare data for JavaScript (JSON format)
	$chart_data = [];
	while ($row = $result_reports_per_date->fetch_assoc()) {
		$chart_data[] = [
			'date' => $row['report_date'],
			'count' => intval($row['count'])
		];
	}

	// Convert PHP array to JSON format for JavaScript
	$chart_data_json = json_encode($chart_data);
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>Monkey AI - Admin Dashboard</title>

		<!-- Site favicon -->
		<link
			rel="apple-touch-icon"
			sizes="180x180"
			href="vendors/images/apple-touch-icon.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="vendors/images/favicon-32x32.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="vendors/images/favicon-16x16.png"
		/>

		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="vendors/styles/core.css" />
		<link
			rel="stylesheet"
			type="text/css"
			href="vendors/styles/icon-font.min.css"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="src/plugins/datatables/css/dataTables.bootstrap4.min.css"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="src/plugins/datatables/css/responsive.bootstrap4.min.css"
		/>
		<link rel="stylesheet" type="text/css" href="vendors/styles/style.css" />

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script
			async
			src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"
		></script>
		<script
			async
			src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
			crossorigin="anonymous"
		></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag() {
				dataLayer.push(arguments);
			}
			gtag("js", new Date());

			gtag("config", "G-GBZ3SGGX85");
		</script>
		<!-- Google Tag Manager -->
		<script>
			(function (w, d, s, l, i) {
				w[l] = w[l] || [];
				w[l].push({ "gtm.start": new Date().getTime(), event: "gtm.js" });
				var f = d.getElementsByTagName(s)[0],
					j = d.createElement(s),
					dl = l != "dataLayer" ? "&l=" + l : "";
				j.async = true;
				j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
				f.parentNode.insertBefore(j, f);
			})(window, document, "script", "dataLayer", "GTM-NXZMQSS");
		</script>
		<!-- End Google Tag Manager -->
	</head>
	<body>
		<!-- <div class="pre-loader">
			<div class="pre-loader-box">
				<div class="loader-logo">
					<img src="../images/monkeylogo.jpg" alt="" />
				</div>
				<div class="loader-progress" id="progress_div">
					<div class="bar" id="bar1"></div>
				</div>
				<div class="percent" id="percent1">0%</div>
				<div class="loading-text">Loading...</div>
			</div>
		</div> -->

		<div class="header">
			<div class="header-left">
				<div class="menu-icon bi bi-list"></div>
			</div>
			<div class="header-right">
				<div class="user-info-dropdown">
					<div class="dropdown">
						<a
							class="dropdown-toggle"
							href="#"
							role="button"
							data-toggle="dropdown"
						>
							<span class="user-icon">
								<img src="<?php echo $admin_image ?>" alt="" />
							</span>
							<span class="user-name"><?php echo $admin_name?></span>
						</a>
						<div
							class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
						>
							<a class="dropdown-item" href="../function_logout.php"
								><i class="dw dw-logout"></i> Log Out</a
							>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="left-side-bar">
			<div class="brand-logo">
				<a href="index.php">
					<img src="../images/monkeyailogo.png" alt="" class="dark-logo" />
					<img
						src="../images/monkeyailogo.png"
						alt=""
						class="light-logo"
					/>
				</a>
				<div class="close-sidebar" data-toggle="left-sidebar-close">
					<i class="ion-close-round"></i>
				</div>
			</div>
			<div class="menu-block customscroll">
				<div class="sidebar-menu">
					<ul id="accordion-menu">
						<li class="dropdown">
							<a href="index.php" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-house"></span
								><span class="mtext">Dashboard</span>
							</a>
						</li>
						<li class="dropdown">
							<a href="report.php" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-file-earmark-text"></span
								><span class="mtext">Report</span>
							</a>
						</li>
						<li>
							<a href="usermanagement.php" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-diagram-3"></span
								><span class="mtext">User Management</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			<div class="xs-pd-20-10 pd-ltr-20">
				<div class="title pb-20">
					<h2 class="h3 mb-0">Monkey AI Overview</h2>
				</div>

				<div class="row pb-10">
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark"><?php echo $count_reports ?></div>
									<div class="font-14 text-secondary weight-500">
										Report
									</div>
								</div>
								<div class="widget-icon">
									<div class="icon" data-color="#00eccf">
										<i class="icon-copy dw dw-calendar1"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark"><?php echo $count_users ?></div>
									<div class="font-14 text-secondary weight-500">
										Total User
									</div>
								</div>
								<div class="widget-icon">
									<div class="icon" data-color="#ff5b5b">
										<span class="icon-copy ti-heart"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark"><?php echo $count_admins ?></div>
									<div class="font-14 text-secondary weight-500">
										Total Admin
									</div>
								</div>
								<div class="widget-icon">
									<div class="icon">
                                        <i class="icon-copy fa fa-user-o" aria-hidden="true"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark" style="color:'green';">Active</div>
									<div class="font-14 text-secondary weight-500">
										Monkey AI
									</div>
								</div>
								<div class="widget-icon">
									<div class="icon">
										<i class="icon-copy dw dw-monkey"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="bg-white pd-20 card-box mb-30">
					<h4 class="h4 text-blue">Monkey Spotted Chart</h4>
					<div id="chart1"></div>
				</div>
				
			</div>
		</div>

		<!-- js -->
		<script src="vendors/scripts/core.js"></script>
		<script src="vendors/scripts/script.min.js"></script>
		<script src="vendors/scripts/process.js"></script>
		<script src="vendors/scripts/layout-settings.js"></script>
		<script src="src/plugins/apexcharts/apexcharts.min.js"></script>
		<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
		<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
		<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
		<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
		<script src="vendors/scripts/dashboard3.js"></script>

		<script>
        // Chart data from PHP
        var chartData = <?php echo $chart_data_json; ?>;

        // Prepare data for ApexCharts format
        var chartOptions = {
            series: [{
                name: 'Reports',
                data: chartData.map(item => item.count)
            }],
            chart: {
                height: 350,
                type: 'line',
                toolbar: {
                    show: true,
					tools: {
						selection:false
					}
                }
            },
            grid: {
                show: true,
                padding: {
                    left: 0,
                    right: 0
                }
            },
            stroke: {
                width: 7,
                curve: 'smooth'
            },
            xaxis: {
                type: 'datetime',
                categories: chartData.map(item => item.date),
                labels: {
                    rotate: -45,
                    format: 'yyyy-MM-dd'
                }
            },
            title: {
                text: 'Reports per Date',
                align: 'left',
                style: {
                    fontSize: "16px",
                    color: '#666'
                }
            },
            markers: {
                size: 4,
                colors: ["#FFA41B"],
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            },
            yaxis: {
                min: 0,
                title: {
                    text: 'Number of Reports'
                }
            }
        };

        // Initialize the chart with ApexCharts
        var chart = new ApexCharts(document.querySelector("#chart1"), chartOptions);
        chart.render();
    </script>
		<!-- Google Tag Manager (noscript) -->
		<noscript
			><iframe
				src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS"
				height="0"
				width="0"
				style="display: none; visibility: hidden"
			></iframe
		></noscript>
		<!-- End Google Tag Manager (noscript) -->
	</body>
</html>
