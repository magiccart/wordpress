<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-25 16:49:06
 * @@Modify Date: 2018-06-06 11:10:19
 * @@Function:
 */

namespace Magiccart\Shopbrand\Controller\Adminhtml;

use Magiccart\Core\Controller\Adminhtml\Action;
use Magiccart\Shopbrand\Block\Adminhtml\Brand\Grid;
use Magiccart\Shopbrand\Block\Adminhtml\Brand\Edit;
use Magiccart\Shopbrand\Model\Brand\Collection;

class Brand extends Action
{
    public $_brands;
    public $_collection;
    
    public function __construct()
    {
        $this->_initAction();
    }
    
    protected function _initAction(){
        add_action('admin_menu', array($this, 'subMenu'));
        if(!$this->is_action_page()) return;
        add_action('admin_enqueue_scripts', array($this, 'add_admin_web'));
        
        $this->_collection   = new Collection();
        $this->_brands = $this->_collection->getCollection();
    }
    
    public function subMenu(){
        add_submenu_page($this->parent_slug, __('Shop Brand', "alothemes"), __('Shop Brand', "alothemes"), 'manage_options',
                $this->get_menu_slug() , array($this, 'indexAction'));
    }
    
    public function indexAction(){

        if(isset($_GET['action']) && trim($_GET['action']) != '' && ($_GET['action'] == 'edit' || $_GET['action'] == 'add') ){
            $edit = new Edit();
            $data = $this->saveBrand();
            
            $edit->addData($data);
            
            echo $edit->toHtml();
        }else{
            if(isset($_GET['action']) && $_GET['action'] == 'delete'){
                $this->delete();
            }
            $brand = new Grid();
            echo $brand->toHtml();
        }
         
        if(isset($_GET['status'])) $this->editStatus();   
    }
    
    public function add_admin_web(){
        wp_register_script('shopbrand', $this->get_url('adminhtml/web/js/shopbrand.js') , '1.0');
        wp_enqueue_script('shopbrand');
        wp_localize_script( 'mpProduct', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

        wp_register_style('shopbrand', $this->get_url("adminhtml/web/css/shopbrand.css"), array(), '1.0');
        wp_enqueue_style('shopbrand');
    }
    
    /* Save data + Edit */
    public function saveBrand(){

    	$action 	= $_GET['action'];
        $brands     = $this->_brands;
        $data       = array();
    	$key		= "";
    	
    	if($action == 'edit'){
    		$key    = $_GET['key'];
    		$brand  = $brands[$key];
    		
    		$data['name'] 		= $brand['name'];
    		$data['url'] 		= $brand['url'];
    		$data['brand'] 	    = isset($brand['brand']) ? $brand['brand'] : '';
    		$data['img'] 		= $brand['img'];
    	}
    	if(isset($_POST['submit'])){
	        $name       = $_POST['name'];
            $url        = $_POST['url'];
            $brand  = $_POST['brand'];
            $img        = $_POST['img'];

	    	if(trim($name) != '' && trim($img)){

                if(!is_array($brands)){
                    $brands = array();
                }

	    		$identifier = sanitize_key($name); // sanitize_title($name);
                if($action == 'edit'){
                    $id = $key;
                }else {
                    $id = end(array_keys($brands)) + 1;
                }
                $brands[$id] = array(
                            'id'         => $id,
                            'name'       => $name,
                            'identifier' => $identifier,
                            'url'        => $url,
                            'brand'      => $brand,
                            'img'        => $img,
                            'status'     => 1,
                    );

                $this->_collection->save($brands);
                wp_redirect('?page=' . $_GET['page'] );
	    		
	    	}else{
	    		$error = __("Name and Image is require not empty !", 'alothemes');
	    		$data['error'] = "<div class='error'>{$error}</div>";
	    	}
    	}
    	
    	if(isset($data['error'])){
    		$data['name'] 		= $name;
    		$data['url'] 		= $url;
    		$data['brand'] 	    = $brand;
    		$data['img'] 		= $img;
    	}
    	return $data;
    }
    
    /* edit status */
    public function editStatus(){

    	$status = $_GET['status'];
    	$key    = $_GET['key'];
    	($status == 'unpublish' ) ? $status = 0 : $status = 1;
        $brands  = $this->_brands;
    	
    	if(isset($brands[$key])) $brands[$key]['status'] = $status;

        $this->_collection->save($brands);
        $paged      = isset($_GET['paged']) ? '&paged=' . $_GET['paged'] : '';
    	wp_redirect("?page=" . $_GET['page'] . $paged );
    }
    
    /* Delete */
    public function delete(){

    	$key    = $_GET['key'];
        $brands = $this->_brands;
    	if(isset($brands[$key])) unset($brands[$key]);
        $this->_collection->save($brands);
    	wp_redirect('?page=' . $_GET['page'] );
    }

}
