<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminBioReporteController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "bio_camara";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];

			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Mac','name'=>'id_mac','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'mac,id'];
			$this->form[] = ['label'=>'Name','name'=>'nombre','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Center','name'=>'id_bio_centro','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'bio_centro,id'];
			$this->form[] = ['label'=>'Description','name'=>'descripcion','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Monday','name'=>'lunes','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tuesday','name'=>'martes','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Wednesday','name'=>'miercoles','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Thursday','name'=>'jueves','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Friday','name'=>'viernes','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Saturday','name'=>'sabado','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Sunday','name'=>'domingo','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Users','name'=>'id_cms_users','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'cms_users,name'];
			$this->form[] = ['label'=>'Time Zone','name'=>'id_bio_zona_horaria','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'bio_zona_horaria,id'];
			$this->form[] = ['label'=>'Average Amperage','name'=>'amperaje_promedio','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Mac","name"=>"id_mac","type"=>"select2","required"=>TRUE,"validation"=>"required|min:1|max:255","datatable"=>"mac,id"];
			//$this->form[] = ["label"=>"Nombre","name"=>"nombre","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Bio Centro","name"=>"id_bio_centro","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"bio_centro,id"];
			//$this->form[] = ["label"=>"Descripcion","name"=>"descripcion","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Lunes","name"=>"lunes","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Martes","name"=>"martes","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Miercoles","name"=>"miercoles","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Jueves","name"=>"jueves","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Viernes","name"=>"viernes","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Sabado","name"=>"sabado","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Domingo","name"=>"domingo","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Cms Users","name"=>"id_cms_users","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"cms_users,name"];
			//$this->form[] = ["label"=>"Bio Zona Horaria","name"=>"id_bio_zona_horaria","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"bio_zona_horaria,id"];
			//$this->form[] = ["label"=>"Amperaje Promedio","name"=>"amperaje_promedio","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = "
	        
	        
	        
	        
	        function dibujarCentro(nombre, centro_id)
			{
				$('#resultados').append( $('#template_centro').html().replace('_NOMBRE_', nombre).replace(/_ID_/g, centro_id) );
			}
		
			function dibujarCamara(centro_id, nombre, seven_days, one_month, prev_month, mac, menos7,menos6,menos5,menos4,menos3,menos2,menos1, prev_month1, prev_month2)
			{
				if(seven_days == 1)
					seven_days = '1 session';
				else
					seven_days = seven_days + ' ".trans('biobarica.labels.sessions')."';
				
				
				if(one_month.split('_')[1] == 1)
					one_monthd = '1 session';
				else
					one_monthd = one_month.split('_')[1] + ' ".trans('biobarica.labels.sessions')."';
				
				one_monthl = one_month.split('_')[0];
				
				
				
				if(prev_month.split('_')[1] == 1)
					prev_monthd = '1 session';
				else
					prev_monthd = prev_month.split('_')[1] + ' ".trans('biobarica.labels.sessions')."';
				
				prev_monthl = prev_month.split('_')[0];
				
				
				if(prev_month1.split('_')[1] == 1)
					prev_month1d = '1 session';
				else
					prev_month1d = prev_month1.split('_')[1] + ' ".trans('biobarica.labels.sessions')."';
				
				prev_month1l = prev_month1.split('_')[0];
				
				if(prev_month2.split('_')[1] == 1)
					prev_month2d = '1 session';
				else
					prev_month2d = prev_month2.split('_')[1] + ' ".trans('biobarica.labels.sessions')."';
				
				prev_month2l = prev_month2.split('_')[0];
				
				
				
				if(menos7.split('_')[1] == 1)
					menos7d = '1 session';
				else
					menos7d = menos7.split('_')[1] + ' ".trans('biobarica.labels.sessions')."';
				
				menos7l = menos7.split('_')[0];
				
				if(menos6.split('_')[1] == 1)
					menos6d = '1 session';
				else
					menos6d = menos6.split('_')[1] + ' ".trans('biobarica.labels.sessions')."';
				
				menos6l = menos6.split('_')[0];
				
				if(menos5.split('_')[1] == 1)
					menos5d = '1 session';
				else
					menos5d = menos5.split('_')[1] + ' ".trans('biobarica.labels.sessions')."';
				
				menos5l = menos5.split('_')[0];
				
				if(menos6.split('_')[1] == 1)
					menos6d = '1 session';
				else
					menos6d = menos6.split('_')[1] + ' ".trans('biobarica.labels.sessions')."';
				
				menos6l = menos6.split('_')[0];
				
				if(menos5.split('_')[1] == 1)
					menos5d = '1 session';
				else
					menos5d = menos5.split('_')[1] + ' ".trans('biobarica.labels.sessions')."';
				
				menos5l = menos5.split('_')[0];
				
				if(menos4.split('_')[1] == 1)
					menos4d = '1 session';
				else
					menos4d = menos4.split('_')[1] + ' ".trans('biobarica.labels.sessions')."';
				
				menos4l = menos4.split('_')[0];
				
				if(menos3.split('_')[1] == 1)
					menos3d = '1 session';
				else
					menos3d = menos3.split('_')[1] + ' ".trans('biobarica.labels.sessions')."';
				
				menos3l = menos3.split('_')[0];
				
				if(menos2.split('_')[1] == 1)
					menos2d = '1 session';
				else
					menos2d = menos2.split('_')[1] + ' ".trans('biobarica.labels.sessions')."';
				
				menos2l = menos2.split('_')[0];
				
				if(menos1.split('_')[1] == 1)
					menos1d = '1 session';
				else
					menos1d = menos1.split('_')[1] + ' ".trans('biobarica.labels.sessions')."';
				
				menos1l = menos1.split('_')[0];
					
					
				$('#camaras_' + centro_id).append( $('#template_camara').html().replace('_NOMBRE_', nombre).replace('_SEVEN_DAYS_', seven_days).replace('_ONE_MONTH_L_', one_monthl).replace('_ONE_MONTH_', one_monthd).replace('_PREV_MONTH_L_', prev_monthl).replace('_PREV_MONTH_', prev_monthd).replace('_MAC_', mac).replace('_DIA_7_L_', menos7l).replace('_DIA_7_', menos7d).replace('_DIA_6_L_', menos6l).replace('_DIA_6_', menos6d).replace('_DIA_5_L_', menos5l).replace('_DIA_5_', menos5d).replace('_DIA_4_L_', menos4l).replace('_DIA_4_', menos4d).replace('_DIA_3_L_', menos3l).replace('_DIA_3_', menos3d).replace('_DIA_2_L_', menos2l).replace('_DIA_2_', menos2d).replace('_DIA_1_L_', menos1l).replace('_DIA_1_', menos1d).replace('_PREV_MONTH1_L_', prev_month1l).replace('_PREV_MONTH1_', prev_month1d).replace('_PREV_MONTH2_L_', prev_month2l).replace('_PREV_MONTH2_', prev_month2d) );
			}
	        
	        
	        
	        
	        
	        

					 

		    $(document).ready(function() {
		    
		    
		    if($('#infocentro').length == 1)
		    {
		    	//begin info centros
		    	
		    	var rightNow = new Date();
					
				var fecha_hasta = rightNow.toISOString().slice(0,10);
			
				rightNow.setDate( rightNow.getDate()-7 );
			
				var fecha_desde = rightNow.toISOString().slice(0,10);
			
				/* MOCK  */
				fecha_desde = '2017-08-02'; 
			
			
				google.charts.load('current', {packages: ['corechart', 'bar']});
				google.charts.setOnLoadCallback(function(){
				$.ajax({
					type: 'GET',
					async: true,
					url: site_url + '/admin/reporte/getEstadisticasCamarasHome',
					success: function(json){
						var i = 0;
						var centro_actual;
						var sesiones_mes_actual;
						var sesiones_mes_anerior;
						var cant_camaras;
						while(i < json.length)
						{
							centro_actual = json[i].centro_id;
							sesiones_mes_actual = 0;
							sesiones_mes_anterior = 0;
							cant_camaras = 0;
							dibujarCentro( json[i].descripcion, json[i].centro_id );
							
							arrData = null;
							arrData2 = null;
							
							con_sesiones = false;
							con_sesiones2 = false;
							while( i < json.length && centro_actual == json[i].centro_id )	
							{
								dibujarCamara(json[i].centro_id, json[i].nombre, json[i].seven_days, json[i].one_month, json[i].prev_month, json[i].id_mac, json[i].menos_7, json[i].menos_6, json[i].menos_5, json[i].menos_4, json[i].menos_3, json[i].menos_2, json[i].menos_1,json[i].prev_month1,json[i].prev_month2);
								cant_camaras++;
								sesiones_mes_actual += parseInt(json[i].one_month.split('_')[1]);
								sesiones_mes_anterior += parseInt(json[i].prev_month.split('_')[1]);
								
								cant_ses = parseInt(json[i].one_month.split('_')[1]);
								cant_ses2 = parseInt(json[i].prev_month.split('_')[1]);
								
								cant_year = parseInt(json[i].current_year.split('_')[1]);
								
								if( arrData == null )
								{
									arrData = [];
									arrData[arrData.length] = ['Camara', json[i].prev_month.split('_')[0], json[i].one_month.split('_')[0]];
								}
								
								if( arrData2 == null )
								{
									arrData2 = [];
									arrData2[arrData2.length] = ['Camara', json[i].current_year.split('_')[0]];
								}
								
								if(cant_ses > 0 || cant_ses2 > 0)
									con_sesiones = true;
									
								if(cant_year > 0)
									con_sesiones2 = true;
								
								arrData[arrData.length] = [json[i].nombre, cant_ses2, cant_ses];
								arrData2[arrData2.length] = [json[i].nombre, cant_year];
								
								i++;
								
							}
						
							//finaliza el centro, meto la info calculada



							//agrego el chart para el centro
							if(con_sesiones)
							{
							var data = google.visualization.arrayToDataTable(arrData);

							  var options = {
							  	height: 400,
								title: '".trans('biobarica.labels.sessionscurrentmonthprevious')."',
								chartArea:{width:'50%',height:'80%'},
								colors: ['#0055aa', '#1b2c5d','#00C0F2'],
								backgroundColor: { fill:'transparent' },
								hAxis: {
								  title: '',
								  minValue: 0
								},
								vAxis: {
								  title: '',
								  minValue: 0
								}
							  };

								  var chart = new google.visualization.BarChart(document.getElementById('chart_div_' + json[i-1].centro_id));
								  chart.draw(data, options);
							}
							else
							{
								$('#chart_div_' + json[i-1].centro_id).html('')
							}
							
							if(con_sesiones2)
							{
							var data = google.visualization.arrayToDataTable(arrData2);

							  var options = {
							  	height: 400,
								title: 'Sessions current year',
								chartArea:{width:'50%',height:'80%'},
								colors: ['#0055aa', '#1b2c5d','#00C0F2'],
								backgroundColor: { fill:'transparent' },
								hAxis: {
								  title: '',
								  minValue: 0
								},
								vAxis: {
								  title: '',
								  minValue: 0
								}
							  };

								  var chart = new google.visualization.BarChart(document.getElementById('chart_div2_' + json[i-1].centro_id));
								  chart.draw(data, options);
							}
							else
							{
								$('#chart_div2_' + json[i-1].centro_id).html('')
							}
							//fin de agrego el chart para el centro




							$('#info_' + json[i-1].centro_id).html('<b>".trans('biobarica.labels.chambers').":</b> ' + cant_camaras + ' | <b>".trans('biobarica.labels.currentmonth').":</b> ' + sesiones_mes_actual + ' | <b>".trans('biobarica.labels.prevmonth').":</b> ' + sesiones_mes_anterior);
						}
					}
				})
		    	});
		    	
		    	//end info centros
		    }
		    
		    
			var rightNow = new Date();
						  
			$('#fecha_hasta').val( rightNow.toISOString().slice(0,10) );
			
			rightNow.setDate( rightNow.getDate()-7 );
			
			$('#fecha_desde').val( rightNow.toISOString().slice(0,10) );
			/*$('#fecha_desde').val('2017-09-01');*/
			
			$('#clear_desde').click(function(){
			    $('#fecha_desde').val('');
			});
			
			$('#clear_hasta').click(function(){
			    $('#fecha_hasta').val('');
			});
			
			var tableTitle = '';
			var tableHeader = '';
			var tableRows = '';
			
			$('#b_reporte').click(function() {
			
			    if( $('#reporte').val()== '0'){
			      alert('".trans('biobarica.labels.youmust')."');
			      return;
			    }
			    
			    if( $('#id_bio_camara').val() == '-1'){
			      alert('There are no devices available to show the report.');
			      return;
			    }
			    
			    
			    if( !($('#fecha_desde').val().length == 0 || $('#fecha_desde').val().length == 10)){
			      alert('The date since has an incompatible format');
			      return;
			    }
			    
			    if( !($('#fecha_hasta').val().length == 0 || $('#fecha_hasta').val().length == 10)){
			      alert('The date up has an incompatible format');
			      return;
			    }
			    
			    
			    /* Armo el reporte */
			    
			    $( '#tableData' ).hide( 'slow', function() {
				//console.log( 'Animation complete.' );
			    });
			    
			    $('#grafico').html('');
			    $('#reporteTitulo').html('');
			    
			    
			    $('#resultados').html('');
			    
			    
			    if( $('#id_bio_camara').val() != '0' )
				    {
				    
				    	$.ajax({
							type: 'GET',
							async: true,
							url: site_url + '/admin/reporte/getReporteCamara',
							data: { 
								
								camara: $('#id_bio_camara').val()
								
								  },
					  
							success: function(json){
							
							
							
							$('#camara_div').append('<h2>".trans('biobarica.labels.datoscamara').": ' + json[0].nombre + '</h2>');
							$('#camara_div').append('<div><b>' + json[0].menos_7.split('_')[0] + ':</b> ' + json[0].menos_7.split('_')[1] + ' ".trans('biobarica.labels.sessions')."</div>');
							$('#camara_div').append('<div><b>' + json[0].menos_6.split('_')[0] + ':</b> ' + json[0].menos_6.split('_')[1] + ' ".trans('biobarica.labels.sessions')."</div>');
							$('#camara_div').append('<div><b>' + json[0].menos_5.split('_')[0] + ':</b> ' + json[0].menos_5.split('_')[1] + ' ".trans('biobarica.labels.sessions')."</div>');
							$('#camara_div').append('<div><b>' + json[0].menos_4.split('_')[0] + ':</b> ' + json[0].menos_4.split('_')[1] + ' ".trans('biobarica.labels.sessions')."</div>');
							$('#camara_div').append('<div><b>' + json[0].menos_3.split('_')[0] + ':</b> ' + json[0].menos_3.split('_')[1] + ' ".trans('biobarica.labels.sessions')."</div>');
							$('#camara_div').append('<div><b>' + json[0].menos_2.split('_')[0] + ':</b> ' + json[0].menos_2.split('_')[1] + ' ".trans('biobarica.labels.sessions')."</div>');
							$('#camara_div').append('<div><b>' + json[0].menos_1.split('_')[0] + ':</b> ' + json[0].menos_1.split('_')[1] + ' ".trans('biobarica.labels.sessions')."</div>');
							
							$('#camara_div').append('<div><b>".trans('biobarica.labels.7days').":</b> ' + json[0].seven_days + ' sessions</div>');
							
							$('#camara_div').append('<div><b>' + json[0].one_month.split('_')[0] + ':</b> ' + json[0].one_month.split('_')[1] + ' ".trans('biobarica.labels.sessions')."</div>');
							$('#camara_div').append('<div><b>' + json[0].prev_month.split('_')[0] + ':</b> ' + json[0].prev_month.split('_')[1] + ' ".trans('biobarica.labels.sessions')."</div>');
							$('#camara_div').append('<div><b>' + json[0].prev_month1.split('_')[0] + ':</b> ' + json[0].prev_month1.split('_')[1] + ' ".trans('biobarica.labels.sessions')."</div>');
							$('#camara_div').append('<div><b>' + json[0].prev_month2.split('_')[0] + ':</b> ' + json[0].prev_month2.split('_')[1] + ' ".trans('biobarica.labels.sessions')."</div>');
							
							
							}
						});
				    
				    }
				    else if( $('#id_bio_centro').val() != '0' )
				    {
				    
				    	$.ajax({
							type: 'GET',
							async: true,
							url: site_url + '/admin/reporte/getReporteCamara',
							data: { 
								
								centro: $('#id_bio_centro').val()
								
								  },
					  
							success: function(json){
				
									var i = 0;
									var centro_actual;
									var sesiones_mes_actual;
									var sesiones_mes_anerior;
									var cant_camaras;
									while(i < json.length)
									{
										centro_actual = json[i].centro_id;
										sesiones_mes_actual = 0;
										sesiones_mes_anterior = 0;
										cant_camaras = 0;
										dibujarCentro( json[i].descripcion, json[i].centro_id );
										while( i < json.length && centro_actual == json[i].centro_id )	
										{
											dibujarCamara(json[i].centro_id, json[i].nombre, json[i].seven_days, json[i].one_month, json[i].prev_month, json[i].id_mac, json[i].menos_7, json[i].menos_6, json[i].menos_5, json[i].menos_4, json[i].menos_3, json[i].menos_2, json[i].menos_1,json[i].prev_month1,json[i].prev_month2);
											cant_camaras++;
											sesiones_mes_actual += parseInt(json[i].one_month.split('_')[1]);
											sesiones_mes_anterior += parseInt(json[i].prev_month.split('_')[1]);
											i++;
										}
						
										//finaliza el centro, meto la info calculada

										$('#info_' + json[i-1].centro_id).html('<b>".trans('biobarica.labels.chambers').":</b> ' + cant_camaras + ' | <b>".trans('biobarica.labels.currentmonth').":</b> ' + sesiones_mes_actual + ' | <b>".trans('biobarica.labels.prevmonth').":</b> ' + sesiones_mes_anterior);
									}
							
							
							}
						});
				    
				    }
			    
			    
			    
			    
			    $.ajax({
				type: 'GET',
				async: true,
				url: site_url + '/admin/reporte/getReporte',
				data: { 
					id_reporte: $('#reporte').val(),
					centro: $('#id_bio_centro').val(),
					camara: $('#id_bio_camara').val(),
					fecha_desde: $('#fecha_desde').val(),
					fecha_hasta: $('#fecha_hasta').val()
				      },
				      
				success: function(json){
				  
				    
				    
				    
				    
				    
				    
				    
				    
				    
				    
				    
				    
				    
				    
				    
				    switch($('#reporte').val()) {
				    
					case '1':
					    
					    var data = [];
					    
					    for (var i = 0; i < json.length; i++) {
					    
						 if(typeof(data[json[i].id_camara])==='undefined' ){
						      data[json[i].id_camara] = [];
						 }
						 if(typeof(data[json[i].id_camara][0])==='undefined' ){
						      data[json[i].id_camara][0] = [];
						      data[json[i].id_camara][1] = [];
						      data[json[i].id_camara][2] = [];
						      data[json[i].id_camara][3] = [];
						      data[json[i].id_camara][4] = [];
						      data[json[i].id_camara][5] = [];
						      data[json[i].id_camara][6] = 0;
						 }
						 
						 data[json[i].id_camara][0].push(json[i].desc_centro);
						 data[json[i].id_camara][1].push(json[i].mac_camara);
						 data[json[i].id_camara][2].push(json[i].fecha);
						 data[json[i].id_camara][3].push(json[i].disp_hs);
						 data[json[i].id_camara][4].push(json[i].porcentaje_uso);
						 data[json[i].id_camara][5].push(json[i].nom_camara);
						 
						 if ( data[json[i].id_camara][6] <  Math.round(parseFloat(json[i].porcentaje_uso)) ){
						      data[json[i].id_camara][6] = Math.round(parseFloat(json[i].porcentaje_uso));
						  }
						 
					    }
					    
					    /* removemos los lugares vacios */
					    data = data.filter(function(n){ return n != undefined });
					    console.log(data);
					    $('#grafico').empty();
					    $('#reporteTitulo').empty();
					    $('#reporteTitulo').append('Consumption Report');
					    
					    if(!data.length){
						$('#grafico').append('<p>".trans('biobarica.labels.norecords')."</p>');
						$( '#grafico' ).show( 'slow', function() {
						  $('html, body').animate({
						      scrollTop: $('#reporteTitulo').offset().top
						  }, 1500);
						});
						return;
					    }
					    
					    for (var i = 0; i < data.length; i++) {
					    
						  $( '#grafico' ).append('<p>".trans('biobarica.labels.center')." : '+data[i][0][0]+'</p>');
						 // $( '#grafico' ).append('<p>Mac : '+data[i][1][0]+'</p>');
						  $( '#grafico' ).append('<p>".trans('biobarica.labels.name')." : '+data[i][5][0]+'</p>');
						  $( '#grafico' ).append('<div id='+String.fromCharCode(34)+'main'+i+String.fromCharCode(34)+'style='+String.fromCharCode(34)+'width:100%;height:500px;'+String.fromCharCode(34)+'>' );
						  
						  /* based on prepared DOM, initialize echarts instance */
						  var myChart = echarts.init(document.getElementById('main'+i));

						  /* specify chart configuration item and data */
						  option = {
						      tooltip: {
							  trigger: 'axis',
							  axisPointer: {
							      type: 'cross',
							      crossStyle: {
								  color: '#999'
							      }
							  },
							  formatter: '".trans('biobarica.labels.date').": {b}<br/> ".trans('biobarica.labels.userpercentaje').": {c}%'
						      },
						      legend: {
							  data:['".trans('biobarica.labels.use')."','".trans('biobarica.labels.dailyhoursav')."']
						      },
						      xAxis: [
							  {
							      type: 'category',
							      data: data[i][2],
							      axisPointer: {
								  type: 'shadow'
							      }
							  }
						      ],
						      yAxis: [
							  {
							      type: 'value',
							      name: 'Use',
							      min: 0,
							      max: 100,
							      interval: 25,
							      axisLabel: {
								  formatter: '{value} %'
							      }
							  },
							  {
							      type: 'value',
							      name: '".trans('biobarica.labels.dailyhoursav')."',
							      min: 0,
							      max: 24,
							      interval: 3,
							      axisLabel: {
								  formatter: '{value} Hs'
							      }
							  }
						      ],
						      series: [
							  {
							      name:'Use',
							      type:'bar',
							      yAxisIndex: 0,
							      data:data[i][4]
							  },
							  {
							      name:'".trans('biobarica.labels.dailyhoursav')."',
							      yAxisIndex: 1,
							      type:'bar',
							      data:data[i][3]
							  }
						      ]
						  };

						  /* use configuration item and data specified to show chart */
						  myChart.setOption(option);
			  
					    }
					    
					    $( '#grafico' ).show( 'slow', function() {
						  $('html, body').animate({
						      scrollTop: $('#reporteTitulo').offset().top
						  }, 1500);
					    });
					    
					    break;
					    
					case '2':
					    
					    console.log(json);
					    
					    $('#grafico').empty();
					    $('#reporteTitulo').empty();
					
					    if(!json.length){
						$('#grafico').append('<p>".trans('biobarica.labels.norecords')."</p>');
						$( '#grafico' ).show( 'slow', function() {
						  $('html, body').animate({
						      scrollTop: $('#reporteTitulo').offset().top
						  }, 1500);
						});
						return;
					    }
					    
					    for (var i = 0; i < json.length; i++) {
						
						$( '#grafico' ).append('<div id='+String.fromCharCode(34)+'main'+i+String.fromCharCode(34)+'style='+String.fromCharCode(34)+'width:100%;height:500px;'+String.fromCharCode(34)+'>' );
						
						/* based on prepared DOM, initialize echarts instance */
						var myChart = echarts.init(document.getElementById('main'+i));
					    
					    
						option = {
						    title : {
							text: 'Mac : ' + json[i].mac_camara,
							subtext: '".trans('biobarica.labels.name').": ' + json[i].nom_camara + ' - Center: ' + json[i].desc_centro ,
							x:'center'
						    },
						    tooltip : {
							trigger: 'item',
							formatter: '{a} <br/>{b} : {c} <br/> ".trans('biobarica.labels.percentaje').": ({d}%)'
						    },
						    legend: {
							orient: 'vertical',
							left: 'left',
							data: ['Unstable','Stable'],
							color: ['#00C0F2','#0055aa', '#1b2c5d', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3']
						    },
						    series : [
							{
								color: ['#00C0F2','#0055aa', '#1b2c5d', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'],
							    name: 'Result:',
							    type: 'pie',
							    radius : '50%',
							    center: ['50%', '50%'],
							    data:[
								{value:json[i].inestables, name:'".trans('biobarica.labels.unstable')."', itemStyle:{ normal: {color:'rgba(100, 0, 0)'}}},
								{value:json[i].estables, name:'".trans('biobarica.labels.stable')."', itemStyle:{ normal: {color:'rgba(0, 100, 0)'}}}
							    ],
							    itemStyle: {
								emphasis: {
								    shadowBlur: 10,
								    shadowOffsetX: 0,
								    shadowColor: 'rgba(0, 0, 0, 0.5)'
								}
							    }
							}
						    ]
						};
						
						myChart.setOption(option);
						
					    }
					    
					    $( '#grafico' ).show( 'slow', function() {
						  $('html, body').animate({
						      scrollTop: $('#reporteTitulo').offset().top
						  }, 1500);
					    });
					    
					    break;
					    
					case '3':
					
					    var data = [];
					    
					    for (var i = 0; i < json.length; i++) {
					    
						 if(typeof(data[json[i].id_camara])==='undefined' ){
						      data[json[i].id_camara] = [];
						      data[json[i].id_camara][0] = [];
						      data[json[i].id_camara][1] = [];
						      data[json[i].id_camara][2] = [];
						      data[json[i].id_camara][3] = [];
						      data[json[i].id_camara][4] = [];
						 }
						 
						 data[json[i].id_camara][0].push(json[i].desc_centro);
						 data[json[i].id_camara][1].push(json[i].mac_camara);
						 data[json[i].id_camara][2].push(json[i].fecha);
						 data[json[i].id_camara][3].push(json[i].cantidad_sesiones);
						 data[json[i].id_camara][4].push(json[i].nom_camara);

					    }
					    
					    /* removemos los lugares vacios */
					    data = data.filter(function(n){ return n != undefined });
					    
					    $('#grafico').empty();
					    $('#reporteTitulo').empty();
					    $('#reporteTitulo').append('".trans('biobarica.labels.sessionsreport')."');
					    
					    if(!data.length){
						$('#grafico').append('<p>".trans('biobarica.labels.norecords')."</p>');
						$( '#grafico' ).show( 'slow', function() {
						  $('html, body').animate({
						      scrollTop: $('#reporteTitulo').offset().top
						  }, 1500);
						});
						return;
					    }
					    
					    for (var i = 0; i < data.length; i++) {
					    
						  $( '#grafico' ).append('<p>".trans('biobarica.labels.center')." : '+data[i][0][0]+'</p>');
						 // $( '#grafico' ).append('<p>Mac : '+data[i][1][0]+'</p>');
						  $( '#grafico' ).append('<p>".trans('biobarica.labels.name')." : '+data[i][4][0]+'</p>');
						  $( '#grafico' ).append('<div id='+String.fromCharCode(34)+'main'+i+String.fromCharCode(34)+'style='+String.fromCharCode(34)+'width:100%;height:500px;'+String.fromCharCode(34)+'>' );
						  
						  /* based on prepared DOM, initialize echarts instance */
						  var myChart = echarts.init(document.getElementById('main'+i));

						  option = {
						      tooltip: {
							  trigger: 'axis',
							  axisPointer: {
							      type: 'cross',
							      crossStyle: {
								  color: '#999'
							      }
							  }
						      },
						      legend: {
							  data:['Sessions']
						      },
						      xAxis: [
							  {
							      type: 'category',
							      data: data[i][2],
							      axisPointer: {
								  type: 'shadow'
							      }
							  }
						      ],
						      yAxis: [
							  {
							      type: 'value',
							      name: '".trans('biobarica.labels.count')."', 
							      min: 0,
							      max: 30,
							      interval: 5,
							      axisLabel: {
								  formatter: '{value} ".trans('biobarica.labels.sessions')."'
							      }
							  }
						      ],
						      series: [
							  {
							      name:'".trans('biobarica.labels.sessions')."',
							      type:'bar',
							      yAxisIndex: 0,
							      data:data[i][3]
							  }
						      ]
						  };

						  /* use configuration item and data specified to show chart */
						  myChart.setOption(option);
			  
					    }
					    
					    $( '#grafico' ).show( 'slow', function() {
						  $('html, body').animate({
						      scrollTop: $('#reporteTitulo').offset().top
						  }, 1500);
					    });
					    
					
					    break;
					
					case '4':
					    
					    var data = [];
					    
					    for (var i = 0; i < json.length; i++) {
					    
						 if(typeof(data[json[i].id_camara])==='undefined' ){
						      data[json[i].id_camara] = [];
						      data[json[i].id_camara][0] = [];
						      data[json[i].id_camara][1] = [];
						      data[json[i].id_camara][2] = [];
						      data[json[i].id_camara][3] = [];
						      data[json[i].id_camara][4] = [];
						      data[json[i].id_camara][5] = [];
						      data[json[i].id_camara][6] = [];
						 }
						 
						 data[json[i].id_camara][0].push(json[i].desc_centro);
						 data[json[i].id_camara][1].push(json[i].mac_camara);
						 data[json[i].id_camara][2].push(json[i].fecha);
						 data[json[i].id_camara][3].push(json[i].cam_consumo_promedio);
						 data[json[i].id_camara][4].push(json[i].cam_consumo_avg);
						 data[json[i].id_camara][5].push(json[i].nom_camara);
						 data[json[i].id_camara][6].push(json[i].clase);
						 
					    }
					    
					    /* removemos los lugares vacios */
					    data = data.filter(function(n){ return n != undefined });
					    
					    $('#grafico').empty();
					    $('#reporteTitulo').empty();
					    $('#reporteTitulo').append('Failure Report');
					    
					    if(!data.length){
						$('#grafico').append('<p>".trans('biobarica.labels.norecords')."</p>');
						$( '#grafico' ).show( 'slow', function() {
						  $('html, body').animate({
						      scrollTop: $('#reporteTitulo').offset().top
						  }, 1500);
						});
						return;
					    }
					    
					    for (var i = 0; i < data.length; i++) {
					    
					    var datata = [];
					    
					    $(data[i][4]).each(function(ii, e){
					    	var colorin = '#38C0DD';
					    	
					    	if(data[i][6][ii] == 'warning'){
					    		colorin = 'yellow';
					    	}
					    	
					    	if(data[i][6][ii] == 'danger'){
					    		colorin = 'red';
					    	}
					    
					    	datata.push({
								value : e,
								itemStyle:{normal: {color: colorin}}    //custom itemStyle=，applicable to the item only, see itemStyle
							})
					    })

						  $( '#grafico' ).append('<p>".trans('biobarica.labels.center')." : '+data[i][0][0]+'</p>');
						  $( '#grafico' ).append('<p>Mac : '+data[i][1][0]+'</p>');
						  $( '#grafico' ).append('<p>".trans('biobarica.labels.name')." : '+data[i][5][0]+'</p>');
						  $( '#grafico' ).append('<div id='+String.fromCharCode(34)+'main'+i+String.fromCharCode(34)+'style='+String.fromCharCode(34)+'width:100%;height:500px;'+String.fromCharCode(34)+'>' );
						  
						  /* based on prepared DOM, initialize echarts instance */
						  var myChart = echarts.init(document.getElementById('main'+i));

						  option = {
						      tooltip: {
							  trigger: 'axis',
							  axisPointer: {
							      type: 'cross',
							      crossStyle: {
								  color: '#999'
							      }
							  }
						      },
						      legend: {
							  data:['".trans('biobarica.labels.consumption')."','".trans('biobarica.labels.average')."']
						      },
						      xAxis: [
							  {
							      type: 'category',
							      data: data[i][2],
							      axisPointer: {
								  type: 'shadow'
							      }
							  }
						      ],
						      yAxis: [
							  {
							      type: 'value',
							      name: '".trans('biobarica.labels.consumption')."',
							      min: 0,
							      max: 10,
							      interval: 1,
							      axisLabel: {
								  formatter: '{value} A'
							      }
							  }
						      ],
						      series: [
							  {
							      name:'".trans('biobarica.labels.consumption')."',
							      type:'bar',
							      yAxisIndex: 0,
							      data:datata
							  },
							  {
							      name:'".trans('biobarica.labels.average')."',
							      type:'line',
							      yAxisIndex: 0,
							      data:data[i][3]
							  }
						      ]
						  };

						  /* use configuration item and data specified to show chart */
						  myChart.setOption(option);
			  
					    }
					    
					    $( '#grafico' ).show( 'slow', function() {
						  $('html, body').animate({
						      scrollTop: $('#reporteTitulo').offset().top
						  }, 1500);
					    });
					    
					    break;
					
					
					case '5':
					    
					    var data = [];
					    
					    for (var i = 0; i < json.length; i++) {
					    
						 if(typeof(data[json[i].id_camara])==='undefined' ){
						      data[json[i].id_camara] = [];
						      data[json[i].id_camara][0] = [];
						      data[json[i].id_camara][1] = [];
						      data[json[i].id_camara][2] = [];
						      data[json[i].id_camara][3] = [];
						      data[json[i].id_camara][4] = [];
						      data[json[i].id_camara][5] = [];
						      data[json[i].id_camara][6] = [];
						 }
						 
						 data[json[i].id_camara][0].push(json[i].desc_centro);
						 data[json[i].id_camara][1].push(json[i].mac_camara);
						 data[json[i].id_camara][2].push(json[i].fecha);
						 data[json[i].id_camara][3].push(json[i].cam_voltaje_promedio);
						 data[json[i].id_camara][4].push(json[i].cam_voltaje_avg);
						 data[json[i].id_camara][5].push(json[i].nom_camara);
						 data[json[i].id_camara][6].push(json[i].clase);
						 
					    }
					    
					    /* removemos los lugares vacios */
					    data = data.filter(function(n){ return n != undefined });
					    
					    $('#grafico').empty();
					    $('#reporteTitulo').empty();
					    $('#reporteTitulo').append('Voltaje Failure Report');
					    
					    if(!data.length){
						$('#grafico').append('<p>".trans('biobarica.labels.norecords')."</p>');
						$( '#grafico' ).show( 'slow', function() {
						  $('html, body').animate({
						      scrollTop: $('#reporteTitulo').offset().top
						  }, 1500);
						});
						return;
					    }
					    
					    for (var i = 0; i < data.length; i++) {
					    
					    var datata = [];
					    
					    $(data[i][4]).each(function(ii, e){
					    	var colorin = '#38C0DD';
					    	
					    	if(data[i][6][ii] == 'warning'){
					    		colorin = 'yellow';
					    	}
					    	
					    	if(data[i][6][ii] == 'danger'){
					    		colorin = 'red';
					    	}
					    
					    	datata.push({
								value : e,
								itemStyle:{normal: {color: colorin}}    //custom itemStyle=，applicable to the item only, see itemStyle
							})
					    })

						  $( '#grafico' ).append('<p>".trans('biobarica.labels.center')." : '+data[i][0][0]+'</p>');
						  $( '#grafico' ).append('<p>Mac : '+data[i][1][0]+'</p>');
						  $( '#grafico' ).append('<p>".trans('biobarica.labels.name')." : '+data[i][5][0]+'</p>');
						  $( '#grafico' ).append('<div id='+String.fromCharCode(34)+'main'+i+String.fromCharCode(34)+'style='+String.fromCharCode(34)+'width:100%;height:500px;'+String.fromCharCode(34)+'>' );
						  
						  /* based on prepared DOM, initialize echarts instance */
						  var myChart = echarts.init(document.getElementById('main'+i));

						  option = {
						      tooltip: {
							  trigger: 'axis',
							  axisPointer: {
							      type: 'cross',
							      crossStyle: {
								  color: '#999'
							      }
							  }
						      },
						      legend: {
							  data:['Voltaje','".trans('biobarica.labels.average')."']
						      },
						      xAxis: [
							  {
							      type: 'category',
							      data: data[i][2],
							      axisPointer: {
								  type: 'shadow'
							      }
							  }
						      ],
						      yAxis: [
							  {
							      type: 'value',
							      name: 'Voltaje',
							      min: 0,
							      max: 300,
							      interval: 10,
							      axisLabel: {
								  formatter: '{value} V'
							      }
							  }
						      ],
						      series: [
							  {
							      name:'".trans('biobarica.labels.consumption')."',
							      type:'bar',
							      yAxisIndex: 0,
							      data:datata
							  },
							  {
							      name:'".trans('biobarica.labels.average')."',
							      type:'line',
							      yAxisIndex: 0,
							      data:data[i][3]
							  }
						      ]
						  };

						  /* use configuration item and data specified to show chart */
						  myChart.setOption(option);
			  
					    }
					    
					    $( '#grafico' ).show( 'slow', function() {
						  $('html, body').animate({
						      scrollTop: $('#reporteTitulo').offset().top
						  }, 1500);
					    });
					    
					    break;
					
					    
					default:
					    //code block
					    break;
				    } 
				     
				},
				
				error: function (xhr, ajaxOptions, thrownError) {
				  alert(xhr.status);
				  alert(thrownError);
				}
	        
			      });
			    
			});
			
			$( '#id_bio_centro' ).change(function() {
			 
			    $.ajax({
				type: 'GET',
				async: true,
				url: site_url + '/admin/reporte/camarasPorCentro',
				data: { 
					centro: $('#id_bio_centro').val(),
				      },
				success: function(json){
				  
				    //console.log(json);
				    
				    $('#id_bio_camara').empty();
				    
				    if(json.length){
				    
					$('#id_bio_camara').append($('<option>', {
					    value: 0,
					    text: '** ".trans('biobarica.labels.all')."'
					}));
					
					for (var i = 0; i < json.length; i++) {
					    $('#id_bio_camara').append($('<option>', {
							value: json[i].id,
							text: json[i].nombre
					    }));
					};
					
				    }else{
				    
					$('#id_bio_camara').append($('<option>', {
					    value: -1,
					    text: '** ".trans('biobarica.labels.noresults')."'
					}));
				    }  
				},
	        
			      });	    
			    
			});
			
		    });
	        
	        ";


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js[] = asset("./vendor/crudbooster/assets/adminlte/plugins/echarts/echarts.js");
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = "
	        
				.tit_camara {
					font-weight: 600;
				}
	        
	        ";
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :) 
	    
	    public function index(){
	      // hacemos que se inicialicen los metodos del controlador
	      $this->cbLoader();
	      
	      $me = CRUDBooster::me();
	      
	      //centros
	      if ($me->id_cms_privileges == "1" or $me->id_cms_privileges == "2"){
		  $sql = "select * from bio_centro";
	      }else{
		  $sql = "select * from bio_centro where id_cms_users = ".chr(39).$me->id.chr(39);
	      }
	      
	      $centros = DB::select($sql);
	      
	      $data['centros'] = $centros;
	      
	      //camaras
	      if ($me->id_cms_privileges == "1" or $me->id_cms_privileges == "2"){
		  $sql = "select * from bio_camara";
	      }else{
		  $sql = "select * from bio_camara where id_cms_users = ".chr(39).$me->id.chr(39);
	      }
	      
	      $camaras = DB::select($sql);
	      
	      $data['camaras'] = $camaras;
	      
	      $data['page_title']      = "Seleccion de Reportes";
	      
	      //$data['page_menu']       = Route::getCurrentRoute()->getActionName();	
	      $data['table_name']      = $this->table_name;
	      $data['referal']         = $this->referal;
	      $data['controller_name'] = $this->controller_name;
	      $data['parent_field']    = $this->parent_field;
	      $data['parent_id']       = $this->parent_id;
	      
	      //$this->cbView("crudbooster::reporte",$data);
	      
	      return view('crudbooster::reporte',$data);
	      // php artisan view:clear()
	      
	    }
	    
	    
	    public function camara(){
	    
	    	$this->cbLoader();
	      
	      $me = CRUDBooster::me();
	    	
	    	echo $_GET['id'];
	    
	    }
	    
	    public function getinfoCentros(){
	      // hacemos que se inicialicen los metodos del controlador
	      $this->cbLoader();
	      
	      $me = CRUDBooster::me();
	      
	      //centros
	      if ($me->id_cms_privileges == "1" or $me->id_cms_privileges == "2"){
		  $sql = "select * from bio_centro";
	      }else{
		  $sql = "select * from bio_centro where id_cms_users = ".chr(39).$me->id.chr(39);
	      }
	      
	      $centros = DB::select($sql);
	      
	      $data['centros'] = $centros;
	      
	      //camaras
	      if ($me->id_cms_privileges == "1" or $me->id_cms_privileges == "2"){
		  $sql = "select * from bio_camara";
	      }else{
		  $sql = "select * from bio_camara where id_cms_users = ".chr(39).$me->id.chr(39);
	      }
	      
	      $camaras = DB::select($sql);
	      
	      $data['camaras'] = $camaras;
	      
	      $data['page_title']      = "Seleccion de Reportes";
	      
	      //$data['page_menu']       = Route::getCurrentRoute()->getActionName();	
	      $data['table_name']      = $this->table_name;
	      $data['referal']         = $this->referal;
	      $data['controller_name'] = $this->controller_name;
	      $data['parent_field']    = $this->parent_field;
	      $data['parent_id']       = $this->parent_id;
	      
	      //$this->cbView("crudbooster::reporte",$data);
	      
	      return view('crudbooster::infocentro',$data);
	      // php artisan view:clear()
	      
	    }
	    
	    
	    public function getCamarasPorCentro(){
	    
	    //site_url + /admin/reporte/data
	    // /var/www/html/dis.dev/vendor/crocodicstudio/crudbooster/src/views
	    // /var/www/html/dis.dev/vendor/crocodicstudio/crudbooster/src/controlle/cbcontroller
	    // /var/www/html/dis.dev/vendor/crocodicstudio/crudbooster/src/routes.php
	    $me = CRUDBooster::me();
	    
	    $centro = $_GET["centro"];
	    
	    if ($centro == "-1"){
	    
		if ($me->id_cms_privileges == "1" or $me->id_cms_privileges == "2"){
		    $sql = "select * from bio_camara";
		}else{
		    $sql = "select * from bio_camara where id_cms_users = ".chr(39).$me->id.chr(39);
		}
		
	    }else{
		
		if ($me->id_cms_privileges == "1" or $me->id_cms_privileges == "2"){
			$sql = "select * from bio_camara where id_bio_centro = '".$centro."'" ;
		}else{
			$sql = "select * from bio_camara where id_cms_users = ".chr(39).$me->id.chr(39)." and id_bio_centro = '".$centro."'";
		}
	      
	    }
	    
	    $camaras = DB::select($sql);
	    
	    //$return = [];
	    //$return[] = ['id' => '1', 'nombre' => 'camara hard'];
	    //$return[] = ['id' => '1', 'nombre' => 'camara hard'];
	    
	    return response()->json($camaras);
	    
	    }
	    
	    public function getEstadisticasCamarasHome()
	    {
	    	$me = CRUDBooster::me();
		
			$user = chr(39).$me->id.chr(39);
		
			//var_dump($me);
			//exit();
		
			$privilege = chr(39).$me->id_cms_privileges.chr(39);
	    
	    
	    	$sql = "call get_data_home(".$user.",".$privilege.");";
	    	$result = DB::select($sql);    
		
			return response()->json($result);
	    }
	    
	    
	    public function getFallasParaHome()
	    {
	    	$centro = ($_GET["centro"] == "-1") ? "NULL" :  chr(39).$_GET["centro"].chr(39);
			$camara = ($_GET["camara"] == "0") ? "NULL" :  chr(39).$_GET["camara"].chr(39);
	    	$me = CRUDBooster::me();
		
			$user = chr(39).$me->id.chr(39);
		
			//var_dump($me);
			//exit();
		
			$privilege = chr(39).$me->id_cms_privileges.chr(39);
	    
	    

	    	$sql = "call check_fallas(".$centro.",".$camara.", '" . Date('Y-m-01') . "','" . Date('Y-m-d') . "',".$user.",".$privilege.");";
	    	$result = DB::select($sql);    
		
			return response()->json($result);
	    }
	    
	    public function getFallasVoltajeParaHome()  
	    {
	    	$centro = ($_GET["centro"] == "-1") ? "NULL" :  chr(39).$_GET["centro"].chr(39);
			$camara = ($_GET["camara"] == "0") ? "NULL" :  chr(39).$_GET["camara"].chr(39);
	    	$me = CRUDBooster::me();
		
			$user = chr(39).$me->id.chr(39);
		
			//var_dump($me);
			//exit();
		
			$privilege = chr(39).$me->id_cms_privileges.chr(39);
	    
	    

	    	$sql = "call check_fallas_voltaje(".$centro.",".$camara.", '" . Date('Y-m-01') . "','" . Date('Y-m-d') . "',".$user.",".$privilege.");";
	    	$result = DB::select($sql);    
		
			return response()->json($result);
	    }
	    
	    public function getFallasDias()
	    {
	    	$centro = ($_GET["centro"] == "-1") ? "NULL" :  chr(39).$_GET["centro"].chr(39);
			$camara = ($_GET["camara"] == "0") ? "NULL" :  chr(39).$_GET["camara"].chr(39);
	    	$me = CRUDBooster::me();
		
			$user = chr(39).$me->id.chr(39);
		
			//var_dump($me);
			//exit();
		
			$privilege = chr(39).$me->id_cms_privileges.chr(39);
	    
	    
	    	$sql = "call check_fallas_dias(".$centro.",".$camara.",".$user.",".$privilege.");";
	    	$result = DB::select($sql);    
		
			return response()->json($result);
	    }
	    
	    public function getFallasVoltajeDias()
	    {
	    	$centro = ($_GET["centro"] == "-1") ? "NULL" :  chr(39).$_GET["centro"].chr(39);
			$camara = ($_GET["camara"] == "0") ? "NULL" :  chr(39).$_GET["camara"].chr(39);
	    	$me = CRUDBooster::me();
		
			$user = chr(39).$me->id.chr(39);
		
			//var_dump($me);
			//exit();
		
			$privilege = chr(39).$me->id_cms_privileges.chr(39);
	    
	    
	    	$sql = "call check_fallas_voltaje_dias(".$centro.",".$camara.",".$user.",".$privilege.");";
	    	$result = DB::select($sql);    
		
			return response()->json($result);
	    }
	    
	    public function getReporteCamara(){
	    	$camara = $_GET['camara'];
	    	if($camara)
			{
				$sql = 'call get_data_camara(' . $camara . ')';
				$result = DB::select($sql);   
				return response()->json($result);
			}
			
			$centro = $_GET['centro'];
	    	if($centro)
			{
				$sql = 'call get_data_centro(' . $centro . ')';
				$result = DB::select($sql);   
				return response()->json($result);
			}
	    }
	    
	    public function getReporte(){
	    
		$centro = ($_GET["centro"] == "-1") ? "NULL" :  chr(39).$_GET["centro"].chr(39);
		$camara = ($_GET["camara"] == "0") ? "NULL" :  chr(39).$_GET["camara"].chr(39);
		$fecha_desde = ($_GET["fecha_desde"] == '') ? "NULL" :  chr(39).$_GET["fecha_desde"].chr(39);
		$fecha_hasta = ($_GET["fecha_hasta"] == '') ? "NULL" :  chr(39).$_GET["fecha_hasta"].chr(39);
		
		/* DEFINIR COMO OBTENER EL ID DEL USUARIO LOGUEADO */
		/* EN PRINCIPIO VOY CON EL 1 QUE ES ADMIN */
		
		$me = CRUDBooster::me();
		
		$user = chr(39).$me->id.chr(39);
		
		//var_dump($me);
		//exit();
		
		$privilege = chr(39).$me->id_cms_privileges.chr(39);
		
		switch ($_GET["id_reporte"]) {
		
			case '1':
			    //horas deconsumo totales

			    $sql = "call check_consumo(".$centro.", ".$camara.", ".$fecha_desde.", ".$fecha_hasta.",".$user.",".$privilege.");";
			    
			    /* echo($sql);
			    exit(); */
			    
			    break;
			    
			case '2':
			    //Estabilidad

			    $sql = "call check_estabilidad(".$centro.", ".$camara.", ".$fecha_desde.", ".$fecha_hasta.",".$user.",".$privilege.");";

			    break;
			    
			case '3':
			    //Sesiones

			    $sql = "call check_sesiones(".$centro.", ".$camara.", ".$fecha_desde.", ".$fecha_hasta.",".$user.",".$privilege.");";
			
			    break;
			case '4':
			    //Fallas

			    $sql = "call check_fallas(".$centro.", ".$camara.", ".$fecha_desde.", ".$fecha_hasta.",".$user.",".$privilege.");";
			
			    break;
			
			case '5':
			    //Fallas

			    $sql = "call check_fallas_voltaje(".$centro.", ".$camara.", ".$fecha_desde.", ".$fecha_hasta.",".$user.",".$privilege.");";

			    break;
			
			default:
			    
			    return response()->json([]);
			    break;
		}
		
		$result = DB::select($sql);    
		
		
		
		
		return response()->json($result);
		
		
		
		
		//break;
	    
		//return response()->json($_GET);
	    
	    }


	}