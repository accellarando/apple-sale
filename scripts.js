function resize(){
	if('parentIFrame' in window){
		parentIFrame.autoResize(true);
		parentIFrame.size();
	}
}

function toggleCategory(element){
	if('parentIFrame' in window) parentIFrame.autoResize(false); 
	originalClasses = element.children('i').attr("class")
	element.parent().children('.categoryExpandItems').toggle("fast",resize());
	//console.log(originalClasses);
	isPointingDown = originalClasses.includes("down");
	if(isPointingDown)
		element.children("i").addClass("bi-chevron-up").removeClass("bi-chevron-down");
	else
		element.children("i").addClass("bi-chevron-down").removeClass("bi-chevron-up");
}

function updateSelect(element){
	selected = element.val();
	if(!$('.itemButton').hasClass('active')){
		$('#helpEligibility').hide();
		$('#helpProduct').show();
	}
	else
		$('#helpBox').hide();
	if(selected==null){
		$('#helpBox').show();
		$('#helpEligibility').show();
		$('#helpProduct').hide();
	}

	if(selected=="alumni"){
		// $(".itemRow"+"alumni").show();
		// $(".itemRow"+"faculty").hide();
		$(".alumniPrice").show();
		$(".studentPrice").hide();
		$(".alumniSavings").show();
		$(".studentSavings").hide();

	}
	if(selected=="faculty"){
		$(".alumniPrice").hide();
		$(".studentPrice").show();
		$(".alumniSavings").hide();
		$(".studentSavings").show();
	}
}

function showProductCategories(categoryName){
	if('parentIFrame' in window) parentIFrame.autoResize(false); 
	//console.log($('#eligibilitySelect').val());
	if($('#eligibilitySelect').val()==null){
		$('#helpBox').show();
		$('#helpEligibility').show().fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
		discombobulate();
	}
	$('#helpBox').hide();
	element = $('#'+categoryName+"Categories");
	if(!element.hasClass("active")){
		activeElement = $('.itemsList.active');
		activeElement.hide("fast",resize());
		if('parentIFrame' in window) parentIFrame.autoResize(false); 
		activeElement.removeClass("active");
		buttonList = $('#productCategoryList').children();
		buttonList.removeClass("active").removeClass("bg-info").addClass("bg-dark");

		buttonElement = $('#button-'+categoryName);
		buttonElement.addClass("active").addClass("bg-info").removeClass("bg-dark");
		element.show("fast",resize());
		element.addClass("active").addClass("bg-info").removeClass("bg-dark");
	}
}

function generateProductList(element){
	selectedProduct = $('#productsFromServer').children('#'+element.id);
	$('#productsFromServer').prepend(selectedProduct);
	populateCategoryButtons();
	getMore();
	//products = $('#productCategoryList').children('.itemButton');
}

function getMore(){
	$('#dropdownOptions').children().remove('.dropdown-item');
	hiddenProducts = $('#productCategoryList').children(':hidden').clone();
	//console.log(hiddenProducts);
	//$('#testDiv').append(hiddenProducts);
	var productsToBeShown = [];
	for(i=0; i<hiddenProducts.length; i++){
		thisProduct = $(hiddenProducts[i]);
		thisId = thisProduct.attr('id');
		thisOnclick = thisProduct.attr('onclick');
		thisText = thisProduct.html();
		productsToBeShown.push("<span id='"+thisId+"' class='bg-dark text-center dropdown-item text-white' onclick='generateProductList(this);"+thisOnclick+"'>"+thisText+"</span>");
	}
	//console.log(productsToBeShown);
	$('#dropdownOptions').append(productsToBeShown);
}

function trimText(element){
	return $(element).html().trim().replace(' ','');
}

function populateCategoryButtons(){
	$('#productCategoryList').children().remove('.itemButton');
	products = $('#productsFromServer').children('li').clone();
	products.addClass('itemButton list-group-item bg-dark text-center');
	products.attr("onclick","showProductCategories(trimText(this));");
	for(i=0; i<products.length; i++){
		thisProduct = $(products[i]);
		thisProduct.addClass("item"+String(i));
		if(i>=2)
			thisProduct.addClass("d-none");
		if(i==2)
			thisProduct.addClass("d-sm-block");
		if(i==3)
			thisProduct.addClass("d-md-block");
		if(i>=4)
			thisProduct.addClass("d-lg-block");
	}
	$('#productCategoryList').prepend(products);
}



