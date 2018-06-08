<?php
class ControllerCommonCart extends Controller {
	public function index() {
		$this->load->language('common/cart');

		// Totals
		$this->load->model('extension/extension');

		$totals = array();
		$taxes = $this->cart->getTaxes();
		$total = 0;

		// Because __call can not keep var references so we put them into an array.
		$total_data = array(
			'totals' => &$totals,
			'taxes'  => &$taxes,
			'total'  => &$total
		);
			
		// Display prices
		if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('extension/total/' . $result['code']);

					// We have to put the totals in an array so that they pass by reference.
					$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
				}
			}

			$sort_order = array();

			foreach ($totals as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $totals);
		}

		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_cart'] = $this->language->get('text_cart');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_recurring'] = $this->language->get('text_recurring');
		$data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
		$data['text_loading'] = $this->language->get('text_loading');

		$data['button_remove'] = $this->language->get('button_remove');

		$this->load->model('tool/image');
		$this->load->model('tool/upload');

		$data['products'] = array();

		foreach ($this->cart->getProducts() as $product) {
			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
			} else {
				$image = '';
			}

			$option_data = array();

			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['value'];
				} else {
					$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

					if ($upload_info) {
						$value = $upload_info['name'];
					} else {
						$value = '';
					}
				}

				$option_data[] = array(
					'name'  => $option['name'],
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
					'type'  => $option['type']
				);
			}

			// Display prices
			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$unit_price = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'));
				
				$price = $this->currency->format($unit_price, $this->session->data['currency']);
				$total = $this->currency->format($unit_price * $product['quantity'], $this->session->data['currency']);
			} else {
				$price = false;
				$total = false;
			}

			$data['products'][] = array(
				'cart_id'   => $product['cart_id'],
				'thumb'     => $image,
				'name'      => $product['name'],
				'model'     => $product['model'],
				'option'    => $option_data,
				'recurring' => ($product['recurring'] ? $product['recurring']['name'] : ''),
				'quantity'  => $product['quantity'],
				'price'     => $price,
				'total'     => $total,
				'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
			);
		}

		// Gift Voucher
		$data['vouchers'] = array();

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency'])
				);
			}
		}

		$data['totals'] = array();

		foreach ($totals as $total) {
			$data['totals'][] = array(
				'title' => $total['title'],
				'text'  => $this->currency->format($total['value'], $this->session->data['currency']),
			);
		}

		$data['cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);

		return $this->load->view('common/cart', $data);
	}

	public function info() {
		$this->response->setOutput($this->index());
	}




    public function modal() {

        $this->load->language('common/cart');

        // Totals
        $this->load->model('extension/extension');


        $min_total_text='';
        //min price start
        if ($this->config->get('min_order_total_status')) {  // start min order total

            $vouchers_amount = 0;
            if (!empty($this->session->data['vouchers'])) {
                foreach ($this->session->data['vouchers'] as $key => $voucher) {
                    $vouchers_amount += $voucher['amount'];
                }
            }

            $this->load->model('extension/module/min_order_total');

            if ($this->config->get('min_order_total_type') == 'total') {
                $compare_total = $this->currency->format($this->model_extension_module_min_order_total->getCartTotalAbsolute(), $this->session->data['currency'], '', false);
            } else {
                $compare_total = $this->currency->format($this->cart->getSubTotal() + $vouchers_amount, $this->session->data['currency'], '', false);
            }

            $min_order_total = $this->currency->format($this->config->get('min_order_total_amount'), $this->session->data['currency'], '', false);

            if ($compare_total < $min_order_total) {

//                $this->response->redirect($this->url->link('checkout/cart'));
                $mot_messages = $this->config->get('min_order_total_message');
                $mot_warning  = $mot_messages[$this->config->get('config_language_id')];

                if ($this->config->get('min_order_total_type') == 'total'){
                    $min_total_text=str_replace("{min_order_total}", $this->currency->format($this->config->get('min_order_total_amount'), $this->session->data['currency']), $mot_warning['total_message']);
                    $data['error_warning'] = str_replace("{min_order_total}", $this->currency->format($this->config->get('min_order_total_amount'), $this->session->data['currency']), $mot_warning['total_message']);
                } else {
                    $min_total_text= str_replace("{min_order_total}", $this->currency->format($this->config->get('min_order_total_amount'), $this->session->data['currency']), $mot_warning['subtotal_message']);
                    $data['error_warning'] = str_replace("{min_order_total}", $this->currency->format($this->config->get('min_order_total_amount'), $this->session->data['currency']), $mot_warning['subtotal_message']);
                }
            } else {
                $data['error_warning'] = '';
            }


        }
        //min price end




        $totals = array();
        $taxes = $this->cart->getTaxes();
        $total = 0;

        // Because __call can not keep var references so we put them into an array.
        $total_data = array(
            'totals' => &$totals,
            'taxes'  => &$taxes,
            'total'  => &$total
        );

        // Display prices
        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
            $sort_order = array();

            $results = $this->model_extension_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->load->model('extension/total/' . $result['code']);

                    // We have to put the totals in an array so that they pass by reference.
                    $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
            }

            $sort_order = array();

            foreach ($totals as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $totals);
        }

        $data['text_empty'] = $this->language->get('text_empty');
        $data['text_cart'] = $this->language->get('text_cart');
        $data['text_checkout'] = $this->language->get('text_checkout');
        $data['text_recurring'] = $this->language->get('text_recurring');
        $data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
        $data['text_loading'] = $this->language->get('text_loading');

        $data['button_remove'] = $this->language->get('button_remove');

        $this->load->model('tool/image');
        $this->load->model('tool/upload');

        $data['products'] = array();

        foreach ($this->cart->getProducts() as $product) {

            $image = '';
            $option_data = array();

            foreach ($product['option'] as $option) {
                if ($option['type'] != 'file') {
                    $value = $option['value'];
                } else {
                    $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                    if ($upload_info) {
                        $value = $upload_info['name'];
                    } else {
                        $value = '';
                    }
                }

                $option_data[] = array(
                    'name'  => $option['name'],
                    'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
                    'type'  => $option['type']
                );
            }

            // Display prices
            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $unit_price = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'));

                $price = $this->currency->format($unit_price, $this->session->data['currency']);
                $total = $this->currency->format($unit_price * $product['quantity'], $this->session->data['currency']);
            } else {
                $price = false;
                $total = false;
            }

            $data['products'][] = array(
                'cart_id'   => $product['cart_id'],
                'thumb'     => $image,
                'name'      => $product['name'],
                'model'     => $product['model'],
                'option'    => $option_data,
                'recurring' => ($product['recurring'] ? $product['recurring']['name'] : ''),
                'quantity'  => $product['quantity'],
                'price'     => $price,
                'total'     => $total,
                'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
            );
        }

        // Gift Voucher
        $data['vouchers'] = array();

        if (!empty($this->session->data['vouchers'])) {
            foreach ($this->session->data['vouchers'] as $key => $voucher) {
                $data['vouchers'][] = array(
                    'key'         => $key,
                    'description' => $voucher['description'],
                    'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency'])
                );
            }
        }

        $data['totals'] = array();

        foreach ($totals as $total) {
            $data['totals'][] = array(
                'title' => $total['title'],
                'text'  => $this->currency->format($total['value'], $this->session->data['currency']),
            );
        }

        $data['cart'] = $this->url->link('checkout/cart');
        $data['checkout'] = $this->url->link('checkout/checkout', '', true);












    $resp= '<div id="ajaxcontent" class="modal-dialog modal-lg cart_modal" tabindex="-1" role="dialog">

  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Корзина</h2>'."<p class='min_total'>{$min_total_text}</p>".'
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Custombox.modal.close();">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body"> <div class="col-sm-6 ">';


        $resp.=$this->generate_modal_items();



     $resp.='</div><div class="col-sm-6 ">';
     $resp.=$this->generate_modal_total_info($totals);
     $resp.='</div>';





   $resp.= ' <div class="clearfix"></div><div class="col-sm-12">';

        $resp.=$this->generate_some_items();




   $resp.='
      </div>

    </div>
    <div class="clearfix"></div>
    <div class="modal-footer">

    </div>
  </div>

