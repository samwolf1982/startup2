<?php
class ControllerProductCategory extends Controller {
	public function index() {
		$this->load->language('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');




       $this->document->addScript('/catalog/view/javascript/libs/jquery-nice-select-master/jquery-nice-select-master/js/jquery.nice-select.min.js');
        $this->document->addStyle('/catalog/view/javascript/libs/jquery-nice-select-master/jquery-nice-select-master/css/nice-select.css');

       $this->document->addStyle('/catalog/view/theme/furniturepro/stylesheet/css/category.css');
       $this->document->addStyle('/catalog/view/theme/furniturepro/stylesheet/css/search.css');
       $this->document->addScript('/catalog/view/javascript/furnitureprojs/js/category.js');





		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['path'])) {
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path . $url)
					);
				}
			}
		} else {
			$category_id = 0;
		}

		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {

			if ($category_info['meta_title']) {
				$this->document->setTitle($category_info['meta_title']);
			} else {
				$this->document->setTitle($category_info['name']);
			}

			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);

			if ($category_info['meta_h1']) {
				$data['heading_title'] = $category_info['meta_h1'];
			} else {
				$data['heading_title'] = $category_info['name'];
			}

			$data['text_refine'] = $this->language->get('text_refine');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');

			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');

			// Set the last category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $category_info['name'],
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
			);

			if ($category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get($this->config->get('config_theme') . '_image_category_width'), $this->config->get($this->config->get('config_theme') . '_image_category_height'));
				$this->document->setOgImage($data['thumb']);
			} else {
				$data['thumb'] = '';
			}

			$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
			$data['compare'] = $this->url->link('product/compare');

			$url = '';

            if (isset($this->request->get['bfilter'])) {
                $url .= '&bfilter=' . $this->request->get['bfilter'];
            }


            if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['categories'] = array();

			$results = $this->model_catalog_category->getCategories($category_id);

			foreach ($results as $result) {
				$filter_data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);

				$h=225;
				$w=250;
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $w, $h);
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png',  $w, $h);
                }
				$data['categories'][] = array(
					'name' => $result['name'],
					//'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url),
                    'img'=>$image
				);
                unset($image);
			}

			$data['products'] = array();




			$filter_data = array(
				'filter_category_id' => $category_id,
				'filter_sub_category'=>true,
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);

			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
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
					$rating = (int)$result['rating'];
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
					'minimum'     => ($result['minimum'] > 0) ? $result['minimum'] : 1,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url)
				);
			}

			$url = '';

            if (isset($this->request->get['bfilter'])) {
                $url .= '&bfilter=' . $this->request->get['bfilter'];
            }



            if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
			);

			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
				);
			}

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
			);

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['limits'] = array();

			$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

			// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'prev');
			} else {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page - 1), true), 'prev');
			}

			if ($limit && ceil($product_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page + 1), true), 'next');
			}

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');






            //brain filter from
            $moduleSettings=   array (
                'layout_id' => '3',
                'position' => 'content_top',
                'sort_order' => '0',
                'status' => '1',
                'bf_layout_id' => '44',
                'name' => 'Категория / Верх страницы',
                'module_id' => '44',
            );
            $settings = $this->_getSettings($moduleSettings['bf_layout_id']);
            $this->load->model('extension/module/brainyfilter');
            $model = new ModelExtensionModuleBrainyFilter($this->registry);
            $model->setData($data);
            $conditions = $model->getConditions();


            $filters = array();
            $secSettings = $settings['behaviour']['sections'];
