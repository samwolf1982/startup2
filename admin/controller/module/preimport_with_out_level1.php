<?php
//232  line разпределение категорий для импорта

class ControllerModulePreimport extends Controller {
    private  $main_arr;
    private  $sku_to_id_list;
    protected $null_array = array();
    protected $main_arr_category_list = array();
    protected $prod_arr_list = array();
    protected $atr_list = array();

    // все категории
    private $all_category=[];



	private $error = array(); 
	
	public function index() {   
	
		//Load language file
		$this->load->language('module/preimport');

		//Set title from language file
		$this->document->setTitle($this->language->get('heading_title'));
		
		//Load settings model
		$this->load->model('setting/setting');
		
		//Save settings
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		    // save file
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["userfile"]["name"]);

               $uploaddir = DIR_DOWNLOAD; //  define('DIR_DOWNLOAD', '/var/www/eklektikstore/eklektikstore.com.ua/system/storage/download/');
                $uploadfile = $uploaddir.'fileexport/' . basename($_FILES['userfile']['name']);



                if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
      //               echo $uploadfile;
                    //echo "Файл корректен и был успешно загружен.\n";
                } else {
                    $uploadfile=null;
    //                echo "Возможная атака с помощью файловой загрузки!\n";
                }

                $cat_names_list=[];
                $result_file_name=null;
