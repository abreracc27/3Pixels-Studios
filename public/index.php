<?php echo file_get_contents("html/header1.html"); ?>
<title>Home | 3Pixels Studios</title>
<?php echo file_get_contents("html/header2.html"); ?>
<?php echo file_get_contents("html/main-nav.html"); ?>
<div class="slides-position">
    <img class="mySlides" src="../images/edit1.jpg">
    <img class="mySlides" src="../images/edit2.jpg">
    <img class="mySlides" src="../images/edit3.jpg">
    <img class="mySlides" src="../images/edit4.jpg">
    <img class="mySlides" src="../images/edit5.jpg">
</div>
<script>
var myIndex = 0;
changes();
function changes() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(changes, 2500); // Change image every 1000 = 1 second. 
}
</script>
<div id="index" class="container-fluid">
    <div class="row">
		<div class="col-12 col-lg-6 mb-4 mt-3">
			<span class="index_name">ABOUT 3PIXELS STUDIOS</span>
			<p class="index_desc">IT ALL STARTED AS AN IDEA TO ESCAPE FROM OUR BORING DAILY ROUTINE, DAY TO DAY JOBS AND PANDEMIC.<br><br>3PIXELS STUDIOS IS A RESULT OF BOREDOM, PASSION AND DETERMINATION TO PURSUE OUR DREAMS OF GIVING A THUMB-STOPPING CONTENT THAT SELLS THE MARKET.<br><br>3PIXELS STUDIOS IS A GROUP OF PASSIONATE AND GOAL-DRIVEN CREATIVES WITH A DETERMINATION TO HELP YOU GROW THROUGH OUR VISION.</p>
            <a class="index_link" href="about.php">LEARN MORE ABOUT US &#8594;</a>
		</div>
        <div class="col-12 col-lg-6 mb-4 mt-3">
			<img src="../images/FINAL-LOGO.png">
		</div>
    </div>
</div>
<script>
	$("body").on("contextmenu", "img", function(e) {
		return false;
	})
</script>
<?php echo file_get_contents("html/footer.html"); ?>