//            if ($secSettings['attribute']['enabled']) {
//                $arr = $model->getAttributes();
//                $this->_applySettings($arr, 'attributes', $settings);
//                if (count($arr)) {
//                    $filters[] = array(
//                        'type'  => 'attribute',
//                        'order' => (int)$settings['behaviour']['sort_order']['attribute'],
//                        'array' => $arr,
//                        'collapsed' => (bool)$secSettings['attribute']['collapsed'],
//                    );
//                }
//            }
            if ($secSettings['attribute']['enabled']) {
                $arr = $model->getAttributes();
                $this->_applySettings($arr, 'attributes', $settings);
                if (count($arr)) {
                    $filters[] = array(
                        'type'  => 'attribute',
                        'order' => (int)$settings['behaviour']['sort_order']['attribute'],
                        'array' => $arr,
                        'collapsed' => (bool)$secSettings['attribute']['collapsed'],
                    );
                }
            }

            $colect=[];
            $atribute_group_id_style=14;
            $sdf=1;
            if (isset($arr[$atribute_group_id_style]['values'])){
                foreach ( $arr[$atribute_group_id_style]['values'] as $attr_item_el) {
                    $url_atr_el=(string) $this->generate_brain_url($this->request->get['path'],$url,$atribute_group_id_style,$attr_item_el['id']);
                    $colect[] = array(
                        'text'  => $attr_item_el['name'],
                        'value' =>  $attr_item_el['id'],
                        'href'  =>$url_atr_el,
                        'current'=>$this->is_gurent_atribute('a',$atribute_group_id_style,$attr_item_el['id']),
                    );
                }
            }


            $attr_item_list_default_url=$this->generate_default_brain_url('a',$this->request->get['path'],$url,$atribute_group_id_style);
            $data['attr_item_list_default_url']=$attr_item_list_default_url;
