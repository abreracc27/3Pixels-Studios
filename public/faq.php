<?php echo file_get_contents("html/header1.html"); ?>
<title>FAQs | 3Pixels Studios</title>
<?php echo file_get_contents("html/header2.html"); ?>
<?php echo file_get_contents("html/main-nav.html"); ?>
<div id="questions" class="container-fluid">
	<div class="row">
		<div class="col-12 col-lg-12 order-lg-first px-5 pt-4">
			<span id="table-header-text">FREQUENTLY ASKED QUESTIONS (FAQ)</span></td>
			<div id="top-line-divider"></div>
		</div>
		<div class="col-12 col-lg-12 order-lg-first px-5 pb-1 pt-3">
			<button class="accordion">WHAT IS THE DESIGN PROCESS?</button>
			<div class="panel">
				<p>ONCE YOU HAVE BOOKED A MEETING WITH US, WE WILL SPEND SOME TIME TALKING TO YOU TO GET A FEEL FOR YOUR BUSINESS AND LEARN HOW BEST TO COMMUNICATE YOUR REQUIRED MATERIAL. </p>
				<p>WE WILL THEN DESIGN SOME ROUGH DRAFTS FOR YOU TO LOOK OVER. YOU CHOOSE THE LOOK YOU ARE MOST SATISFIED WITH AND WE TAKE IT FROM THERE – TWEAKING AND REFINING THE DESIGN AS NEEDED. </p>
				<p>ONCE YOU ARE COMPLETELY SATISFIED WITH THE DESIGN AND HAVE APPROVED IT, WE FINALIZE THE DESIGN. </p>
			</div>
		</div>
		<div class="col-12 col-lg-12 px-5 pb-1 pt-1">
			<button class="accordion">HOW LONG WILL EACH DESIGN TAKE?</button>
			<div class="panel">
				<p>EVERY JOB IS DIFFERENT AND EVERY DEADLINE IS DIFFERENT.</p>
				<p>REALLY YOU SHOULD ALLOW SUFFICIENT TIME FOR THE DESIGNING AND PROOFING OF YOUR WORK.</p>
				<p>IF YOUR DEADLINE IS VERY TIGHT, WE WILL DO OUR BEST TO COMPLETE YOUR WORK WITHIN THIS TIME.</p>
				<p>WE WILL, OF COURSE, ADVISE AT THE TIME OF THE WORK. WE HAVEN’T MISSED A DEADLINE YET AND DON’T INTEND TO IN THE FUTURE!</p>
			</div>
		</div>
		<div class="col-12 col-lg-12 px-5 pb-1 pt-1">
			<button class="accordion">HOW MUCH INFORMATION ABOUT MY SHOOT DO YOU NEED TO GET STARTED?</button>
			<div class="panel">
				<p>THE QUICK ANSWER IS “AS MUCH AS POSSIBLE”. BEFORE SENDING OUT AN ORDER, THERE’S A NUMBER OF THINGS WE NEED TO KNOW:</p>
				<p>
					<ul>
						<li>THE EXACT NUMBER OF SHOTS YOU’RE ORDERING</li>
						<li>DESCRIPTION OF YOUR PRODUCT(S)</li>
						<li>ARE THERE ANY GROUP SHOTS</li>
						<li>HOW YOU WOULD LIKE THEM SHOT. KNOWING THE ANGLES, PRODUCT PLACEMENT, SHOT STRAIGHT ON, AT AN ANGLE, ETC. IS CRITICAL TO ENSURING THAT THE PHOTOS WE TAKE WILL FIT YOUR VISION</li>
						<li>TRANSPARENCY, SILHOUETTE, CLIPPING PATH TO CUT OUT THE PRODUCT FROM THE BACKGROUND TO CREATE TRANSPARENCY</li>
						<li>DROP SHADOW, CAST SHADOW, REFLECTION</li>
						<li>FINAL IMAGE FORMAT, IF YOU ARE NOT SURE, ASK US, WE CAN GUIDE YOU</li>
					</ul>
				</p>
				<p>WITHOUT THAT INFORMATION, WE EXECUTE OUR ‘BEST JUDGMENT’ FOR PHOTOS AND CREATIVE DIRECTION. GRANTED, AFTER HUNDREDS OF CLIENTS AND HUNDREDS OF SHOOTS, OUR INSTINCTS ARE VERY GOOD, BUT THERE’S ALWAYS A CHANCE THAT A PRODUCT WILL EITHER BE PHOTOGRAPHED INCORRECTLY OR THE RESULTS MAY NOT FIT WHAT YOU HAD IN MIND.</p>
			</div>
		</div>
		<div class="col-12 col-lg-12 px-5 pb-1 pt-1">
			<button class="accordion">WHAT IF I’M NOT SURE HOW I’D LIKE MY PRODUCTS PHOTOGRAPHED? CAN’T YOU FIGURE THAT OUT FOR ME?</button>
			<div class="panel">
				<p>YES, JUST SEND US A MESSAGE!</p>
			</div>
		</div>
		<div class="col-12 col-lg-12 px-5 pb-1 pt-1">
			<button class="accordion">I WANT MY PRODUCTS TO LOOK DIFFERENT THAN EVERYONE ELSE’S. HOW MUCH CUSTOMIZATION DO YOU OFFER?</button>
			<div class="panel">
				<p>IF YOU KNOW EXACTLY HOW YOU WANT YOUR ITEMS POSITIONED IN THE IMAGES, TELL US.</p>
				<p>IF YOU DON'T, ASK US. OUR PHOTOGRAPHERS CAN ACCESS YOUR STYLE GUIDES FOR EACH ITEM AND POSE THE ITEM ACCORDINGLY.</p>
				<p>YOU CAN EVEN HAVE MULTIPLE GUIDES FOR ITEMS THAT WILL RESULT IN MULTIPLE POSES AND IMAGES. WE CAN BE FLEXIBLE WITH IT.</p>
			</div>
		</div>
		<div class="col-12 col-lg-12 px-5 pb-1 pt-1">
			<button class="accordion">CAN I AS A CLIENT GET TO BE A PART OF THE PHOTOGRAPHY PROCESS?</button>
			<div class="panel">
				<p>QUALITY ASSURANCE IS IMPORTANT TO US. YOU'LL BE ABLE TO FOLLOW EVERY STEP OF THE PROCESS USING OUR CLIENT WEBSITE AND TO ACCEPT OR REJECT AN IMAGE THAT DOESN'T MEET YOUR NEEDS. </p>
				<p>WE GIVE YOU ALL OF THE TOOLS NECESSARY TO MAKE THAT DETERMINATION, INCLUDING IMAGE SIZE, ITEM ANGLE, AND CLIPPING PATH.</p>
			</div>
		</div>
		<div class="col-12 col-lg-12 order-last offset-12 offset-lg-0 px-5 pb-4 pt-1">
			<button class="accordion">ANY MORE QUESTIONS?</button>
			<div class="panel">
				<p>IF YOU HAVE ANY MORE QUESTIONS YOU WOULD LIKE ANSWERED, PLEASE CONTACT US THROUGH OUR CONTACT FORM OR EMAIL US ON 3PIXELS.STUDIOS@GMAIL.COM.</p>
			</div>
		</div>
	</div>
	<script>
	var acc = document.getElementsByClassName("accordion");
	var i;
	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			if (panel.style.maxHeight) {
				panel.style.maxHeight = null;
			} else {
				panel.style.maxHeight = panel.scrollHeight + "px";
			} 
		});
	}
	</script>
</div>
<script>
	$("body").on("contextmenu", "img", function(e) {
		return false;
	})
</script>
<?php echo file_get_contents("html/footer.html"); ?>