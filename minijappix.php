<?php
/*
Plugin Name: Mini Jappix
Plugin URI: http://adresseContenantLesInfosSurVotrePlugin
Description: Courte description du plugin.
Version: 0.1
Author: Pavel Aurélien
Author URI: http://siteWebAuteur
*/

/*  Copyright 2011  Pavel Aurélien  (email : le.manchot@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action('wp_head', 'get_mini_jappix');
add_action('admin_menu', 'mini_jappix_menu');
add_action('admin_init', 'register_mysettings' );

function get_mini_jappix() {
	if(get_option('auto_login') == 1)
		$auto_login = "true";
	else
		$auto_login = "false";
	if(get_option('auto_show') == 1)
		$auto_show = "true";
	else
		$auto_show = "false";
	if(get_option('yet_jquery') != 1)
		$jquery = "&amp;f=jquery.js";
	$groups = explode(',', get_option('join_groupchats'));
	foreach ($groups as $value) {
		$group .= '"'.trim($value).'", '; 
	}
	$group = substr ($group, 0, -2);
	echo '<script type="text/javascript" src="https://static.jappix.com/php/get.php?l=en&amp;t=js&amp;g=mini.xml'.$jquery.'"></script>

<script type="text/javascript">
   jQuery(document).ready(function() {
      MINI_GROUPCHATS = ['.$group.'];
      launchMini('.$auto_login.', '.$auto_show.', "anonymous.jappix.com");
   });
</script>';

}

function mini_jappix_menu() {
  add_options_page('Mini Jappix Options', 'Mini Jappix', 'manage_options', 'my-unique-identifier', 'mini_jappix_options');
}

function register_mysettings() {
	//register our settings
	register_setting('mini_jappix', 'yet_jquery');
	register_setting('mini_jappix', 'language');
	register_setting('mini_jappix', 'auto_login');
	register_setting('mini_jappix', 'auto_show');
	register_setting('mini_jappix', 'join_groupchats');
}

function mini_jappix_options() {
  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }
 ?>
 <div class="wrap">
<h2>Your Plugin Name</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'mini_jappix' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Auto login to the account</th>
        <td><input type="checkbox" name="auto_login" value="1" <?php checked('1', get_option('auto_login')); ?> /></td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Auto show the opened chat</th>
        <td><input type="checkbox" name="auto_show" value="1" <?php checked('1', get_option('auto_show')); ?> /></td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Chat rooms to join (if any)</th>
        <td><input type="text" name="join_groupchats" value="<?php echo get_option('join_groupchats'); ?>" /></td>
        </tr>
		
		<tr valign="top">
        <th scope="row">jQuery is yet included</th>
        <td><input type="checkbox" name="yet_jquery" value="1" <?php checked('1', get_option('yet_jquery')); ?> /></td>
        </tr>
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } ?>