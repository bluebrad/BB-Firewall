<form method="post">
  <label for="ip_address">Enter IP address to block:</label><br>
  <input type="text" id="ip_address" name="ip_address"><br>
  <input type="submit" value="Block IP and hostname">
</form>

<?php
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

  // Insert "Require not ip $ip_address" and "Require not host $hostname" directives before "Require all granted"
if (!empty($hostname)) {
  $htaccess_contents = str_replace('Require all granted', "Require not ip $ip_address\nRequire not host $hostname\nRequire all granted", $htaccess_contents);
} else {
  $htaccess_contents = str_replace('Require all granted', "Require not ip $ip_address\nRequire all granted", $htaccess_contents);
}

  // Open .htaccess file in write mode
  $htaccess_file = fopen('.htaccess', 'w');

  // Write modified .htaccess contents back to file
  fwrite($htaccess_file, $htaccess_contents);

  // Close .htaccess file
  fclose($htaccess_file);

  echo "IP address $ip_address and hostname $hostname have been blocked.";
}
<!-- Default Statcounter code for bluebrad.net
http://bluebrad.net -->
<script type="text/javascript">
var sc_project=10142707; 
var sc_invisible=1; 
var sc_security="e1f9cefd"; 
</script>
<script type="text/javascript"
src="https://www.statcounter.com/counter/counter.js"
async></script>
<noscript><div class="statcounter"><a title="Web Analytics
Made Easy - Statcounter" href="https://statcounter.com/"
target="_blank"><img class="statcounter"
src="https://c.statcounter.com/10142707/0/e1f9cefd/1/"
alt="Web Analytics Made Easy - Statcounter"
referrerPolicy="no-referrer-when-downgrade"></a></div></noscript>
<!-- End of Statcounter Code -->
?>
