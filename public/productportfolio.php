<?php 
require_once '../admin/db.class.php';
$db = new DB();

// Fetch the images data
$condition = array('where' => array('status' => 1));
$images = $db->getRows('imgproduct', $condition);
?>
<?php echo file_get_contents("html/header1.html"); ?>
<title>Product Photography | 3Pixels Studios</title>
<?php echo file_get_contents("html/header2.html"); ?>
<?php echo file_get_contents("html/main-nav.html"); ?>
<div class="container-fluid">
	<div class="row my-3">
		<span id="media-title">PRODUCT PHOTOGRAPHY</span>
	</div>
	<div class="grid">
		<div class="grid-col grid-col--1"></div>
		<div class="grid-col grid-col--2"></div>
		<div class="grid-col grid-col--3"></div>
		<div class="grid-col grid-col--4"></div>
		<?php
		if(!empty($images)){
			foreach($images as $row){
				$uploadDir = '../uploads/imgproduct/';
				$imageURL = $uploadDir.$row["file_name"];
		?>
		<div class="grid-item">
			<a href="<?php echo $imageURL; ?>" data-fancybox="gallery" >
				<img id="img-gallery" src="<?php echo $imageURL; ?>" alt="image" />
			</a>
		</div>
		<?php }
		} ?>
	</div>
</div>

<script>
	var colc = new Colcade( '.grid', {
	columns: '.grid-col',
	items: '.grid-item'
	});

	$("body").on("contextmenu", function(e) {
		return false;
	})
</script>
<?php echo file_get_contents("html/footer.html"); ?>