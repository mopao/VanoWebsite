
$(document).ready(function(){
   


    var $container = $('div#vanofashion_eshoppingbundle_item_stocks');
    
    var index = $container.find(':input').length;
    
    $('#add_stock').click(function(e) {        
      addStock($container);       
      e.preventDefault(); 
      return false;
    });

     if (index == 0) {
      addStock($container);
    } else {
      // If there are stocks, we add delete link on each stock
      $container.children('div').each(function() {
        addDeleteLink($(this));
      });
    }

   // add stock form
    function addStock($container) {
      
      var template = $container.attr('data-prototype')
        .replace(/__name__label__/g, 'Stock n°' + (index+1))
        .replace(/__name__/g,        index);
      
      var $prototype = $(template);

      addDeleteLink($prototype);
      
      $container.append($prototype);
      
      index++;
    }

    // add delete link
    function addDeleteLink($prototype) {
      // Create link
      var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');

      // Add link
      $prototype.append($deleteLink);

      // Add listener
      $deleteLink.click(function(e) {
        $prototype.remove();
        e.preventDefault(); 
        return false;
      });
    }

    
});