</div>';
        echo $resp;

        die();
    }

    public function thanks() {

        $this->load->language('common/cart');

        // Totals
        $this->load->model('extension/extension');

        $totals = array();
        $taxes = $this->cart->getTaxes();
        $total = 0;

        // Because __call can not keep var references so we put them into an array.
        $total_data = array(
            'totals' => &$totals,
            'taxes'  => &$taxes,
            'total'  => &$total
        );

        // Display prices
        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
            $sort_order = array();

            $results = $this->model_extension_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->load->model('extension/total/' . $result['code']);

                    // We have to put the totals in an array so that they pass by reference.
                    $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
            }

            $sort_order = array();

            foreach ($totals as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $totals);
        }

        $data['text_empty'] = $this->language->get('text_empty');
        $data['text_cart'] = $this->language->get('text_cart');
        $data['text_checkout'] = $this->language->get('text_checkout');
        $data['text_recurring'] = $this->language->get('text_recurring');
        $data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
        $data['text_loading'] = $this->language->get('text_loading');

        $data['button_remove'] = $this->language->get('button_remove');

        $this->load->model('tool/image');
        $this->load->model('tool/upload');

        $data['products'] = array();

        foreach ($this->cart->getProducts() as $product) {

            $image = '';
            $option_data = array();

            foreach ($product['option'] as $option) {
                if ($option['type'] != 'file') {
                    $value = $option['value'];
                } else {
                    $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                    if ($upload_info) {
                        $value = $upload_info['name'];
                    } else {
                        $value = '';
                    }
                }

                $option_data[] = array(
                    'name'  => $option['name'],
                    'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
                    'type'  => $option['type']
                );
            }

            // Display prices
            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $unit_price = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'));

                $price = $this->currency->format($unit_price, $this->session->data['currency']);
                $total = $this->currency->format($unit_price * $product['quantity'], $this->session->data['currency']);
            } else {
                $price = false;
                $total = false;
            }

            $data['products'][] = array(
                'cart_id'   => $product['cart_id'],
                'thumb'     => $image,
                'name'      => $product['name'],
                'model'     => $product['model'],
                'option'    => $option_data,
                'recurring' => ($product['recurring'] ? $product['recurring']['name'] : ''),
                'quantity'  => $product['quantity'],
                'price'     => $price,
                'total'     => $total,
                'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
            );
        }

        // Gift Voucher
        $data['vouchers'] = array();

        if (!empty($this->session->data['vouchers'])) {
            foreach ($this->session->data['vouchers'] as $key => $voucher) {
                $data['vouchers'][] = array(
                    'key'         => $key,
                    'description' => $voucher['description'],
                    'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency'])
                );
            }
        }

        $data['totals'] = array();

        foreach ($totals as $total) {
            $data['totals'][] = array(
                'title' => $total['title'],
                'text'  => $this->currency->format($total['value'], $this->session->data['currency']),
            );
        }

        $data['cart'] = $this->url->link('checkout/cart');
        $data['checkout'] = $this->url->link('checkout/checkout', '', true);












        $resp= '<div id="ajaxcontent" class="modal-dialog modal-lg cart_modal" tabindex="-1" role="dialog">

  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Ваш заказ оформлен</h2>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Custombox.modal.close();">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body"> <div class="col-sm-12 text-center">';


        $resp.='Ваш заказ принят на обработку. Наш менеджер свяжется с Вами в ближайшее время.';



        $resp.='</div><div class="col-sm-12 ">';
        $resp.=$this->generate_modal_total_info($totals);
        $resp.='</div>';





        $resp.= ' <div class="clearfix"></div><div class="col-sm-12">';

        $resp.=$this->generate_some_items();




        $resp.='
      </div>

    </div>
    <div class="clearfix"></div>
    <div class="modal-footer">

    </div>
  </div>

