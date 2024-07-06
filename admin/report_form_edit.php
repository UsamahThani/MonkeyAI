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
    $report_id = $_GET['reportId'];
    // Fetch report data
    $report_query = "SELECT report_location, report_date, report_time, report_context, report_admin FROM report WHERE report_id = '$report_id'";
    $report_result = mysqli_query($connect, $report_query);

    if ($report_result) {
        $report_row = mysqli_fetch_array($report_result);

    }
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
		<link rel="stylesheet" type="text/css" href="vendors/styles/form.css" />

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
					<h2 class="h3 mb-0">Monkey Detection Report</h2>
				</div>

                <div class="card-box mb-30">
				<h2 class="h4 pd-20">Report Form</h2>
				<div class="data-table table nowrap form-report">
					
                    <form method="post" action="function_report_edit.php">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Admin Name</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control" name="admin_name" type="text" wfd-id="id26" value="<?php echo $report_row['report_admin']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Location</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control" name="location" type="text" value="<?php echo $report_row['report_location']; ?>" wfd-id="id26">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Date</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control date-picker" name="date" placeholder="Select Date" type="text" value="<?php echo $report_row['report_date']; ?>" wfd-id="id34">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Time</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control time-picker td-input" name="time" placeholder="Select time" value="<?php echo $report_row['report_time']; ?>" type="text" readonly="" wfd-id="id36">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Note</label>
                            <div class="col-sm-12 col-md-10">
                                <textarea class="form-control" name="note"><?php echo $report_row['report_context']; ?></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
                        <div class="form-submit">
                            <input class="btn btn-primary" type="submit" value="Update">
                        </div>
                    </form>
							
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
        <script>
            // Wait for the document to load
            document.addEventListener("DOMContentLoaded", function() {
                // Get today's date
                var today = new Date();

                // Define months array for month names
                var months = ["January", "February", "March", "April", "May", "June",
                            "July", "August", "September", "October", "November", "December"];

                // Format the date as "DD Month YYYY"
                var formattedDate = today.getDate() + " " + months[today.getMonth()] + " " + today.getFullYear();

                // Set the value of the date picker input field
                document.getElementById("datepicker").value = formattedDate;
            });
        </script>
	</body>
</html>
