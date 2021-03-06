
$(document).ready(function(){
    $("#item-menu").click(function(){
        $("#item-menuItem").slideToggle();        
    });

    $("#product-menu").click(function(){
        $("#product-menuItem").slideToggle();        
    });

    $("#category-menu").click(function(){
        $("#category-menuItem").slideToggle();        
    });

    $("#user-menu").click(function(){
        $("#user-menuItem").slideToggle();        
    });

    $("#customer-menu").click(function(){
        $("#customer-menuItem").slideToggle();        
    });

    $("#discount-menu").click(function(){
        $("#discount-menuItem").slideToggle();        
    });

    $("#gender-menu").click(function(){
        $("#gender-menuItem").slideToggle();        
    });


   /*$("#addGender-menuItem").click(function(){
        $("#management-container").load("/vanofashion/websitemanagement/en/itemGender/add", function(responseTxt, statusTxt, xhr){
        if(statusTxt == "success")
          console.log(responseTxt);
            alert(responseTxt);
        if(statusTxt == "error")
            alert("Error: " + xhr.status + ": " + xhr.statusText);
    });       
    });*/



   
    
});

//this function delete a category
function deleteCategory(id){
      $.get("/vanofashion/websitemanagement/itemCategory/delete/"+id, function(data, status){
        
        if(status==="success"){
          $('#'+id).remove();
          var total=$("#nb-results").html();
          total=total-1;          
          $("#nb-results").html(total--);


        }
    });
    }


function deleteProduct(id){
      $.get("/vanofashion/websitemanagement/itemProduct/delete/"+id, function(data, status){
        
        if(status==="success"){
          $('#'+id).remove();
          var total=$("#nb-results").html();
          total=total-1;          
          $("#nb-results").html(total--);


        }
    });
    }


function deleteGender(id){
      $.get("/vanofashion/websitemanagement/itemGender/delete/"+id, function(data, status){
        
        if(status==="success"){
          $('#'+id).remove();
          var total=$("#nb-results").html();
          total=total-1;          
          $("#nb-results").html(total--);


        }
    });
    }





function showModalCategory(id){

       $.getJSON("/vanofashion/websitemanagement/itemCategory/"+id, function(category, status){
        
        if(status==="success"){
          $("#category-modal-name").text(category.name);
          $("#category-modal-nberProducts").text(category.products.length);
          $("#category-modal-list-products").empty();
          for (var i = 0; i < category.products.length; i++) {
            $("#category-modal-list-products").append("<li>"+category.products[i].name +" ----> "+
              category.products[i].gender+"</li>");
          };

          var d = new Date(category.addingDate.date);
          $("#category-added-date").text(d.toUTCString());
          //console.log(category);
          $("#categoryModal").modal();


        }
    });
       
}

function showModalProduct(id){

       $.getJSON("/vanofashion/websitemanagement/itemProduct/"+id, function(product, status){
        
        if(status==="success"){
          $("#product-modal-name").text(product.name);          
          $("#productCategory").text(product.category);
          var d = new Date(product.addingDate.date);
          $("#product-added-date").text(d.toUTCString());
          //console.log(product);
          $("#productModal").modal();


        }
    });
       
    }