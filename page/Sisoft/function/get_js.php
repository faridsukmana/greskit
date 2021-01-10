<?php
	//------*****************************************----Fungsi yang dibutuhkan dalam halaman page---*************************------------

########################################################## KHUSUS JAVASCRIPT, JQUERY AND FRIEND###########################################	
	
	//===========Fungsi untuk menampilkan data ke dalam jeasyui tabel menggunakan id tanpa melewatkan parameter url
	//===========Efek tidak akan menampilkan loading data, dan terlalu berat untuk digunakan, cocok untuk 
	//===========Aplikasi mobile berbasis web
	//===========Dengan cara menyesuaikan id pada tabel ke dengan fungsi yang ada dalam get_jd_data_easyui
	function get_jd_data_easyui(){
		$content = "
			<script>
			$(function(){
				$('#tt').datagrid({
					data: data
				});
			});
			</script>
			";
		return $content;
	}
	
	//===========Fungsi dialog form untuk query========================
	function get_dialog_form($data){
		$name_id = $data[0];
		return $content ='
			<script>
				$(function(){
					$("#'.$name_id.'").dialog({
						width:300,
						height:100
					})
				});
			</script>
		';
	}
	
	//===========Text Area dengan TInyMCE===============================
	function get_js_textarea(){
		$content = "
			<script>
			var RTL = false;

			function mockSpellcheck(method, data, success) {
				if (method == \"spellcheck\") {
					var words = data.match(this.getWordCharPattern());
					var suggestions = {};

					for (var i = 0; i < words.length; i++) {
						suggestions[words[i]] = [\"First\", \"second\"];
					}

					success({words: suggestions, dictionary: true});
				}

				if (method == \"addToDictionary\") {
					success();
				}
			}

			tinymce.init({
				selector: \"textarea#elm1\",
				rtl_ui: RTL,

				theme: \"modern\",
				plugins: [
					\"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker\",
					\"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking\",
					\"save table contextmenu directionality emoticons template paste textcolor importcss colorpicker textpattern\"
				],
				external_plugins: {
					//\"moxiemanager\": \"/moxiemanager-php/plugin.js\"
				},
				content_css: \"css/development.css\",
				add_unload_trigger: false,

				toolbar: \"insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons table\",

				image_advtab: true,

				style_formats: [
					{title: 'Bold text', format: 'h1'},
					{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
					{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
					{title: 'Example 1', inline: 'span', classes: 'example1'},
					{title: 'Example 2', inline: 'span', classes: 'example2'},
					{title: 'Table styles'},
					{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
				],

				template_replace_values : {
					username : \"Jack Black\"
				},

				template_preview_replace_values : {
					username : \"Preview user name\"
				},

				link_class_list: [
					{title: 'Example 1', value: 'example1'},
					{title: 'Example 2', value: 'example2'}
				],

				image_class_list: [
					{title: 'Example 1', value: 'example1'},
					{title: 'Example 2', value: 'example2'}
				],

				templates: [
					{title: 'Some title 1', description: 'Some desc 1', content: '<strong class=\"red\">My content</strong>'},
					{title: 'Some title 2', description: 'Some desc 2', url: 'development.html'}
				],

				spellchecker_callback: mockSpellcheck
			});

			tinymce.init({
				selector: \"textarea#small\",
				toolbar_items_size: 'small',
				rtl_ui: RTL,

				theme: \"modern\",
				plugins: [
					\"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker\",
					\"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking\",
					\"save table contextmenu directionality emoticons template paste textcolor importcss colorpicker textpattern\"
				],
				external_plugins: {
					//\"moxiemanager\": \"/moxiemanager-php/plugin.js\"
				},
				content_css: \"css/development.css\",
				add_unload_trigger: false,

				toolbar: \"insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons table\",

				image_advtab: true,

				style_formats: [
					{title: 'Bold text', format: 'h1'},
					{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
					{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
					{title: 'Example 1', inline: 'span', classes: 'example1'},
					{title: 'Example 2', inline: 'span', classes: 'example2'},
					{title: 'Table styles'},
					{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
				],

				template_replace_values : {
					username : \"Jack Black\"
				},

				template_preview_replace_values : {
					username : \"Preview user name\"
				},

				link_class_list: [
					{title: 'Example 1', value: 'example1'},
					{title: 'Example 2', value: 'example2'}
				],

				image_class_list: [
					{title: 'Example 1', value: 'example1'},
					{title: 'Example 2', value: 'example2'}
				],

				templates: [
					{title: 'Some title 1', description: 'Some desc 1', content: '<strong class=\"red\">My content</strong>'},
					{title: 'Some title 2', description: 'Some desc 2', url: 'development.html'}
				],

				spellchecker_callback: mockSpellcheck
			});
		</script>
		";
		return $content;
	}

	//===========Mendapatkan grafik dengan highcharts===================
	function get_js_graph($data){
		$query = $data[0];
		$model = $data[1];
		$title = $data[2];
		$name = $data[3];
		$id = $data[4];
		$width = $data[5];
		$height = $data[6];
		$typequery = $data[7];
		$page = $data[8];
		$totaltitle = $data[9];
		//------- Model kolom bentuk 3D---------------
		if(strcmp($model,'3d-column-interactive')==0){
			$data=''; $categories='';
			if(strcmp($typequery,'typequery1')==0){
				$result = mysql_query($query) or die('Failed Query 3d-pie and Typequery1, <span style="color:red"><b>Please Make Sure Tax Rate Updated</b></span>'); $i=0; $num_row=mysql_num_rows($result); $data = '';
				while($result_now = mysql_fetch_array($result)){
					if($i==$num_row-1){
						$categories .= "'".$result_now[0]."'";
						$data.="{name:'".$result_now[0]."',y:".$result_now[1].",events:{click:function(){window.location='".$page."'+this.name;}}}"; 
					}else{
						$categories .= "'".$result_now[0]."',";
						$data.="{name:'".$result_now[0]."',y:".$result_now[1].",events:{click:function(){window.location='".$page."'+this.name;}}},"; 
					}
					$i++;
				}
			}
			$categories = '['.$categories .']'; 
			$data = '['.$data.']'; 
			$content = "
					<script type=\"text/javascript\">
						$(function () {
							$('#".$id."').highcharts({
								chart: {
									type: 'column'
								},
								title: {
									text: '".$title."'
								},
								subtitle: {
									text: ''
								},
								xAxis: {
									categories: ".$categories.",
									crosshair: true
								},
								yAxis: {
									title: {
										text: ''
									}
								},
								tooltip: {
									headerFormat: '<span style=\"font-size:13px\">{point.key}</span><table>',
									pointFormat: '<tr><td style=\"color:{series.color};padding:0\"></td></tr>' +
										'<tr><td style=\"font-size:12px\">Total : <br/><b>{point.y:.2f}</td></tr>',
									footerFormat: '</table>',
									shared: true,
									useHTML: true
								},
								plotOptions: {
									column: {
										pointPadding: 0.2,
										borderWidth: 0
									}
								},
								credits: {
									enabled: false
								},
								series: [{
									name: '".$name."',
									data: ".$data."
								}]
							});
						});
					</script>
					";
		}
		//-------Model pie 3D----------------
		else if(strcmp($model,'3d-pie')==0){
			if(strcmp($typequery,'typequery1')==0){
				$result = mysql_query($query) or die('Failed Query 3d-pie and Typequery1, <span style="color:red"><b>Please Make Sure Tax Rate Updated</b></span>'); $i=0; $num_row=mysql_num_rows($result); $data = '';
				while($result_now = mysql_fetch_array($result)){
					if($i==$num_row-1){
						$data.="{name:'".$result_now[0]."',y:".$result_now[1].",events:{click:function(){window.location='".$page."'+this.name;}}}"; 
					}else{
						$data.="{name:'".$result_now[0]."',y:".$result_now[1].",events:{click:function(){window.location='".$page."'+this.name;}}},"; 
					}
					$i++;
				}
			}
			if(strcmp($typequery,'typequery2')==0){ 
				$result = mysql_query($query) or die('Failed Query 3d-pie and typequery2, <span style="color:red"><b>Please Make Sure Tax Rate Updated</b><span>'); $i=0; $data = '';
				$num_field = mysql_num_fields($result);
				$result_now = mysql_fetch_array($result);
				while($i<$num_field){
					if($i==$num_field-1){
						$data.="{name:'".str_replace('_',' ',mysql_field_name($result,$i))."',y:".$result_now[$i].",events:{click:function(){window.location='".$page."'+this.name;}}}";
					}else{
						$data.="{name:'".str_replace('_',' ',mysql_field_name($result,$i))."',y:".$result_now[$i].",events:{click:function(){window.location='".$page."'+this.name;}}},";
					}
					$i++;
				}
			}
			$data = '['.$data.']'; 
			$content = "
					<script type='text/javascript'>
						$(function () {
							$('#".$id."').highcharts({
								chart: {
									type: 'pie',
									plotBackgroundColor: null,
									plotBorderWidth: null,
									plotShadow: false,
									height: ".$height.",
									width : ".$width."
								},
								title: {
									text: '".$title."'
								},
								tooltip: {
									pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br>".$totaltitle." : <b>{point.y}<b></br>'
								},
								plotOptions: {
									pie: {
										allowPointSelect: true,
										cursor: 'pointer',
										depth: 35,
										dataLabels: {
											enabled: true,
											format: '{point.name}'
										}
									}
								},
								series: [{
									type: 'pie',
									name: '".$name."',
									data: ".$data."
								}]
							});
						});
					</script>
			";
		}
		
		return $content;
	}
	
	//===========JAVASCRIPT untuk jeasyui =============================
	//-----------datebox_onselect untuk mendapatkan date dari datebox--
	function datebox_onselect($page){
		$content ="
			<script>
			    function onSelect(date){
					//$('#result').text(date);
					var y = date.getFullYear();
					var m = date.getMonth()+1;
					var d = date.getDate();
					var date = y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
					window.location='".$page."&date='+date;
				}
				
				function myformatter(date){
					var y = date.getFullYear();
					var m = date.getMonth()+1;
					var d = date.getDate();
					return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
				}
				function myparser(s){
					if (!s) return new Date();
					var ss = (s.split('-'));
					var y = parseInt(ss[0],10);
					var m = parseInt(ss[1],10);
					var d = parseInt(ss[2],10);
					if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
						return new Date(y,m-1,d);
					} else {
						return new Date();
					}
				}
		   </script>
		";
		return $content;
	}
	
	//-----------combobox_onselect untuk mendapatkan date dari datebox--
	function combobox_onselect($data){
		$page = $data[0];
		$id = $data[1];		
		$type = $data[2];
		if($type==1){
		$content = "
			<script>
				$('#".$id."').combobox({
					onChange:function(newValue,oldValue){
						window.location='".$page."&".$id."='+newValue;
					}
				});
			</script>
		";
		}else if($type==2){
		$content = "
			<script>
				$('#".$id."').combobox({
					onChange:function(newValue,oldValue){
						window.location='".$page."';
					}
				});
			</script>
		";
		}
		return $content;
	}
	
	function datebox_onselect2nd($data){
		$page = $data[0];
		$id = $data[1];		
		$content = "
			<script>
				$('#".$id."').datebox({
					onChange:function(newValue,oldValue){
						window.location='".$page."&".$id."='+newValue;
					}
				});
			</script>
		";
		return $content;
	}
	
	//-----------Fungsi merubah field lain pada id tertentu ketika terjadi perubahan nilai-------------//
	function box_onchange($data){
		$page = $data[0];
		$id = $data[1];	
		/*$content = "
			<script>
			$(function(){
				   $('#".$id."').textbox('textbox').css('text-transform','uppercase');
			});
			</script>
		";*/
		/*$content = "
			<script>
			$(function(){
					var u = $('#".$id."');
					var t = $('#days');
					u.textbox('textbox').bind('keydown', function(e){
						if (e.keyCode == 9 || e.keyCode == 32){	// when press ENTER key, accept the inputed value.
							t.textbox('setValue', '3');
						}
					});
			});
			</script>
		";*/
		if(strcmp($id,'wpdays')==0){
			$content = "
				<script>
				$(function(){
						var u = $('#".$id."');
						var e = $('#tarcdate');
						u.textbox({
						  onChange: function(value){
							var valuedate = $('#tarsdate').datebox('getText');
							var valdate = new Date(valuedate);
							var tarcdate = new Date(valdate);
							
							// Get pm frequency 
							var pmfreq = $('#freq').textbox('getText');
							pmfreq = parseInt(pmfreq);
							
							var v = $('#frequ').combobox('getText');
							if(v=='Days')
								tdays = pmfreq*1;
							else if(v=='Weeks')
								tdays = pmfreq*7;
							else if(v=='Months')
								tdays = pmfreq*28;
							if(v=='Years')
								tdays = pmfreq*365;
							
							// Get work periode days with u variable
							var lengthwpdays = u.textbox('getText');
							lengthwpdays = parseInt(lengthwpdays);
							
							if(tdays<lengthwpdays){
								alert('Work Period days can not be larger than PM Frequency');
							}else{
								// For set automatic Target Completed Date
								tarcdate.setDate(tarcdate.getDate() + lengthwpdays);
								var dd = ('0' + tarcdate.getDate()).slice(-2);
								var mm = ('0' + (tarcdate.getMonth() + 1)).slice(-2);
								var y = tarcdate.getFullYear();
								var Ftarcdate = mm + '/' + dd + '/' + y;
								
								e.datebox('setValue', Ftarcdate);
							}
						  }
						});
				});
				</script>
			";
		}else if(strcmp($id,'indate')==0){
			$content = "
				<script>
				$(function(){
						var u = $('#".$id."');
						var d = $('#tarsdate');
						var e = $('#tarcdate');
						var f = $('#nextdate');
						var t = $('#days');
						var w = $('#wpdays');
						u.datebox({
						  onChange: function(value){
							var valuedate = $('#".$id."').datebox('getText');
							var valdate = new Date(valuedate);
							var tarsdate = new Date(valdate);
							var tarcdate = new Date(valdate);
							
							// Get days length from t variable 
							var lengthdays = t.textbox('getText');
							lengthdays = parseInt(lengthdays);
							
							// For set automatic Target Start Date
							tarsdate.setDate(tarsdate.getDate() + lengthdays);
							var dd = ('0' + tarsdate.getDate()).slice(-2);
							var mm = ('0' + (tarsdate.getMonth() + 1)).slice(-2);
							var y = tarsdate.getFullYear();
							var Ftarsdate = mm + '/' + dd + '/' + y;
							
							// Get work periode days with w variable
							var lengthwpdays = w.textbox('getText');
							lengthwpdays = parseInt(lengthwpdays);
							
							// For set automatic Target Completed Date
							tarcdate.setDate(tarcdate.getDate() + lengthdays + lengthwpdays);
							var dd = ('0' + tarcdate.getDate()).slice(-2);
							var mm = ('0' + (tarcdate.getMonth() + 1)).slice(-2);
							var y = tarcdate.getFullYear();
							var Ftarcdate = mm + '/' + dd + '/' + y;
							
							// For set automatic Next Completed Date
							var nextdate = new Date(Ftarsdate);
							nextdate.setDate(nextdate.getDate() + lengthdays);
							var dd = ('0' + nextdate.getDate()).slice(-2);
							var mm = ('0' + (nextdate.getMonth() + 1)).slice(-2);
							var y = nextdate.getFullYear();
							var Fnextdate = mm + '/' + dd + '/' + y;
							
							d.datebox('setValue', Ftarsdate);
							e.datebox('setValue', Ftarcdate);
							f.datebox('setValue', Fnextdate);
						  }
						});
				});
				</script>
			";
		}else if(strcmp($id,'frequ')==0){
			$content = "
				<script>
				$(function(){
						var u = $('#".$id."');
						var t = $('#days');
						var n = $('#freq');
						var m = $('#wpdays');
						u.combobox({
						  onChange: function(value){
							t.textbox('setValue', 0);
							n.textbox('setValue', 0);
							m.textbox('setValue', 0);
						  }
						});
				});
				</script>
			";
		}elseif(strcmp($id,'freq')==0){
			$content = "
				<script>
				$(function(){
						var tdays = 0;
						var u = $('#".$id."');
						var t = $('#days');
						var d = $('#tarsdate');
						var e = $('#tarcdate');
						var f = $('#nextdate');
						var w = $('#wpdays');
						u.textbox({
						  onChange: function(value){
							var v = $('#frequ').combobox('getText');
							var n = $('#freq').textbox('getText');
							if(v=='Days')
								tdays = n*1;
							else if(v=='Weeks')
								tdays = n*7;
							else if(v=='Months')
								tdays = n*28;
							if(v=='Years')
								tdays = n*365;
							t.textbox('setValue', tdays);
							
							var valuedate = $('#indate').datebox('getText');
							var valdate = new Date(valuedate);
							var tarsdate = new Date(valdate);
							var tarcdate = new Date(valdate);
							
							// Get days length from t variable 
							var lengthdays = t.textbox('getText');
							lengthdays = parseInt(lengthdays);
							
							// For set automatic Target Start Date
							tarsdate.setDate(tarsdate.getDate() + lengthdays);
							var dd = ('0' + tarsdate.getDate()).slice(-2);
							var mm = ('0' + (tarsdate.getMonth() + 1)).slice(-2);
							var y = tarsdate.getFullYear();
							var Ftarsdate = mm + '/' + dd + '/' + y;
							
							// Get work periode days with w variable
							var lengthwpdays = w.textbox('getText');
							lengthwpdays = parseInt(lengthwpdays);
							
							// For set automatic Target Completed Date
							tarcdate.setDate(tarcdate.getDate() + lengthdays + lengthwpdays);
							var dd = ('0' + tarcdate.getDate()).slice(-2);
							var mm = ('0' + (tarcdate.getMonth() + 1)).slice(-2);
							var y = tarcdate.getFullYear();
							var Ftarcdate = mm + '/' + dd + '/' + y;
							
							// For set automatic Next Completed Date
							var nextdate = new Date(Ftarsdate);
							nextdate.setDate(nextdate.getDate() + lengthdays);
							var dd = ('0' + nextdate.getDate()).slice(-2);
							var mm = ('0' + (nextdate.getMonth() + 1)).slice(-2);
							var y = nextdate.getFullYear();
							var Fnextdate = mm + '/' + dd + '/' + y;
							
							d.datebox('setValue', Ftarsdate);
							e.datebox('setValue', Ftarcdate);
							f.datebox('setValue', Fnextdate);
						  }
						});
				});
				</script>
			";
		}
		return $content;
	}
	
	//===========Menampilkan data handsontable di js===================
	//-----------Fungsi hanya untuk load data pada handsontable dan tidak disertai dengan style total
	function get_handson($sethandson){
		$head = $sethandson[0];
		$id = $sethandson[1];
		$data = $sethandson[2];
		$width = $sethandson[3];
		$fixedcolleft = $sethandson[4];
		$content = "
			<script data-jsfiddle='example1'>
            var data = ".$data.",
              container = document.getElementById(\"example1\"),
              lastChange = null,
              hot;
			
            hot = new Handsontable(container, {
              data: data,
			  colWidths: ".$width.",
              colHeaders: true,
              rowHeaders: true,
			  colHeaders: ".$head.",
			  colFooters: ['Testing', 'If', 'This', 'Works'],
              minSpareRows: 0,
			  manualColumnResize: true,
			  manualRowResize: true,
			  columnSorting: true,
			  columns: ".$id.",
			  sortIndicator: true,
			  dropdownMenu: true,
			  filters: true,
			  fixedColumnsLeft:".$fixedcolleft.",
			  className: 'htRight'
			});
          </script>
		";
		return $content;
	}
	
	//-----------Fungsi hanya untuk load data pada handsontable dan untuk conditional format background
	function get_handson_conditional($sethandson){
		$head = $sethandson[0];
		$id = $sethandson[1];
		$data = $sethandson[2];
		$width = $sethandson[3];
		$fixedcolleft = $sethandson[4];
		$content = "
			<script data-jsfiddle='example1'>
            var data = ".$data.",
              container = document.getElementById(\"example1\"),
              lastChange = null,
              hot;
			
			function DataRowRenderer(instance, td, row, col, prop, value, cellProperties) {
				Handsontable.renderers.NumericRenderer.apply(this, arguments);
				    // if row contains negative number
					if (parseInt(value, 10) > 0) {
					  $(td).parent().addClass('someColorClassName'); 
					}

			}
			
			function DataRowRendererTwo(instance, td, row, col, prop, value, cellProperties) {
				Handsontable.renderers.NumericRenderer.apply(this, arguments);
				    // if row contains negative number
					if (parseInt(value, 10) > 0) {
					  $(td).parent().addClass('someColorClassNameTwo'); 
					}

			}
			
			function DataRowRendererThree(instance, td, row, col, prop, value, cellProperties) {
				Handsontable.renderers.NumericRenderer.apply(this, arguments);
				    // if row contains negative number
					if (parseInt(value, 10) > 0) {
					  $(td).parent().addClass('someColorClassNameThree'); 
					}

			}
			
            hot = new Handsontable(container, {
              data: data,
			  colWidths: ".$width.",
              colHeaders: true,
              rowHeaders: true,
			  colHeaders: ".$head.",
			  colFooters: ['Testing', 'If', 'This', 'Works'],
              minSpareRows: 0,
			  manualColumnResize: true,
			  manualRowResize: true,
			  columns: ".$id.",
			  dropdownMenu: true,
			  filters: true,
			  fixedColumnsLeft:".$fixedcolleft.",
			  className: 'htRight',
			  cells: function (row, col, prop) {
				var cellProperties = {};
				if(col==12 || col==13 || col==14 || col==15 || col==16)	
					cellProperties.renderer = DataRowRenderer; 
				if(col==11 && this.instance.getData()[row][col+1] == 0
					&& this.instance.getData()[row][col+2] == 0
					&& this.instance.getData()[row][col+3] == 0
					&& this.instance.getData()[row][col+4] == 0
					&& this.instance.getData()[row][col+5] == 0)
					cellProperties.renderer = DataRowRendererTwo; 
				if(col==10 && this.instance.getData()[row][col+1] == 0 && this.instance.getData()[row][col+2] == 0
					&& this.instance.getData()[row][col+3] == 0
					&& this.instance.getData()[row][col+4] == 0
					&& this.instance.getData()[row][col+5] == 0
					&& this.instance.getData()[row][col+6] == 0)
					cellProperties.renderer = DataRowRendererThree; 
				return cellProperties;
			  }
			});
          </script>
		";
		return $content;
	}
	
	function get_handson_conditional_dest($sethandson){
		$head = $sethandson[0];
		$id = $sethandson[1];
		$data = $sethandson[2];
		$width = $sethandson[3];
		$fixedcolleft = $sethandson[4];
		$fixedRowsTop = $sethandson[5];
		$content = "
			<script data-jsfiddle='example1'>
            var data = ".$data.",
              container = document.getElementById(\"example1\"),
              lastChange = null,
              hot;
			
			function endRowRenderer(instance, td, row, col, prop, value, cellProperties) {
				Handsontable.renderers.NumericRenderer.apply(this, arguments);
				td.style.fontWeight = 'bold';
				td.style.color = 'green';
				td.style.background = '#CEC';
				$(td).parent().addClass('FirstRowColor'); 
			}
			
			function DataRowRenderer(instance, td, row, col, prop, value, cellProperties) {
				Handsontable.renderers.NumericRenderer.apply(this, arguments);
				    // if row contains negative number
					if (parseInt(value, 10) > 0) {
					  $(td).parent().addClass('someColorClassName'); 
					}

			}
			
			function DataRowRendererTwo(instance, td, row, col, prop, value, cellProperties) {
				Handsontable.renderers.NumericRenderer.apply(this, arguments);
				    // if row contains negative number
					if (parseInt(value, 10) > 0) {
					  $(td).parent().addClass('someColorClassNameTwo'); 
					}

			}
			
			function DataRowRendererThree(instance, td, row, col, prop, value, cellProperties) {
				Handsontable.renderers.NumericRenderer.apply(this, arguments);
				    // if row contains negative number
					if (parseInt(value, 10) > 0) {
					  $(td).parent().addClass('someColorClassNameThree'); 
					}

			}
			
            hot = new Handsontable(container, {
              data: data,
			  colWidths: ".$width.",
              colHeaders: true,
              rowHeaders: true,
			  colHeaders: ".$head.",
			  colFooters: ['Testing', 'If', 'This', 'Works'],
              minSpareRows: 0,
			  manualColumnResize: true,
			  manualRowResize: true,
			  columns: ".$id.",
			  dropdownMenu: true,
			  filters: true,
			  fixedRowsTop: ".$fixedRowsTop.",
			  fixedColumnsLeft:".$fixedcolleft.",
			  className: 'htRight',
			  cells: function (row, col, prop) {
				var cellProperties = {};
				if (row === 0) {
				    cellProperties.renderer = endRowRenderer; // uses function directly
				}
				if(row > 0 && (col==14 || col==15 || col==16 || col==17 || col==18))	
					cellProperties.renderer = DataRowRenderer; 
				if(row > 0 && (col==13 && this.instance.getData()[row][col+1] == 0
					&& this.instance.getData()[row][col+2] == 0
					&& this.instance.getData()[row][col+3] == 0
					&& this.instance.getData()[row][col+4] == 0
					&& this.instance.getData()[row][col+5] == 0))
					cellProperties.renderer = DataRowRendererTwo; 
				if(row > 0 && (col==12 && this.instance.getData()[row][col+1] == 0 && this.instance.getData()[row][col+2] == 0
					&& this.instance.getData()[row][col+3] == 0
					&& this.instance.getData()[row][col+4] == 0
					&& this.instance.getData()[row][col+5] == 0
					&& this.instance.getData()[row][col+6] == 0))
					cellProperties.renderer = DataRowRendererThree; 
				return cellProperties;
			  }
			});
          </script>
		";
		return $content;
	}
	
	//-----------Fungsi hanya untuk load data pada handsontable dan disertai dengan style total
	function get_handson_total($sethandson){
		$head = $sethandson[0];
		$id = $sethandson[1];
		$data = $sethandson[2];
		$width = $sethandson[3];
		$fixedcolleft = $sethandson[4];
		$fixedRowsTop = $sethandson[5];
		$content = "
			<script data-jsfiddle='example1'>
            var data = ".$data.",
              container = document.getElementById(\"example1\"),
              lastChange = null,
              hot;
			
			function endRowRenderer(instance, td, row, col, prop, value, cellProperties) {
				Handsontable.renderers.NumericRenderer.apply(this, arguments);
				td.style.fontWeight = 'bold';
				td.style.color = 'green';
				td.style.background = '#CEC';
			}
			
            hot = new Handsontable(container, {
              data: data,
			  colWidths: ".$width.",
              colHeaders: true,
              rowHeaders: true,
			  colHeaders: ".$head.",
			  colFooters: ['Testing', 'If', 'This', 'Works'],
              minSpareRows: 0,
			  manualColumnResize: true,
			  manualRowResize: true,
			  columns: ".$id.",
			  dropdownMenu: true,
			  filters: true,
			  fixedRowsTop: ".$fixedRowsTop.",
			  fixedColumnsLeft:".$fixedcolleft.",
			  className: 'htRight',
			  cells: function (row, col, prop) {
				var cellProperties = {};
			//	var trow = countRows();
				if (row === 0) {
				    cellProperties.renderer = endRowRenderer; // uses function directly
				}
				return cellProperties;
			  }
			});
          </script>
		";
		return $content;
	}
	
	//-----------Fungsi hanya untuk load, save, reset data pada handsontable
	function get_handson_loadsave($sethandson){
		$head = $sethandson[0];
		$id = $sethandson[1];
		$data = $sethandson[2];
		$width = $sethandson[3];
		$url = $sethandson[4];
		$content = "
		<script>
			var
			  data = ".$data.",
			  container = $(\"#example1\"),
			  console = $(\"#exampleConsole\"),
			  parent = container.parent(),
			  autosaveNotification,
			  hot;

			hot = new Handsontable(container[0], {
			  data: data,
			  colWidths: ".$width.",
			  columnSorting: true,
			  startRows: 8,
			  startCols: 3,
			  rowHeaders: true,
			  colHeaders: ".$head.",
			  columns: ".$id.",
			  minSpareCols: 0,
			  minSpareRows: 1,
			  dropdownMenu: true,
			  filters: true,
			  contextMenu: true
			});

			parent.find('button[name=load]').click(function () {
			  $.ajax({
				url: 'data/load.php',
				dataType: 'json',
				type: 'GET',
				success: function (res) {
				  var data = [], row;

				  for (var i = 0, ilen = res.cars.length; i < ilen; i++) {
					row = [];
					row[0] = res.cars[i].manufacturer;
					row[1] = res.cars[i].year;
					row[2] = res.cars[i].price;
					data[res.cars[i].id - 1] = row;
				  }
				  console.text('Data loaded');
				  hot.loadData(data);
				}
			  });
			}).click(); // execute immediately

			parent.find('button[name=save]').click(function () {
			  $.ajax({
				url: '".$url."',
				data: {data: hot.getData()}, // returns all cells' data
				dataType: 'json',
				type: 'POST',
				success: function (res) {
				  if (res.result === 'ok') {
					console.text('Data saved');
				  }
				  else {
					console.text('Save error');
				  }
				},
				error: function () {
				  console.text('Save error function');
				}
			  });
			});

			parent.find('button[name=reset]').click(function () {
			  $.ajax({
				url: 'php/reset.php',
				success: function () {
				  parent.find('button[name=load]').click();
				},
				error: function () {
				  console.text('Data reset failed');
				}
			  });
			});

			parent.find('input[name=autosave]').click(function () {
			  if ($(this).is(':checked')) {
				console.text('Changes will be autosaved');
			  }
			  else {
				console.text('Changes will not be autosaved');
			  }
			});
		</script>
		";
		return $content;
	}
	//-----------Fungsi hanya untuk load data pada handsontable dan tidak disertai dengan style total dan bisa edit id
	function get_handson_id($sethandson){
		$head = $sethandson[0];
		$id = $sethandson[1];
		$data = $sethandson[2];
		$width = $sethandson[3];
		$fixedcolleft = $sethandson[4];
		$idcss = $sethandson[5];
		$content = "
			<script data-jsfiddle='".$idcss."'>
            var data = ".$data.",
              container = document.getElementById(\"".$idcss."\"),
              lastChange = null,
              hot;
			
            hot = new Handsontable(container, {
              data: data,
			  colWidths: ".$width.",
              colHeaders: true,
              rowHeaders: true,
			  colHeaders: ".$head.",
			  colFooters: ['Testing', 'If', 'This', 'Works'],
              minSpareRows: 0,
			  manualColumnResize: true,
			  manualRowResize: true,
			  columnSorting: true,
			  columns: ".$id.",
			  sortIndicator: true,
			  dropdownMenu: true,
			  filters: true,
			  fixedColumnsLeft:".$fixedcolleft.",
			  className: 'htRight'
			});
          </script>
		";
		return $content;
	}
#########################################################################################################################################	
?>