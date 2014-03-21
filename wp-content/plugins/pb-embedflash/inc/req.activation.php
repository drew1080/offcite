<?php 
	global $wpdb;
	$dbversion = get_option('pb_embedFlash_dbversion');
	if (empty($dbversion)) { $dbversion = '0'; }
	// add charset & collate like wp core
	$charset_collate = null;
	if (version_compare(mysql_get_server_info(),'4.1.0','>='))
	{
		if (!empty($wpdb->charset)) { $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset"; }
		if (!empty($wpdb->collate)) { $charset_collate .= " COLLATE $wpdb->collate"; }
	}

   	$pbefmm_media 		= $wpdb->prefix.'pbefmm_media';
	$pbefmm_playlists 	= $wpdb->prefix.'pbefmm_playlists';
# < installation
	if ($wpdb->get_var("SHOW TABLES LIKE '$pbefmm_media'") != $pbefmm_media)
	{
		$wpdb->query("CREATE TABLE `$pbefmm_media` (
		`id` BIGINT(20) NOT NULL,
		`url` MEDIUMTEXT NOT NULL,
		`title` VARCHAR(255) NULL,
		`image` MEDIUMTEXT NULL,
		`author` VARCHAR(255) NULL,
		`link` MEDIUMTEXT NULL,
		`type` VARCHAR(4) NULL,
		`captions` MEDIUMTEXT NULL,
		`audio` MEDIUMTEXT NULL,
		`album` VARCHAR(255) NULL,
		`attributes` MEDIUMTEXT NULL,
		PRIMARY KEY `id` (id)
		) $charset_collate;");
		$dbversion = PBEF_DBVERSION;
	}
	if ($wpdb->get_var("SHOW TABLES LIKE '$pbefmm_playlists'") != $pbefmm_playlists)
	{
		$wpdb->query("CREATE TABLE `$pbefmm_playlists` (
		`id` BIGINT(20) NOT NULL,
		`title` VARCHAR(255) NULL,
		`attributes` MEDIUMTEXT NULL,
		`ids` MEDIUMTEXT NULL,
		PRIMARY KEY `id` (id)
		) $charset_collate;");
		$dbversion = PBEF_DBVERSION;
	}
# installation >
# < updates
	if (version_compare($dbversion,'1.0','<') && strlen($wpdb->query("DESCRIBE `$pbefmm_media` `attributes`") == 0))
	{
		$wpdb->query("ALTER TABLE `$pbefmm_media` ADD `attributes` MEDIUMTEXT NULL AFTER `album`;");
		$dbversion = '1.0';
	}
# updates >
	update_option('pb_embedFlash_dbversion',$dbversion);

	if (is_array(get_option('pb_embedFlash')))
	{
		$pbef_options = pbef_options();
		$oldmmoptions = get_option('pb_embedFlash_mediamanager');
		if (is_array($oldmmoptions))
		{
			$sql = "INSERT INTO `$pbefmm_media` (`id`,`url`,`title`,`image`,`author`,`link`,`type`,`captions`,`audio`,`album`) VALUES ";
			foreach ($oldmmoptions['media'] as $id => $m)
			{
				$sql .= "('$id','".$m['url']."','".$m['title']."','".$m['image']."','".$m['author']."','".$m['link']."','".$m['type']."','".$m['captions']."','".$m['audio']."','".$m['album']."'),";
			}
			$wpdb->query(substr($sql,0,-1).';');
			
			$sql = "INSERT INTO `$pbefmm_playlists` (`id`,`title`,`attributes`,`ids`) VALUES ";
			foreach ($oldmmoptions['playlists'] as $id => $p)
			{
				$sql .= "('$id','".$p['title']."','".$p['attributes']."','".serialize($p['ids'])."'),";
			}
			$wpdb->query(substr($sql,0,-1).';');
			$pbef_options['mm']['count_media'] = $oldmmoptions['count']['media'];
			$pbef_options['mm']['count_playlists'] = $oldmmoptions['count']['playlists'];
			delete_option('pb_embedFlash_mediamanager');
		}
		update_option('pb_embedFlash',$pbef_options);
	} else {
		require(PBEF_PATH.'/inc/inc.options.php');
		add_option('pb_embedFlash',$options,'','yes');
	}
?>