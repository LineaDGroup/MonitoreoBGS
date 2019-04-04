<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminBioCamaraController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {
			$me = CRUDBooster::me();

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "30";
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
			$this->col[] = ["label"=>trans('biobarica.labels.macaddress'),"name"=>"id_mac"];
			$this->col[] = ["label"=>trans('biobarica.labels.name'),"name"=>"nombre"];
			$this->col[] = ["label"=>trans('biobarica.labels.center'),"name"=>"id_bio_centro","join"=>"bio_centro,descripcion"];
			$this->col[] = ["label"=>trans('biobarica.labels.description'),"name"=>"descripcion"];
			$this->col[] = ["label"=>trans('biobarica.labels.averageamperage'),"name"=>"amperaje_promedio"];
			//$this->col[] = ["label"=>"Voltaje","name"=>"voltaje"];
			$this->col[] = ["label"=>trans('biobarica.labels.timezone'),"name"=>"id_bio_zona_horaria","join"=>"bio_zona_horaria,zona"];
			$this->col[] = ["label"=>trans('biobarica.labels.users'),"name"=>"id_cms_users","join"=>"cms_users,email"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>trans('biobarica.labels.macaddress'),'name'=>'id_mac','type'=>'text','validation'=>'required|min:17|max:17','width'=>'6'];
			$this->form[] = ['label'=>trans('biobarica.labels.name'),'name'=>'nombre','type'=>'text','validation'=>'required|min:1|max:100','width'=>'6'];
			
			if ($me->id_cms_privileges === 1 || $me->id_cms_privileges === 2 ){
			    $this->form[] = ['label'=>trans('biobarica.labels.center'),'name'=>'id_bio_centro','type'=>'select2','validation'=>'required','width'=>'6','datatable'=>'bio_centro,descripcion'];
			}else{
			    $this->form[] = ['label'=>trans('biobarica.labels.center'),'name'=>'id_bio_centro','type'=>'select2','validation'=>'required','width'=>'6','datatable'=>'bio_centro,descripcion','datatable_where'=>'id_cms_users='.$me->id];
			}
			$this->form[] = ['label'=>trans('biobarica.labels.description'),'name'=>'descripcion','type'=>'text','validation'=>'required|min:1|max:200','width'=>'6'];
			$this->form[] = ['label'=>trans('biobarica.labels.averageamperage'),'name'=>'id_bio_zona_horaria','type'=>'select2','validation'=>'required','width'=>'6','datatable'=>'bio_zona_horaria,zona'];
			
			$this->form[] = array("label"=>trans('biobarica.labels.dailyhoursav'),"type"=>"header", "name"=>"lunes");
			
			$this->form[] = ['label'=> trans('biobarica.labels.days.monday'),'id'=>'lunes', 'name'=>'lunes','type'=>'number','validation'=>'required|min:0|max:24','width'=>'2' ];
			$this->form[] = ['label'=>trans('biobarica.labels.days.tuesday'),'id'=>'martes','name'=>'martes','type'=>'number','validation'=>'required|min:0|max:24','width'=>'2'];
			$this->form[] = ['label'=>trans('biobarica.labels.days.wednesday'),'id'=>'miercoles','name'=>'miercoles','type'=>'number','validation'=>'required|min:0|max:24','width'=>'2'];
			$this->form[] = ['label'=>trans('biobarica.labels.days.thursday'),'id'=>'jueves','name'=>'jueves','type'=>'number','validation'=>'required|min:0|max:24','width'=>'2'];
			$this->form[] = ['label'=>trans('biobarica.labels.days.friday'),'id'=>'viernes','name'=>'viernes','type'=>'number','validation'=>'required|min:0|max:24','width'=>'2'];
			$this->form[] = ['label'=>trans('biobarica.labels.days.saturday'),'id'=>'sabado','name'=>'sabado','type'=>'number','validation'=>'required|min:0|max:24','width'=>'2'];
			$this->form[] = ['label'=>trans('biobarica.labels.days.sunday'),'id'=>'domingo','name'=>'domingo','type'=>'number','validation'=>'required|min:0|max:24','width'=>'2'];
			
		//	$this->form[] = ['label'=>'Voltaje','id'=>'voltaje','name'=>'voltaje','type'=>'number','validation'=>'required|min:0|max:440','width'=>'4'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Mac','name'=>'id_mac','type'=>'text','validation'=>'required|min:17|max:17','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Nombre','name'=>'nombre','type'=>'text','validation'=>'required|min:1|max:100','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Centro','name'=>'id_bio_centro','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'bio_centro,descripcion'];
			//$this->form[] = ['label'=>'Descripcion','name'=>'descripcion','type'=>'text','validation'=>'required|min:1|max:200','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Zona horaria','name'=>'id_bio_zona_horaria','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'bio_zona_horaria,zona'];
			//$this->form[] = ['label'=>'Lunes','name'=>'lunes','type'=>'number','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'Martes','name'=>'martes','type'=>'number','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'Miercoles','name'=>'miercoles','type'=>'number','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'Jueves','name'=>'jueves','type'=>'number','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'Viernes','name'=>'viernes','type'=>'number','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'Sabado','name'=>'sabado','type'=>'number','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'Domingo','name'=>'domingo','type'=>'number','validation'=>'required','width'=>'col-sm-9'];
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
		    $(document).ready(function() {
			
			$('#id_mac').mask('FF:FF:FF:FF:FF:FF', {
			    translation: {'F': { pattern: '[0-9a-z]'} }
			});
			
			$('#lunes').attr('min',0);
			$('#martes').attr('min',0);
			$('#miercoles').attr('min',0);
			$('#jueves').attr('min',0);
			$('#viernes').attr('min',0);
			$('#sabado').attr('min',0);
			$('#domingo').attr('min',0);
			
			$('#lunes').attr('max',24);
			$('#martes').attr('max',24);
			$('#miercoles').attr('max',24);
			$('#jueves').attr('max',24);
			$('#viernes').attr('max',24);
			$('#sabado').attr('max',24);
			$('#domingo').attr('max',24);
			
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
	        $this->load_js[] = asset("./vendor/crudbooster/assets/adminlte/plugins/jquery-mask/jquery.mask.js");
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = "
	        
	        
	        #lunes, #martes, #miercoles, #jueves, #viernes, #sabado, #domingo{
	        	width: 80px !Important;
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
	    
		$me = CRUDBooster::me();
		
		//var_dump($me->id_cms_privileges);
		//exit();
		
		//si no es administrador
		if(!($me->id_cms_privileges === 1 || $me->id_cms_privileges === 2) ){
		     $query->where('bio_camara.id_cms_users', $me->id);
		}
	            
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
	    
		$me = CRUDBooster::me();
		    
		$postdata['id_cms_users'] = $me->id;
		

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        


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


	}