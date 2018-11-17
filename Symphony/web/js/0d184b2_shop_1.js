

$(document).ready(function(){

    // manage price filter button
	$("#price-filter").click(function(){

		var minPrice= $("#minPrice").val();
		var maxPrice= $("#maxPrice").val();
       
		if ((minPrice && !isNaN(minPrice)) || (maxPrice && !isNaN(maxPrice))) {

			var filter=minPrice;
			if (!filter || isNaN(filter) ) { filter="0";}
			filter+="-";
			if (!maxPrice || isNaN(maxPrice)) {filter+="Inf";} else { filter+=maxPrice;}

			var url=window.location.href;
			window.location.assign( url.split('&price')[0]+'&price='+filter);

			console.log(  url.split('&price'));
  
		}

		if (!minPrice && !maxPrice) {
			var url=window.location.href;
			if (url.split('&price').length>1) {
				window.location.assign( url.split('&price')[0]);

			}
		}
    });
   
});