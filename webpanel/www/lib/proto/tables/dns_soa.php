<?php
class dns_soa extends Proto {
	// What table is our class going to use? This can be left empty.
	public $table = 'dns_soa';
	
	// We need to know some things about the table we're using...
	public $primary_key = 'id'; // required for save() to work
	
	// This is used when join statements are needed
	public $join_fragment = '';

}
