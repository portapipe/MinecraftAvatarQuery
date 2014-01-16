<?php
//This work is licensed under a Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-sa/3.0/
//Big thanks to IamPhoenix's wonderful API.

//The following script is tested only with servers running on Minecraft 1.7.

$SERVER_IP="127.0.0.1:25565"; //Insert the IP of the server you want to query. Query must be enabled in your server.properties file!

//You can either insert the DNS (eg. play.hivemc.com) OR the IP itself (eg. 187.23.123.21). 
//Note: port is not neccesary when running the server on default port, otherwise use it!

//Query the data from the server using IamPhoenix's API
$data_list = json_decode(file_get_contents("http://api.iamphoenix.me/list/?server_ip=".$SERVER_IP."&clean=true"), true);
$data_general = json_decode(file_get_contents("http://api.iamphoenix.me/get/?server_ip=".$SERVER_IP."&clean=true"), true);

//Put the collected player information into an array for later use.
$array_list = explode(',', $data_list['players']);
?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <title>MC PHP Query</title>
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css">
    	<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
    	<link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    	<script type="text/javascript" src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    	<script>
    	jQuery(function ($) {
        	$("a").tooltip()
    	}); 
    	</script>
    	<style>
    	/*Custom CSS Overrides*/
    	body {
      		font-family: 'Lato', sans-serif !important;
    	}
    	</style>
    </head>
    <body>
	<div class="container">
        <h1>MC PHP Query</h1><hr>       
		<div class="row">
			<div class="span4">
				<h3>General Information</h3>
				<table class="table table-striped">
					<tbody>
					<tr>
					<td><b>IP</b></td>
					<td><?php echo $SERVER_IP; ?></td>
					</tr>
					<tr>
					<td><b>Version</b></td>
					<td><?php echo $data_general['version']; ?></td>
					</tr>
					<tr>
					<td><b>Players</b></td>
					<td><?php echo "".$data_general['players']." / ".$data_general['players_max']."";?></td>
					</tr>
					<tr>
					<td><b>Status</b></td>
					<td><? if($data_general['status'] == 'true') { echo "<i class=\"icon-ok-sign\"></i> Server is online"; } else { echo "<i class=\"icon-remove-sign\"></i> Server is offline";}?></td>
					</tr>
					<tr>
					<td><b>Latency</b></td>
					<td><?php echo "".$data_general['latency']."ms"; ?></td>
					</tr>			
					</tbody>
				</table>
			</div>
			<div class="span8">
				<h3>Players</h3>
				<?php
				//Take the username values from the array & grab the avatars from Minotar.				
				foreach($array_list as $key => $value){$users .= "<a data-placement=\"top\" rel=\"tooltip\" style=\"display: inline-block;\" title=\"".$value."\">
				<img src=\"https://minotar.net/avatar/".$value."/50\" size=\"40\" width=\"40\" height=\"40\" style=\"width: 40px; height: 40px; margin-bottom: 5px; margin-left: 5px; border-radius: 3px;\"/></a>";}
				//Display the avatars only when there are players online.
				if($data_general['players'] > 0) {
					print_r($users);
					}
				//If no avatars can be shown, display an error.
				else { 
					echo "<div class=\"alert\"> There are no players online at the moment!</div>";
					}				
				?>
			</div>
		</div>
	</div>
	</body>
</html>