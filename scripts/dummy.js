(function () {
  var offset = 0;
  var limit = 12;
  $(document).ready(function(){
    api_key = "z7f4b8zmq5be0lrwb8zl9l30";
    //loop through all the hidden fields to get listing IDs that are already saved
    loadSaved();
    //if image is dragged from other area, that area isn't full so enable
    $('#etsy-images').droppable({
			activeClass: "ui-state-highlight",
			drop: function(event, ui) {
			  var dropParent = $(ui.draggable).parent();
				addToEtsyImages(ui.draggable, dropParent);
				dropParent.droppable('enable');
			}
		});
      //each piece for the outfit is droppable, also enables/disables
      //can only hold one image at a time
  		$('.piece').droppable({
  			activeClass: "ui-state-highlight",
  			drop: function(event, ui) {
  				addToOutfit(ui.draggable, this);
  				var dropParent = $(ui.draggable).parent();
  				dropParent.droppable('enable');
  				$(this).droppable('disable');
  			},
  		});
  		//sets the hidden input to 0 once you drag an image out
  		function addToEtsyImages($item, piece) {
  		  pieceID = $(piece).attr('id');
  		  $('input[name="' + pieceID + '"]').val($item.find('img').attr('0'));
        $item.fadeOut(function() {
      			$item.appendTo('#etsy-images').fadeIn(function() {
      					$item
      					  //TODO animate sizes to shrink/grow
      						.animate({ width: "170px" })
      						.find( "img" )
      							.animate({ height: "135px" });
      							});
    							});
      }
  		//sets the hidden input value once you drag an image in
  		function addToOutfit($item, piece) {
  		  pieceID = $(piece).attr('id');
  		  $('input[name="' + pieceID + '"]').val($item.find('img').attr('id'));
  		  $item.fadeOut(function() {
      			$item.appendTo(piece).fadeIn(function() {
      					$item
      						.animate({ width: "170px" })
      						.find( "img" )
      							.animate({ height: "135px" });
      							});
    							});
      }
      
      $('#etsy-search').bind('submit', function() {
          return loadResults(offset);
      })

  });
  function loadSaved() {
    $.each($('.savedID'), function(i, element) {
      listingID = $(element).val();
      if(listingID.length > 1) {
        inputID = $(this).attr('name');
        pieceDiv = $('#' + inputID);
        loadURL = "http://openapi.etsy.com/v2/public/listings/" + listingID + ".js?limit=1&includes=Images:1&api_key="+api_key;
        $.ajax({
            url: loadURL,
            dataType: 'jsonp',
            success: function(data) {
                if (data.ok) {
                  if (data.count > 0) {
                      //find listings from the IDs and create images/links
                      $.each(data.results, function(j,item) {
                        inputID = $(element).attr('name');
                        pieceDiv = $('#' + inputID);
                         $("<img/>").attr("src", item.Images[0].url_170x135).attr("id", item.listing_id).appendTo(pieceDiv)
                           .wrap("<a href='" + item.url + "' style='display: inline-block' target='blank'></a>")
                           .parent('a')
                           .draggable({
                             revert: "invalid", 
                             stack: '.piece',
                             helper: "clone",
                             cursor: "move"
                             });
                             $(pieceDiv).droppable('disable');                 
                      });
                  } else {
                    print_r('invalid or no listing ID');
                  }
                } else {
                    alert(data.error);
                }
            }
        });//end ajax
      }//end if there's a savedID
    });//end loop
  }
  function loadResults(offset) {
    terms = $('#etsy-terms').val();
    etsyURL = "http://openapi.etsy.com/v2/public/listings/active.js?keywords="+
        terms+"&category=clothing&limit=" + limit + "&offset=" + offset + "&includes=Images:1&api_key="+api_key;
        //TODO add other searches for jewelry/etc
    $('#etsy-images').empty();
    $('<p>Searching for '+terms+'</p>').appendTo('#etsy-images');
    //get search results, make draggable, add to droppable
    //stack so the overlap on drag
    $.ajax({
        url: etsyURL,
        dataType: 'jsonp',
        success: function(data) {
            if (data.ok) {
              $('#etsy-images').empty();
              $('<p>Showing results ' + (offset + 1) + ' - ' + (offset + limit) + '</p>').appendTo('#etsy-images');
              if (data.count > 0) {
                  $.each(data.results, function(i,item) {
                      $("<img/>").attr("src", item.Images[0].url_170x135).attr("id", item.listing_id).appendTo("#etsy-images")
                        .wrap("<a href='" + item.url + "' style='display: inline-block' target='blank'></a>")
                        .parent('a')
                        .draggable({
                          revert: "invalid", 
                          stack: '.piece',
                          helper: "clone",
                          cursor: "move"
                          })
                      if (i%4 == 4) {
                          $('<br/>').appendTo('#etsy-images');
                      }
                  });
                  if(!$('.load').length) $('<button class="load">Load More</button>').appendTo('#results');
                  //load more images
                  $('.load').click(function(event){
                    offset += limit;
                    loadResults(offset);
                  });
              } else {
                  $('<p>No results.</p>').appendTo('#etsy-images');
              }
            } else {
                $('#results').empty();
                alert(data.error);
            }
        }
    });
    return false;
  }
}());