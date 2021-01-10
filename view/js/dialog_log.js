$(function(){
	/*		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
			var name = $( "#diagnosa" ),
				allFields = $( [] ).add( name ),
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
			
			$( "#dialog-form-2" ).dialog({
			autoOpen: false,
			height: 200,
			width: 350,
			modal: true,
			show:{
				"Add Diagnosa": function() {
					var bValid = true;
					var diagnosa = '';
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkLength( name, "diagnosa", 3, 16 );

					if ( bValid ) {
						var url = "index.php?content=first&add=true&var="+name.val();
						window.open(url,"_self")
						$( this ).dialog( "close" );
					}
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
				});*/
		$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var domain = $( "#domain" ),
			password = $( "#password" ),
			allFields = $( [] ).add( domain ),
			tips = $( ".validateTips" );
				
		function checkLength( o, n, min, max ) {
			if((domain.val()!="") && password.val()!="") {
				o.addClass( "ui-state-error" );
				return false;
			} else {
				return true;
			}
			}
	
		$( "#dialog-form-2" ).dialog({
			modal: true,
			buttons: {
				Ok: function() {
					var bvalid = true;
					
					if((domain.val()!="") && password.val()!=""){
					//	document.form_hide.dom.value = domain.val();
					//	document.form_hide.pas.value = password.val();
						var url = "index.php?domain="+domain.val()+"&password="+password.val();	
					//	var url = "index.php";	
						window.open(url,"_self")
						$( this ).dialog( "close" );
					}else{
						allFields.removeClass( "ui-state-error" );
						if(domain.val()==""){
							domain.addClass( "ui-state-error" );
						}else if(password.val()==""){
							password.addClass( "ui-state-error" );
						}
					}
				}
			}
		});
	});
		});