<?php
// * Bluebrads quick PHP firewall for Apachie servers.  V2.4
// This is a suitable choice for Wordpress,drupal,joomla or Opencart platforms, as well as other PHP systems. 
// Please refer to the HTACCESS document for instructions on how to add the Deny IP block to your HTACCESS file.
// You are free to change the background image to what ever you like including css and redirect locations. But if you have fixes to this code please share and help keep this updated and open to the community.
if (isset($_POST['ip_address']) && !empty($_POST['ip_address'])) {
  $ip_address = $_POST['ip_address'];
  // Get hostname associated with IP address
  $hostname = gethostbyaddr($ip_address);
  // Open .htaccess file in read mode
  $htaccess_file = fopen('.htaccess', 'r');
  // Read .htaccess file into a string
  $htaccess_contents = fread($htaccess_file, filesize('.htaccess'));
  // Close .htaccess file
  fclose($htaccess_file);
  // Check for duplicate entries
  if (strpos($htaccess_contents, "Require not ip $ip_address") === false) {
    // Insert "Require not ip $ip_address" and "Require not host $hostname" directives before "Require all granted"
    if (!empty($hostname)) {
      $htaccess_contents = str_replace('</RequireAll>', "Require not ip $ip_address\nRequire not host $hostname\n</RequireAll>", $htaccess_contents);
    } else {
      $htaccess_contents = str_replace('</RequireAll>', "Require not ip $ip_address\n</RequireAll>", $htaccess_contents);
    }
    // Open .htaccess file in write mode
    $htaccess_file = fopen('.htaccess', 'w');
    // Write modified .htaccess contents back to file
    fwrite($htaccess_file, $htaccess_contents);
    // Close .htaccess file
    fclose($htaccess_file);
    echo "IP address $ip_address and hostname $hostname have been blocked.";} else {echo "IP address $ip_address is already blocked.";}}
?>

<html>
  <head>
    <title>Deny access to this site</title>
    <style>
      body { background-color: #224488; text-align: center; color:White; text-size:14px; background: url(https://i-brad.com/images/BG2.png) no-repeat center center fixed; 
  -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; }
      p{color:white;}
      form{ width: 50%; margin: auto; text-align: center; }
      input{ color:black; background: white; border-radius:3px; width:400px; padding: 12px 20px; margin: 8px 0; box-sizing: border-box; font-size:20px; Font-style:bold; }
      h1 {color: navy;}
      label{color:white;}
    </style>
  </head>
  <body>
    <div>
      <form method="post">
        <label for="ip_address">Enter IP address to block:</label><br>
        <input type="text" id="ip_address" name="ip_address"><br>
        <input type="submit" value="Block IP and hostname">
      </form>
    </div>
	<div style="text-align:center">Bluebrad - Deny v2.4</div>
  </body>
</html>
