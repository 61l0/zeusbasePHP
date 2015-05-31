<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Home extends CI_Controller {
	public function index() { // example1
		$this->load->add_package_path ( APPPATH . 'third_party/codeignitercrud/' );
		$this->load->library ( 'CodeigniterCrud' );
		
		$this->codeignitercrud->table ( 'categories' );
		$this->codeignitercrud->tableAlias ( 'Category Manager	' );
		
		$this->codeignitercrud->addNoCol ( true );
		
		$this->codeignitercrud->cols ( 'category_name' );
		
		$this->codeignitercrud->alias ( 'category_name', 'Name' );
		$this->codeignitercrud->alias ( 'category_description', 'Description' );
		
		$this->codeignitercrud->type ( 'category_description', 'editor' );
		
		$this->codeignitercrud->validate ( 'category_name', 'required' );
		
		$this->codeignitercrud->search ( 'all' );
		
		$html = $this->codeignitercrud->fetch ();
		
		$this->load->view ( 'example1', array (
				'html' => $html 
		) );
	}
	public function example2() {
		$this->load->add_package_path ( APPPATH . 'third_party/codeignitercrud/' );
		$this->load->library ( 'CodeigniterCrud' );
		
		$this->codeignitercrud->table ( 'articles' );
		$this->codeignitercrud->tableAlias ( 'Articles manager' );
		
		$this->codeignitercrud->autoType ( true );
		$this->codeignitercrud->addNoCol ( true );
		
		$this->codeignitercrud->alias ( 'id', 'Id' )->alias ( 'category_id', 'Category' )->alias ( 'article_title', 'Title' )->alias ( 'article_date', 'date	' )->alias ( 'image', 'Image' )->alias ( 'article_summary', 'Summary' )->alias ( 'article_content', 'Content' );
		
		$this->codeignitercrud->search ( 'all' );
		$this->codeignitercrud->cols ( array (
				'image',
				'article_title',
				'article_date',
				'article_summary' 
		) );
		
		$this->codeignitercrud->colWith ( 'image', 150 );
		$this->codeignitercrud->colWith ( 'article_title', 200 );
		$this->codeignitercrud->colWith ( 'category_id', 80 );
		$this->codeignitercrud->colWith ( 'article_date', 80 );
		
		$this->codeignitercrud->colAlign ( 'image', 'center' );
		$this->codeignitercrud->colAlign ( 'category_id', 'center' );
		$this->codeignitercrud->colAlign ( 'article_date', 'center' );
		
		$this->codeignitercrud->type ( 'article_title', 'text', array (
				'class' => 'span6' 
		) );
		$this->codeignitercrud->type ( 'image', 'image', FCPATH . 'media/images', 'large', 500, 700 );
		$this->codeignitercrud->type ( 'article_summary', 'editor' );
		$this->codeignitercrud->type ( 'article_content', 'editor', array (
				'height' => '400' 
		) );
		
		$options = getCategories ( $this );
		$this->codeignitercrud->type ( 'category_id', 'selectbox', $options );
		
		$this->codeignitercrud->validate ( 'article_title', 'required' );
		
		$html = $this->codeignitercrud->fetch ();
		
		$this->load->view ( 'example2', array (
				'html' => $html 
		) );
	}
	public function example3() {
		$this->load->add_package_path ( APPPATH . 'third_party/codeignitercrud/' );
		$this->load->library ( 'CodeigniterCrud' );
		
		$this->codeignitercrud->table ( 'articles' );
		$this->codeignitercrud->tableAlias ( 'Articles manager' );
		
		$this->codeignitercrud->theme ( 'bootstrap01' );
		
		$this->codeignitercrud->autoType ( true );
		$this->codeignitercrud->addNoCol ( true );
		
		$this->codeignitercrud->alias ( 'id', 'Id' )->alias ( 'category_id', 'Category' )->alias ( 'article_title', 'Title' )->alias ( 'article_date', 'date	' )->alias ( 'image', 'Image' )->alias ( 'article_summary', 'Summary' )->alias ( 'article_content', 'Content' );
		
		$this->codeignitercrud->search ( 'all' );
		$this->codeignitercrud->cols ( array (
				'article_title',
				'category_id',
				'article_date',
				'article_summary' 
		) );
		
		$this->codeignitercrud->colWith ( 'article_title', 200 );
		$this->codeignitercrud->colWith ( 'category_id', 80 );
		$this->codeignitercrud->colWith ( 'article_date', 80 );
		
		$this->codeignitercrud->colAlign ( 'category_id', 'center' );
		$this->codeignitercrud->colAlign ( 'article_date', 'center' );
		
		$this->codeignitercrud->type ( 'article_title', 'text', array (
				'class' => 'span6' 
		) );
		$this->codeignitercrud->type ( 'image', 'image', FCPATH . 'media/images', 'large', 500, 700 );
		$this->codeignitercrud->type ( 'article_summary', 'editor' );
		$this->codeignitercrud->type ( 'article_content', 'editor', array (
				'height' => '400' 
		) );
		
		$options = getCategories ( $this );
		$this->codeignitercrud->type ( 'category_id', 'selectbox', $options );
		
		$this->codeignitercrud->validate ( 'article_title', 'required' );
		
		$this->codeignitercrud->order ( 'article_title', 'acs' );
		
		$html = $this->codeignitercrud->fetch ();
		
		$this->load->view ( 'example3', array (
				'html' => $html 
		) );
	}
}
function getCategories(&$CI) {
	$query = $CI->db->query ( 'select id,category_name from categories' );
	$categories = $query->result_array ();
	$options = array ();
	$options [''] = '';
	foreach ( $categories as $v ) {
		$options [$v ['id']] = $v ['category_name'];
	}
	
	return $options;
}