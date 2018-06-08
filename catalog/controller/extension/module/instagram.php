<?php

class ControllerExtensionModuleInstagram extends Controller {
    public function index() {
        $this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
        $this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');

        $this->load->language('extension/module/instagram');
        $data['text_load'] = $this->language->get('text_load');
        $data['text_go'] = $this->language->get('text_go');

        $data['is_error'] = false;
        $title = $this->config->get('instagram_module_name');
        if(isset($title) && $title != ""){
            $data['title'] = $title;
        }else{
            $data['title'] = "";
        }

        $limit = 0;
        $limit = $this->config->get('instagram_limit');
        $data['limit'] = $limit;

        $user_id = $this->config->get('instagram_user_id');
        $data["images"] = $this->get_instagram_images($user_id, $limit);

        return $this->load->view('extension/module/instagram', $data);
    }

    private function get_instagram_images( $user_id, $limit = 100 ){
        
        $profile_url = "https://instagram.com/graphql/query/?query_id=17888483320059182&id=".$user_id."&first=".$limit;
        //$profile_url = "https://instagram.com/graphql/query/?query_id=7450360943.54da896.c5a548573e5740d5af9cd028607db8d3&id=".$user_id."&first=".$limit;
        //$profile_url = "https://www.instagram.com/graphql/query/?query_hash=42323d64886122307be10013ad2dcc44&variables=%7B%22id%22%3A%225895545289%22%2C%22first%22%3A12%2C%22after%22%3A%22AQCDTSXQL_cwn0bmGAVbQBU7FdsKrRKOI3CFN9cRwKpydsY2B6AaE2CfrGkAJl6WWQHwREatrsU1i974mkC_FoF96QPjsQG6IArcHXN6X5o_Qg%22%7D";
        $iteration_url = $profile_url;
        $tryNext = true;
        $found = 0;
        $images = array();
        while ($tryNext) {
            $tryNext = false;


            $response = file_get_contents($iteration_url);
//            $context = stream_context_create(
//                array(
//                    "http" => array(
//                        "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
//                    )
//                )
//            );

          //  $response= file_get_contents($iteration_url, false, $context);


            if ($response === false) {
                break;
            }
            $data = json_decode($response, true);
            if ($data === null) {
                break;
            }

            $media = $data['data']['user']['edge_owner_to_timeline_media']['edges'];

            foreach ( $media as $index => $node ) {
                if ( $found + $index < $limit ) {
                    $image = array(
                        'thumbnail' => $node['node']['thumbnail_src'],
                        'original' => $node['node']['display_url'],
                    );
                    array_push($images, $image);
                }
       
            }
            
            $found += count($media);

            if ( $data['data']['user']['edge_owner_to_timeline_media']['page_info']['has_next_page'] && $found < $limit ) {
                $end = $data['data']['user']['edge_owner_to_timeline_media']['page_info']['end_cursor'];
                $iteration_url = $profile_url."&after=".$end;
                $tryNext = true;
            }
        }
        return $images;
    }


    public function loadmore() {
        $this->load->language('extension/module/instagram');
        $text_end = $this->language->get('text_end');

        $limit = 0;
        $from = (int)$_GET['from'];
        $limit = $from + $this->config->get('instagram_limit');
        
        $user_id = $this->config->get('instagram_user_id');
        $images = $this->get_instagram_images($user_id, $limit);
        
        $html = '';
            foreach ($images as $image){
                $html .= '<div class="col-sm-3">';
                $html .= '<a href="'.$image['original'].'" class="ista-popup">';
                $html .= '<img src="'.$image['thumbnail'].'" class="insta-img" />';
                $html .= '</a>';
                $html .= '</div>';
            }
        $html .= '<div class="clearfix"></div>';
        $html .= '
        <script type="text/javascript">
        $(document).ready(function() {
            $("#instagram").magnificPopup({
                type:"image",
                delegate: "a.ista-popup",
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1]
                },
            });
        });
        </script>';
        $this->response->setOutput($html);
    }
}