if (!is_null($uploadfile)){
    $this->load->model('catalog/category');



  //
  $c_list= $this->model_catalog_category->getCategories();

  $this->all_category=$c_list;



    foreach ($c_list as $item) {
     $c= $this->model_catalog_category-> getCategory($item['category_id']);

     if (isset($cat_names_list[ htmlspecialchars_decode ( trim( $c['name']))])){

     }else{
         $cat_names_list[htmlspecialchars_decode ( trim( $c['name'])) ]=[ $c['category_id'],$c['parent_id'],htmlspecialchars_decode ( $c['name'])];
     }
  }


   $this->main_arr_category_list=  $cat_names_list;





//$ccp=    $this->model_catalog_category-> getCategoriesByParentId(68);
//
//
//    $ccp_ch=    $this->model_catalog_category-> getCategoriesByParentId(192);

    $this->load_csv_prod($uploadfile,true); //read csv upload file


    if ( $this-> validate_category()){
        $result_file_name=    $this->generate_product();

        $data['result_file_name']=$result_file_name;

        try
        {
            $this->download('p');
        } catch(Exception $e) {
            echo $e->getMessage();
        }
        $data['result_file_name']=    $result_file_name;

    };






}




		}
		
		$text_strings = array(
				'heading_title',
				'button_save',
				'button_cancel',
				'button_add_module',
				'button_remove',
				'placeholder',
		);
		
		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}
		
	
		//error handling
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/preimport', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('module/preimport', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');

	
		//Check if multiple instances of this module
		$data['modules'] = array();
		
		if (isset($this->request->post['preimport_module'])) {
			$data['modules'] = $this->request->post['preimport_module'];
		} elseif ($this->config->get('preimport_module')) { 
			$data['modules'] = $this->config->get('preimport_module');
		}		

		//Prepare for display
		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		//Send the output
		$this->response->setOutput($this->load->view('module/preimport.tpl', $data));
	}



    public  function generate_product(){

        $this->load->model('catalog/product');
        $tmp_prod_array=[];

      $atr_list=   OcAttributeDescription::all();
        foreach ($atr_list as $a_list) {
            $this->atr_list[$a_list->name]=['attribute_id'=>$a_list->attribute_id,'name'=>$a_list->name];
 }


   $p_max=null;
        foreach ($this->main_arr as $k=> $item) {
            $t_prod=[];
            $p_id=null;

        $o=    OcProduct::find(['sku'=> trim($item[4])]);


        if (is_null($o)){
            $p_last=OcProduct::last();

            if (is_null($p_last)){ if(is_null($p_max)){ $p_max =1;}else{$p_max++;} }else{

                if(is_null($p_max)){
                    $p_max=$p_last->product_id+1;

                }else{
                    $p_max++;

                }
            }
            $p_id=$p_max;

        }else{
        //    if(is_null($p_id)){
                $p_id=$o->product_id;

//                else{
//                $p_id++;
//            }

        }
            $this->sku_to_id_list[ trim($item[4]) ]=$p_id;   //артикул как sku id
            $t_prod['sku']= trim($item[4]);
            $t_prod['model']= trim($item[4]);
            $t_prod['id']=$p_id ;
            $t_prod['name']=$item[6]; // id name
            $t_prod['quantity']=$item[10];


            $cat_id_colect=[];

            $cat_name=trim( $item[3] );




            //fix
            $colect_cats_arr=  explode (',',$cat_name);
            foreach ( $colect_cats_arr as $ccr) {
                $t2=$this->main_arr_category_list[htmlspecialchars_decode (trim($ccr))];
                $cat_id_colect[]= $t2[0];
                unset($t2);
            }
            unset($colect_cats_arr);
 //fix enfd
           // $t=$this->main_arr_category_list[  htmlspecialchars_decode (  trim( $cat_name))];

            unset($cat_name);

            //fix cat with parent  1) находим родителя 2) по его ид находим категории и в массив с третим уровнем также как и с первым
            // lv 1
$parent_cat_id=0;
            $cat_id_colect_full=[];

            $c_list= $this->model_catalog_category->getCategoriesByParentId(0);

            foreach ($c_list as $parent_cat) {
                $cur_cat_name=htmlspecialchars_decode (trim(($item[1])));
                $parent_cat_name=htmlspecialchars_decode (trim(($parent_cat['name'])));
               if(!strcmp( $parent_cat_name,$cur_cat_name)){
                   $parent_cat_id= $parent_cat['category_id'];
                   break;
               }
            }

            if (!$parent_cat){
                // ERROR нету род кат с таким названием.
            }
            $cat_id_colect_full[]=$parent_cat_id;

            $c_list_lv2= $this->model_catalog_category->getCategoriesByParentId($parent_cat_id);

            // разделить по названиям категорий поменять 3-2    МАКАРОНЫ
            $colect_cats_arr_lv2=  explode (',',trim($item[2]));

            foreach ($colect_cats_arr_lv2 as $vat_name_lv_2) {

                foreach ($c_list_lv2 as $parent_cat_lv2) {
                    $cur_cat_name=htmlspecialchars_decode (trim(($vat_name_lv_2)));
                    $parent_cat_name_lv2=htmlspecialchars_decode (trim(($parent_cat_lv2['name'])));
                    if(!strcmp( $parent_cat_name_lv2,$cur_cat_name)){
                        $cat_id_colect_full[]=$parent_cat_lv2['category_id'];

                        $c_list_lv3 = $this->model_catalog_category->getCategoriesByParentId($parent_cat_lv2['category_id']);
                                            // макаронка       // разделить по названиям категорий поменять 2-3    МАКАРОНЫ
                        $colect_cats_arr_lv3 =  explode (',',trim($item[3]));
                        foreach ($colect_cats_arr_lv3 as $vat_name_lv_3) {
                            foreach ($c_list_lv3 as $parent_cat_lv3) {
                                $cur_cat_name3=htmlspecialchars_decode (trim(($vat_name_lv_3)));
                                $parent_cat_name_lv3=htmlspecialchars_decode (trim(($parent_cat_lv3['name'])));
                                if(!strcmp( $cur_cat_name3,$parent_cat_name_lv3)){
                                    $cat_id_colect_full[]=$parent_cat_lv3['category_id'];
                                }
                                $c=123;
                        }

                    }

                }
            }
            }


          //  $cat_id_colect[]= $t[0];

            //---------
            $cat_name=trim( $item[2] );
          $colect_cats_arr=  explode (',',$cat_name);

          foreach ( $colect_cats_arr as $ccr) {
                $t=$this->main_arr_category_list[htmlspecialchars_decode (trim($ccr))];
                $cat_id_colect[]= $t[0];
                 }
            unset($colect_cats_arr);


            //---------
            $cat_name=trim( $item[1] );



            $t=$this->main_arr_category_list[htmlspecialchars_decode ( trim($cat_name))];


            $cat_id_colect[]= $t[0];
            unset($cats_list);
//                            yii::error($cat_id_colect);
//            ----------------------------

            $cat_id_colect_string=implode(',',$cat_id_colect);
            $cat_id_colect_string=implode(',',$cat_id_colect_full);
          //  $cat_id_colect_full


            $t_prod['cat']= $cat_id_colect_string;
            unset($cat_id_colect);
//            -----------
            $t_prod['manuf']= $item[0];

            // $img_list = explode(";", $item[56]);
            $img_path='catalog/images/'.$item[5];




//            if(isset($img_list[0])){
//                $img_path=str_replace('http://brand-fashion.com.ua/','catalog/images/',$img_list[0]);
//            }
            $t_prod['img']= $img_path;
            $tmp_price=str_replace(',','.',$item[12]);
            $tmp_price=str_replace(' ','',$tmp_price);

            $tmp_price=  preg_replace("/[^0-9.]/", '', $tmp_price);
            $t_prod['price']=   (string) intval( $tmp_price );


            $t_prod['seo']=  $item[6].' '.$item[8];
            $t_prod['des']= empty( $item[6])?$item[13]:$item[6];
            $t_prod['meta_title']= $item[6].' '.$item[8];
            $t_prod['meta_desc']= $item[6].' '.$item[8];
//            $t_prod['meta_key']= $item[6].' '.$item[8];
            $t_prod['meta_key']=           translit( $item[6].'_'.$item[4] );
            $t_prod['store_id']= 0;
//            $t_prod['meta_key']= $item[46];
            $t_prod['tags']= $item[6].','.$item[7].','.$item[9].','.$item[13];

            $tmp_atr=[];

            // цвет 7 размер 8 составк 9 стиль 14
            if(!empty($item[7])){
                $tmp_atr['atr_0']=['a_name'=>'Цвет','a_val'=>$item[7]];
            }
            if(!empty($item[8])){
                $tmp_atr['atr_1']=['a_name'=>'Размер','a_val'=>$item[8]];
            }
            if(!empty($item[9])){
                $tmp_atr['atr_2']=['a_name'=>'Состав','a_val'=>$item[9]];
            }
            if(!empty($item[14])){
                $tmp_atr['atr_3']=['a_name'=>'Стиль','a_val'=>$item[14]];
            }
//            Размер
//Состав
//Стиль
//Цвет




            $t_prod['attr_list']=$tmp_atr;

            $tmp_prod_array[]= $t_prod;
            // yii::error($tmp_prod_array);
            unset($t_prod);
            unset($p_id);
        } // end $this->main_arr forach


        // yii::error($tmp_prod_array);
        $this->prod_arr_list=$tmp_prod_array;
        // $this->main_arr_category_list=$tmp_cat_array;
        return $this->create_product_csv_presta();

//        yii::error( $this->main_arr_category_list)  ;

    }







	/*
	 * 
	 * Check that user actions are authorized
	 * 
	 */
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/preimport')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}

    private function validate_category() {

$error_list=[];
        foreach ($this->main_arr as $item) {


            $pieces_1 = explode(",", $item[1]);
            foreach ($pieces_1 as $p1) {
                if(!isset($this->main_arr_category_list[trim( $p1)])){

                    $error_list[]=trim( $p1);
                }
            }
            $pieces_2 = explode(",", $item[2]);
            foreach ($pieces_2 as $p1) {
                if(!isset($this->main_arr_category_list[trim($p1)])){

                    $error_list[]=trim( $p1);
                }
            }
            $pieces_3 = explode(",", $item[3]);
            foreach ($pieces_3 as $p1) {
                if(!isset($this->main_arr_category_list[trim($p1)])){

                    $error_list[]=trim( $p1);
                }
            }

	    }

	    if (empty($error_list)){
            return true;
        }
        $this->error['warning']= sprintf("Категория  '%s'  на нейдена.",$error_list[0]);
	return false;

    }






    public function load_csv_prod($file_path,$clear_header_name=false)
    {

        $arr=[];


        $row = 1;
        if (($handle = fopen($file_path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $num = count( $data);
                //  echo " $num полей в строке $row: ".PHP_EOL;
                $row++;
                $tmp=[];
                for ($c=0; $c < $num; $c++) {
                    $tmp[]=$data[$c];
//                    echo $data[$c] . PHP_EOL;
                }
                $arr[]=$tmp;
            }
            fclose($handle);
        }
        if ($clear_header_name){
            unset($arr[0]);
        }

        $this->main_arr=$arr;
        // yii::error($this->main_arr);

    }

    private function create_product_csv_presta($file_name_prod='product.csv'){

	    $file_name=DIR_DOWNLOAD.'fileexport/dest/'.$file_name_prod;
//        system/storage/download/fileexport/dest/product.csv
        $res_f_name= HTTPS_CATALOG. 'system/storage/download/fileexport/dest/'.$file_name_prod;
        //   product_id	name(ru-ru)	categories	sku	upc	ean	jan	isbn	mpn	location
        //	quantity	model	manufacturer	image_name	shipping	price	points	date_added	date_modified	date_available
        //	weight	weight_unit	length	width	height	length_unit	status	tax_class_id	seo_keyword
        //  description(ru-ru)	meta_title(ru-ru)	meta_description(ru-ru)	meta_keywords(ru-ru)	stock_status_id	store_ids	layout	related_ids	tags(ru-ru)	sort_order	subtract	minimum

        $list_atr_prod=[];
        // $list_atr_prod[]=['product_id','name(ru-ru)','categories','sku','upc','ean','jan','isbn','mpn','location','quantity','model','manufacturer','image_name','shipping','price','points','date_added','date_modified','date_available','weight','weight_unit','length','width','height','length_unit','status','tax_class_id','seo_keyword','description(ru-ru)','meta_title(ru-ru)','meta_description(ru-ru)','meta_keywords(ru-ru)','stock_status_id','store_ids','layout','related_ids','tags(ru-ru)','sort_order','subtract','minimum'];

        foreach ($this->prod_arr_list as $v){
            $list_atr_prod[]=[ $v['id'],$v['name'],$v['cat'],$v['sku'],'','','','','','',// location
                100,$v['model'],$v['manuf'],$v['img'],'yes',$v['price'],'0','2009-02-03 16:59:00','2009-02-03 16:59:00','2009-02-03', //date_available
                '0','кг','0','0','0','см','true','9',$v['seo'],//seo_keyword
                $v['des'],$v['meta_title'],$v['meta_desc'],$v['meta_key'],6,0,'','',$v['tags'],0,'true',1];
        }
        $fp = fopen($file_name, 'w');
        foreach ($list_atr_prod as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);

        return $res_f_name;

    }

    public  function download( $export_type, $offset=null, $rows=null, $min_id=null, $max_id=null) {
        // we use our own error handler
        global $registry;
//        $registry = $this->registry;
        $registry = '';
        //set_error_handler('error_handler_for_export_import',E_ALL);
      //  register_shutdown_function('fatal_error_shutdown_handler_for_export_import');

        // Use the PHPExcel package from https://github.com/PHPOffice/PHPExcel
        $cwd = getcwd();
        $dir = (strcmp(VERSION,'3.0.0.0')>=0) ? 'library/export_import' : 'PHPExcel';
        chdir( DIR_SYSTEM.$dir );
        require_once( 'Classes/PHPExcel.php' );
        PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_ExportImportValueBinder() );
        chdir( $cwd );

        // find out whether all data is to be downloaded
        $all = !isset($offset) && !isset($rows) && !isset($min_id) && !isset($max_id);

        // Memory Optimization
        if (0) {
            $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
            $cacheSettings = array( 'memoryCacheSize'  => '16MB' );
            PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        }

        try {
            // set appropriate timeout limit
//            set_time_limit( 1800 );


            $languages = [['code'=>'ru-ru','language_id'=>1]];
            $default_language_id = $this->getDefaultLanguageId();

            // create a new workbook
            $workbook = new PHPExcel();

            // set some default styles
            $workbook->getDefaultStyle()->getFont()->setName('Arial');
            $workbook->getDefaultStyle()->getFont()->setSize(10);
            //$workbook->getDefaultStyle()->getAlignment()->setIndent(0.5);
            $workbook->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $workbook->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $workbook->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_GENERAL);

            // pre-define some commonly used styles
            $box_format = array(
                'fill' => array(
                    'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                    'color'     => array( 'rgb' => 'F0F0F0')
                ),
                /*
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'       => false,
                    'indent'     => 0
                )
                */
            );
            $text_format = array(
                'numberformat' => array(
                    'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
                ),
                /*
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'       => false,
                    'indent'     => 0
                )
                */
            );
            $price_format = array(
                'numberformat' => array(
                    'code' => '######0.00'
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    /*
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'       => false,
                    'indent'     => 0
                    */
                )
            );
            $weight_format = array(
                'numberformat' => array(
                    'code' => '##0.00'
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    /*
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'       => false,
                    'indent'     => 0
                    */
                )
            );

            // create the worksheets
            $worksheet_index = 0;
            switch ($export_type) {
//                case 'c':
//                    // creating the Categories worksheet
//                    $workbook->setActiveSheetIndex($worksheet_index++);
//                    $worksheet = $workbook->getActiveSheet();
//                    $worksheet->setTitle( 'Categories' );
//                    $this->populateCategoriesWorksheet( $worksheet, $languages, $box_format, $text_format, $offset, $rows, $min_id, $max_id );
//                    $worksheet->freezePaneByColumnAndRow( 1, 2 );
//
//                    // creating the CategoryFilters worksheet
//                    if ($this->existFilter()) {
//                        $workbook->createSheet();
//                        $workbook->setActiveSheetIndex($worksheet_index++);
//                        $worksheet = $workbook->getActiveSheet();
//                        $worksheet->setTitle( 'CategoryFilters' );
//                        $this->populateCategoryFiltersWorksheet( $worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id, $max_id );
//                        $worksheet->freezePaneByColumnAndRow( 1, 2 );
//                    }
//
//                    // creating the CategorySEOKeywords worksheet
//                    if ($this->use_table_seo_url) {
//                        $workbook->createSheet();
//                        $workbook->setActiveSheetIndex($worksheet_index++);
//                        $worksheet = $workbook->getActiveSheet();
//                        $worksheet->setTitle( 'CategorySEOKeywords' );
//                        $this->populateCategorySEOKeywordsWorksheet( $worksheet, $languages, $box_format, $text_format, $min_id, $max_id );
//                        $worksheet->freezePaneByColumnAndRow( 1, 2 );
//                    }
//                    break;

                case 'p':
                    // creating the Products worksheet
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'Products' );
                    $this->populateProductsWorksheet( $worksheet, $languages, $default_language_id, $price_format, $box_format, $weight_format, $text_format, $offset, $rows, $min_id, $max_id );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );

                    // creating the AdditionalImages worksheet
                    $workbook->createSheet();
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'AdditionalImages' );
                    $this->populateAdditionalImagesWorksheet( $worksheet, $box_format, $text_format, $min_id, $max_id );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );

                    // creating the Specials worksheet
                    $workbook->createSheet();
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'Specials' );
                    $this->populateSpecialsWorksheet( $worksheet, $default_language_id, $price_format, $box_format, $text_format, $min_id, $max_id );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );

                    // creating the Discounts worksheet
                    $workbook->createSheet();
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'Discounts' );
                    $this->populateDiscountsWorksheet( $worksheet, $default_language_id, $price_format, $box_format, $text_format, $min_id, $max_id );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );

                    // creating the Rewards worksheet
                    $workbook->createSheet();
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'Rewards' );
                    $this->populateRewardsWorksheet( $worksheet, $default_language_id, $box_format, $text_format, $min_id, $max_id );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );

                    // creating the ProductOptions worksheet
                    $workbook->createSheet();
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'ProductOptions' );
                    $this->populateProductOptionsWorksheet( $worksheet, $box_format, $text_format, $min_id, $max_id );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );

                    // creating the ProductOptionValues worksheet
                    $workbook->createSheet();
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'ProductOptionValues' );
                    $this->populateProductOptionValuesWorksheet( $worksheet, $price_format, $box_format, $weight_format, $text_format, $min_id, $max_id );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );

                    // creating the ProductAttributes worksheet
                    $workbook->createSheet();
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'ProductAttributes' );
                    $this->populateProductAttributesWorksheet( $worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id, $max_id );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );

                    // creating the ProductFilters worksheet
                    if ($this->existFilter()) {
                        $workbook->createSheet();
                        $workbook->setActiveSheetIndex($worksheet_index++);
                        $worksheet = $workbook->getActiveSheet();
                        $worksheet->setTitle( 'ProductFilters' );
                        $this->populateProductFiltersWorksheet( $worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id, $max_id );
                        $worksheet->freezePaneByColumnAndRow( 1, 2 );
                    }

                    // creating the ProductSEOKeywords worksheet
                    if ($this->use_table_seo_url) {
                        $workbook->createSheet();
                        $workbook->setActiveSheetIndex($worksheet_index++);
                        $worksheet = $workbook->getActiveSheet();
                        $worksheet->setTitle( 'ProductSEOKeywords' );
                        $this->populateProductSEOKeywordsWorksheet( $worksheet, $languages, $box_format, $text_format, $min_id, $max_id );
                        $worksheet->freezePaneByColumnAndRow( 1, 2 );
                    }
                    break;

                case 'o':
                    // creating the Options worksheet
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'Options' );
                    $this->populateOptionsWorksheet( $worksheet, $languages, $box_format, $text_format );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );

                    // creating the OptionValues worksheet
                    $workbook->createSheet();
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'OptionValues' );
                    $this->populateOptionValuesWorksheet( $worksheet, $languages, $box_format, $text_format );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );
                    break;

                case 'a':
                    // creating the AttributeGroups worksheet
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'AttributeGroups' );
                    $this->populateAttributeGroupsWorksheet( $worksheet, $languages, $box_format, $text_format );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );

                    // creating the Attributes worksheet
                    $workbook->createSheet();
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'Attributes' );
                    $this->populateAttributesWorksheet( $worksheet, $languages, $box_format, $text_format );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );
                    break;

                case 'f':
                    if (!$this->existFilter()) {
                        throw new Exception( $this->language->get( 'error_filter_not_supported' ) );
                        break;
                    }

                    // creating the FilterGroups worksheet
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'FilterGroups' );
                    $this->populateFilterGroupsWorksheet( $worksheet, $languages, $box_format, $text_format );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );

                    // creating the Filters worksheet
                    $workbook->createSheet();
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'Filters' );
                    $this->populateFiltersWorksheet( $worksheet, $languages, $box_format, $text_format );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );
                    break;

                case 'u':
                    // creating the Customers worksheet
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'Customers' );
                    $this->populateCustomersWorksheet( $worksheet, $box_format, $text_format, $offset, $rows, $min_id, $max_id );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );

                    // creating the Addresses worksheet
                    $workbook->createSheet();
                    $workbook->setActiveSheetIndex($worksheet_index++);
                    $worksheet = $workbook->getActiveSheet();
                    $worksheet->setTitle( 'Addresses' );
                    $this->populateAddressesWorksheet( $worksheet, $box_format, $text_format, $min_id, $max_id );
                    $worksheet->freezePaneByColumnAndRow( 1, 2 );
                    break;

                default:
                    break;
            }

            $workbook->setActiveSheetIndex(0);

            // redirect output to client browser
            $datetime = date('Y-m-d');
            switch ($export_type) {
                case 'c':
                    $filename = 'categories-'.$datetime;
                    if (!$all) {
                        if (isset($offset)) {
                            $filename .= "-offset-$offset";
                        } else if (isset($min_id)) {
                            $filename .= "-start-$min_id";
                        }
                        if (isset($rows)) {
                            $filename .= "-rows-$rows";
                        } else if (isset($max_id)) {
                            $filename .= "-end-$max_id";
                        }
                    }
                    $filename .= '.xlsx';
                    break;
                case 'p':
                    $filename = 'products-'.$datetime;
                    if (!$all) {
                        if (isset($offset)) {
                            $filename .= "-offset-$offset";
                        } else if (isset($min_id)) {
                            $filename .= "-start-$min_id";
                        }
                        if (isset($rows)) {
                            $filename .= "-rows-$rows";
                        } else if (isset($max_id)) {
                            $filename .= "-end-$max_id";
                        }
                    }
                    $filename .= '.xlsx';
                    break;
                case 'o':
                    $filename = 'options-'.$datetime.'.xlsx';
                    break;
                case 'a':
                    $filename = 'attributes-'.$datetime.'.xlsx';
                    break;
                case 'f':
                    if (!$this->existFilter()) {
                        throw new Exception( $this->language->get( 'error_filter_not_supported' ) );
                        break;
                    }
                    $filename = 'filters-'.$datetime.'.xlsx';
                    break;
                case 'u':
                    $filename = 'customers-'.$datetime;
                    if (!$all) {
                        if (isset($offset)) {
                            $filename .= "-offset-$offset";
                        } else if (isset($min_id)) {
                            $filename .= "-start-$min_id";
                        }
                        if (isset($rows)) {
                            $filename .= "-rows-$rows";
                        } else if (isset($max_id)) {
                            $filename .= "-end-$max_id";
                        }
                    }
                    $filename .= '.xlsx';
                    break;
                default:
                    $filename = $datetime.'.xlsx';
                    break;
            }
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($workbook, 'Excel2007');
            $objWriter->setPreCalculateFormulas(false);
            $objWriter->save('php://output');

            // Clear the spreadsheet caches
            $this->clearSpreadsheetCache();
            exit;

        } catch (Exception $e) {
            $errstr = $e->getMessage();
            $errline = $e->getLine();
            $errfile = $e->getFile();
            $errno = $e->getCode();
            $this->session->data['export_import_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
            if ($this->config->get('config_error_log')) {
                $this->log->write('PHP ' . get_class($e) . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
            }
            return;
        }
    }



    protected function getDefaultLanguageId() {
        $code = $this->config->get('config_language');
        $sql = "SELECT language_id FROM `".DB_PREFIX."language` WHERE code = '$code'";
        $result = $this->db->query( $sql );
        $language_id = 1;
        if ($result->rows) {
            foreach ($result->rows as $row) {
                $language_id = $row['language_id'];
                break;
            }
        }
        return $language_id;
    }

    protected function populateProductsWorksheet( &$worksheet, &$languages, $default_language_id, &$price_format, &$box_format, &$weight_format, &$text_format, $offset=null, $rows=null, &$min_id=null, &$max_id=null) {
        // get list of the field names, some are only available for certain OpenCart versions
        $query = $this->db->query( "DESCRIBE `".DB_PREFIX."product`" );
        $product_fields = array();
        foreach ($query->rows as $row) {
            $product_fields[] = $row['Field'];
        }

        // Opencart versions from 2.0 onwards also have product_description.meta_title
        $sql = "SHOW COLUMNS FROM `".DB_PREFIX."product_description` LIKE 'meta_title'";
        $query = $this->db->query( $sql );
        $exist_meta_title = ($query->num_rows > 0) ? true : false;

        // Opencart versions from 3.0 onwards use the seo_url DB table
        $exist_seo_url_table = $this->use_table_seo_url;

        // Set the column widths
        $j = 0;
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('product_id'),4)+1);
        foreach ($languages as $language) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4,30)+1);
        }
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('categories'),12)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sku'),10)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('upc'),12)+1);
        if (in_array('ean',$product_fields)) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('ean'),14)+1);
        }
        if (in_array('jan',$product_fields)) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('jan'),13)+1);
        }
        if (in_array('isbn',$product_fields)) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('isbn'),13)+1);
        }
        if (in_array('mpn',$product_fields)) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('mpn'),15)+1);
        }
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('location'),10)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('quantity'),4)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('model'),8)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('manufacturer'),10)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('image_name'),12)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('shipping'),5)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('price'),10)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('points'),5)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_added'),19)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_modified'),19)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_available'),10)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('weight'),6)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('weight_unit'),3)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('length'),8)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('width'),8)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('height'),8)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('length_unit'),3)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('status'),5)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('tax_class_id'),2)+1);
        if (!$exist_seo_url_table) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('seo_keyword'),16)+1);
        }
        foreach ($languages as $language) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('description')+4,32)+1);
        }
        if ($exist_meta_title) {
            foreach ($languages as $language) {
                $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('meta_title')+4,20)+1);
            }
        }
        foreach ($languages as $language) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('meta_description')+4,32)+1);
        }
        foreach ($languages as $language) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('meta_keywords')+4,32)+1);
        }
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('stock_status_id'),3)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('store_ids'),16)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('layout'),16)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('related_ids'),16)+1);
        foreach ($languages as $language) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('tags')+4,32)+1);
        }
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'),8)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('subtract'),5)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('minimum'),8)+1);

        // The product headings row and column styles
        $styles = array();
        $data = array();
        $i = 1;
        $j = 0;
        $data[$j++] = 'product_id';
        foreach ($languages as $language) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'name('.$language['code'].')';
        }
        $styles[$j] = &$text_format;
        $data[$j++] = 'categories';
        $styles[$j] = &$text_format;
        $data[$j++] = 'sku';
        $styles[$j] = &$text_format;
        $data[$j++] = 'upc';
        if (in_array('ean',$product_fields)) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'ean';
        }
        if (in_array('jan',$product_fields)) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'jan';
        }
        if (in_array('isbn',$product_fields)) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'isbn';
        }
        if (in_array('mpn',$product_fields)) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'mpn';
        }
        $styles[$j] = &$text_format;
        $data[$j++] = 'location';
        $data[$j++] = 'quantity';
        $styles[$j] = &$text_format;
        $data[$j++] = 'model';
        $styles[$j] = &$text_format;
        $data[$j++] = 'manufacturer';
        $styles[$j] = &$text_format;
        $data[$j++] = 'image_name';
        $data[$j++] = 'shipping';
        $styles[$j] = &$price_format;
        $data[$j++] = 'price';
        $data[$j++] = 'points';
        $data[$j++] = 'date_added';
        $data[$j++] = 'date_modified';
        $data[$j++] = 'date_available';
        $styles[$j] = &$weight_format;
        $data[$j++] = 'weight';
        $data[$j++] = 'weight_unit';
        $data[$j++] = 'length';
        $data[$j++] = 'width';
        $data[$j++] = 'height';
        $data[$j++] = 'length_unit';
        $data[$j++] = 'status';
        $data[$j++] = 'tax_class_id';
        if (!$exist_seo_url_table) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'seo_keyword';
        }
        foreach ($languages as $language) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'description('.$language['code'].')';
        }
        if ($exist_meta_title) {
            foreach ($languages as $language) {
                $styles[$j] = &$text_format;
                $data[$j++] = 'meta_title('.$language['code'].')';
            }
        }
        foreach ($languages as $language) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'meta_description('.$language['code'].')';
        }
        foreach ($languages as $language) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'meta_keywords('.$language['code'].')';
        }
        $data[$j++] = 'stock_status_id';
        $data[$j++] = 'store_ids';
        $styles[$j] = &$text_format;
        $data[$j++] = 'layout';
        $data[$j++] = 'related_ids';
        foreach ($languages as $language) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'tags('.$language['code'].')';
        }
        $data[$j++] = 'sort_order';
        $data[$j++] = 'subtract';
        $data[$j++] = 'minimum';
        $worksheet->getRowDimension($i)->setRowHeight(30);
        $this->setCellRow( $worksheet, $i, $data, $box_format );

        // The actual products data
        $i += 1;
        $j = 0;
        $store_ids = $this->getStoreIdsForProducts();
        $layouts = $this->getLayoutsForProducts();
        $products = $this->getProducts( $languages, $default_language_id, $product_fields, $exist_meta_title, $exist_seo_url_table, $offset, $rows, $min_id, $max_id );
        $len = count($products);
        $min_id = ($len>0) ? $products[0]['product_id'] : 0;
        $max_id = ($len>0) ? $products[$len-1]['product_id'] : 0;

        // подмена массива продуктов из файла

        $products_fix=[];
        $ik=0;

        $order_sort=$this->prod_arr_list;

