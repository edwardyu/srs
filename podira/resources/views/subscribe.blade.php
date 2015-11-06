<!DOCTYPE html>
<html>
<head>
	<title>Subscribe</title>
</head>
<body>
	Display create podira account if they don't have one.
	<form action="/createSubscription" method="POST">
	  <script
	    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
	    data-key="pk_test_nzeoeMa0b7m6pAGajczglP45"
	    data-amount="2000"
	    data-name="Demo Site"
	    data-description="2 widgets ($20.00)"
	    data-image="/128x128.png"
	    data-locale="auto">
	  </script>
	</form>
</body>
</html>