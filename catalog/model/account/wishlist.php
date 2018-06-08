<?php
class ModelAccountWishlist extends Model {

    /**
     * @param $product_id
     * @param string $user_id_key    отрицательное значение для анонимного пользователя
     */
    public function addWishlist($product_id, $user_id_key='') {
	    if (empty($user_id_key)){
            $this->db->query("DELETE FROM " . DB_PREFIX . "customer_wishlist WHERE customer_id = '" . (int)$this->customer->getId() . "' AND product_id = '" . (int)$product_id . "'");

            $this->db->query("INSERT INTO " . DB_PREFIX . "customer_wishlist SET customer_id = '" . (int)$this->customer->getId() . "', product_id = '" . (int)$product_id . "', date_added = NOW()");
        }else{
            $this->db->query("DELETE FROM " . DB_PREFIX . "customer_wishlist WHERE customer_id = '" . (int)$user_id_key . "' AND product_id = '" . (int)$product_id . "'");

            $this->db->query("INSERT INTO " . DB_PREFIX . "customer_wishlist SET customer_id = '" . (int)$user_id_key . "', product_id = '" . (int)$product_id . "', date_added = NOW()");
        }

	}

	public function deleteWishlist($product_id, $user_id_key='') {
        if (empty($user_id_key)) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "customer_wishlist WHERE customer_id = '" . (int)$this->customer->getId() . "' AND product_id = '" . (int)$product_id . "'");
        }else{
            $this->db->query("DELETE FROM " . DB_PREFIX . "customer_wishlist WHERE customer_id = '" . (int)$user_id_key . "' AND product_id = '" . (int)$product_id . "'");
        }
	}

	public function getWishlist($user_id_key='') {
        if (empty($user_id_key)) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_wishlist WHERE customer_id = '" . (int)$this->customer->getId() . "'");
        }else{
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_wishlist WHERE customer_id = '" . (int)$user_id_key . "'");
        }



		return $query->rows;
	}

	public function getTotalWishlist($user_id_key='') {
        if (empty($user_id_key)) {
            $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_wishlist WHERE customer_id = '" . (int)$this->customer->getId() . "'");
        }else{
            $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_wishlist WHERE customer_id = '" . (int)$user_id_key . "'");
        }

		return $query->row['total'];
	}
}
