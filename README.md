# ACF To Post
### https://thefancyrobot.com

ACF to Post was started as a way to get ACF fields into the post object, but is becoming so much more than that.
  - ACF fields automatically added to post object. Simply use `$post->fields` to access all of your ACF fields data.
  - Create ACF fields in a modular/reuseable way using code. No need for the cumbersome ACF GUI.
  - Automatically sanitize your ACF fields without littering your template files with sanitization functions (NOTE: this feature is still in development)

## Getting Started
#### ACF to Post is currently in alpha. There is no guarantee that it will work. DO NOT USE IN PRODUCTION.
ACF to Post is a WordPress plugin. Just add the `/acf-to-post/` directory to your `/wp-content/plugins/` directory and activate the plugin in the WordPress admin.

## Bread and Butter
The main feature of the plugin is adding ACF fields to the post object. To make this work all you have to do is install and activate the plugin, then you can access all of your fields with `$post->fields`.

### Sanitation
At this time only text and URL field types are sanitized. More fields and customibility of this feature are at the top of the list of features to finish developing.

### Reuseable fields
A big part of this plugin is that you can create ACF groups, and flexible content layouts that are completely reuseable accross multiple projects. There are three base classes available to make this easy.

#### Groups
To create a group, just extend the \TFR\ACFToPost\Base\Group class. 

Example:
```
<?php

use TFR\ACFToPost\Base\Group;
use TFR\ACFToPost\Util\FieldGenerator;

class Page extends Group {

	public function __construct() {
		parent::__construct();

		// Set the group parameters
		$this->setTitle( __( 'Page Group', 'tfr' ) );
		$this->setPostTypes( ['page', 'post'] );
	}

	public function setFields() {
		$fields = new FieldGenerator( $this->getKey() );

		$this->fields = [
			$fields->add( 'text', [
				'name'  => 'text',
				'label' => __( 'Page Group Text', 'tfr' ),
			] ),
		];
	}
}
```

There are methods to set all of the parameters for each group. Those parameters are:
 - `key` - the key is dynamically set as the class name, but can be manually set by using the `setKey()` method.
 - `title` - the title can be set with the `setTitle()` method.
 - `fields` - the `setFields()` method is called when the group is created. In this method give `$this->fields` a value of an ACF fields array.
 - `location` - location is where the group should be displayed. This is defined with two methods: `setPostTypes()` and `setTemplates()`.
 - `hide_on_screen` - set hidden elements with the `setHiddenElements()` method;
 
