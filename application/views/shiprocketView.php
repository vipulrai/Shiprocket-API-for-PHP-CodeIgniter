<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Shiprocket</title>	
</head>
<body>

<div id="container">
	<form action="<?php echo base_url(); ?>shiprocket/shiprocketSendToCustomer" method="post">
		<button type="submit" alue="Submit">Send to Customer</button>
	</form>
	
	<form action="<?php echo base_url(); ?>shiprocket/shiprocketPickupFromCustomer" method="post">
		<button type="submit" alue="Submit">Pickup From Customer</button>
	</form>
</div>


</body>
</html>