$(document).ready(function(){


    $("#btn-chevron-up").hide();

    $("#btn-chevron-down").click(function(){
        $("#management-item-filter").slideDown("slow");
        $(this).hide();
        $("#btn-chevron-up").show();
    });

    $("#btn-chevron-up").click(function(){
        $("#management-item-filter").slideUp("slow");
        $(this).hide();
        $("#btn-chevron-down").show();
    });

    // get navigator language
    var userLang = navigator.language || navigator.userLanguage; 
    
    // load gender select list
    $.get("/vanofashion/websitemanagement/"+userLang+"/itemGender/list", function(genders, status){
        
        if(status==="success"){
            //console.log(genders);
            var elt=$("<option>  </option>").text("all").attr('value','all');

            $('#item-gender').append(elt);

            for (var i = 0; i < genders.length; i++) {
                
                elt=$("<option>  </option>").text(genders[i].gender).attr('value', genders[i].name);

               $('#item-gender').append(elt);
            };

        }
    });


     // load product select list
    $.get("/vanofashion/websitemanagement/"+userLang+"/itemProduct/list", function(products, status){
        
        if(status==="success"){
            //console.log(products);
            var elt=$("<option>  </option>").text("all").attr('value','all');

            $('#item-product').append(elt);

            for (var i = 0; i < products.length; i++) {
                
                elt=$("<option>  </option>").text(products[i].name).attr('value', products[i].name);

               $('#item-product').append(elt);
            };

        }
    });

     // load category select list
    $.get("/vanofashion/websitemanagement/"+userLang+"/itemCategory/list", function(categories, status){
        
        if(status==="success"){
            //console.log(categories);
            var elt=$("<option>  </option>").text("all").attr('value','all');
            $('#item-category').append(elt);

            for (var i = 0; i < categories.length; i++) {
                
                elt=$("<option>  </option>").text(categories[i].name).attr('value', categories[i].id);

               $('#item-category').append(elt);
            };

        }
    });

    // load color, brand and item label select lists
    $.get("/vanofashion/websitemanagement/"+userLang+"/item/list", function(items, status){
        
        if(status==="success"){
           // console.log(items);
            
            var colors=[];
            var brands=[];
            var labels=[];
            for (var i = 0; i < items.length; i++) {
                if(colors.indexOf(items[i].color)<0){
                    colors.push(items[i].color);
                }

                if(brands.indexOf(items[i].brand)<0){
                    brands.push(items[i].brand);
                }

                if(labels.indexOf(items[i].itemLabel)<0){
                    labels.push(items[i].itemLabel);
                }         
               
           
            }

            for (var i = 0; i < colors.length; i++) {
                var elt=$("<option>  </option>").text(colors[i]).attr('value', colors[i]);
                $('#item-color').append(elt);
            };

            for (var i = 0; i < brands.length; i++) {
                var elt=$("<option>  </option>").text(brands[i]).attr('value', brands[i]);
                $('#item-brand').append(elt);
            };

            for (var i = 0; i < labels.length; i++) {
                var elt=$("<option>  </option>").text(labels[i]).attr('value', labels[i]);
                $('#item-label').append(elt);
            };           

            

        }
    });


    
}); 
    
    
 
//load products belonging to a selected category
 function loadCategoryProducts(){
    
    if($('#item-category').val()!=='all'){
            $.get("/vanofashion/websitemanagement/itemCategory/"+$('#item-category').find(":selected").val(), function(category, status){
            
            if(status==="success"){
                //console.log(category);
                $('#item-product').empty();
                if(category.products.length>0){
                    var elt=$("<option>  </option>").text("all").attr('value','all');
                    $('#item-product').append(elt);

                    for (var i = 0; i < category.products.length; i++) {
                        
                        elt=$("<option>  </option>").text(category.products[i].name).attr('value', category.products[i].name);

                       $('#item-product').append(elt);
                    }

                }
            }
        });
    }
    else{

        $('#item-product').empty();

        var userLang = navigator.language || navigator.userLanguage; 

         // load product select list
        $.get("/vanofashion/websitemanagement/"+userLang+"/itemProduct/list", function(products, status){
            
            if(status==="success"){
                
                var elt=$("<option>  </option>").text("all").attr('value','all');

                $('#item-product').append(elt);

                for (var i = 0; i < products.length; i++) {
                    
                    elt=$("<option>  </option>").text(products[i].name).attr('value', products[i].id);

                   $('#item-product').append(elt);
                };

            }
        });

    }

}


// refine items list at management side

function refineListItems(){

    var filter="category="+$('#item-category').val()+"&product="+$('#item-product').val()+"&gender="+$('#item-gender').val()+"&itemlabel="+$('#item-label').val();
    if($('#item-color').val()!==null && $('#item-color').val().length>0){

        filter+="&color=";
        for (var i = 0; i < $('#item-color').val().length; i++) {
            if(i>0){
                filter+=","+$('#item-color').val()[i];
            }
            else{
                filter+=$('#item-color').val()[i];
            }
        };

    }

    if($('#item-brand').val()!==null && $('#item-brand').val().length>0){

        filter+="&brand=";
        for (var i = 0; i < $('#item-brand').val().length; i++) {
            if(i>0){
                filter+=","+$('#item-brand').val()[i];
            }
            else{
                filter+=$('#item-brand').val()[i];
            }
        };

    }
    var currentUrl=window.location.href;
    var url=new URL(currentUrl);
    var limit = url.searchParams.get("limit");    
    if(limit!==null){
        filter+="&limit="+limit;
    }
    var userLang = navigator.language || navigator.userLanguage; 
    window.location.href ="/vanofashion/websitemanagement/"+userLang+"/item/list?"+filter;
    alert("filter="+filter);
   
    
}


function deleteItem(id){


    $( "#dialog-confirm-delete-item" ).dialog({
      resizable: false,      
      modal: true,
      draggable: false,
      dialogClass: 'dialogButtons',
      buttons: [
            {
               text: "Delete",
               class:"btn btn-reset btn-md",
               
               click: function() { 

                console.log(id);
                $.get("/vanofashion/websitemanagement/item/delete/"+id, function(data, status){
        
                     if(status==="success"){
                      $('#'+id).remove();
                      var total=$("#nb-results").html();
                      total=total-1;          
                      $("#nb-results").html(total--);

                      }
                });                    
                $(this).dialog("close"); 
               }
            },
            
          ]     
      
    });

   



     
          /*$.get("/vanofashion/websitemanagement/item/delete/"+id, function(data, status){
        
         if(status==="success"){
          $('#'+id).remove();
          var total=$("#nb-results").html();
          total=total-1;          
          $("#nb-results").html(total--);


        }
    });*/
        
       
       
      
    }