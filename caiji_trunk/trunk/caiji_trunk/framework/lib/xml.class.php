<?php 
class xml { 
	var $parser; 
	var $i =0; 
	var $search_result = array(); 
	var $row = array(); 
	var $data = array(); 
	var $now_tag; 
	var $tags = array("ID", "CLASSID", "SUBCLASSID", "CLASSNAME", "TITLE", "SHORTTITLE", "AUTHOR", "PRODUCER", "SUMMARY", "CONTENT", "DATE"); 
	function xml() {
		$this->parser = xml_parser_create(); 
		xml_set_object($this->parser, $this); 
		xml_set_element_handler($this->parser, "tag_open", "tag_close"); 
		xml_set_character_data_handler($this->parser, "cdata"); 
	} 

	function parse($data) { 
		xml_parse($this->parser, $data); 
	} 

	function tag_open($parser, $tag, $attributes) { 
		$this->now_tag=$tag; 
		if($tag=='RESULT') { 
			$this->search_result = $attributes; 
		} 
		if($tag=='ROW') { 
			$this->row[$this->i] = $attributes; 
		} 
	} 

	function cdata($parser, $cdata) { 
		if(in_array($this->now_tag, $this->tags)){ 
			$tagname = strtolower($this->now_tag); 
			$this->data[$this->i][$tagname] = $cdata; 
		} 
	} 

	function tag_close($parser, $tag) { 
		$this->now_tag=""; 
		if($tag=='ROW') { 
			$this->i++; 
		} 
	} 
} 
?>