</div>';
        echo $resp;

        die();
    }

    public function modal_quick() {






        $min_total_text='';
        //min price start
        if ($this->config->get('min_order_total_status')) {  // start min order total

            $vouchers_amount = 0;
            if (!empty($this->session->data['vouchers'])) {
                foreach ($this->session->data['vouchers'] as $key => $voucher) {
                    $vouchers_amount += $voucher['amount'];
                }
            }

            $this->load->model('extension/module/min_order_total');

            if ($this->config->get('min_order_total_type') == 'total') {
                $compare_total = $this->currency->format($this->model_extension_module_min_order_total->getCartTotalAbsolute(), $this->session->data['currency'], '', false);
            } else {
                $compare_total = $this->currency->format($this->cart->getSubTotal() + $vouchers_amount, $this->session->data['currency'], '', false);
            }

            $min_order_total = $this->currency->format($this->config->get('min_order_total_amount'), $this->session->data['currency'], '', false);

            if ($compare_total < $min_order_total) {

//                $this->response->redirect($this->url->link('checkout/cart'));
                $mot_messages = $this->config->get('min_order_total_message');
                $mot_warning  = $mot_messages[$this->config->get('config_language_id')];

                if ($this->config->get('min_order_total_type') == 'total'){
                    //min price end
                    $this->modal();  // обрыв дальше не идет
                    $min_total_text=str_replace("{min_order_total}", $this->currency->format($this->config->get('min_order_total_amount'), $this->session->data['currency']), $mot_warning['total_message']);
                    $data['error_warning'] = str_replace("{min_order_total}", $this->currency->format($this->config->get('min_order_total_amount'), $this->session->data['currency']), $mot_warning['total_message']);
                } else {
                    //min price end
                    $this->modal();  // обрыв дальше не идет
                    $min_total_text= str_replace("{min_order_total}", $this->currency->format($this->config->get('min_order_total_amount'), $this->session->data['currency']), $mot_warning['subtotal_message']);
                    $data['error_warning'] = str_replace("{min_order_total}", $this->currency->format($this->config->get('min_order_total_amount'), $this->session->data['currency']), $mot_warning['subtotal_message']);
                }
            } else {
                $data['error_warning'] = '';
            }
        }


        $this->load->language('common/cart');

        // Totals
        $this->load->model('extension/extension');

        $totals = array();
        $taxes = $this->cart->getTaxes();
        $total = 0;

        // Because __call can not keep var references so we put them into an array.
        $total_data = array(
            'totals' => &$totals,
            'taxes'  => &$taxes,
            'total'  => &$total
        );

        // Display prices
        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
            $sort_order = array();

            $results = $this->model_extension_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->load->model('extension/total/' . $result['code']);

                    // We have to put the totals in an array so that they pass by reference.
                    $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
            }

            $sort_order = array();

            foreach ($totals as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $totals);
        }

        $data['text_empty'] = $this->language->get('text_empty');
        $data['text_cart'] = $this->language->get('text_cart');
        $data['text_checkout'] = $this->language->get('text_checkout');
        $data['text_recurring'] = $this->language->get('text_recurring');
        $data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
        $data['text_loading'] = $this->language->get('text_loading');

        $data['button_remove'] = $this->language->get('button_remove');

        $this->load->model('tool/image');
        $this->load->model('tool/upload');

        $data['products'] = array();

        foreach ($this->cart->getProducts() as $product) {

            $image = '';
            $option_data = array();

            foreach ($product['option'] as $option) {
                if ($option['type'] != 'file') {
                    $value = $option['value'];
                } else {
                    $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                    if ($upload_info) {
                        $value = $upload_info['name'];
                    } else {
                        $value = '';
                    }
                }

                $option_data[] = array(
                    'name'  => $option['name'],
                    'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
                    'type'  => $option['type']
                );
            }

            // Display prices
            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $unit_price = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'));

                $price = $this->currency->format($unit_price, $this->session->data['currency']);
                $total = $this->currency->format($unit_price * $product['quantity'], $this->session->data['currency']);
            } else {
                $price = false;
                $total = false;
            }

            $data['products'][] = array(
                'cart_id'   => $product['cart_id'],
                'thumb'     => $image,
                'name'      => $product['name'],
                'model'     => $product['model'],
                'option'    => $option_data,
                'recurring' => ($product['recurring'] ? $product['recurring']['name'] : ''),
                'quantity'  => $product['quantity'],
                'price'     => $price,
                'total'     => $total,
                'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
            );
        }

        // Gift Voucher
        $data['vouchers'] = array();

        if (!empty($this->session->data['vouchers'])) {
            foreach ($this->session->data['vouchers'] as $key => $voucher) {
                $data['vouchers'][] = array(
                    'key'         => $key,
                    'description' => $voucher['description'],
                    'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency'])
                );
            }
        }

        $data['totals'] = array();

        foreach ($totals as $total) {
            $data['totals'][] = array(
                'title' => $total['title'],
                'text'  => $this->currency->format($total['value'], $this->session->data['currency']),
            );
        }

        $data['cart'] = $this->url->link('checkout/cart');
        $data['checkout'] = $this->url->link('checkout/checkout', '', true);












        $resp= '<div id="ajaxcontent" class="modal-dialog modal-lg cart_modal" tabindex="-1" role="dialog">

  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Быстрый заказ</h2>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Custombox.modal.close();">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body"> <div class="col-sm-6 ">';


        $resp.=$this->generate_modal_items();



        $resp.='</div><div class="col-sm-6 ">';
        $resp.=$this->generate_modal_total_info_quick($totals);
        $resp.='</div>';





        $resp.= ' <div class="clearfix"></div><div class="col-sm-12">';

        $resp.=$this->generate_some_items();




        $resp.='
      </div>

    </div>
    <div class="clearfix"></div>
    <div class="modal-footer">

    </div>
  </div>

