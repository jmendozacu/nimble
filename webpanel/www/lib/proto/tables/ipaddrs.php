<?php
class ipaddrs extends Proto {
	// What table is our class going to use? This can be left empty.
	public $table = 'nimble_ipaddr';
	
	// We need to know some things about the table we're using...
	public $primary_key = 'ip_id'; // required for save() to work
	
	// This is used when join statements are needed
	public $join_fragment = '';

}
