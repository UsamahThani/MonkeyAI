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

	// Fetch report data
    $studentQuery = "SELECT * FROM user";
    $studentResult = mysqli_query($connect, $studentQuery);

	$adminQuery = "SELECT * FROM admin";
	$adminResult = mysqli_query($connect, $adminQuery);
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
		<link rel="stylesheet" type="text/css" href="vendors/styles/form.css"/>

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
				<div
					class="search-toggle-icon bi bi-search"
					data-toggle="header_search"
				></div>
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
							<span class="user-name"><?php echo $admin_name ?></span>
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
					<img src="../images/monkeylogo.jpg" alt="" class="dark-logo" />
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
					<h2 class="h3 mb-0">User Management Page</h2>
				</div>
				<div class="card-box mb-30">
                    <div class="pd-20 flex-btn">
                        <h4 class="text-blue h4">List of Student</h4>
                    </div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">No</th>
									<th>Student Name</th>
									<th>Email</th>
									<th>Phone Number</th>
									<th class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if ($studentResult->num_rows > 0) {
									$counter = 1;
									while ($student_row = $studentResult->fetch_assoc()) {
										?>
										<tr>
											<td class="table-plus"><?php echo $counter ?></td>
											<td><?php echo $student_row['user_name']; ?></td>
											<td><?php echo $student_row['user_email']; ?></td>
											<td><?php echo $student_row['user_phonum']; ?></td>
											<td>
												<div class="dropdown">
													<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
														<i class="dw dw-more"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
														<a class="dropdown-item" href="user_form_edit.php?userId=<?php echo $student_row['user_id']; ?>"><i class="dw dw-edit2"></i> Edit</a>
														<a class="dropdown-item" href="function_user_delete.php?userId=<?php echo $student_row['user_id']; ?>&userType=student"><i class="dw dw-delete-3"></i> Delete</a>
													</div>
												</div>
											</td>
										</tr>
										<?php
										$counter++;
									}
								} else {
									echo "<tr><td colspan='7'>No students found</td></tr>";
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="card-box mb-30">
                    <div class="pd-20 flex-btn">
                        <h4 class="text-blue h4">List of Admin</h4>
						<a href="admin_register.php" class="btn btn-info">Add Admin</a>
                    </div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">No</th>
									<th>Admin Name</th>
									<th>Email</th>
									<th class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if ($adminResult->num_rows > 0) {
									$counter = 1;
									while ($admin_row = $adminResult->fetch_assoc()) {
										?>
										<tr>
											<td class="table-plus"><?php echo $counter ?></td>
											<td><?php echo $admin_row['admin_name']; ?></td>
											<td><?php echo $admin_row['admin_email']; ?></td>
											<td>
												<div class="dropdown">
													<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
														<i class="dw dw-more"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
														<a class="dropdown-item" href="admin_form_edit.php?userId=<?php echo $admin_row['admin_id']; ?>"><i class="dw dw-edit2"></i> Edit</a>
														<a class="dropdown-item" href="function_user_delete.php?userId=<?php echo $admin_row['admin_id']; ?>&userType=admin"><i class="dw dw-delete-3"></i> Delete</a>
													</div>
												</div>
											</td>
										</tr>
										<?php
										$counter++;
									}
								} else {
									echo "<tr><td colspan='7'>No admins found</td></tr>";
								}
								?>
							</tbody>
						</table>
					</div>
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
