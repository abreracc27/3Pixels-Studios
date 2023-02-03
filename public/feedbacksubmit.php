<?php echo file_get_contents("html/header1.html"); ?>
<title>Submission Successful | 3Pixels Studios</title>
<?php echo file_get_contents("html/header2.html"); ?>
<?php echo file_get_contents("html/submitted1.html"); ?>
<div class="col-12 col-lg-12 order-lg-first pt-4">
    <span id="table-header-text">FEEDBACK SUBMITTED</span>
    <div id="top-line-divider">
        <span class="frm-text">THANK YOU FOR CHOOSING 3PIXELS STUDIOS! WE ARE GRATEFUL FOR YOUR HELP IN IMPROVING OUR SERVICE.</span>
    </div>
</div>
<script>
	$("body").on("contextmenu", "img", function(e) {
		return false;
	})
</script>
<?php echo file_get_contents("html/submitted2.html"); ?>