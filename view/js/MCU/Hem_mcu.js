$(function(){
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
			var eo1 = $( "#eo1" ),
				allFields = $( [] ).add( eo1 ),
				tips = $( ".validateTips" );
			var eo2 = $( "#eo2" ),
				allFields = $( [] ).add( eo2 ),
				tips = $( ".validateTips" );
			var led1 = $( "#led1" ),
				allFields = $( [] ).add( led1 ),
				tips = $( ".validateTips" );
			var led2 = $( "#eled2" ),
				allFields = $( [] ).add( led2 ),
				tips = $( ".validateTips" );
			var leu1 = $( "#leu1" ),
				allFields = $( [] ).add( leu1 ),
				tips = $( ".validateTips" );
			var leu2 = $( "#leu2" ),
				allFields = $( [] ).add( leu2 ),
				tips = $( ".validateTips" );
			var hg1 = $( "#hg1" ),
				allFields = $( [] ).add( hg1 ),
				tips = $( ".validateTips" );
			var hg2 = $( "#hg2" ),
				allFields = $( [] ).add( hg2 ),
				tips = $( ".validateTips" );
				
			function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
				setTimeout(function() {
					tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
			}
			
			function checkLength( o, n, min, max ) {
			if ( o.val().length > max || o.val().length < min ) {
				o.addClass( "ui-state-error" );
				updateTips( "Length of " + n + " must be between " +
					min + " and " + max + "." );
				return false;
			} else {
				return true;
			}
			}

			function checkRegexp( o, regexp, n ) {
				if ( !( regexp.test( o.val() ) ) ) {
					o.addClass( "ui-state-error" );
					updateTips( n );
					return false;
				} else {
					return true;
				}
			}
			
			$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 350,
			width: 350,
			modal: true,
			buttons: {
				"Submit": function() {
					var bValid = true;
					var diagnosa = '';
					allFields.removeClass( "ui-state-error" );

				//	bValid = bValid && checkLength( name, "diagnosa", 3, 16 );

				//	if ( bValid ) {
				//		var url = "index.php?add=true&var="+name.val();
				//		window.open(url,"_self")
					var url = "index.php?content=two&add=true";
					if (eo1.val()!="")
						url = url+"&eo1="+eo1.val();
					window.open(url,"_self")
					$( this ).dialog( "close" );
				//	}
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
			});

			$( "#add_diagnosa" )
				.click(function() {
					$( "#dialog-form" ).dialog( "open" );
				});
		});