// Получение списка столбцов      СОРТИРОВКА
foreach ($order_sort as $key_i => $row_i) {
    $prod_id[$key_i]  = $row_i['id'];

}

// Сортируем данные по volume по убыванию и по edition по возрастанию
// Добавляем $data в качестве последнего параметра, для сортировки по общему ключу
array_multisort($prod_id, SORT_ASC,  $order_sort);

        $this->prod_arr_list=$order_sort;

        foreach ($this->prod_arr_list as $kj=> $mr) {
           // if($kj==0||$kj==1){continue;}
            $tmp=[
                'product_id' => $mr['id'], // id by sku
                'categories' => $mr['cat'],
                'sku' => $mr['sku'],
                'upc' => '',
                'ean' => '',
                'jan' => '',
                'isbn' => '',
                'mpn' => '',
                'location' => '',
                'quantity' =>(integer)$mr['quantity'],
                'model' => $mr['sku'],
                'manufacturer' => $mr['manuf'],
                'image_name' => $mr['img'],
                'shipping' => '1',
                'price' => (float) $mr['price'],
              //  'price' => 25.66,
                'points' => '',
                'date_added' => '2009-02-03 16:59:00',
                'date_modified' => '2009-02-03 16:59:00',
                'date_available' => '2009-02-03',
                'weight' => '0.00',
                'weight_unit' => 'кг',
                'length' => '0.00',
                'width' => '0.00',
                'height' => '0.00',
                'status' => '1',
                'tax_class_id' => '9',
                'sort_order' => '0',
                'keyword' => $mr['meta_key'],
                'stock_status_id' => '6',
                'length_unit' => 'см',
                'subtract' => '1',
                'minimum' => '1',
                'related' => NULL,
                'name' =>
                    array (
                        'ru-ru' => $mr['name'],
                    ),
                'description' =>
                    array (
                        'ru-ru' =>$mr['des'],
                    ),
                'meta_title' =>
                    array (
                        'ru-ru' =>$mr['meta_title'],
                    ),
                'meta_description' =>
                    array (
                        'ru-ru' => $mr['meta_desc'],
                    ),
                'meta_keyword' =>
                    array (
                        'ru-ru' => $mr['meta_key'],
                    ),
                'tag' =>
                    array (
                        'ru-ru' => $mr['tags'],
                    )
            ];

            $products_fix[]=$tmp;
      }


        $products=$products_fix;

        foreach ($products as $row) {
            $data = array();
            $worksheet->getRowDimension($i)->setRowHeight(26);
            $product_id = $row['product_id'];
            $data[$j++] = $product_id;
            foreach ($languages as $language) {
                $data[$j++] = html_entity_decode($row['name'][$language['code']],ENT_QUOTES,'UTF-8');
            }
            $data[$j++] = $row['categories'];
            $data[$j++] = $row['sku'];
            $data[$j++] = $row['upc'];
            if (in_array('ean',$product_fields)) {
                $data[$j++] = $row['ean'];
            }
            if (in_array('jan',$product_fields)) {
                $data[$j++] = $row['jan'];
            }
            if (in_array('isbn',$product_fields)) {
                $data[$j++] = $row['isbn'];
            }
            if (in_array('mpn',$product_fields)) {
                $data[$j++] = $row['mpn'];
            }
            $data[$j++] = $row['location'];
            $data[$j++] = $row['quantity'];
            $data[$j++] = $row['model'];
            $data[$j++] = $row['manufacturer'];
            $data[$j++] = $row['image_name'];
            $data[$j++] = ($row['shipping']==0) ? 'no' : 'yes';
            $data[$j++] = $row['price'];
            $data[$j++] = $row['points'];
            $data[$j++] = $row['date_added'];
            $data[$j++] = $row['date_modified'];
            $data[$j++] = $row['date_available'];
            $data[$j++] = $row['weight'];
            $data[$j++] = $row['weight_unit'];
            $data[$j++] = $row['length'];
            $data[$j++] = $row['width'];
            $data[$j++] = $row['height'];
            $data[$j++] = $row['length_unit'];
            $data[$j++] = ($row['status']==0) ? 'false' : 'true';
            $data[$j++] = $row['tax_class_id'];
            if (!$exist_seo_url_table) {
                $data[$j++] = ($row['keyword']) ? $row['keyword'] : '';
            }
            foreach ($languages as $language) {
                $data[$j++] = html_entity_decode($row['description'][$language['code']],ENT_QUOTES,'UTF-8');
            }
            if ($exist_meta_title) {
                foreach ($languages as $language) {
                    $data[$j++] = html_entity_decode($row['meta_title'][$language['code']],ENT_QUOTES,'UTF-8');
                }
            }
            foreach ($languages as $language) {
                $data[$j++] = html_entity_decode($row['meta_description'][$language['code']],ENT_QUOTES,'UTF-8');
            }
            foreach ($languages as $language) {
                $data[$j++] = html_entity_decode($row['meta_keyword'][$language['code']],ENT_QUOTES,'UTF-8');
            }
            $data[$j++] = $row['stock_status_id'];
            $store_id_list = '0';
//            if (isset($store_ids[$product_id])) {
//                foreach ($store_ids[$product_id] as $store_id) {
//                    $store_id_list .= ($store_id_list=='') ? $store_id : ','.$store_id;
//                }
//            }
            $data[$j++] = $store_id_list;


            $layout_list = '';
            if (isset($layouts[$product_id])) {
                foreach ($layouts[$product_id] as $store_id => $name) {
                    $layout_list .= ($layout_list=='') ? $store_id.':'.$name : ','.$store_id.':'.$name;
                }
            }
            $data[$j++] = $layout_list;
            $data[$j++] = $row['related'];
            foreach ($languages as $language) {
                $data[$j++] = html_entity_decode($row['tag'][$language['code']],ENT_QUOTES,'UTF-8');
            }
            $data[$j++] = $row['sort_order'];
            $data[$j++] = ($row['subtract']==0) ? 'false' : 'true';
            $data[$j++] = $row['minimum'];
            //$this->null_arra
           // $this->setCellRow( $worksheet, $i, $data, $this->null_array, $styles );
            $sss=null;
            $this->setCellRow( $worksheet, $i, $data, $sss, $styles );
            $i += 1;
            $j = 0;
        }
    }




    protected function setCellRow( $worksheet, $row/*1-based*/, $data, &$default_style=null, &$styles=null ) {
        if (!empty($default_style)) {
            $worksheet->getStyle( "$row:$row" )->applyFromArray( $default_style, false );
        }
        if (!empty($styles)) {
            foreach ($styles as $col=>$style) {
                $worksheet->getStyleByColumnAndRow($col,$row)->applyFromArray($style,false);
            }
        }
        $worksheet->fromArray( $data, null, 'A'.$row, true );
//		foreach ($data as $col=>$val) {
//			$worksheet->setCellValueExplicitByColumnAndRow( $col, $row-1, $val );
//		}
//		foreach ($data as $col=>$val) {
//			$worksheet->setCellValueByColumnAndRow( $col, $row, $val );
//		}
    }

    protected function getStoreIdsForProducts() {

	return '0';
//        $sql =  "SELECT product_id, store_id FROM `".DB_PREFIX."product_to_store` ps;";
//        $store_ids = array();
//        $result = $this->db->query( $sql );
//        foreach ($result->rows as $row) {
//            $productId = $row['product_id'];
//            $store_id = $row['store_id'];
//            if (!isset($store_ids[$productId])) {
//                $store_ids[$productId] = array();
//            }
//            if (!in_array($store_id,$store_ids[$productId])) {
//                $store_ids[$productId][] = $store_id;
//            }
//        }
//        return $store_ids;
    }

    protected function getLayoutsForProducts() {
        $sql  = "SELECT pl.*, l.name FROM `".DB_PREFIX."product_to_layout` pl ";
        $sql .= "LEFT JOIN `".DB_PREFIX."layout` l ON pl.layout_id = l.layout_id ";
        $sql .= "ORDER BY pl.product_id, pl.store_id;";
        $result = $this->db->query( $sql );
        $layouts = array();
        foreach ($result->rows as $row) {
            $productId = $row['product_id'];
            $store_id = $row['store_id'];
            $name = $row['name'];
            if (!isset($layouts[$productId])) {
                $layouts[$productId] = array();
            }
            $layouts[$productId][$store_id] = $name;
        }
        return $layouts;
    }

    protected function getProducts( &$languages, $default_language_id, $product_fields, $exist_meta_title, $exist_seo_url_table, $offset=null, $rows=null, $min_id=null, $max_id=null ) {
        $sql  = "SELECT ";
        $sql .= "  p.product_id,";
        $sql .= "  GROUP_CONCAT( DISTINCT CAST(pc.category_id AS CHAR(11)) SEPARATOR \",\" ) AS categories,";
        $sql .= "  p.sku,";
        $sql .= "  p.upc,";
        if (in_array( 'ean', $product_fields )) {
            $sql .= "  p.ean,";
        }
        if (in_array('jan',$product_fields)) {
            $sql .= "  p.jan,";
        }
        if (in_array('isbn',$product_fields)) {
            $sql .= "  p.isbn,";
        }
        if (in_array('mpn',$product_fields)) {
            $sql .= "  p.mpn,";
        }
        $sql .= "  p.location,";
        $sql .= "  p.quantity,";
        $sql .= "  p.model,";
        $sql .= "  m.name AS manufacturer,";
        $sql .= "  p.image AS image_name,";
        $sql .= "  p.shipping,";
        $sql .= "  p.price,";
        $sql .= "  p.points,";
        $sql .= "  p.date_added,";
        $sql .= "  p.date_modified,";
        $sql .= "  p.date_available,";
        $sql .= "  p.weight,";
        $sql .= "  wc.unit AS weight_unit,";
        $sql .= "  p.length,";
        $sql .= "  p.width,";
        $sql .= "  p.height,";
        $sql .= "  p.status,";
        $sql .= "  p.tax_class_id,";
        $sql .= "  p.sort_order,";
        if (!$exist_seo_url_table) {
            $sql .= "  ua.keyword,";
        }
        $sql .= "  p.stock_status_id, ";
        $sql .= "  mc.unit AS length_unit, ";
        $sql .= "  p.subtract, ";
        $sql .= "  p.minimum, ";
        $sql .= "  GROUP_CONCAT( DISTINCT CAST(pr.related_id AS CHAR(11)) SEPARATOR \",\" ) AS related ";
        $sql .= "FROM `".DB_PREFIX."product` p ";
        $sql .= "LEFT JOIN `".DB_PREFIX."product_to_category` pc ON p.product_id=pc.product_id ";
        if (!$exist_seo_url_table) {
            $sql .= "LEFT JOIN `".DB_PREFIX."url_alias` ua ON ua.query=CONCAT('product_id=',p.product_id) ";
        }
        $sql .= "LEFT JOIN `".DB_PREFIX."manufacturer` m ON m.manufacturer_id = p.manufacturer_id ";
        $sql .= "LEFT JOIN `".DB_PREFIX."weight_class_description` wc ON wc.weight_class_id = p.weight_class_id ";
        $sql .= "  AND wc.language_id=$default_language_id ";
        $sql .= "LEFT JOIN `".DB_PREFIX."length_class_description` mc ON mc.length_class_id=p.length_class_id ";
        $sql .= "  AND mc.language_id=$default_language_id ";
        $sql .= "LEFT JOIN `".DB_PREFIX."product_related` pr ON pr.product_id=p.product_id ";
        if (isset($min_id) && isset($max_id)) {
            $sql .= "WHERE p.product_id BETWEEN $min_id AND $max_id ";
        }
        $sql .= "GROUP BY p.product_id ";
        $sql .= "ORDER BY p.product_id ";
        if (isset($offset) && isset($rows)) {
            $sql .= "LIMIT $offset,$rows; ";
        } else {
            $sql .= "; ";
        }
        $results = $this->db->query( $sql );
        $product_descriptions = $this->getProductDescriptions( $languages, $offset, $rows, $min_id, $max_id );
        foreach ($languages as $language) {
            $language_code = $language['code'];
            foreach ($results->rows as $key=>$row) {
                if (isset($product_descriptions[$language_code][$key])) {
                    $results->rows[$key]['name'][$language_code] = $product_descriptions[$language_code][$key]['name'];
                    $results->rows[$key]['description'][$language_code] = $product_descriptions[$language_code][$key]['description'];
                    if ($exist_meta_title) {
                        $results->rows[$key]['meta_title'][$language_code] = $product_descriptions[$language_code][$key]['meta_title'];
                    }
                    $results->rows[$key]['meta_description'][$language_code] = $product_descriptions[$language_code][$key]['meta_description'];
                    $results->rows[$key]['meta_keyword'][$language_code] = $product_descriptions[$language_code][$key]['meta_keyword'];
                    $results->rows[$key]['tag'][$language_code] = $product_descriptions[$language_code][$key]['tag'];
                } else {
                    $results->rows[$key]['name'][$language_code] = '';
                    $results->rows[$key]['description'][$language_code] = '';
                    if ($exist_meta_title) {
                        $results->rows[$key]['meta_title'][$language_code] = '';
                    }
                    $results->rows[$key]['meta_description'][$language_code] = '';
                    $results->rows[$key]['meta_keyword'][$language_code] = '';
                    $results->rows[$key]['tag'][$language_code] = '';
                }
            }
        }
        return $results->rows;
    }
    protected function getProductDescriptions( &$languages, $offset=null, $rows=null, $min_id=null, $max_id=null ) {
        // some older versions of OpenCart use the 'product_tag' table
        $exist_table_product_tag = false;
        $query = $this->db->query( "SHOW TABLES LIKE '".DB_PREFIX."product_tag'" );
        $exist_table_product_tag = ($query->num_rows > 0);

        // query the product_description table for each language
        $product_descriptions = array();
        foreach ($languages as $language) {
            $language_id = $language['language_id'];
            $language_code = $language['code'];
            $sql  = "SELECT p.product_id, ".(($exist_table_product_tag) ? "GROUP_CONCAT(pt.tag SEPARATOR \",\") AS tag, " : "")."pd.* ";
            $sql .= "FROM `".DB_PREFIX."product` p ";
            $sql .= "LEFT JOIN `".DB_PREFIX."product_description` pd ON pd.product_id=p.product_id AND pd.language_id='".(int)$language_id."' ";
            if ($exist_table_product_tag) {
                $sql .= "LEFT JOIN `".DB_PREFIX."product_tag` pt ON pt.product_id=p.product_id AND pt.language_id='".(int)$language_id."' ";
            }
            if (isset($min_id) && isset($max_id)) {
                $sql .= "WHERE p.product_id BETWEEN $min_id AND $max_id ";
            }
            $sql .= "GROUP BY p.product_id ";
            $sql .= "ORDER BY p.product_id ";
            if (isset($offset) && isset($rows)) {
                $sql .= "LIMIT $offset,$rows; ";
            } else {
                $sql .= "; ";
            }
            $query = $this->db->query( $sql );
            $product_descriptions[$language_code] = $query->rows;
        }
        return $product_descriptions;
    }
    protected function populateAdditionalImagesWorksheet( &$worksheet, &$box_format, &$text_format, $min_id=null, $max_id=null) {
        // check for the existence of product_image.sort_order field
        $sql = "SHOW COLUMNS FROM `".DB_PREFIX."product_image` LIKE 'sort_order'";
        $query = $this->db->query( $sql );
        $exist_sort_order = ($query->num_rows > 0) ? true : false;

        // Set the column widths
        $j = 0;
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('product_id'),4)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('image'),30)+1);
        if ($exist_sort_order) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'),5)+1);
        }

        // The additional images headings row and colum styles
        $styles = array();
        $data = array();
        $i = 1;
        $j = 0;
        $data[$j++] = 'product_id';
        $styles[$j] = &$text_format;
        $data[$j++] = 'image';
        if ($exist_sort_order) {
            $data[$j++] = 'sort_order';
        }
        $worksheet->getRowDimension($i)->setRowHeight(30);
        $this->setCellRow( $worksheet, $i, $data, $box_format );

        // The actual additional images data
        $styles = array();
        $i += 1;
        $j = 0;
        $additional_images = $this->getAdditionalImages( $min_id, $max_id, $exist_sort_order );
        foreach ($additional_images as $row) {
            $data = array();
            $worksheet->getRowDimension($i)->setRowHeight(13);
            $data[$j++] = $row['product_id'];
            $data[$j++] = $row['image'];
            if ($exist_sort_order) {
                $data[$j++] = $row['sort_order'];
            }
            $this->setCellRow( $worksheet, $i, $data, $this->null_array, $styles );
            $i += 1;
            $j = 0;
        }
    }

    protected function getAdditionalImages( $min_id=null, $max_id=null, $exist_sort_order=true  ) {
	    return [];
        if ($exist_sort_order) {
            $sql  = "SELECT product_id, image, sort_order ";
        } else {
            $sql  = "SELECT product_id, image ";
        }
        $sql .= "FROM `".DB_PREFIX."product_image` ";
        if (isset($min_id) && isset($max_id)) {
            $sql .= "WHERE product_id BETWEEN $min_id AND $max_id ";
        }
        if ($exist_sort_order) {
            $sql .= "ORDER BY product_id, sort_order, image;";
        } else {
            $sql .= "ORDER BY product_id, image;";
        }
        $result = $this->db->query( $sql );
        return $result->rows;
    }

    protected function populateSpecialsWorksheet( &$worksheet, $language_id, &$price_format, &$box_format, &$text_format, $min_id=null, $max_id=null ) {
        // Set the column widths
        $j = 0;
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('customer_group')+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('priority')+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('price'),10)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_start'),19)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_end'),19)+1);

        // The heading row and column styles
        $styles = array();
        $data = array();
        $i = 1;
        $j = 0;
        $data[$j++] = 'product_id';
        $styles[$j] = &$text_format;
        $data[$j++] = 'customer_group';
        $data[$j++] = 'priority';
        $styles[$j] = &$price_format;
        $data[$j++] = 'price';
        $data[$j++] = 'date_start';
        $data[$j++] = 'date_end';
        $worksheet->getRowDimension($i)->setRowHeight(30);
        $this->setCellRow( $worksheet, $i, $data, $box_format );

        // The actual product specials data
        $i += 1;
        $j = 0;
        $specials = $this->getSpecials( $language_id, $min_id, $max_id );
        foreach ($specials as $row) {
            $worksheet->getRowDimension($i)->setRowHeight(13);
            $data = array();
            $data[$j++] = $row['product_id'];
            $data[$j++] = $row['name'];
            $data[$j++] = $row['priority'];
            $data[$j++] = $row['price'];
            $data[$j++] = $row['date_start'];
            $data[$j++] = $row['date_end'];
            $this->setCellRow( $worksheet, $i, $data, $this->null_array, $styles );
            $i += 1;
            $j = 0;
        }
    }

    protected function getSpecials( $language_id, $min_id=null, $max_id=null ) {
	    return [];
        // Newer OC versions use the 'customer_group_description' instead of 'customer_group' table for the 'name' field
        $exist_table_customer_group_description = false;
        $query = $this->db->query( "SHOW TABLES LIKE '".DB_PREFIX."customer_group_description'" );
        $exist_table_customer_group_description = ($query->num_rows > 0);

        // get the product specials
        $sql  = "SELECT ps.*, ";
        $sql .= ($exist_table_customer_group_description) ? "cgd.name " : "cg.name ";
        $sql .= "FROM `".DB_PREFIX."product_special` ps ";
        if ($exist_table_customer_group_description) {
            $sql .= "LEFT JOIN `".DB_PREFIX."customer_group_description` cgd ON cgd.customer_group_id=ps.customer_group_id ";
            $sql .= "  AND cgd.language_id=$language_id ";
        } else {
            $sql .= "LEFT JOIN `".DB_PREFIX."customer_group` cg ON cg.customer_group_id=ps.customer_group_id ";
        }
        if (isset($min_id) && isset($max_id)) {
            $sql .= "WHERE ps.product_id BETWEEN $min_id AND $max_id ";
        }
        $sql .= "ORDER BY ps.product_id, name, ps.priority";
        $result = $this->db->query( $sql );
        return $result->rows;
    }
    protected function populateDiscountsWorksheet( &$worksheet, $language_id, &$price_format, &$box_format, &$text_format, $min_id=null, $max_id=null ) {
        // Set the column widths
        $j = 0;
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('customer_group')+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('quantity')+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('priority')+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('price'),10)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_start'),19)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_end'),19)+1);

        // The heading row and column styles
        $styles = array();
        $data = array();
        $i = 1;
        $j = 0;
        $data[$j++] = 'product_id';
        $styles[$j] = &$text_format;
        $data[$j++] = 'customer_group';
        $data[$j++] = 'quantity';
        $data[$j++] = 'priority';
        $styles[$j] = &$price_format;
        $data[$j++] = 'price';
        $data[$j++] = 'date_start';
        $data[$j++] = 'date_end';
        $worksheet->getRowDimension($i)->setRowHeight(30);
        $this->setCellRow( $worksheet, $i, $data, $box_format );

        // The actual product discounts data
        $i += 1;
        $j = 0;
        $discounts = $this->getDiscounts( $language_id, $min_id, $max_id );
        foreach ($discounts as $row) {
            $worksheet->getRowDimension($i)->setRowHeight(13);
            $data = array();
            $data[$j++] = $row['product_id'];
            $data[$j++] = $row['name'];
            $data[$j++] = $row['quantity'];
            $data[$j++] = $row['priority'];
            $data[$j++] = $row['price'];
            $data[$j++] = $row['date_start'];
            $data[$j++] = $row['date_end'];
            $this->setCellRow( $worksheet, $i, $data, $this->null_array, $styles );
            $i += 1;
            $j = 0;
        }
    }

    protected function getDiscounts( $language_id, $min_id=null, $max_id=null ) {
	    return [];
        // Newer OC versions use the 'customer_group_description' instead of 'customer_group' table for the 'name' field
        $exist_table_customer_group_description = false;
        $query = $this->db->query( "SHOW TABLES LIKE '".DB_PREFIX."customer_group_description'" );
        $exist_table_customer_group_description = ($query->num_rows > 0);

        // get the product discounts
        $sql  = "SELECT pd.*, ";
        $sql .= ($exist_table_customer_group_description) ? "cgd.name " : "cg.name ";
        $sql .= "FROM `".DB_PREFIX."product_discount` pd ";
        if ($exist_table_customer_group_description) {
            $sql .= "LEFT JOIN `".DB_PREFIX."customer_group_description` cgd ON cgd.customer_group_id=pd.customer_group_id ";
            $sql .= "  AND cgd.language_id=$language_id ";
        } else {
            $sql .= "LEFT JOIN `".DB_PREFIX."customer_group` cg ON cg.customer_group_id=pd.customer_group_id ";
        }
        if (isset($min_id) && isset($max_id)) {
            $sql .= "WHERE pd.product_id BETWEEN $min_id AND $max_id ";
        }
        $sql .= "ORDER BY pd.product_id ASC, name ASC, pd.quantity ASC";
        $result = $this->db->query( $sql );
        return $result->rows;
    }

    protected function populateRewardsWorksheet( &$worksheet, $language_id, &$box_format, &$text_format, $min_id=null, $max_id=null ) {
        // Set the column widths
        $j = 0;
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('customer_group')+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('points')+1);

        // The heading row and column styles
        $styles = array();
        $data = array();
        $i = 1;
        $j = 0;
        $data[$j++] = 'product_id';
        $styles[$j] = &$text_format;
        $data[$j++] = 'customer_group';
        $data[$j++] = 'points';
        $worksheet->getRowDimension($i)->setRowHeight(30);
        $this->setCellRow( $worksheet, $i, $data, $box_format );

        // The actual product rewards data
        $i += 1;
        $j = 0;
        $rewards = $this->getRewards( $language_id, $min_id, $max_id );
        foreach ($rewards as $row) {
            $worksheet->getRowDimension($i)->setRowHeight(13);
            $data = array();
            $data[$j++] = $row['product_id'];
            $data[$j++] = $row['name'];
            $data[$j++] = $row['points'];
            $this->setCellRow( $worksheet, $i, $data, $this->null_array, $styles );
            $i += 1;
            $j = 0;
        }
    }
    protected function getRewards( $language_id, $min_id=null, $max_id=null ) {

	    return [];
        // Newer OC versions use the 'customer_group_description' instead of 'customer_group' table for the 'name' field
        $exist_table_customer_group_description = false;
        $query = $this->db->query( "SHOW TABLES LIKE '".DB_PREFIX."customer_group_description'" );
        $exist_table_customer_group_description = ($query->num_rows > 0);

        // get the product rewards
        $sql  = "SELECT pr.*, ";
        $sql .= ($exist_table_customer_group_description) ? "cgd.name " : "cg.name ";
        $sql .= "FROM `".DB_PREFIX."product_reward` pr ";
        if ($exist_table_customer_group_description) {
            $sql .= "LEFT JOIN `".DB_PREFIX."customer_group_description` cgd ON cgd.customer_group_id=pr.customer_group_id ";
            $sql .= "  AND cgd.language_id=$language_id ";
        } else {
            $sql .= "LEFT JOIN `".DB_PREFIX."customer_group` cg ON cg.customer_group_id=pr.customer_group_id ";
        }
        if (isset($min_id) && isset($max_id)) {
            $sql .= "WHERE pr.product_id BETWEEN $min_id AND $max_id ";
        }
        $sql .= "ORDER BY pr.product_id, name";
        $result = $this->db->query( $sql );
        return $result->rows;
    }
    protected function populateProductOptionsWorksheet( &$worksheet, &$box_format, &$text_format, $min_id=null, $max_id=null ) {
        // Set the column widths
        $j = 0;
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
        if ($this->config->get( 'export_import_settings_use_option_id' )) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('option_id')+1);
        } else {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('option'),30)+1);
        }
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('default_option_value')+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('required'),5)+1);

        // The heading row and column styles
        $styles = array();
        $data = array();
        $i = 1;
        $j = 0;
        $data[$j++] = 'product_id';
        if ($this->config->get( 'export_import_settings_use_option_id' )) {
            $data[$j++] = 'option_id';
        } else {
            $styles[$j] = &$text_format;
            $data[$j++] = 'option';
        }
        $styles[$j] = &$text_format;
        $data[$j++] = 'default_option_value';
        $data[$j++] = 'required';
        $worksheet->getRowDimension($i)->setRowHeight(30);
        $this->setCellRow( $worksheet, $i, $data, $box_format );

        // The actual product options data
        $i += 1;
        $j = 0;
        $product_options = $this->getProductOptions( $min_id, $max_id );
        foreach ($product_options as $row) {
            $worksheet->getRowDimension($i)->setRowHeight(13);
            $data = array();
            $data[$j++] = $row['product_id'];
            if ($this->config->get( 'export_import_settings_use_option_id' )) {
                $data[$j++] = $row['option_id'];
            } else {
                $data[$j++] = html_entity_decode($row['option'],ENT_QUOTES,'UTF-8');
            }
            $data[$j++] = html_entity_decode($row['option_value'],ENT_QUOTES,'UTF-8');
            $data[$j++] = ($row['required']==0) ? 'false' : 'true';
            $this->setCellRow( $worksheet, $i, $data, $this->null_array, $styles );
            $i += 1;
            $j = 0;
        }
    }

    protected function getProductOptions( $min_id, $max_id ) {
        // get default language id
        $language_id = $this->getDefaultLanguageId();

        // Opencart versions from 2.0 onwards use product_option.value instead of the older product_option.option_value
        $sql = "SHOW COLUMNS FROM `".DB_PREFIX."product_option` LIKE 'value'";
        $query = $this->db->query( $sql );
        $exist_po_value = ($query->num_rows > 0) ? true : false;

        // DB query for getting the product options
        if ($exist_po_value) {
            $sql  = "SELECT p.product_id, po.option_id, po.value AS option_value, po.required, od.name AS `option` FROM ";
        } else {
            $sql  = "SELECT p.product_id, po.option_id, po.option_value, po.required, od.name AS `option` FROM ";
        }
        $sql .= "( SELECT product_id ";
        $sql .= "  FROM `".DB_PREFIX."product` ";
        if (isset($min_id) && isset($max_id)) {
            $sql .= "  WHERE product_id BETWEEN $min_id AND $max_id ";
        }
        $sql .= "  ORDER BY product_id ASC ";
        $sql .= ") AS p ";
        $sql .= "INNER JOIN `".DB_PREFIX."product_option` po ON po.product_id=p.product_id ";
        $sql .= "INNER JOIN `".DB_PREFIX."option_description` od ON od.option_id=po.option_id AND od.language_id='".(int)$language_id."' ";
        $sql .= "ORDER BY p.product_id ASC, po.option_id ASC";
        $query = $this->db->query( $sql );
        return $query->rows;
    }


    //---------




    protected function getProductOptionValues( $min_id, $max_id ) {
        $language_id = $this->getDefaultLanguageId();
        $sql  = "SELECT ";
        $sql .= "  p.product_id, pov.option_id, pov.option_value_id, pov.quantity, pov.subtract, od.name AS `option`, ovd.name AS option_value, ";
        $sql .= "  pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix ";
        $sql .= "FROM ";
        $sql .= "( SELECT product_id ";
        $sql .= "  FROM `".DB_PREFIX."product` ";
        if (isset($min_id) && isset($max_id)) {
            $sql .= "  WHERE product_id BETWEEN $min_id AND $max_id ";
        }
        $sql .= "  ORDER BY product_id ASC ";
        $sql .= ") AS p ";
        $sql .= "INNER JOIN `".DB_PREFIX."product_option_value` pov ON pov.product_id=p.product_id ";
        $sql .= "INNER JOIN `".DB_PREFIX."option_value_description` ovd ON ovd.option_value_id=pov.option_value_id AND ovd.language_id='".(int)$language_id."' ";
        $sql .= "INNER JOIN `".DB_PREFIX."option_description` od ON od.option_id=ovd.option_id AND od.language_id='".(int)$language_id."' ";
        $sql .= "ORDER BY p.product_id ASC, pov.option_id ASC, pov.option_value_id";
        $query = $this->db->query( $sql );
        return $query->rows;
    }


    protected function populateProductOptionValuesWorksheet( &$worksheet, &$price_format, &$box_format, &$weight_format, &$text_format, $min_id=null, $max_id=null ) {
        // Set the column widths
        $j = 0;
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
        if ($this->config->get( 'export_import_settings_use_option_id' )) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('option_id')+1);
        } else {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('option'),30)+1);
        }
        if ($this->config->get( 'export_import_settings_use_option_value_id' )) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('option_value_id')+1);
        } else {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('option_value'),30)+1);
        }
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('quantity'),4)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('subtract'),5)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('price'),10)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('price_prefix'),5)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('points'),10)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('points_prefix'),5)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('weight'),10)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('weight_prefix'),5)+1);

        // The heading row and column styles
        $styles = array();
        $data = array();
        $i = 1;
        $j = 0;
        $data[$j++] = 'product_id';
        if ($this->config->get( 'export_import_settings_use_option_id' )) {
            $data[$j++] = 'option_id';
        } else {
            $styles[$j] = &$text_format;
            $data[$j++] = 'option';
        }
        if ($this->config->get( 'export_import_settings_use_option_value_id' )) {
            $data[$j++] = 'option_value_id';
        } else {
            $styles[$j] = &$text_format;
            $data[$j++] = 'option_value';
        }
        $data[$j++] = 'quantity';
        $data[$j++] = 'subtract';
        $styles[$j] = &$price_format;
        $data[$j++] = 'price';
        $data[$j++] = "price_prefix";
        $data[$j++] = 'points';
        $data[$j++] = "points_prefix";
        $styles[$j] = &$weight_format;
        $data[$j++] = 'weight';
        $data[$j++] = 'weight_prefix';
        $worksheet->getRowDimension($i)->setRowHeight(30);
        $this->setCellRow( $worksheet, $i, $data, $box_format );

        // The actual product option values data
        $i += 1;
        $j = 0;
        $product_option_values = $this->getProductOptionValues( $min_id, $max_id );
        foreach ($product_option_values as $row) {
            $worksheet->getRowDimension($i)->setRowHeight(13);
            $data = array();
            $data[$j++] = $row['product_id'];
            if ($this->config->get( 'export_import_settings_use_option_id' )) {
                $data[$j++] = $row['option_id'];
            } else {
                $data[$j++] = html_entity_decode($row['option'],ENT_QUOTES,'UTF-8');
            }
            if ($this->config->get( 'export_import_settings_use_option_value_id' )) {
                $data[$j++] = $row['option_value_id'];
            } else {
                $data[$j++] = html_entity_decode($row['option_value'],ENT_QUOTES,'UTF-8');
            }
            $data[$j++] = $row['quantity'];
            $data[$j++] = ($row['subtract']==0) ? 'false' : 'true';
            $data[$j++] = $row['price'];
            $data[$j++] = $row['price_prefix'];
            $data[$j++] = $row['points'];
            $data[$j++] = $row['points_prefix'];
            $data[$j++] = $row['weight'];
            $data[$j++] = $row['weight_prefix'];
            $this->setCellRow( $worksheet, $i, $data, $this->null_array, $styles );
            $i += 1;
            $j = 0;
        }
    }


    protected function getProductSEOKeywords( &$languages, $min_id, $max_id ) {
        $sql  = "SELECT * FROM `".DB_PREFIX."seo_url` ";
        $sql .= "WHERE query LIKE 'product_id=%' AND ";
        $sql .= "CAST(SUBSTRING(query FROM 12) AS UNSIGNED INTEGER) >= '".(int)$min_id."' AND ";
        $sql .= "CAST(SUBSTRING(query FROM 12) AS UNSIGNED INTEGER) <= '".(int)$max_id."' ";
        $sql .= "ORDER BY CAST(SUBSTRING(query FROM 12) AS UNSIGNED INTEGER), store_id, language_id";
        $query = $this->db->query( $sql );
        $seo_keywords = array();
        foreach ($query->rows as $row) {
            $product_id = (int)substr($row['query'],11);
            $store_id = (int)$row['store_id'];
            $language_id = (int)$row['language_id'];
            if (!isset($seo_keywords[$product_id])) {
                $seo_keywords[$product_id] = array();
            }
            if (!isset($seo_keywords[$product_id][$store_id])) {
                $seo_keywords[$product_id][$store_id] = array();
            }
            $seo_keywords[$product_id][$store_id][$language_id] = $row['keyword'];
        }
        $results = array();
        foreach ($seo_keywords as $product_id=>$val1) {
            foreach ($val1 as $store_id=>$val2) {
                $keyword = array();
                foreach ($languages as $language) {
                    $language_id = $language['language_id'];
                    $language_code = $language['code'];
                    $keyword[$language_code] = isset($val2[$language_id]) ? $val2[$language_id] : '';
                }
                $results[] = array(
                    'product_id'    => $product_id,
                    'store_id'      => $store_id,
                    'keyword'       => $keyword
                );
            }
        }
        return $results;
    }


    protected function populateProductSEOKeywordsWorksheet( &$worksheet, &$languages, &$box_format, &$text_format, $min_id=null, $max_id=null ) {
        // Set the column widths
        $j = 0;
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('store_id')+1);
        foreach ($languages as $language) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('keyword')+4,30)+1);
        }

        // The heading row and column styles
        $styles = array();
        $data = array();
        $i = 1;
        $j = 0;
        $data[$j++] = 'product_id';
        $data[$j++] = 'store_id';
        foreach ($languages as $language) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'keyword('.$language['code'].')';
        }
        $worksheet->getRowDimension($i)->setRowHeight(30);
        $this->setCellRow( $worksheet, $i, $data, $box_format );

        // The actual product SEO keywords data
        $i += 1;
        $j = 0;
        $product_seo_keywords = $this->getProductSEOKeywords( $languages, $min_id, $max_id );
        foreach ($product_seo_keywords as $row) {
            $worksheet->getRowDimension($i)->setRowHeight(26);
            $data = array();
            $data[$j++] = $row['product_id'];
            $data[$j++] = $row['store_id'];
            foreach ($languages as $language) {
                $data[$j++] = html_entity_decode($row['keyword'][$language['code']],ENT_QUOTES,'UTF-8');
            }
            $this->setCellRow( $worksheet, $i, $data, $this->null_array, $styles );
            $i += 1;
            $j = 0;
        }

    }


    protected function getAttributeGroupNames( $language_id ) {
        $sql  = "SELECT attribute_group_id, name ";
        $sql .= "FROM `".DB_PREFIX."attribute_group_description` ";
        $sql .= "WHERE language_id='".(int)$language_id."' ";
        $sql .= "ORDER BY attribute_group_id ASC";
        $query = $this->db->query( $sql );
        $attribute_group_names = array();
        foreach ($query->rows as $row) {
            $attribute_group_id = $row['attribute_group_id'];
            $name = $row['name'];
            $attribute_group_names[$attribute_group_id] = $name;
        }
        return $attribute_group_names;
    }


    protected function getAttributeNames( $language_id ) {
        $sql  = "SELECT attribute_id, name ";
        $sql .= "FROM `".DB_PREFIX."attribute_description` ";
        $sql .= "WHERE language_id='".(int)$language_id."' ";
        $sql .= "ORDER BY attribute_id ASC";
        $query = $this->db->query( $sql );
        $attribute_names = array();
        foreach ($query->rows as $row) {
            $attribute_id = $row['attribute_id'];
            $attribute_name = $row['name'];
            $attribute_names[$attribute_id] = $attribute_name;
        }
        return $attribute_names;
    }


    protected function getProductAttributes( &$languages, $min_id, $max_id ) {
        $sql  = "SELECT pa.product_id, ag.attribute_group_id, pa.attribute_id, pa.language_id, pa.text ";
        $sql .= "FROM `".DB_PREFIX."product_attribute` pa ";
        $sql .= "INNER JOIN `".DB_PREFIX."attribute` a ON a.attribute_id=pa.attribute_id ";
        $sql .= "INNER JOIN `".DB_PREFIX."attribute_group` ag ON ag.attribute_group_id=a.attribute_group_id ";
        if (isset($min_id) && isset($max_id)) {
            $sql .= "WHERE product_id BETWEEN $min_id AND $max_id ";
        }
        $sql .= "ORDER BY pa.product_id ASC, ag.attribute_group_id ASC, pa.attribute_id ASC";
        $query = $this->db->query( $sql );
        $texts = array();
        foreach ($query->rows as $row) {
            $product_id = $row['product_id'];
            $attribute_group_id = $row['attribute_group_id'];
            $attribute_id = $row['attribute_id'];
            $language_id = $row['language_id'];
            $text = $row['text'];
            $texts[$product_id][$attribute_group_id][$attribute_id][$language_id] = $text;
        }
        $product_attributes = array();
        foreach ($texts as $product_id=>$level1) {
            foreach ($level1 as $attribute_group_id=>$level2) {
                foreach ($level2 as $attribute_id=>$text) {
                    $product_attribute = array();
                    $product_attribute['product_id'] = $product_id;
                    $product_attribute['attribute_group_id'] = $attribute_group_id;
                    $product_attribute['attribute_id'] = $attribute_id;
                    $product_attribute['text'] = array();
                    foreach ($languages as $language) {
                        $language_id = $language['language_id'];
                        $code = $language['code'];
                        if (isset($text[$language_id])) {
                            $product_attribute['text'][$code] = $text[$language_id];
                        } else {
                            $product_attribute['text'][$code] = '';
                        }
                    }
                    $product_attributes[] = $product_attribute;
                }
            }
        }


        //fix attr


        $fix_attr=[];
        foreach ( $this->prod_arr_list as $item) {

            foreach ( $item['attr_list'] as $it){


             $el= $it;

             $atrr_main_el=$this->atr_list[$el['a_name']]; // if

             $tmp=
                 [
                     'product_id' =>$item['id'],
                     'attribute_group_id' => 7,
                     'attribute_id' => $atrr_main_el['attribute_id'],
                     'text' =>
                         array (
                             'ru-ru' => $el['a_val'],)];

             $fix_attr[]=$tmp;
             unset($tmp);
         }


        }
return $fix_attr;

        return $product_attributes;
    }


    protected function populateProductAttributesWorksheet( &$worksheet, &$languages, $default_language_id, &$box_format, &$text_format, $min_id=null, $max_id=null ) {
        // Set the column widths
        $j = 0;
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
        if ($this->config->get( 'export_import_settings_use_attribute_group_id' )) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('attribute_group_id')+1);
        } else {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('attribute_group'),30)+1);
        }
        if ($this->config->get( 'export_import_settings_use_attribute_id' )) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('attribute_id')+1);
        } else {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('attribute'),30)+1);
        }
        foreach ($languages as $language) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('text')+4,30)+1);
        }

        // The heading row and column styles
        $styles = array();
        $data = array();
        $i = 1;
        $j = 0;
        $data[$j++] = 'product_id';
        if ($this->config->get( 'export_import_settings_use_attribute_group_id' )) {
            $data[$j++] = 'attribute_group_id';
        } else {
            $styles[$j] = &$text_format;
            $data[$j++] = 'attribute_group';
        }
        if ($this->config->get( 'export_import_settings_use_attribute_id' )) {
            $data[$j++] = 'attribute_id';
        } else {
            $styles[$j] = &$text_format;
            $data[$j++] = 'attribute';
        }
        foreach ($languages as $language) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'text('.$language['code'].')';
        }
        $worksheet->getRowDimension($i)->setRowHeight(30);
        $this->setCellRow( $worksheet, $i, $data, $box_format );

        // The actual product attributes data
        if (!$this->config->get( 'export_import_settings_use_attribute_group_id' )) {
            $attribute_group_names = $this->getAttributeGroupNames( $default_language_id );
        }
        if (!$this->config->get( 'export_import_settings_use_attribute_id' )) {
            $attribute_names = $this->getAttributeNames( $default_language_id );
        }
        $i += 1;
        $j = 0;
        $product_attributes = $this->getProductAttributes( $languages, $min_id, $max_id );




        foreach ($product_attributes as $row) {
            $worksheet->getRowDimension($i)->setRowHeight(13);
            $data = array();
            $data[$j++] = $row['product_id'];
            if ($this->config->get( 'export_import_settings_use_attribute_group_id' )) {
                $data[$j++] = $row['attribute_group_id'];
            } else {
                $data[$j++] = html_entity_decode($attribute_group_names[$row['attribute_group_id']],ENT_QUOTES,'UTF-8');
            }
            if ($this->config->get( 'export_import_settings_use_attribute_id' )) {
                $data[$j++] = $row['attribute_id'];
            } else {
                $data[$j++] = html_entity_decode($attribute_names[$row['attribute_id']],ENT_QUOTES,'UTF-8');
            }
            foreach ($languages as $language) {
                $data[$j++] = html_entity_decode($row['text'][$language['code']],ENT_QUOTES,'UTF-8');
            }
            $this->setCellRow( $worksheet, $i, $data, $this->null_array, $styles );
            $i += 1;
            $j = 0;
        }
    }


    protected function getProductFilters( $min_id, $max_id ) {
        $sql  = "SELECT pf.product_id, fg.filter_group_id, pf.filter_id ";
        $sql .= "FROM `".DB_PREFIX."product_filter` pf ";
        $sql .= "INNER JOIN `".DB_PREFIX."filter` f ON f.filter_id=pf.filter_id ";
        $sql .= "INNER JOIN `".DB_PREFIX."filter_group` fg ON fg.filter_group_id=f.filter_group_id ";
        if (isset($min_id) && isset($max_id)) {
            $sql .= "WHERE product_id BETWEEN $min_id AND $max_id ";
        }
        $sql .= "ORDER BY pf.product_id ASC, fg.filter_group_id ASC, pf.filter_id ASC";
        $query = $this->db->query( $sql );
        $product_filters = array();
        foreach ($query->rows as $row) {
            $product_filter = array();
            $product_filter['product_id'] = $row['product_id'];
            $product_filter['filter_group_id'] = $row['filter_group_id'];
            $product_filter['filter_id'] = $row['filter_id'];
            $product_filters[] = $product_filter;
        }
        return $product_filters;
    }


    protected function populateProductFiltersWorksheet( &$worksheet, &$languages, $default_language_id, &$box_format, &$text_format, $min_id=null, $max_id=null ) {
        // Set the column widths
        $j = 0;
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
        if ($this->config->get( 'export_import_settings_use_filter_group_id' )) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('filter_group_id')+1);
        } else {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('filter_group'),30)+1);
        }
        if ($this->config->get( 'export_import_settings_use_filter_id' )) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('filter_id')+1);
        } else {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('filter'),30)+1);
        }
        foreach ($languages as $language) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('text')+4,30)+1);
        }

        // The heading row and column styles
        $styles = array();
        $data = array();
        $i = 1;
        $j = 0;
        $data[$j++] = 'product_id';
        if ($this->config->get( 'export_import_settings_use_filter_group_id' )) {
            $data[$j++] = 'filter_group_id';
        } else {
            $styles[$j] = &$text_format;
            $data[$j++] = 'filter_group';
        }
        if ($this->config->get( 'export_import_settings_use_filter_id' )) {
            $data[$j++] = 'filter_id';
        } else {
            $styles[$j] = &$text_format;
            $data[$j++] = 'filter';
        }
        $worksheet->getRowDimension($i)->setRowHeight(30);
        $this->setCellRow( $worksheet, $i, $data, $box_format );

        // The actual product filters data
        if (!$this->config->get( 'export_import_settings_use_filter_group_id' )) {
            $filter_group_names = $this->getFilterGroupNames( $default_language_id );
        }
        if (!$this->config->get( 'export_import_settings_use_filter_id' )) {
            $filter_names = $this->getFilterNames( $default_language_id );
        }
        $i += 1;
        $j = 0;
        $product_filters = $this->getProductFilters( $min_id, $max_id );
        foreach ($product_filters as $row) {
            $worksheet->getRowDimension($i)->setRowHeight(13);
            $data = array();
            $data[$j++] = $row['product_id'];
            if ($this->config->get( 'export_import_settings_use_filter_group_id' )) {
                $data[$j++] = $row['filter_group_id'];
            } else {
                $data[$j++] = html_entity_decode($filter_group_names[$row['filter_group_id']],ENT_QUOTES,'UTF-8');
            }
            if ($this->config->get( 'export_import_settings_use_filter_id' )) {
                $data[$j++] = $row['filter_id'];
            } else {
                $data[$j++] = html_entity_decode($filter_names[$row['filter_id']],ENT_QUOTES,'UTF-8');
            }
            $this->setCellRow( $worksheet, $i, $data, $this->null_array, $styles );
            $i += 1;
            $j = 0;
        }
    }


    protected function getOptionDescriptions( &$languages ) {
        // query the option_description table for each language
        $option_descriptions = array();
        foreach ($languages as $language) {
            $language_id = $language['language_id'];
            $language_code = $language['code'];
            $sql  = "SELECT o.option_id, od.* ";
            $sql .= "FROM `".DB_PREFIX."option` o ";
            $sql .= "LEFT JOIN `".DB_PREFIX."option_description` od ON od.option_id=o.option_id AND od.language_id='".(int)$language_id."' ";
            $sql .= "GROUP BY o.option_id ";
            $sql .= "ORDER BY o.option_id ASC ";
            $query = $this->db->query( $sql );
            $option_descriptions[$language_code] = $query->rows;
        }
        return $option_descriptions;
    }


    protected function getOptions( &$languages ) {
        $results = $this->db->query( "SELECT * FROM `".DB_PREFIX."option` ORDER BY option_id ASC" );
        $option_descriptions = $this->getOptionDescriptions( $languages );
        foreach ($languages as $language) {
            $language_code = $language['code'];
            foreach ($results->rows as $key=>$row) {
                if (isset($option_descriptions[$language_code][$key])) {
                    $results->rows[$key]['name'][$language_code] = $option_descriptions[$language_code][$key]['name'];
                } else {
                    $results->rows[$key]['name'][$language_code] = '';
                }
            }
        }
        return $results->rows;
    }


    protected function populateOptionsWorksheet( &$worksheet, &$languages, &$box_format, &$text_format ) {
        // Set the column widths
        $j = 0;
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('option_id'),4)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('type'),10)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'),5)+1);
        foreach ($languages as $language) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4,30)+1);
        }

        // The options headings row and column styles
        $styles = array();
        $data = array();
        $i = 1;
        $j = 0;
        $data[$j++] = 'option_id';
        $data[$j++] = 'type';
        $data[$j++] = 'sort_order';
        foreach ($languages as $language) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'name('.$language['code'].')';
        }
        $worksheet->getRowDimension($i)->setRowHeight(30);
        $this->setCellRow( $worksheet, $i, $data, $box_format );

        // The actual options data
        $i += 1;
        $j = 0;
        $options = $this->getOptions( $languages );
        foreach ($options as $row) {
            $worksheet->getRowDimension($i)->setRowHeight(13);
            $data = array();
            $data[$j++] = $row['option_id'];
            $data[$j++] = $row['type'];
            $data[$j++] = $row['sort_order'];
            foreach ($languages as $language) {
                $data[$j++] = html_entity_decode($row['name'][$language['code']],ENT_QUOTES,'UTF-8');
            }
            $this->setCellRow( $worksheet, $i, $data, $this->null_array, $styles );
            $i += 1;
            $j = 0;
        }
    }


    protected function getOptionValueDescriptions( &$languages ) {
        // query the option_description table for each language
        $option_value_descriptions = array();
        foreach ($languages as $language) {
            $language_id = $language['language_id'];
            $language_code = $language['code'];
            $sql  = "SELECT ov.option_id, ov.option_value_id, ovd.* ";
            $sql .= "FROM `".DB_PREFIX."option_value` ov ";
            $sql .= "LEFT JOIN `".DB_PREFIX."option_value_description` ovd ON ovd.option_value_id=ov.option_value_id AND ovd.language_id='".(int)$language_id."' ";
            $sql .= "GROUP BY ov.option_id, ov.option_value_id ";
            $sql .= "ORDER BY ov.option_id ASC, ov.option_value_id ASC ";
            $query = $this->db->query( $sql );
            $option_value_descriptions[$language_code] = $query->rows;
        }
        return $option_value_descriptions;
    }


    protected function getOptionValues( &$languages ) {
        $results = $this->db->query( "SELECT * FROM `".DB_PREFIX."option_value` ORDER BY option_id ASC, option_value_id ASC" );
        $option_value_descriptions = $this->getOptionValueDescriptions( $languages );
        foreach ($languages as $language) {
            $language_code = $language['code'];
            foreach ($results->rows as $key=>$row) {
                if (isset($option_value_descriptions[$language_code][$key])) {
                    $results->rows[$key]['name'][$language_code] = $option_value_descriptions[$language_code][$key]['name'];
                } else {
                    $results->rows[$key]['name'][$language_code] = '';
                }
            }
        }
        return $results->rows;
    }


    protected function populateOptionValuesWorksheet( &$worksheet, $languages, &$box_format, &$text_format ) {
        // check for the existence of option_value.image field
        $sql = "SHOW COLUMNS FROM `".DB_PREFIX."option_value` LIKE 'image'";
        $query = $this->db->query( $sql );
        $exist_image = ($query->num_rows > 0) ? true : false;

        // Set the column widths
        $j = 0;
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('option_value_id'),2)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('option_id'),4)+1);
        if ($exist_image) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('image'),12)+1);
        }
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'),5)+1);
        foreach ($languages as $language) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4,30)+1);
        }

        // The option values headings row and column styles
        $styles = array();
        $data = array();
        $i = 1;
        $j = 0;
        $data[$j++] = 'option_value_id';
        $data[$j++] = 'option_id';
        if ($exist_image) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'image';
        }
        $data[$j++] = 'sort_order';
        foreach ($languages as $language) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'name('.$language['code'].')';
        }
        $worksheet->getRowDimension($i)->setRowHeight(30);
        $this->setCellRow( $worksheet, $i, $data, $box_format );

        // The actual option values data
        $i += 1;
        $j = 0;
        $options = $this->getOptionValues( $languages );
        foreach ($options as $row) {
            $worksheet->getRowDimension($i)->setRowHeight(13);
            $data = array();
            $data[$j++] = $row['option_value_id'];
            $data[$j++] = $row['option_id'];
            if ($exist_image) {
                $data[$j++] = $row['image'];
            }
            $data[$j++] = $row['sort_order'];
            foreach ($languages as $language) {
                $data[$j++] = html_entity_decode($row['name'][$language['code']],ENT_QUOTES,'UTF-8');
            }
            $this->setCellRow( $worksheet, $i, $data, $this->null_array, $styles );
            $i += 1;
            $j = 0;
        }
    }


    protected function getAttributeGroupDescriptions( &$languages ) {
        // query the attribute_group_description table for each language
        $attribute_group_descriptions = array();
        foreach ($languages as $language) {
            $language_id = $language['language_id'];
            $language_code = $language['code'];
            $sql  = "SELECT ag.attribute_group_id, agd.* ";
            $sql .= "FROM `".DB_PREFIX."attribute_group` ag ";
            $sql .= "LEFT JOIN `".DB_PREFIX."attribute_group_description` agd ON agd.attribute_group_id=ag.attribute_group_id AND agd.language_id='".(int)$language_id."' ";
            $sql .= "GROUP BY ag.attribute_group_id ";
            $sql .= "ORDER BY ag.attribute_group_id ASC ";
            $query = $this->db->query( $sql );
            $attribute_group_descriptions[$language_code] = $query->rows;
        }
        return $attribute_group_descriptions;
    }


    protected function getAttributeGroups( &$languages ) {
        $results = $this->db->query( "SELECT * FROM `".DB_PREFIX."attribute_group` ORDER BY attribute_group_id ASC" );
        $attribute_group_descriptions = $this->getAttributeGroupDescriptions( $languages );
        foreach ($languages as $language) {
            $language_code = $language['code'];
            foreach ($results->rows as $key=>$row) {
                if (isset($attribute_group_descriptions[$language_code][$key])) {
                    $results->rows[$key]['name'][$language_code] = $attribute_group_descriptions[$language_code][$key]['name'];
                } else {
                    $results->rows[$key]['name'][$language_code] = '';
                }
            }
        }
        return $results->rows;
    }


    protected function populateAttributeGroupsWorksheet( &$worksheet, $languages, &$box_format, &$text_format ) {
        // Set the column widths
        $j = 0;
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('attribute_group_id'),4)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'),5)+1);
        foreach ($languages as $language) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4,30)+1);
        }

        // The attribute groups headings row and column styles
        $styles = array();
        $data = array();
        $i = 1;
        $j = 0;
        $data[$j++] = 'attribute_group_id';
        $data[$j++] = 'sort_order';
        foreach ($languages as $language) {
            $styles[$j] = &$text_format;
            $data[$j++] ='name('.$language['code'].')';
        }
        $worksheet->getRowDimension($i)->setRowHeight(30);
        $this->setCellRow( $worksheet, $i, $data, $box_format );

        // The actual attribute groups data
        $i += 1;
        $j = 0;
        $attributes = $this->getAttributeGroups( $languages );
        foreach ($attributes as $row) {
            $worksheet->getRowDimension($i)->setRowHeight(13);
            $data = array();
            $data[$j++] = $row['attribute_group_id'];
            $data[$j++] = $row['sort_order'];
            foreach ($languages as $language) {
                $data[$j++] = html_entity_decode($row['name'][$language['code']],ENT_QUOTES,'UTF-8');
            }
            $this->setCellRow( $worksheet, $i, $data, $this->null_array, $styles );
            $i += 1;
            $j = 0;
        }
    }


    protected function getAttributeDescriptions( &$languages ) {
        // query the attribute_description table for each language
        $attribute_descriptions = array();
        foreach ($languages as $language) {
            $language_id = $language['language_id'];
            $language_code = $language['code'];
            $sql  = "SELECT a.attribute_group_id, a.attribute_id, ad.* ";
            $sql .= "FROM `".DB_PREFIX."attribute` a ";
            $sql .= "LEFT JOIN `".DB_PREFIX."attribute_description` ad ON ad.attribute_id=a.attribute_id AND ad.language_id='".(int)$language_id."' ";
            $sql .= "GROUP BY a.attribute_group_id, a.attribute_id ";
            $sql .= "ORDER BY a.attribute_group_id ASC, a.attribute_id ASC ";
            $query = $this->db->query( $sql );
            $attribute_descriptions[$language_code] = $query->rows;
        }
        return $attribute_descriptions;
    }


    protected function getAttributes( &$languages ) {
        $results = $this->db->query( "SELECT * FROM `".DB_PREFIX."attribute` ORDER BY attribute_group_id ASC, attribute_id ASC" );
        $attribute_descriptions = $this->getAttributeDescriptions( $languages );
        foreach ($languages as $language) {
            $language_code = $language['code'];
            foreach ($results->rows as $key=>$row) {
                if (isset($attribute_descriptions[$language_code][$key])) {
                    $results->rows[$key]['name'][$language_code] = $attribute_descriptions[$language_code][$key]['name'];
                } else {
                    $results->rows[$key]['name'][$language_code] = '';
                }
            }
        }
        return $results->rows;
    }


    protected function populateAttributesWorksheet( &$worksheet, $languages, &$box_format, &$text_format ) {
        // Set the column widths
        $j = 0;
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('attribute_id'),2)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('attribute_group_id'),4)+1);
        $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'),5)+1);
        foreach ($languages as $language) {
            $worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4,30)+1);
        }

        // The attributes headings row and column styles
        $styles = array();
        $data = array();
        $i = 1;
        $j = 0;
        $data[$j++] = 'attribute_id';
        $data[$j++] = 'attribute_group_id';
        $data[$j++] = 'sort_order';
        foreach ($languages as $language) {
            $styles[$j] = &$text_format;
            $data[$j++] = 'name('.$language['code'].')';
        }
        $worksheet->getRowDimension($i)->setRowHeight(30);
        $this->setCellRow( $worksheet, $i, $data, $box_format );

        // The actual attributes values data
        $i += 1;
        $j = 0;
        $options = $this->getAttributes( $languages );
        foreach ($options as $row) {
            $worksheet->getRowDimension($i)->setRowHeight(13);
            $data = array();
            $data[$j++] = $row['attribute_id'];
            $data[$j++] = $row['attribute_group_id'];
            $data[$j++] = $row['sort_order'];
            foreach ($languages as $language) {
                $data[$j++] = html_entity_decode($row['name'][$language['code']],ENT_QUOTES,'UTF-8');
            }
            $this->setCellRow( $worksheet, $i, $data, $this->null_array, $styles );
            $i += 1;
            $j = 0;
        }
    }



    public function getFilterGroupNameCounts() {
        $default_language_id = $this->getDefaultLanguageId();
        $sql  = "SELECT `name`, COUNT(filter_group_id) AS `count` FROM `".DB_PREFIX."filter_group_description` ";
        $sql .= "WHERE language_id='".(int)$default_language_id."' ";
        $sql .= "GROUP BY `name`";
        $query = $this->db->query( $sql );
        return $query->rows;
    }


    public function getFilterNameCounts() {
        $default_language_id = $this->getDefaultLanguageId();
        $sql  = "SELECT fg.filter_group_id, fd.`name`, COUNT(fd.filter_id) AS `count` FROM `".DB_PREFIX."filter_description` fd ";
        $sql .= "INNER JOIN `".DB_PREFIX."filter` f ON f.filter_id=fd.filter_id ";
        $sql .= "INNER JOIN `".DB_PREFIX."filter_group` fg ON fg.filter_group_id=f.filter_group_id ";
        $sql .= "WHERE fd.language_id='".(int)$default_language_id."' ";
        $sql .= "GROUP BY fg.filter_group_id, fd.`name`";
        $query = $this->db->query( $sql );
        return $query->rows;
    }


    public function existFilter() {
        // only newer OpenCart versions support filters
        $query = $this->db->query( "SHOW TABLES LIKE '".DB_PREFIX."filter'" );
        $exist_table_filter = ($query->num_rows > 0);
        $query = $this->db->query( "SHOW TABLES LIKE '".DB_PREFIX."filter_group'" );
        $exist_table_filter_group = ($query->num_rows > 0);
        $query = $this->db->query( "SHOW TABLES LIKE '".DB_PREFIX."product_filter'" );
        $exist_table_product_filter = ($query->num_rows > 0);
        $query = $this->db->query( "SHOW TABLES LIKE '".DB_PREFIX."category_filter'" );
        $exist_table_category_filter = ($query->num_rows > 0);

        if (!$exist_table_filter) {
            return false;
        }
        if (!$exist_table_filter_group) {
            return false;
        }
        if (!$exist_table_product_filter) {
            return false;
        }
        if (!$exist_table_category_filter) {
            return false;
        }
        return true;
    }


    protected function getFilterGroupNames( $language_id ) {
        $sql  = "SELECT filter_group_id, name ";
        $sql .= "FROM `".DB_PREFIX."filter_group_description` ";
        $sql .= "WHERE language_id='".(int)$language_id."' ";
        $sql .= "ORDER BY filter_group_id ASC";
        $query = $this->db->query( $sql );
        $filter_group_names = array();
        foreach ($query->rows as $row) {
            $filter_group_id = $row['filter_group_id'];
            $name = $row['name'];
            $filter_group_names[$filter_group_id] = $name;
        }
        return $filter_group_names;
    }


    protected function getFilterNames( $language_id ) {
        $sql  = "SELECT filter_id, name ";
        $sql .= "FROM `".DB_PREFIX."filter_description` ";
        $sql .= "WHERE language_id='".(int)$language_id."' ";
        $sql .= "ORDER BY filter_id ASC";
        $query = $this->db->query( $sql );
        $filter_names = array();
        foreach ($query->rows as $row) {
            $filter_id = $row['filter_id'];
            $filter_name = $row['name'];
            $filter_names[$filter_id] = $filter_name;
        }
        return $filter_names;
    }


    protected function clearSpreadsheetCache() {
        $files = glob(DIR_CACHE . 'Spreadsheet_Excel_Writer' . '*');

        if ($files) {
            foreach ($files as $file) {
                if (file_exists($file)) {
                    @unlink($file);
                    clearstatcache();
                }
            }
        }
    }





}



