<?php
	/*
	Plugin Name: Laan Links
	Plugin URI: http://www.laaneinfo.dk
	Description: Displays specific or random links below yours posts
	Author: Hans Laan
	Version: 1.0
	Author URI: http://www.laaneinfo.dk
	*/
	
	/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    */
	
	add_action('activate_laan_links.php', 'Install');
	
	// Install the plugin
	function Install() 
	{
	    global $wpdb;
	    
	    $structure = "CREATE TABLE 'laan_categories' (
  			'id' int(11) NOT NULL auto_increment,
			'categoryId' int(11) default NULL,
			'linkId' int(11) default NULL,
			PRIMARY KEY  ('id')
		)";

		$wpdb->query($structure);

		$structure = "CREATE TABLE 'laan_links' (
		  	'id' int(11) NOT NULL auto_increment,
			'linkId' int(11) default NULL,
			'text' varchar(255) default NULL,
		    'url' varchar(255) default NULL,
		    PRIMARY KEY  ('id')
		)";

		$wpdb->query($structure);

		$structure = "CREATE TABLE 'laan_posts' (
			'Id' int(11) NOT NULL auto_increment,
			'PostId' int(11) default NULL,
			'LinkId' int(11) default NULL,
			PRIMARY KEY  ('Id')
		)";
	    
		$wpdb->query($structure);
	}

	// Display links
	function ShowLinks($categoryID, $postID, $wpdb)
	{
	 	// Received postId? If yes, show specific links for that post
	 	if($postID != 0)
	 	{	 	 
		 	// Get the links
		 	$sql = "SELECT text, url FROM laan_posts, laan_links WHERE postId = $postID AND laan_posts.linkId = laan_links.linkId";
		}
		else // Received category id, use it to show random links specific for that category
		{
			// Get the links
		 	$sql = "SELECT text, url FROM laan_categories, laan_links WHERE categoryId = $categoryID AND laan_categories.linkId = laan_links.linkId";	
		}
		
		$links = $wpdb->get_results($sql);
	 	
	 	foreach ($links as $link) 
		{
			print("<a href='$link->url'>$link->text</a><br/>");
		}
	}
?>