<?php
class vhosts extends Proto {
	// What table is our class going to use? This can be left empty.
	public $table = 'website_vhosts';
	
	// We need to know some things about the table we're using...
	public $primary_key = 'vhost_id'; // required for save() to work
	
	// This is used when join statements are needed
	public $join_fragment = '';

}
