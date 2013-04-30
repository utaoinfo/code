<?php
/**
 * @copyright Copyright(c) 2011 jooyea.net
 * @file site.php
 * @brief
 * @author webning
 * @date 2011-03-22
 * @version 0.6
 * @note
 */
/**
 * @brief Site
 * @class Site
 * @note
 */
class Frontend extends IController
{
    public $layout='frontend';
    private $tablePre = '';
	function init(){
		$this->tablePre = isset(IWeb::$app->config['DB']['tablePre']) ? IWeb::$app->config['DB']['tablePre'] : '';
		// 获取导航配置
		$guideObj       = new IModel('guide');
		$guide_list = $guideObj->query('','`order`,`name`,`link`','`order`','desc');
		if(count($guide_list)>0){
			$this->guide_list = $guide_list;
		}

	}

	public function index(){
		$data = array();
		$siteConfigObj = new Config("site_config");
		$site_config   = $siteConfigObj->getInfo();
		$this->site_config = $site_config;

		$index_slide = isset($site_config['index_slide'])? unserialize($site_config['index_slide']) :array();




		// 获取各个类型商品前4
		// 获取二级类
		$categoryObj = new IModel('category');

		// 获取前四个分类
		$sql  = "SELECT id,name FROM {$this->tablePre}category WHERE parent_id IN (SELECT id FROM {$this->tablePre}category WHERE parent_id=0 ) ORDER BY sort ASC LIMIT 4 ";
		$categories =  $categoryObj->query_sql($sql);
		$goods_list = array();
		if(count($categories)>0){
			foreach($categories as $key=>$value){
				$cid = $value['id'];
				$sql = "SELECT DISTINCT({$this->tablePre}goods.id),{$this->tablePre}goods.name,{$this->tablePre}goods.notes,{$this->tablePre}goods.sell_price,{$this->tablePre}goods.market_price,{$this->tablePre}goods.from,{$this->tablePre}goods.list_img,{$this->tablePre}goods.url 
				FROM {$this->tablePre}goods
				LEFT JOIN {$this->tablePre}category_extend ON {$this->tablePre}goods.id = {$this->tablePre}category_extend.goods_id
				WHERE {$this->tablePre}category_extend.category_id = {$cid} AND  {$this->tablePre}goods.is_del=0
				ORDER BY {$this->tablePre}goods.sort ASC
				LIMIT 4";
				$goods =  $categoryObj->query_sql($sql);
				if(count($goods)>0){
					$goods_list[$value['id']] = $goods;
					$goods_list[$value['id']]['cname'] = $value['name'];
				}
			}
		}
	
		$data['title'] = isset($site_config['index_seo_title'])? $site_config['index_seo_title']:'';
		$data['description'] = isset($site_config['index_seo_description'])? $site_config['index_seo_description']:'';
		$data['keywords'] = isset($site_config['index_seo_keywords'])? $site_config['index_seo_keywords']:'';
		$data['slide'] = $index_slide;
		//$data['guide_list'] = $guide_list;
		$data['goods_list'] = $goods_list;

		$this->setRenderData($data);
		$this->redirect('index');
	}

	/**
	*	列表展示
	*	@author keenhome@126.com
	*	@date 2013-4-30
	*/
	public function glist(){
		$data = array();
		$goods_list = array();
		$cid = IFilter::act(IReq::get('cid'),'int');
		//echo $cid;exit();
		$page = IFilter::act(IReq::get('page'),'int');
		$pagesize = 9;
		$start = $page*$pagesize;
		$end = ($page+1)*$pagesize;
		if($cid){
			$categoryObj = new IModel('category');
			$sql = "SELECT DISTINCT({$this->tablePre}goods.id),{$this->tablePre}goods.*,{$this->tablePre}category.name as cname FROM {$this->tablePre}goods
					LEFT JOIN {$this->tablePre}category_extend ON {$this->tablePre}category_extend.goods_id={$this->tablePre}goods.id
					LEFT JOIN {$this->tablePre}category ON {$this->tablePre}category.id={$this->tablePre}category_extend.category_id
					WHERE {$this->tablePre}category.id={$cid} AND  {$this->tablePre}goods.is_del=0
					ORDER BY {$this->tablePre}goods.sort ASC
					LIMIT $start,$end ";
			$goods_list =  $categoryObj->query_sql($sql);
		}
			

		$data['goods_list'] = $goods_list;
		$data['cid'] = $cid;
		$data['cname'] = count($goods_list)>0?$goods_list[0]['cname'] : '';
		$data['page'] = $page;
		
		$this->setRenderData($data);
		$this->redirect('glist');
	}

}
