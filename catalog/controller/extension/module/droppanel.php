<?php

class ControllerExtensionModuleDroppanel extends Controller {
	
	public function index() {

		//Load language file
		$this->language->load('module/droppanel');

		//Set title from language file
      	$data['heading_title'] = $this->language->get('heading_title');

		//Load model
		$this->load->model('module/droppanel');


		//$this->document->addScript('//code.jquery.com/ui/1.8.21/jquery-ui.min.js');


		//Sample - get data from loaded model
		$data['customers'] = $this->model_module_droppanel->getCustomerData();

        $this->document->addStyle('//fonts.googleapis.com/css?family=Cormorant');
        $this->document->addStyle('/catalog/view/theme/default/stylesheet/droppanel.css');
        $this->document->addScript('//code.jquery.com/ui/1.12.1/jquery-ui.js');

        $this->document->addScript('/catalog/view/javascript/libs/slideReveal-master/slideReveal-master/dist/jquery.slidereveal.min.js');


        $this->document->addScript('/catalog/view/javascript/furnitureprojs/js/slidereveal_init.js');


      //  $this->document->addScript('/catalog/view/javascript/furnitureprojs/js/jquery.ui.touch-punch.js');
        $this->document->addScript('/catalog/view/javascript/furnitureprojs/js/droppanel.js');




        $cookie_name = "user_drop_panel_id";
        if (!isset($_COOKIE['user_drop_panel_id'])){
            $cookie_value = rand(-99999999 ,-1);
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
            $user_drop_panel_id=$cookie_value;
        }else{
            $user_drop_panel_id=$_COOKIE['user_drop_panel_id'];

        }
        if ($this->customer->isLogged()) {
            if (isset($_COOKIE['user_drop_panel_id'])){
                 // перенос в кабинет
            }
            $cookie_value = $this->customer->getId();
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
            $user_drop_panel_id=$cookie_value;
        }

         $arr_drop_list=[];
        $ready_category_list=[];
        foreach (Wishlist::find('all',['user_id'=>$user_drop_panel_id]) as $item) {    // проход по таблице
            $ready_category_list[]=$item->product_id;
        }



        $data['ready_category_list']=$ready_category_list;
        $results=[];
        foreach ( $data['ready_category_list']as $item) {
            $results[]=$this->model_catalog_product->getProduct($item);
        }


        //$results = //$this->model_catalog_product->getProducts($filter_data);
        $setting['width']=150;
        $setting['height']=150;
        $data['products']=[];
        if (!empty( $results)) {
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
                }

                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $price = false;
                }

                if ((float)$result['special']) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $special = false;
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
                } else {
                    $tax = false;
                }

                if ($this->config->get('config_review_status')) {
                    $rating = $result['rating'];
                } else {
                    $rating = false;
                }




                $data['products'][] = array(
                    'product_id'  => $result['product_id'],
                    'thumb'       => $image,
                    'name'        => $result['name'],
                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                    'price'       => $price,
                    'special'     => $special,
                    'tax'         => $tax,
                    'rating'      => $rating,
                    'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
                );
            }



        }







        return $this->load->view('module/droppanel', $data);




	}

    public function add() {


        $resp=['remove'=>1];

	    if(isset( $this->request->post['product_id'])){
            if (isset($_COOKIE['user_drop_panel_id'])){
                $user_drop_panel_id=$_COOKIE['user_drop_panel_id'];
              $cw=  Wishlist::count(array('user_id' => $user_drop_panel_id,'product_id'=>$this->request->post['product_id']));
                    if($cw==0){ //new post
                        $resp=['remove'=>11];
                        $post=new Wishlist();
                        $post->user_id = (int)$user_drop_panel_id;
                        $post->product_id = (int)$this->request->post['product_id'];
                        $post->save();
                        }else{
                        $resp=['remove'=>0];
                    }


            }

        }


        $myJSON = json_encode($resp);
        echo $myJSON;
        die();

//        $cookie_name = "user_drop_panel_id";
//        if (isset($_COOKIE['user_drop_panel_id'])){
//            $cookie_value = rand(-99999999 ,-1);
//            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
//            $user_drop_panel_id=$cookie_value;
//        }else{
//            $user_drop_panel_id=$_COOKIE['user_drop_panel_id'];
//
//        }
//        if ($this->customer->isLogged()) {
//            if (isset($_COOKIE['user_drop_panel_id'])){
//                // перенос в кабинет
//            }
//            $cookie_value = $this->customer->getId();
//            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
//            $user_drop_panel_id=$cookie_value;
//        }
        if (isset($_COOKIE['user_drop_panel_id'])){
            $user_drop_panel_id=$_COOKIE['user_drop_panel_id'];

        }
        $myJSON = json_encode([$user_drop_panel_id,1,2,3,]);
        echo $myJSON;
	    die();




    }

    public function del() {


        $resp=['remove'=>1];

        if(isset( $this->request->post['product_id'])){
            if (isset($_COOKIE['user_drop_panel_id'])){

                $user_drop_panel_id=$_COOKIE['user_drop_panel_id'];
                Wishlist::table()->delete(array('user_id' => $user_drop_panel_id,'product_id'=>$this->request->post['product_id']));
            }

        }


        $myJSON = json_encode($resp);
        echo $myJSON;
        die();

//        $cookie_name = "user_drop_panel_id";
//        if (isset($_COOKIE['user_drop_panel_id'])){
//            $cookie_value = rand(-99999999 ,-1);
//            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
//            $user_drop_panel_id=$cookie_value;
//        }else{
//            $user_drop_panel_id=$_COOKIE['user_drop_panel_id'];
//
//        }
//        if ($this->customer->isLogged()) {
//            if (isset($_COOKIE['user_drop_panel_id'])){
//                // перенос в кабинет
//            }
//            $cookie_value = $this->customer->getId();
//            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
//            $user_drop_panel_id=$cookie_value;
//        }
        if (isset($_COOKIE['user_drop_panel_id'])){
            $user_drop_panel_id=$_COOKIE['user_drop_panel_id'];

        }
        $myJSON = json_encode([$user_drop_panel_id,1,2,3,]);
        echo $myJSON;
        die();




    }
}

?>