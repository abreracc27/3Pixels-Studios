<?php echo file_get_contents("html/header1.html"); ?>
<title>Submission Successful | 3Pixels Studios</title>
<?php echo file_get_contents("html/header2.html"); ?>
<?php echo file_get_contents("html/submitted1.html"); ?>
<div class="col-12 col-lg-12 order-lg-first pt-4">
    <span id="table-header-text">APPOINTMENT REQUEST SUBMITTED</span>
    <div id="top-line-divider">
        <span class="frm-text">THANK YOU FOR CHOOSING 3PIXELS STUDIOS! WE HAVE RECORDED YOUR REQUEST AND SENT YOU ALSO A COPY OF YOUR SUBMISSION TO YOUR PROVIDED EMAIL. WE'LL CONNECT WITH YOU AS SOON AS POSSSIBLE.</span>
    </div>
</div>
<script>
	$("body").on("contextmenu", "img", function(e) {
		return false;
	})
</script>
<?php echo file_get_contents("html/submitted2.html"); ?>