//            var_dump($colect);

            $data['attr_item_list']=$colect;


            //------------- color
            $colect=[];
            $atribute_group_id_style=15;
            if (isset($arr[$atribute_group_id_style]['values'])){
                foreach ( $arr[$atribute_group_id_style]['values'] as $attr_item_el) {
                    $url_atr_el=(string) $this->generate_brain_url($this->request->get['path'],$url,$atribute_group_id_style,$attr_item_el['id']);
                    $colect[] = array(
                        'text'  => $attr_item_el['name'],
                        'value' =>  $attr_item_el['id'],
                        'href'  =>$url_atr_el,
                        'current'=>$this->is_gurent_atribute('a',$atribute_group_id_style,$attr_item_el['id']),
                    );
                }
            }


            $attr_item_list_default_url=$this->generate_default_brain_url('a',$this->request->get['path'],$url,$atribute_group_id_style);
            $data['attr_item_list_color_default_url']=$attr_item_list_default_url;
            $data['attr_item_list_color']=$colect;



            //------------- price
            $colect=[];
            $atribute_group_id_price=['na-1000','1000-2000','2000-3000','3000-5000','5000-7000','7000-10000','10000-15000','15000-20000','20000-30000','30000-50000','50000-100000','100000-na',];


            // до -1000
            //от 100000
                foreach ( $atribute_group_id_price as $ki=> $attr_item_el) {
                    $url_atr_el=(string) $this->generate_brain_price_url($this->request->get['path'],$url,$atribute_group_id_style,$attr_item_el);
                    $text_price=$attr_item_el;
                    if ( $ki==0 ){ $text_price='до 1000'; }
                    if ( $ki== ( count($atribute_group_id_price)-1) ) {  $text_price='от 100000'; }
                    $colect[] = array(
                        'text'  => $text_price,
                        'value' =>  $attr_item_el,
                        'href'  =>$url_atr_el,
                        'current'=>$this->is_gurent_atribute('price',$atribute_group_id_style,$attr_item_el),
                    );
                }


            $attr_item_list_default_url=$this->generate_default_brain_price_url('price',$this->request->get['path'],$url,$atribute_group_id_style);
            $data['attr_item_list_price_default_url']=$attr_item_list_default_url;
            $data['attr_item_list_price']=$colect;

            //brain filter from --end









			$this->response->setOutput($this->load->view('product/category', $data));
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/category', $url)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}


    private function generate_brain_price_url($g_path,$url,$v_left,$v_right){
        // $res= $this->url->link($route, $path . '&sort=p.sort_order&order=ASC' . $url);

        //bfilter=price:na-12000
        $a=sprintf('price:%s',$v_right);
        $colect_b_filters=[];
        if (isset($this->request->get['bfilter'])) {
            //$url .=  $this->request->get['bfilter'];
            $bfilter_arr=explode(';',$this->request->get['bfilter']);

            $find_bprice=true;
            foreach ($bfilter_arr as $group_id) {
                if (empty($group_id))continue;
                $group_ids_arr=explode(':',$group_id);
                if (count($group_ids_arr)){
                    if ($group_ids_arr[0]=="price"){ // совпаадение
                        $ert=789;
                        $group_id=$a;
                        $find_bprice=false;
                        // $ert=789;
                    }
                }
                $colect_b_filters[]=$group_id;

                unset($group_ids_arr);
            }
            if ($find_bprice){ $colect_b_filters[]=$a; }

            $replace_b_filtrer=implode(';', $colect_b_filters);
            $replace_b_filtrer= trim($replace_b_filtrer);
            $res= $this->url->link('product/category', 'path=' . $g_path. '&bfilter='.$replace_b_filtrer.';' . $url);
        }else{    // фильтра нету просто клеим
            $res= $this->url->link('product/category', 'path=' . $g_path. '&bfilter='.$a.';' . $url);

        }


        return $res;
    }


    private function generate_brain_url($g_path,$url,$v_left,$v_right){
        // $res= $this->url->link($route, $path . '&sort=p.sort_order&order=ASC' . $url);
        $a=sprintf('a%s:%s',$v_left,$v_right);
        $filter_url=parse_url($url, PHP_URL_QUERY);
        $replace_b_filtrer='';
        $colect_b_filters=[];
        if (isset($this->request->get['bfilter'])) {
            //$url .=  $this->request->get['bfilter'];
            $bfilter_arr=explode(';',$this->request->get['bfilter']);

            foreach ($bfilter_arr as $group_id) {
                if (empty($group_id))continue;
                $group_ids_arr=explode(':',$group_id);
                if (count($group_ids_arr)){
                    if ($group_ids_arr[0]=="a".$v_left){ // совпаадение

                        $ert=789;
                        $group_id=$a;
                        // $ert=789;
                    }
                }
                $colect_b_filters[]=$group_id;

                unset($group_ids_arr);
            }

            $replace_b_filtrer=implode(';', $colect_b_filters);
            $replace_b_filtrer= trim($replace_b_filtrer);
            $res= $this->url->link('product/category', 'path=' . $g_path. '&bfilter='.$replace_b_filtrer.';' . $url);
        }else{    // фильтра нету просто клеим
            $res= $this->url->link('product/category', 'path=' . $g_path. '&bfilter='.$a.';' . $url);

        }


        return $res;
    }

    private function is_gurent_atribute($prefix,$v_left,$v_right){
        if ($prefix=='price'){
            $a=sprintf('%s:%s',$prefix,$v_right);
        }else{
            $a=sprintf('%s%s:%s',$prefix,$v_left,$v_right);
        }

        if (isset($this->request->get['bfilter'])) {
            //$url .=  $this->request->get['bfilter'];
            $bfilter_arr=explode(';',$this->request->get['bfilter']);

            foreach ($bfilter_arr as $group_id) {
                if (empty($group_id))continue;
                if($group_id==$a) return true;
            }

        }


        return false;
    }

    private function generate_default_brain_url($prefix,$g_path,$url,$v_left){
        // $res= $this->url->link($route, $path . '&sort=p.sort_order&order=ASC' . $url);
        $a=sprintf('%s%s',$prefix,$v_left);

        $colect_b_filters=[];
        if (isset($this->request->get['bfilter'])) {
            //$url .=  $this->request->get['bfilter'];
            $bfilter_arr=explode(';',$this->request->get['bfilter']);
            $clear_arr=[];
            foreach ( $bfilter_arr as  $item) {
                if (!empty($item)){
                    $clear_arr[]=$item;
                }
            }
            $bfilter_arr=$clear_arr;

            foreach ($bfilter_arr as $group_id) {
                if (empty($group_id))continue;
                $group_ids_arr=explode(':',$group_id);
                if (count($group_ids_arr)){
                    if ($group_ids_arr[0].':'==$prefix.$v_left.':'){ // совпаадение

                        $ert=789;
                        $group_id=$a;
                        // $ert=789;
                    }else{
                        $colect_b_filters[]=$group_ids_arr[0].':'.$group_ids_arr[1];
                    }
                }


                unset($group_ids_arr);
            }

            if (!empty($colect_b_filters)){
                $replace_b_filtrer=implode(';', $colect_b_filters);
                $replace_b_filtrer= trim($replace_b_filtrer);
                $res= $this->url->link('product/category', 'path=' . $g_path. '&bfilter='.$replace_b_filtrer.';' . $url);
            }else{
                $res= $this->url->link('product/category', 'path=' . $g_path. $url);
            }

        }else{    // фильтра нету просто клеим
            $res= $this->url->link('product/category', 'path=' . $g_path. $url);

        }


        return $res;
    }

    private function generate_default_brain_price_url($prefix,$g_path,$url,$v_right){

        $colect_b_filters=[];
        if (isset($this->request->get['bfilter'])) {
            //$url .=  $this->request->get['bfilter'];
            $bfilter_arr=explode(';',$this->request->get['bfilter']);
            $clear_arr=[];
            foreach ( $bfilter_arr as  $item) {
                if (!empty($item)){
                    $clear_arr[]=$item;
                }
            }
            $bfilter_arr=$clear_arr;

            foreach ($bfilter_arr as $group_id) {
                if (empty($group_id))continue;
                $group_ids_arr=explode(':',$group_id);
                if (count($group_ids_arr)){
                    if ($group_ids_arr[0].':'==$prefix.':'){ // совпаадение

                        $ert=789;
                        // $group_id=$a;
                        // $ert=789;
                    }else{
                        $colect_b_filters[]=$group_ids_arr[0].':'.$group_ids_arr[1];
                    }
                }


                unset($group_ids_arr);
            }

            if (!empty($colect_b_filters)){
                $replace_b_filtrer=implode(';', $colect_b_filters);
                $replace_b_filtrer= trim($replace_b_filtrer);
                $res= $this->url->link('product/category', 'path=' . $g_path. '&bfilter='.$replace_b_filtrer.';' . $url);
            }else{
                $res= $this->url->link('product/category', 'path=' . $g_path. $url);
            }

        }else{    // фильтра нету просто клеим
            $res= $this->url->link('product/category', 'path=' . $g_path. $url);

        }


        return $res;
    }




	/// from brain filter
    private function _getSettings($layoutId)
    {
        $bfSettings = array();
        if ($this->config->get('brainyfilter_layout_basic')) {
            $bfSettings['basic'] = $this->config->get('brainyfilter_layout_basic');
        }

        $settings = self::_arrayReplaceRecursive($bfSettings['basic'], $this->config->get('brainyfilter_layout_' . $layoutId));

        return $settings;
    }

    /// from brain filter
    /**
     * An alternative of PHP native function array_replace_recursive(), which is designed
     * to bring similar functionality for PHP versions lower then 5.3. <br>
     * <b>Note</b>: unlike PHP native function the method holds only two arrays as parameters.
     * @param array $array An original array
     * @param array $array1 Replacement
     * @return array
     */
    private static function _arrayReplaceRecursive($array, $array1)
    {
        if (is_array($array1) && count($array1)) {
            foreach ($array1 as $key => $value) {
                if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key]))) {
                    $array[$key] = array();
                }

                if (is_array($value)) {
                    $value = self::_arrayReplaceRecursive($array[$key], $value);
                }
                $array[$key] = $value;
            }
        }
        return $array;
    }
    /// from brain filter
    private function _applySettings(&$filters, $type, $settings)
    {
        if (!is_array($filters) || !count($filters)) {
            return;
        }
        $secSettings = isset($settings[$type]) ? $settings[$type] : null;
        $defSettings = $settings["{$type}_default"];
        foreach ($filters as $k => $f) {
            if (   (!$defSettings['enable_all'] && !isset($secSettings[$k]['enabled']))
                || (isset($secSettings[$k]['enabled']) && !$secSettings[$k]['enabled']) ) {
                unset($filters[$k]);
            } else {
                $f['type'] = isset($secSettings[$k]['control']) ? $secSettings[$k]['control'] : $defSettings['control'];
                if (isset($secSettings[$k]['mode']) || isset($defSettings['mode'])) {
                    $f['mode'] = isset($secSettings[$k]['mode']) ? $secSettings[$k]['mode'] : $defSettings['mode'];
                }
                if (in_array($f['type'], array('slider', 'slider_lbl', 'slider_lbl_inp'))) {
                    $values = array();
                    foreach ($f['values'] as $val) {
                        $values[] = array('n' => $val['name'], 's' => $val['sort']);
                    }
                    $f['values'] = $values;
                    $f['min'] = array_shift($values);
                    $f['max'] = array_pop($values);
                }
                $filters[$k] = $f;
            }
        }
    }

}
