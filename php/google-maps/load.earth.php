<?php
	$extLibraryVersion = "ext-3.2.0";
	$uxLibraryVersion = "ux-3.2.0";
	
	$baseURLConfig = "http://cms.crownflooring/library/CodeIgniter/index.php";
	$propertyImages = "../../../media.library/";
	
	$sytemEmail 	= "support@tinlabapps.com";
	$systemOwner 	= "tinlab.earth";
	$systemName 	= "Google Earth by tinlab";
	$systemVersion 	= "1.0";
	$gmapsAPIkey 	= "ABQIAAAAhMg8B3oW9LFauXOPG2Gc_BRQrWnPlS7r3zEs01reqZ1-ic88IBQoTIkaLLMV0LdFx4puRx3x4v3GJQ";

?>
<html>
<head>
    <title><?php echo $systemOwner ?> : <?php echo $systemName ?> : <?php echo $systemVersion ?></title>
	<link rel="icon" href="../../../tinBase/images/icon/folder_black_lock.ico" type="image/x-icon" />       


	<!-- ------------------------------------------------------------------------- -->	
	<!-- CSS - INCLUDES -->
	<!-- ------------------------------------------------------------------------- -->
    
	<link rel="stylesheet" type="text/css" href="../../../library/<?php echo $extLibraryVersion ?>/resources/css/ext-all.css" />	
	<link rel="stylesheet" type="text/css" href="../../../library/ext-custom/css/xtheme-slickness.css" />
	
	 
    <!-- overrides to base library -->
    <link rel="stylesheet" type="text/css" href="../../../library/<?php echo $uxLibraryVersion ?>/css/Portal.css" />
    <link rel="stylesheet" type="text/css" href="../../../library/<?php echo $uxLibraryVersion ?>/css/GroupTab.css" />
    <link rel="stylesheet" type="text/css" href="../../../library/<?php echo $uxLibraryVersion ?>/fileuploadfield/css/fileuploadfield.css"/>	 
	 
	<link rel="stylesheet" type="text/css" href="../../../tinBase/css/Ext.ux.GEarthPanel-1.1.css" />

	<!-- ------------------------------------------------------------------------- -->	
	<!-- JS - INCLUDES -->
	<!-- ------------------------------------------------------------------------- -->
	
    <script type="text/javascript" src="../../../library/<?php echo $extLibraryVersion ?>/adapter/ext/ext-base-debug.js"></script>
    <script type="text/javascript" src="../../../library/<?php echo $extLibraryVersion ?>/ext-all-debug.js"></script>
	
	
	<!-- ------------------------------------------------------------------------- -->	
	<!-- DTO - GLOBALS -->
	<!-- ------------------------------------------------------------------------- -->
	<script type="text/javascript" src="../../../tinBase/js/dto/SystemConfig.js"></script>
   	<script type="text/javascript">
		
		// Determinie host name for MAP API key generation
		//alert(window.location.host);
   	
		Ext.onReady(function(){										
			Ext.SystemConfig.StoreURL 		= '<?php echo $baseURLConfig ?>';		
			Ext.SystemConfig.AccountEmail 	= '<?php echo $systemEmail ?>';
			Ext.SystemConfig.Owner			= '<?php echo $systemOwner ?>';
			Ext.SystemConfig.Name			= '<?php echo $systemName ?>';	
			Ext.SystemConfig.Version		= '<?php echo $systemVersion ?>';	
		});
	</script>

	<script type="text/javascript" src="../../../tinBase/js/utilities/Messages.js"></script>



	<!-- ------------------------------------------------------------------------- -->	
	<!-- extensions -->
	<!-- ------------------------------------------------------------------------- -->    


	<!-- ------------------------------------------------------------------------- -->	
	<!-- tinBase -->
	<!-- ------------------------------------------------------------------------- -->
	
    <!-- form --> 	
    <!-- search -->
    <!-- windows -->
    <!-- stores -->    	
	<!-- grids -->        
    <!-- layout -->    
    <script type="text/javascript" src="http://www.google.com/jsapi?key=<?php echo $gmapsAPIkey ?>"></script> 	
   	<script type="text/javascript" src="../../../tinBase/js/google/Ext.ux.GEarthPanel-1.1.js"></script>


    <!-- ------------------------------------------------------------------------- -->    
 	<!-- API for Direct Classes --> 
 	<!-- ------------------------------------------------------------------------- -->	
	<script type="text/javascript" src="../../../tinBase/php/api.php"></script>    	
	
    <!-- ------------------------------------------------------------------------- -->    
 	<!-- FUSION CHARTS --> 
 	<!-- ------------------------------------------------------------------------- -->	
	<script type="text/javascript" src="../../../library/Fusion-Charts/JSClass/FusionCharts.js"></script>


    <!-- ------------------------------------------------------------------------- -->    
 	<!-- ORIGINAL HEADER CODE --> 
 	<!-- ------------------------------------------------------------------------- -->	

	<!-- 
    <link rel="stylesheet" type="text/css" href="../lib/extjs/resources/css/ext-all.css" />
	<script type="text/javascript" src="../lib/extjs/adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="../lib/extjs/ext-all.js"></script>

	 
    <link rel="stylesheet" type="text/css" href="Ext.ux.GEarthPanel-1.1.css" />
    <script type="text/javascript" src="http://www.google.com/jsapi?key=<?//= $gmapsAPIkey ?>"></script> 	
  	<script type="text/javascript" src="Ext.ux.GEarthPanel-1.1.js"></script>
	 -->    
	 
	  
    <script type="text/javascript">

        google.load("earth", "1");
        google.load("maps", "2.xx");

        Ext.onReady(function(){

            // Create Google Earth panel
            var earthPanel = new Ext.ux.GEarthPanel({
                region: 'center',
                contentEl: 'eastPanel',
                margins: '5 5 5 0'
            });

            // Create control panel
            var controlPanel = new Ext.Panel({
                region: 'west',
                contentEl: 'westPanel',
                title: 'tinlab: Google Earth Controls ',
                width: 280,
                border: true,
                collapsible: true,
                margins: '5 5 5 5',
                layout: 'accordion',
                layoutConfig: {
                    animate: true
                },
                defaultType: 'panel',
                defaults: {
                    bodyStyle: 'padding: 10px'
                }
            });

            // Add panels to browser viewport
            var viewport = new Ext.Viewport({
                layout: 'border',
                items: [ controlPanel, earthPanel]
            });

            // Build control panel
            earthPanel.on('earthLoaded', function(){

                // Display KMLs
                //earthPanel.fetchKml('http://earthatlas.info/kml/statistics/infant_mortality_rate_2005_prism.kmz');

                // Add panels
                //controlPanel.add(earthPanel.getKmlPanel());
                controlPanel.add(earthPanel.getLocationPanel());
                controlPanel.add(earthPanel.getLayersPanel());
                controlPanel.add(earthPanel.getOptionsPanel());
                controlPanel.doLayout();

            });
        });

    </script>
</head>
<body>
    <div id="westPanel"></div>
    <div id="eastPanel"></div>
</body>
</html>