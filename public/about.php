<?php echo file_get_contents("html/header1.html"); ?>
<title>About Us | 3Pixels Studios</title>
<?php echo file_get_contents("html/header2.html"); ?>
<?php echo file_get_contents("html/main-nav.html"); ?>
<div id="members" class="container-fluid">
	<div class="row">
		<div class="col-12 col-lg-12 order-lg-first mt-4">
			<span id="table-header-text">ABOUT US</span></td>
			<div id="top-line-divider"></div>
		</div>
		<div class="col-12 col-lg-12 order-lg-first">
			<span class="mem_title">TEAM</span>
		</div>
		<div class="col-12 col-lg-6 mb-4 mt-3 px-4">
			<span class="mem_name">ANGELO LINGAD</span>
			<span class="mem_pos">OWNER/PHOTOGRAPHER</span>
			<p class="mem_desc">RESPONSIBLE FOR CAPTURING IMAGES OF THE PRODUCTS FOR ADVERTISING PURPOSES, CREATING IMAGES THAT WILL BEST REPRESENT THE PRODUCT.</p>
		</div>
		<div class="col-12 col-lg-6 mb-4 mt-3 px-4">
			<span class="mem_name">CRISTINE JOY SALAO</span>
			<span class="mem_pos">CREATIVE LEAD</span>
			<p class="mem_desc">WORKS VERY CLOSELY WITH THE MANAGEMENT AND CLIENTS TO CREATE ARTISTIC CONCEPTS TO ACHIEVE SALES GOALS.</p>
		</div>
		<div class="col-12 col-lg-6 mb-4 mt-3 px-4">
			<span class="mem_name">ROSS MATTHEW VALLE</span>
			<span class="mem_pos">GRAPHIC DESIGNER</span>
			<p class="mem_desc">CREATES VISUAL CONCEPTS TO COMMUNICATE IDEAS THAT CAN INSPIRE, INFORM AND CAPTIVATE CONSUMERS.</p>
		</div>
		<div class="col-12 col-lg-6 mb-4 mt-3 px-4">
			<span class="mem_name">HOWELL BOOK</span>
			<span class="mem_pos">PROJECT MANAGER</span>
			<p class="mem_desc">RESPONSIBLE FOR PLANNING, ORGANIZING, AND DIRECTING THE COMPLETION OF PROJECTS FOR AN ORGANIZATION WHILE ENSURING THESE PROJECTS ARE ON TIME, ON BUDGET, AND WITHIN SCOPE.</p>
		</div>
		<div class="col-12 col-lg-12 mt-3 px-4">
			<div id="top-line-divider"></div>
		</div>
		<div class="col-12 col-lg-12">
			<span class="mem_title">SERVICES</span>
		</div>
		<div class="col-12 col-lg-6 mb-4 mt-3 px-4">
			<span class="mem_name">PORTRAIT PHOTOGRAPHY</span>
			<p class="mem_desc">A TYPE OF PHOTOGRAPHY AIMED TOWARD CAPTURING THE PERSONALITY OF A PERSON OR GROUP OF PEOPLE BY USING EFFECTIVE LIGHTING, BACKDROPS, AND POSES. A PORTRAIT PHOTOGRAPH MAY BE ARTISTIC OR CLINICAL.</p>
		</div>
		<div class="col-12 col-lg-6 mb-4 mt-3 px-4">
			<span class="mem_name">PRODUCT PHOTOGRAPHY</span>
			<p class="mem_desc">A FORM OF COMMERCIAL PHOTOGRAPHY THAT HAS THE GOAL OF PRESENTING A PRODUCT IN THE BEST POSSIBLE PHOTOGRAPHIC REPRESENTATION. GREAT PRODUCT PHOTOGRAPHY TAKES INTO CAREFUL CONSIDERATION THE TOOLS OF PROPER LIGHTING, BACKGROUND MATERIALS, SHARP CAMERA FOCUS WITH PROPER DEPTH OF FIELD, ADVANTAGEOUS CAMERA ANGLES AND CAREFUL EDITING.</p>
		</div>
		<div class="col-12 col-lg-6 order-last offset-12 offset-lg-0 mb-4 mt-3 px-4">
			<span class="mem_name">GRAPHIC DESIGN</span>
			<p class="mem_desc">A CRAFT WHERE PROFESSIONALS CREATE VISUAL CONTENT TO COMMUNICATE MESSAGES. BY APPLYING VISUAL HIERARCHY AND PAGE LAYOUT TECHNIQUES, DESIGNERS USE TYPOGRAPHY AND PICTURES TO MEET USERS' SPECIFIC NEEDS AND FOCUS ON THE LOGIC OF DISPLAYING ELEMENTS IN INTERACTIVE DESIGNS, TO OPTIMIZE THE USER EXPERIENCE.</p>
		</div>
	</div>
</div>
<script>
	$("body").on("contextmenu", "img", function(e) {
		return false;
	})
</script>
<?php echo file_get_contents("html/footer.html"); ?>
