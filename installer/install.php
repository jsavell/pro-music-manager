<?php
/*todo: 
 create db after testing connection
 create db user after building tables
 make it easy to get to login screen after app is configured
make it pretty
*/
error_reporting (0);
if (!empty($_POST['config'])) {
	$config = $_POST['config'];
	$config['path_http'] = $config['path_http'].$config['app_dir'].'/';
	$config['path_file'] = $config['path_root'].$config['app_dir'].'/';
	$config['path_app'] = "{$config['path_file']}_application/";
	$config['path_lib'] = "{$config['path_app']}lib/";
	$config['path_classes'] = "{$config['path_app']}classes/";
	$config['path_controllers'] = "{$config['path_app']}controllers/";
	$config['path_views'] = "{$config['path_app']}views/";
	$config['path_css'] = "{$config['path_http']}_application/css/";
	$config['path_js'] = "{$config['path_http']}_application/js/";
	$config['path_images'] = "{$config['path_http']}_application/images/";
	$filename = $config['path_app']."/config/config.json";
	if (file_put_contents($filename, json_encode($config))) {
		$result = 1;
	} else {
		$result = 0;
	}
	echo json_encode(array("result"=>$result));
} elseif (!empty($_POST['dbimport'])) {
	$dbConfig = $_POST['dbimport'];
	$filename = "musicmanager.sql";
	if (is_file($filename)) {
		$command='mysql --protocol=TCP -h ' .$dbConfig['host'].' -u '.$dbConfig['user'].' '.$dbConfig['password'].' '.$dbConfig['database'].' < '.$filename;
		exec($command,$output=array(),$result);
		echo json_encode(array("result"=>$result));
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
			html, body {
				margin: 0px;
				padding: 0px;
				font-family: Arial;
			}

			body {
				background-color: #efefef;
			}

			h4 {
				margin-bottom: 8px;
			}

			input,label {
				display: block;
				margin: 8px 8px 0px 8px;
				padding: 12px;
			}

			label {
				padding-bottom: 4px;
			}

			input {
				margin-top: 4px;
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

			#dbResults {
				border: 1px solid #000;
				background-color: #fff;
				margin-top: 24px;
				padding: 10px;
				height: 300px;
				overflow-y: auto;
				font-family: Consolas, Menlo, Monaco, Lucida Console, Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono, monospace, serif;
			}
		</style>
		<script type="text/javascript" src="../_application/js/jquery.min.js"></script>
	<head>
	<body>
		<div class="column">
			<h4>Install Operation Results:</h4>
			<div id="dbResults"></div>
		</div>
		<div class="column">
			<form id="dbInstaller" name="installer" method="POST">
				<h4>Configure DB:</h4>
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
		</div>
		<div class="column">
			<h4>Build DB:</h4>
			<form class="hidden" id="dbImport" name="importer" method="POST">
				<input id="dbImportHost" type="hidden" name="dbimport[host]" />
				<input id="dbImportDataBase" type="hidden" name="dbimport[database]" />
				<input id="dbImportUser" type="hidden" name="dbimport[user]" />
				<input id="dbImportPassword" type="hidden" name="dbimport[password]" />
				<input type="submit" name="submitconfig" value="Build Database Tables" />
			</form>
		</div>
		<div class="column">
			<h4>Configure App:</h4>
			<form class="hidden" id="configApp" name="configapp" method="POST">
				<label for="config[path_root]">Document Root</label>
				<input type="text" name="config[path_root]" />
				<label for="config[path_http]">Base Domain</label>
				<input type="text" name="config[path_http]" />
				<label for="config[app_dir]">App Directory</label>
				<input type="text" name="config[app_dir]" />
				<input type="hidden" name="config[title]" value="Pro Music Manager" />
				<input id="configHost" type="hidden" name="config[db][host]" />
				<input id="configDataBase" type="hidden" name="config[db][database]" />
				<input id="configUser" type="hidden" name="config[db][user]" />
				<input id="configPassword" type="hidden" name="config[db][password]" />
				<input type="submit" name="submitconfig" value="Generate Config File" />
			</form>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#configApp").submit(function() {
					$.ajax({type:"POST",url:"<?php echo $_SERVER['PHP_SELF'];?>",data:$(this).serialize()}).done(function(data) {
						if (data) {
							var imported = JSON.parse(data);
							if (parseInt(imported.result) == 1) {
								message = "Configuration file generated!";
								$("#configApp").fadeOut("fast");
							} else {
								message = "There was an error building the configuration file...";
							}
							$("#dbResults").html(message);
						} else {
							$("#dbResults").html("HTTP Error. Try again?");
						}
					});
					return false;
				});

				$("#dbImport").submit(function() {
					$.ajax({type:"POST",url:"<?php echo $_SERVER['PHP_SELF'];?>",data:$(this).serialize()}).done(function(data) {
						if (data) {
							var imported = JSON.parse(data);
							if (parseInt(imported.result) == 0) {
								message = "Database successfully built!";
								$("#dbImport").fadeOut("fast");
								$("#configApp").fadeIn("fast");
							} else {
								message = "There was an error building the database...";
							}
							$("#dbResults").html(message);
						} else {
							$("#dbResults").html("HTTP Error. Try again?");
						}
					});
					return false;
				});

				$("#dbInstaller").submit(function() {
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

									$("#configHost").val($("#dbConfigHost").val());
									$("#configDataBase").val($("#dbConfigDataBase").val());
									$("#configUser").val($("#dbConfigUser").val());
									$("#configPassword").val($("#dbConfigPassword").val());
									message = "DB connection successful!";
									$("#dbInstaller").fadeOut("fast");
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