</div>';
        echo $resp;

        die();
    }



    /**
     *  нужно набрать 4 связныхи или новых продукта
     * @return string
     */
    private  function generate_some_items(){
        $this->load->model('catalog/product');
        $this->load->model('tool/image');
        $info=['С этим товаром покупают','С этими товарами покупают','Возможно вам это будет интересно'];
           $id=2;
        if (count($this->cart->getProducts())==1) {
            $id=0;
        }
        if (count($this->cart->getProducts())>1) {
            $id=1;
        }
        $r='<h3 class="text-center">'.$info[$id].'</h3>
        <section>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad animi aperiam consequuntur doloribus ex fugiat iusto libero nemo perspiciatis quasi quidem quo rem reprehenderit, repudiandae rerum sapiente sequi totam?
        </section>
        <div class="cart_some_product">';
        if (count($this->cart->getProducts())<=0) { // 4 из послединх

            $filter_data = array(
                'sort'  => 'p.date_added',
                'order' => 'DESC',
                'start' => 0,
                'limit' =>4,
            );
            $prods = $this->model_catalog_product->getProducts($filter_data);
            if ($prods) {
                foreach ($prods as $p) {
                    if ($p['image']) {
                        $image = $this->model_tool_image->resize($p['image'], $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
                    } else {
                        $image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
                    }
                    $href=$this->url->link('product/product', 'product_id=' . $p['product_id']);
                    $r .= '  <caption>
         <a href="'.$href.'">   <img class="item_img" src="'.$image.'" alt="item"> <p class="text-center">'. $p['name'].'</p> </a>
          </caption>';
                }
            }

        }else{
                 // cвязные продукты нужно набрать 4 продукта

            $counter=0;
            foreach ($this->cart->getProducts() as $p){
                if ($counter>3){ break;}
                $results = $this->model_catalog_product->getProductRelated($p['product_id']);
                if ($results){
                    foreach ($results as $p) {
                        if ($counter>3){ break;}
                        if ($p['image']) {
                            $image = $this->model_tool_image->resize($p['image'], $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
                        } else {
                            $image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
                        }
                        $href=$this->url->link('product/product', 'product_id=' . $p['product_id']);
                        $r .= '  <caption>
         <a href="'.$href.'">   <img class="item_img" src="'.$image.'" alt="item"> <p class="text-center">'. $p['name'].'</p> </a> 
          </caption>';
                        $counter++;
                    }
                }
            }

            if ($counter<4){ //если не хватает товаров до 4 шт.
                $filter_data = array(
                    'sort'  => 'p.date_added',
                    'order' => 'DESC',
                    'start' => 0,
                    'limit' =>(4-$counter)
                );
                $prods = $this->model_catalog_product->getProducts($filter_data);
                if ($prods) {
                    foreach ($prods as $p) {
                        if ($p['image']) {
                            $image = $this->model_tool_image->resize($p['image'], $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
                        } else {
                            $image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
                        }
                        $href=$this->url->link('product/product', 'product_id=' . $p['product_id']);
                        $r .= '  <caption>
         <a href="'.$href.'">   <img class="item_img" src="'.$image.'" alt="item"> <p class="text-center">'. $p['name'].'</p> </a>
          </caption>';
                    }
                }

            }




        }


        $r.=' </div>';
        return $r;

    }


             private  function generate_modal_items(){

	    if (count($this->cart->getProducts())>0){


            $r='<ul class="cart_items">';
                 foreach ($this->cart->getProducts() as $product) {
                     $href=$this->url->link('product/product', 'product_id=' . $product['product_id']);
                     if ($product['image']) {
                         $image = $this->model_tool_image->resize($product['image'], $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
                     } else {
                         $image = '';
                     }
                     // Display prices
                     if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                         $unit_price = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'));

                         $price = $this->currency->format($unit_price, $this->session->data['currency']);
                         $total = $this->currency->format($unit_price * $product['quantity'], $this->session->data['currency']);
                     } else {
                         $price = false;
                         $total = false;
                     }
                     $r.='
          <li>
            <div class="cart_item">
         <a href="'.$href.'">     <img class="item_img" src="'.$image.'" alt="item"></a>
              <div class="text_item">
         <a href="'.$href.'">       <h3 class="name_item">'.$product['name'].'</h3></a>
                <ul>
                  <li>Артикул : '. $product['model'].'</li>
                  <li>Количество: '.$product['quantity'].' шт.</li>
                  <li>Цена: '.$price.'</li>
                </ul>
              </div>
            </div>
          </li> ';
                 }


          $r.='</ul>';
	                   return $r;

        }else{
            return 'Ваша корзина пустая';
        }

               }


    private  function generate_modal_total_info($totals){





        if (count($this->cart->getProducts())>0){
            $count=0;
            foreach ( $this->cart->getProducts() as $product) {
                $count+= $product['quantity'];
            }


           $r='        <div class="cart_calculate">
          <p class="count_in_cart">Корзина: '.$count.'шт.</p>';

            foreach ($totals as $total) {
                $r.='<p class="count_in_cart">'.$total['title'].'  '.$this->currency->format($total['value'], $this->session->data['currency']).'</p>';
            }

         $r.='
          <section>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad animi aperiam consequuntur doloribus ex fugiat iusto libero nemo perspiciatis quasi quidem quo rem reprehenderit, repudiandae rerum sapiente sequi totam?
          </section>
          <div class="cart_button_area">
            <a href="#" class="btn btn-primary btn-lg"  onclick="Custombox.modal.close(); return false;"        >ПРОДОЛЖИТЬ ПОКУПКУ</a>
            <a href="/cart" class="btn btn-primary btn-lg sale">ЗАКАЗ</a>
            <a href="#" class="btn btn-primary btn-lg sale"  onclick="qiuck_buy_page(); event.preventDefault();  return false;"    > БЫСТРЫЙ ЗАКАЗ</a>
          </div>
        </div>';

            return $r;

        }else{
            return '';
        }

    }

    private  function generate_modal_total_info_quick($totals){





        if (count($this->cart->getProducts())>0){
            $count=0;
            foreach ( $this->cart->getProducts() as $product) {
                $count+= $product['quantity'];
            }

            $product_ist='';
            foreach ( $this->cart->getProducts() as $product) {
                $product_ist.=$product['product_id'].':'.$product['quantity'].';';
            }


            $r='        <div class="cart_calculate">
          <p class="count_in_cart">Корзина: '.$count.'шт.</p>';

            foreach ($totals as $total) {
                $r.='<p class="count_in_cart">'.$total['title'].'  '.$this->currency->format($total['value'], $this->session->data['currency']).'</p>';
            }

            $r.='
          <section>
               <form id="quick_form_buy" onsubmit="return occmAjaxPostAdd_quick();" >
                                        <div class="fields-group">
                                        <label for="firstname-ch"><span class="required">*</span>   ФИО :</label><br>
                                        <input required  type="text" id="firstname-ch" name="occ_customer[firstname]"   class="form-control large-field required">
                                        <span class="error"></span>
                                        </div>
                                                                                
                                        <div class="fields-group">
                                        <label for="telephone-ch"><span class="required">*</span>   Телефон:</label><br>
                                        <input required  type="text" id="telephone-ch" name="occ_customer[telephone]"   class="form-control large-field required" maxlength="18" >
                                        <span class="error"></span>

                                        </div>
                         
                                        <div class="fields-group">
                                        <label for="email-ch">   E-Mail:</label><br>
                                        <input type="text" id="email-ch" name="occ_customer[email]" value="" class="form-control large-field">
                                        <span class="error"></span>

                                        </div>
                                        
                                        
                                             <div class="fields-group">
                              
                                        <input type="text" id="product_list" name="occ_customer[product_ist]" value="'.$product_ist.'" class="form-control large-field hidden">
                                        <span class="error"></span>

                                        </div> 
          <div class="cart_button_area">
            <a  href="#" class="btn btn-primary btn-lg hidden"  onclick=" Custombox.modal.close(); return false;"        >ПРОДОЛЖИТЬ ПОКУПКУ</a>
            <input type="submit"  class="btn btn-primary btn-lg sale" value="ЗАКАЗ">
          </div>
              </form>
                  </section>
        </div>';

            return $r;

        }else{
            return '';
        }

    }



}