/**
 * CSVToExcelConverter
 */
class CSVToExcelConverter extends Model
{
    /**
     * Read given csv file and write all rows to given xls file
     *
     * @param string $csv_file Resource path of the csv file
     * @param string $xls_file Resource path of the excel file
     * @param string $csv_enc Encoding of the csv file, use utf8 if null
     * @throws Exception
     */
    public static function convert($csv_file, $xls_file, $csv_enc=null) {


        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        /** Include PHPExcel */
       // require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
// Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');
// Miscellaneous glyphs, UTF-8
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
// Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

//        //set cache
//        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
//        PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
//
//        //open csv file
//        $objReader = new PHPExcel_Reader_CSV();
//        if ($csv_enc != null)
//            $objReader->setInputEncoding($csv_enc);
//        $objPHPExcel = $objReader->load($csv_file);
//        $in_sheet = $objPHPExcel->getActiveSheet();
//
//        //open excel file
//        $objPHPExcel = new PHPExcel();
//        $out_sheet = $objPHPExcel->getActiveSheet();
//
//        //row index start from 1
//        $row_index = 0;
//        foreach ($in_sheet->getRowIterator() as $row) {
//            $row_index++;
//            $cellIterator = $row->getCellIterator();
//            $cellIterator->setIterateOnlyExistingCells(false);
//
//            //column index start from 0
//            $column_index = -1;
//            foreach ($cellIterator as $cell) {
//                $column_index++;
//                $out_sheet->setCellValueByColumnAndRow($column_index, $row_index, $cell->getValue());
//            }
//        }
//
//        //write excel file
//        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//        $objWriter->save($xls_file);
    }


}
function translit($s) {
    $s = (string) $s; // преобразуем в строковое значение
    $s = strip_tags($s); // убираем HTML-теги
    $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
    $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
    $s = trim($s); // убираем пробелы в начале и конце строки
    $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
    $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
    $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
    $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
    return $s; // возвращаем результат
}


?>