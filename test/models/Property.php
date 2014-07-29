<?php
class Property extends ActiveRecord\Model
{
	static $table_name = 'property';
	static $primary_key = 'property_id';

	static $has_many = array(
		'property_amenities',
    array('amenities', 'through' => 'property_amenities'),
    array('property_amenities_2', 'class_name' => 'PropertyAmenity'),
    array('amenities_2', 'class_name' => 'Amenity', 'through' => 'property_amenities_2'),
	);
};
?>
