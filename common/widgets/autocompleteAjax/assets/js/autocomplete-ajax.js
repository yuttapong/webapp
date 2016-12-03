function autocomplet_ajax(val,id_option) {
	var url=$( "#"+val.id ).attr( "data-url" );
			arr = val.id.split("-");
			 $('#'+arr[0]+'-'+arr[1]+'-'+id_option).val('');
	   		jQuery('#'+val.id ).autocomplete(  {
                    minLength: 1,
                    source: function( request, response )
                    {
                        $.getJSON(url, request, function( data, status, xhr ) {
                            response(data);
                        });
                    },
                    select: function(event, ui) {             	
                        $('#'+arr[0]+'-'+arr[1]+'-'+id_option).val(ui.item.id);
                    }
                });

	
	
}