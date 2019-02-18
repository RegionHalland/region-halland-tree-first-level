<?php

	/**
	 * @package Region Halland Tree First Level
	 */
	/*
	Plugin Name: Region Halland Tree First Level
	Description: Front-end-plugin som returnerar första nivån i en sid-taxonomi
	Version: 1.0.1
	Author: Roland Hydén
	License: MIT
	Text Domain: regionhalland
	*/

	// Returnera en array med page-info
	function get_region_halland_tree_first_level($sortOrder = 'menu_order') {
		
		// Aktuell post
		global $post;

		// Variabel med ID för aktuell post
		if ($post) {
			$top_page = $post->ID;
		} else {
			$top_page = 0;
		}
		
		// Hämta alla sidor från första nivån i en sid-taxonomi
		$pages = get_pages(array(
			'parent' => 0,
			'sort_column' => $sortOrder, 
			'sort_order' => 'ASC'
		));

		// Variabel med ID för första-sidan
		$frontpage = (int)get_option('page_on_front');

		// Loopa ut alla sidor exklusive första-sidan
		foreach ($pages as $i => $page) {
			
			// Exkludera första-sidan
			if ($page->ID === $frontpage) {
				unset($pages[$i]);
				continue;
			}
			
			// Sätt en flagga om loopad sida är nuvarande sida
			if (isset($top_page) && $top_page === $page->ID) {
				$page->active = true;
			}

			// Sätt url
			$page->url = get_page_link($page->ID);
		
		}

		// Return alla sidor
		return $pages;
	}

	// Metod som anropas när pluginen aktiveras
	function region_halland_tree_first_level_activate() {
		// Ingenting just nu...
	}

	// Metod som anropas när pluginen av-aktiveras
	function region_halland_tree_first_level_deactivate() {
		// Ingenting just nu...
	}
	
	// Aktivera pluginen och anropa metod
	register_activation_hook( __FILE__, 'region_halland_tree_first_level_activate');

	// Av-aktivera pluginen och anropa metod
	register_deactivation_hook( __FILE__, 'region_halland_tree_first_level_deactivate');
	
?>