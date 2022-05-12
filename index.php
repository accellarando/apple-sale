<?php
require("include/conn.php");
error_reporting(E_ALL);
$categories=array();
//$categories = mysqli_fetch_all(mysqli_query($conn,"SELECT * FROM categories"),MYSQLI_ASSOC);
$ipadCategories = mysqli_fetch_all(mysqli_query($conn,"SELECT * FROM categories WHERE name LIKE '%iPad%'"),MYSQLI_ASSOC);
$categories['iPad'][0] = $ipadCategories;
$categories['iPad'][1] = "https://www.campusstore.utah.edu/utah/U-of-U/Apple-Products/iPads";

// $MacBookCategories = mysqli_fetch_all(mysqli_query($conn,"SELECT * FROM categories WHERE name LIKE '%MacBook%'"),MYSQLI_ASSOC);
// $categories['Mac Book'][0] = $MacBookCategories;
// $categories['Mac Book'][1] = "https://www.campusstore.utah.edu/utah/U-of-U/Apple-Products/Macs";

$imacCategories = mysqli_fetch_all(mysqli_query($conn,"SELECT * FROM categories WHERE name LIKE '%iMac%' OR name LIKE '%Mac Mini%'"),MYSQLI_ASSOC);
$categories['iMac'][0] = $imacCategories;
$categories['iMac'][1] = "https://www.campusstore.utah.edu/utah/U-of-U/Apple-Products/Macs";

// $WatchCategories = mysqli_fetch_all(mysqli_query($conn,"SELECT * FROM categories WHERE name LIKE '%Watch%'"),MYSQLI_ASSOC);
// $categories['Watch'][0] = $WatchCategories;
// $categories['Watch'][1] = "https://www.campusstore.utah.edu/utah/U-of-U/Apple-Products/Watch";

// $warrantyCategories = mysqli_fetch_all(mysqli_query($conn,"SELECT * FROM categories WHERE name LIKE '%are%'"),MYSQLI_ASSOC); //safeware, applecare
// $categories['Warranty'][0] = $warrantyCategories;
// $categories['Warranty'][1] = "https://www.campusstore.utah.edu/utah/merchlist?ID=32292";

$airpodCategories = mysqli_fetch_all(mysqli_query($conn,"SELECT * FROM categories WHERE name LIKE '%AirPod%'"),MYSQLI_ASSOC);
$categories['AirPods'][0] = $airpodCategories;
$categories['AirPods'][1] = "https://www.campusstore.utah.edu/utah/U-of-U/Apple-Products/Headphones";

$numberOfCategories = count($categories);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base target="_parent"><!-- iframe: open links in parent tab -->

		<title>Apple Sale Pricing at UTech</title>

		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="../Libraries/UCSbootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="stylesheets/style.css">

	</head>

	<body>
		<div class="container-md">
			<div class="desktopOnly">

			</div>
			<div id="mainNav" class="text-white">
				<div id="eligibility">
					<select class="form-select bg-primary text-white text-center" id="eligibilitySelect" onchange="updateSelect($(this))">
						<option value="null" selected disabled>---Select Pricing Group---</option>
						<option value="faculty">Students, Staff, and Faculty</option>
						<option value="alumni">Alumni</option>
					</select>
				</div>

				<div id="productCategoryLinks"> <!-- Macbook, iPad, etc -->
					<ul id="productCategoryList" class="list-group list-group-horizontal flex-fill" style="width:100%;">
						<li class="list-group-item bg-dark text-center more-expand d-lg-none">
							<div class="btn-group dropleft">
								<button class="btn btn-dark btn-sm dropdown-toggle" type="button" id="moreButton" 
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="getMore()">
									More
								</button>
								<div class="dropdown-menu bg-dark" id="moreDropdown">
									<div id="dropdownOptions">
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>

				<div class="text-center text-dark" id="helpBox">
					<div class="helptext" id="helpEligibility">
						<h3>Please select your pricing group in the red box.</h3>
					</div>
					<div class="helptext" id="helpProduct" style="display:none;">
						<h3>Select a product to view prices.</h3>
					</div>
				</div>

				<?php foreach(array_keys($categories) as $category): ?>
				<div class="itemsList" id="<?php echo str_replace(' ','',$category); ?>Categories" style="display:none;">
					<ul class="list-group categoryList text-dark"> 
<?php foreach($categories[$category][0] as $specificCategory): 
							$categoryLink=$categories[$category][1];?>
							<li class="list-group-item" >
								<div onclick='toggleCategory($(this));'>
									<?php echo $specificCategory['name']; ?>
									<i class="bi bi-chevron-down" style="color:black;"></i>
								</div>
								<div class="categoryExpandItems" style="display:none;"> 
									<table class="table table-bordered">
										<thead>
											<th>Item</th>
											<th>Sale Price</th>
											<th>Apple Store Price</th>
											<th>Total Savings</th>
										</thead>
										<tbody>
							<?php
							$categoryID = $specificCategory['id'];
							$items = mysqli_fetch_all(mysqli_query($conn,"SELECT * FROM items WHERE category=$categoryID"),MYSQLI_ASSOC);
							
							foreach($items as $item){
								$studentSavings = number_format(($item['applePrice']/100 - $item['studentPrice']/100),2);
								$alumniSavings = number_format(($item['applePrice']/100 - $item['alumniPrice']/100),2);
								$applePrice = ($item['applePrice']/100==0) ? "-" : "$".number_format($item['applePrice']/100,2);
								$studentPrice = ($item['studentPrice']/100==0) ? "-" : "$".number_format($item['studentPrice']/100,2);
								$alumniPrice = ($item['alumniPrice']/100==0) ? "-" : "$".number_format($item['alumniPrice']/100,2);

								$studentSavings = ($studentSavings<0) ? "-" : "$".$studentSavings;
								$alumniSavings = ($alumniSavings<0) ? "-" : "$".$alumniSavings;

								//echo '<tr class="itemRow'.$item['eligibility'].'">';
								echo "<td><a href='$categoryLink'>".$item['item']."</a></td>";
								echo "<td class='studentPrice'><a href='$categoryLink'>$studentPrice</a></td>";
								echo "<td class='alumniPrice'><a href='$categoryLink'>$alumniPrice</a></td>";
								echo "<td><a href='$categoryLink'>".$applePrice."</a></td>";
								echo "<td class='studentSavings'><a href='$categoryLink'>$studentSavings</a></td>";
								echo "<td class='alumniSavings'><a href='$categoryLink'>$alumniSavings</a></td>";
								echo "</tr>";
							}
							?>
										</tbody>
									</table>
								</div>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>

			<script src='scripts.js'></script>

			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
			<script src="../Libraries/UCSbootstrap/js/bootstrap.min.js"></script>
			<!-- https://github.com/davidjbradshaw/iframe-resizer/tree/master/docs -->
<script>
$(document).ready(function (){
	populateCategoryButtons();
	updateSelect($('#eligibilitySelect'));
});
</script>
<script src="js/iframeResizer.contentWindow.js"></script>
<script src="/Libraries/hideDisclaimer.js"></script>

<ul id="productsFromServer" hidden>
	<?php for($i=0;$i<$numberOfCategories;$i++): ?>
	<li	id="button-<?php echo trim(str_replace(' ','',array_keys($categories)[$i]));?>">
		<?php echo trim(array_keys($categories)[$i]); ?>
	</li>
	<?php endfor;?>
</ul>
<?php include("../Libraries/footer.html"); ?>

	</body>

</html>


