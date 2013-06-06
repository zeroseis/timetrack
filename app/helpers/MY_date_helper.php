<?php

function display_date($format, $timestamp)
{
	if ( ! empty($timestamp))
	{
		return date($format, $timestamp);
	}
	return FALSE;
}

// end of file