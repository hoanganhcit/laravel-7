<?php

namespace App\Components;

class Recusive {

	private $data;
	private $htmlSelect = '';

	public function __construct($data) {
		$this->data = $data;
	}

	public function CategoryRecusive($CategoryParent = 0, $id = 0, $text = '') {

		foreach($this->data as $value) {
			if($value['category_parent'] == $id) {
				if(!empty($CategoryParent) && $CategoryParent == $value['id']) {
					$this->htmlSelect.='<option selected value="'. $value['id'] .'">'. $text . $value['name'] .'</option>';
				} else {
					$this->htmlSelect.='<option value="'. $value['id'] .'">'. $text . $value['name'] .'</option>';
				}
				$this->CategoryRecusive($CategoryParent, $value['id'], $text. ' &nbsp;&nbsp;&nbsp; ');
			}
		}
		return $this->htmlSelect;
	}
}
