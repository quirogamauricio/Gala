<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	
	if (!function_exists('transform_date')) 
	{
		function transform_date($date, $new_separator = '/', $intial_separator = '-') 
		{
			return implode($new_separator, array_reverse(explode($intial_separator, substr($date, 0, 10))));
		}
	}

	

