<?php 
	
	/**
	 * This file necessary for organizing 
	 * routes on the websait
	 * 
	 * 
	 * 
	 */
	return [

		'' => 

			[
				'controller' => 'main',
				'action' => 'index'
			],
		'search' =>
			[
				'controller' => 'main',
				'action' => 'search'
			],
		'news' => 

			[
				'controller' => 'news',
				'action' => 'show'
			],
		'preview' =>
			[
				'controller' => 'main',
				'action' => 'preview'
			],
		'profile' =>
			[
				'controller' => 'main',
				'action' => 'profile'
			],
		'forums' =>
			[
				'controller' => 'forums',
				'action' => 'show'
			],
		'auth' =>
			[

				'controller' => 'main',
				'action' => 'authentication'
			],
		'shop' =>
			[

				'controller' => 'shop',
				'action' => 'show'
			],
		'basket' =>
			[

				'controller' => 'shop',
				'action' => 'basket'
			],
		'journal' =>
			[

				'controller' => 'news',
				'action' => 'newsMaker'
			],
		'subscription' =>
			[

				'controller' => 'main',
				'action' => 'subscribe'
			],
		'storeroom' =>
			[

				'controller' => 'shop',
				'action' => 'shopMaker'
			],
		'admin' =>
			[

				'controller' => 'main',
				'action' => 'manage'
			],
		'download' =>
			[
				'controller' => 'main',
				'action' => 'download'
			]
	];

?>