<?php
class __template__ extends Proto {
	// What table is our class going to use? This can be left empty.
	public $table = '__database__';
	
	// We need to know some things about the table we're using...
	public $primary_key = '__primarykey__'; // required for save() to work
	
	// This is used when join statements are needed
	public $join_fragment = '';

}
