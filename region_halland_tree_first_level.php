<?php

	/**
	 * @package Region Halland Tree First Level
	 */
	/*
	Plugin Name: Region Halland Tree First Level
	Description: Front-end-plugin som returnerar första nivån i en sid-taxonomi
	Version: 1.4.0
	Author: Roland Hydén
	License: GPL-3.0
	Text Domain: regionhalland
	*/

	// Returnera en array med page-info
	function get_region_halland_tree_first_level($sortOrder = 'menu_order') {
		
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		// Aktuell post
		global $post;

		// Variabel med ID för aktuell post
		if ($post) {
			$myPostID = $post->ID;
			$myPostParentID = $post->post_parent;
			if($myPostParentID == 0) {
				$_SESSION["tre_first_level_post_id"] = $myPostID;
			}
		} else {
			$myPostID = 0;
		}

		$totalActive = 0;

		// Hämta alla sidor från första nivån i en sid-taxonomi
		$pages = get_pages(array(
			'parent' => 0,
			'exclude' => get_option('page_on_front'),
			'sort_column' => $sortOrder, 
			'sort_order' => 'ASC'
		));

		// Loopa ut alla sidor exklusive första-sidan
		foreach ($pages as $page) {
			
			// För bakåtkompabilitet
			if ($page->ID == $_SESSION["tre_first_level_post_id"]) {
				$page->active = true;
			}

			// Använd endast detta när det är justerat på alla front-siter
			if ($page->ID == $_SESSION["tre_first_level_post_id"]) {
				$page->is_active = 1;
			} else {
				$page->is_active = 0;
			}

			$totalActive = $totalActive + $page->is_active;

			// Sätt url
			$page->url = get_page_link($page->ID);
		
		}

		if ($totalActive == 0) {
			$pages['0']->is_active = 1;
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