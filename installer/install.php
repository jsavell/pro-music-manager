<?php
error_reporting (0);

if (!empty($_POST['dbimport'])) {
	$dbConfig = $_POST['dbimport'];
	$filename = "musicmanager.sql";
	if (is_file($filename)) {
		$command='mysql --protocol=TCP -h ' .$dbConfig['host'].' -u '.$dbConfig['user'].' '.$dbConfig['password'].' '.$dbConfig['database'].' < '.$filename;
		exec($command,$output=array(),$worked);
		switch($worked){
		    case 0:
		        echo 'Database successfully built!';
		        break;
		    case 1:
		        echo 'There was an error building the database...';
		        break;
		}
	} else {
		echo "Couldn't find the import SQL file";
	}
} elseif (!empty($_POST['dbconfig'])) {
	$dsn = 'mysql:host='.$_POST['dbconfig']['host'].';dbname='.$_POST['dbconfig']['database'];
	$opt = array(
	    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);
    try {
		$handle = new PDO($dsn, $_POST['dbconfig']['user'], $_POST['dbconfig']['password'],$opt);
		echo json_encode(array("result"=>1));
	} catch (PDOException $e) {
		echo json_encode(array("result"=>$e->getMessage()));
	}
} else {
?>
<html>
	<head>
		<style type="text/css">
			input,label {
				display: block;
				margin: 8px;
				padding: 12px;
			}
			.column {
				display: inline-block;
				vertical-align: top;
				width: 200px;
				margin: 20px;
			}

			.hidden {
				display: none;
			}
		</style>
		<script type="text/javascript" src="../_application/js/jquery.min.js"></script>
	<head>
	<body>
		<form class="column" id="doInstaller" name="installer" method="POST">
			<label for="dbconfig[host]">Host</label>
			<input id="dbConfigHost" type="text" name="dbconfig[host]" />
			<label for="dbconfig[host]">Database Name</label>
			<input id="dbConfigDataBase" type="text" name="dbconfig[database]" />
			<label for="dbconfig[host]">User</label>
			<input id="dbConfigUser" type="text" name="dbconfig[user]" />
			<label for="dbconfig[host]">Password</label>
			<input id="dbConfigPassword" type="password" name="dbconfig[password]" />
			<input type="submit" name="submitconfig" value="Test Connection" />
		</form>
		<div class="column">
			<h4>DB Test Results:</h4>
			<div id="dbResults"></div>
			<form class="hidden" id="dbImport" name="importer" method="POST">
				<input id="dbImportHost" type="hidden" name="dbimport[host]" />
				<input id="dbImportDataBase" type="hidden" name="dbimport[database]" />
				<input id="dbImportUser" type="hidden" name="dbimport[user]" />
				<input id="dbImportPassword" type="hidden" name="dbimport[password]" />
				<input type="submit" name="submitconfig" value="Build Database Tables" />
			</form>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#doInstaller").submit(function() {
					flag = false;
					$(this).children("input").each(function() {
						if (!$(this).val() && $(this).attr("type") != 'password') {
							flag = true;
							return false;
						}
					});

					if (!flag) {
						$.ajax({type:"POST",url:"<?php echo $_SERVER['PHP_SELF'];?>",data:$(this).serialize()}).done(function(data) {
							if (data) {
								test = JSON.parse(data);
								if (test.result == 1) {
									$("#dbImportHost").val($("#dbConfigHost").val());
									$("#dbImportDataBase").val($("#dbConfigDataBase").val());
									$("#dbImportUser").val($("#dbConfigUser").val());
									$("#dbImportPassword").val($("#dbConfigPassword").val());
									message = "DB connection successful!";
									$("#dbImport").fadeIn("fast");
								} else {
									message = "Error connecting to the DB: "+test.result;
									$("#dbImport").fadeOut("fast");
								}
								$("#dbResults").html(message);
							} else {
								$("#dbResults").html("HTTP Error. Try again?");
							}
						});
					} else {
						alert("The Installer needs to know your MySQL host,Database name, user, and password");
					}
					return false;
				});
			});
		</script>
	</body>
</html>
<?php
}
?>