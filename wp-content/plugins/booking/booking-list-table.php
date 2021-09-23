<?php

class BookingListTable extends WP_List_Table {

    function get_data()
	{
		global $wpdb;
		$table_name = $wpdb->prefix . 'posts';
		$results    = $wpdb->get_results("SELECT p.id,p.post_title,pm.meta_value,pm.meta_key 
											FROM wp_postmeta AS pm 
											LEFT JOIN $table_name AS p 
											ON p.id = pm.post_id 
											WHERE p.post_type = 'booking' 
											AND pm.meta_key = 'dateBooking';", ARRAY_A);
		return $results;
	}

    function get_columns() 
	{
		return array(
			'id' 			=> 'id',
			'first_name' 	=> 'Prénom',
			'last_name' 	=> 'Nom de famille',
			'email'			=> 'Email',
			'booking_id' 	=> 'ID Reservation'
		);
	}
    

    function get_sortable_columns() 
	{
		return array(
			'id' => array('id', false),
		);
	}

    function column_default($item, $column_name) 
	{
		switch($column_name) {
			case 'id':
			case 'first_name':
			case 'last_name':
			case 'email':
			case 'booking_id':
				return $item[$column_name];
			default:
				return print_r($item, true);
		}
	}

    function usort_reorder($a, $b) 
	{
		$orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'id';
		$order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
		$result = strcmp($a[$orderby], $b[$orderby]);
		return ($order === 'asc') ? $result : -$result;
	}

    function prepare_items() 
	{
        $data = $this->get_data();
        $columns    = $this->get_columns();
        $hidden     = array();
        $sortable   = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        usort($data, array($this,'usort_reorder'));
        $this->items = $data;
    }
}