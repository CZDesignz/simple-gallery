<?php

class conf{
	
	private $dir;
	private $pglim;
	private $links;
	private $width;
	private $height;
	private $top;
	private $bottom;
	private $table;
	private $cols;
	private $rows;
	private $title;
	private $deftitle;
	private $defdir;
	private $defpglim;
	private $deflinks;
	private $defwidth;
	private $defheight;
	private $deftop;
	private $defbottom;
	private $deftable;
	private $defcols;
	private $defrows;
	
	public function defset($var, $value){

		$this->$var = $value;
		$this->def.$var = $value;
		
	}
	
	public function reset($var){

		$this->$var = $this->def.$var;
		
	}
	
	public function set($var, $value){

		$this->$var = $value;
		
	}
	
	public function conf(){
		
		global $_SESSION;
		
		if(!empty($_SESSION)){
			
			$this->dir = $_SESSION['dir'];
			$this->pglim = $_SESSION['pglim'];
			$this->links = $_SESSION['links'];
			$this->width = $_SESSION['width'];
			$this->height = $_SESSION['height'];
			$this->top = $_SESSION['top'];
			$this->bottom = $_SESSION['bottom'];
			$this->table = $_SESSION['table'];
			$this->cols = $_SESSION['cols'];
			$this->rows = $_SESSION['rows'];
			$this->title = $_SESSION['title'];
			$this->defdir = $_SESSION['defdir'];
			$this->defpglim = $_SESSION['defpglim'];
			$this->deflinks = $_SESSION['deflinks'];
			$this->defwidth = $_SESSION['defwidth'];
			$this->defheight = $_SESSION['defheight'];
			$this->deftop = $_SESSION['deftop'];
			$this->defbottom = $_SESSION['defbottom'];
			$this->deftable = $_SESSION['deftable'];
			$this->defcols = $_SESSION['defcols'];
			$this->defrows = $_SESSION['defrows'];
			$this->deftitle = $_SESSION['deftitle'];
			
		}
	
	}
	
	public function out($var){
	
		return $this->$var;
		
	}
	
}

?>