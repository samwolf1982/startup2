<?php

class ModelModuleDroppanel extends Model {
	
	//Sample DB access - Get all customers
	function getCustomerData() {
		$query = "SELECT * FROM " . DB_PREFIX . "customer";
		$result = $this->db->query($query);
		return $result->rows;
	}
	
}

?>