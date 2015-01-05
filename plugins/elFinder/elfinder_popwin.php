<?php
	$albumId =  isset($_GET['albumId']) ? $_GET['albumId'] : '0';
	$imageId =  isset($_GET['imageId']) ? $_GET['imageId'] : '0';
	$searchText =  isset($_GET['searchText']) ? $_GET['searchText'] : '';	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Resize, Rotate, Crop</title>

	<script src="jquery/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="jquery/jquery-ui-1.10.1.custom.min.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="jquery/ui-themes/smoothness/jquery-ui-1.10.1.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
	
	<link rel="stylesheet" href="css/common.css"      type="text/css">
	<link rel="stylesheet" href="css/dialog.css"      type="text/css">
	<link rel="stylesheet" href="css/toolbar.css"     type="text/css">
	<link rel="stylesheet" href="css/navbar.css"      type="text/css">
	<link rel="stylesheet" href="css/statusbar.css"   type="text/css">
	<link rel="stylesheet" href="css/contextmenu.css" type="text/css">
	<link rel="stylesheet" href="css/cwd.css"         type="text/css">
	<link rel="stylesheet" href="css/quicklook.css"   type="text/css">
	<link rel="stylesheet" href="css/commands.css"    type="text/css">

	<link rel="stylesheet" href="css/fonts.css"       type="text/css">
	<link rel="stylesheet" href="css/theme.css"       type="text/css">

	<!-- elfinder core -->
	<script src="js/elFinder.js"></script>
	<script src="js/elFinder.version.js"></script>
	<script src="js/jquery.elfinder.js"></script>
	<script src="js/elFinder.resources.js"></script>
	<script src="js/elFinder.options.js"></script>
	<script src="js/elFinder.history.js"></script>
	<script src="js/elFinder.command.js"></script>

	<!-- elfinder ui -->
	<script src="js/ui/overlay.js"></script>
	<script src="js/ui/workzone.js"></script>
	<script src="js/ui/navbar.js"></script>
	<script src="js/ui/dialog.js"></script>
	<script src="js/ui/tree.js"></script>
	<script src="js/ui/cwd.js"></script>
	<script src="js/ui/toolbar.js"></script>
	<script src="js/ui/button.js"></script>
	<script src="js/ui/uploadButton.js"></script>
	<script src="js/ui/viewbutton.js"></script>
	<script src="js/ui/searchbutton.js"></script>
	<script src="js/ui/sortbutton.js"></script>
	<script src="js/ui/panel.js"></script>
	<script src="js/ui/contextmenu.js"></script>
	<script src="js/ui/path.js"></script>
	<script src="js/ui/stat.js"></script>
	<script src="js/ui/places.js"></script>

	<!-- elfinder commands -->
	<script src="js/commands/back.js"></script>
	<script src="js/commands/forward.js"></script>
	<script src="js/commands/reload.js"></script>
	<script src="js/commands/up.js"></script>
	<script src="js/commands/home.js"></script>
	<script src="js/commands/copy.js"></script>
	<script src="js/commands/cut.js"></script>
	<script src="js/commands/paste.js"></script>
	<script src="js/commands/open.js"></script>
	<script src="js/commands/rm.js"></script>
	<script src="js/commands/info.js"></script>
	<script src="js/commands/duplicate.js"></script>
	<script src="js/commands/rename.js"></script>
	<script src="js/commands/help.js"></script>
	<script src="js/commands/getfile.js"></script>
	<script src="js/commands/mkdir.js"></script>
	<script src="js/commands/mkfile.js"></script>
	<script src="js/commands/upload.js"></script>
	<script src="js/commands/download.js"></script>
	<script src="js/commands/edit.js"></script>
	<script src="js/commands/quicklook.js"></script>
	<script src="js/commands/quicklook.plugins.js"></script>
	<script src="js/commands/extract.js"></script>
	<script src="js/commands/archive.js"></script>
	<script src="js/commands/search.js"></script>
	<script src="js/commands/view.js"></script>
	<script src="js/commands/resize.js"></script>
	<script src="js/commands/sort.js"></script>	
	<script src="js/commands/netmount.js"></script>	

	<!-- elfinder languages -->
	<script src="js/i18n/elfinder.en.js"></script>

	<!-- elfinder dialog -->
	<script src="js/jquery.dialogelfinder.js"></script>

	<!-- elfinder 1.x connector API support -->
	<script src="js/proxy/elFinderSupportVer1.js"></script>

	<!-- elfinder custom extenstions 
	<script src="extensions/jplayer/elfinder.quicklook.jplayer.js"></script>
	-->
	<style type="text/css">
		body { font-family:arial, verdana, sans-serif;}
		.button {
			width: 100px;
			position:relative;
			display: -moz-inline-stack;
			display: inline-block;
			vertical-align: top;
			zoom: 1;
			*display: inline;
			margin:0 3px 3px 0;
			padding:1px 0;
			text-align:center;
			border:1px solid #ccc;
			background-color:#eee;
			margin:1em .5em;
			padding:.3em .7em;
			border-radius:5px; 
			-moz-border-radius:5px; 
			-webkit-border-radius:5px;
			cursor:pointer;
		}
/**
		#finder {
			position:absolute;
			left:0px;
			top:0px;
			width: 100%;
			height: 700px;
		}
*/
	</style>

	<script>
		$().ready(function() {
			var finder = $('#finder').elfinder({
				requestType : 'post',
				commandsOptions : {
					// configure value for "getFileCallback" used for editor integration
					getfile : {
						// send only URL or URL+path if false
						onlyURL  : true,
				
						// allow to return multiple files info
						multiple : false,
				
						// allow to return folders info
						folders  : false,
				
						// action after callback (close/destroy)
						oncomplete : ''
					},
				
					// "upload" command options.
					upload : {
						ui : 'uploadbutton'
					},
				
					// "quicklook" command options. For additional extensions
					quicklook : {
						autoplay : true,
						jplayer  : 'extensions/jplayer'
					},
				
					// configure custom editor for file editing command
					edit : {
						// list of allowed mimetypes to edit
						// if empty - any text files can be edited
						mimes : [],
				
						// edit files in wysisyg's
						editors : [
							// {
							// 	/**
							// 	 * files mimetypes allowed to edit in current wysisyg
							// 	 * @type  Array
							// 	 */
							// 	mimes : ['text/html'], 
							// 	/**
							// 	 * Called when "edit" dialog loaded.
							// 	 * Place to init wysisyg.
							// 	 * Can return wysisyg instance
							// 	 *
							// 	 * @param  DOMElement  textarea node
							// 	 * @return Object
							// 	 */
							// 	load : function(textarea) { },
							// 	/**
							// 	 * Called before "edit" dialog closed.
							// 	 * Place to destroy wysisyg instance.
							// 	 *
							// 	 * @param  DOMElement  textarea node
							// 	 * @param  Object      wysisyg instance (if was returned by "load" callback)
							// 	 * @return void
							// 	 */
							// 	close : function(textarea, instance) { },
							// 	/**
							// 	 * Called before file content send to backend.
							// 	 * Place to update textarea content if needed.
							// 	 *
							// 	 * @param  DOMElement  textarea node
							// 	 * @param  Object      wysisyg instance (if was returned by "load" callback)
							// 	 * @return void
							// 	 */
							// 	save : function(textarea, editor) {}
							// 
							// }
						]
					},
				
					// help dialog tabs
					help : { view : ['about', 'shortcuts', 'help'] }
				},				
				url : 'php/connector.album.php',
				uiOptions : {
					// toolbar configuration
					toolbar : [
						//['back', 'forward'],
					    ['reload'],
						['home'],
						//['mkdir', 'mkfile', 'upload'],
						//['open', 'download', 'getfile'],
						['info'],
						['quicklook'],
						//['copy', 'cut', 'paste'],
						//['rm'],
						//['duplicate', 'rename', 'edit', 'resize'],
						['resize'],
						//['extract', 'archive'],
						['search'],
						['view']
						//['help']
					],				
					// directories tree options
					tree : {
						// expand current root on init
						openRootOnLoad : true,
						// auto load current dir parents
						syncTree : true
					},				
					// navbar options
					navbar : {
						minWidth : 150,
						maxWidth : 500
					},				
					// current working directory options
					cwd : {
						// display parent directory in listing as ".."
						oldSchool : false
					}
				},				
				contextmenu : {
					// navbarfolder menu
					navbar : ['open', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|', 'info'],				
					// current directory menu
					cwd    : ['reload', 'back', '|', 'upload', 'mkdir', 'mkfile', 'paste', '|', 'info'],				
					// current directory file menu
					files  : [
						'getfile', '|','open', 'quicklook', '|', 'download', '|',
						'rm', '|', 'edit', 'rename', 'resize', '|', 'archive', 'extract', '|', 'info'
					]
				},	
				commands : [
					'open', 'reload', 'home', 'up', 'back', 'forward', 'getfile', 'quicklook', 
					'download', 'rm', 'duplicate', 'rename', 'mkdir', 'mkfile', 'upload', 'copy', 
					'cut', 'paste', 'edit', 'extract', 'archive', 'search', 'info', 'view', 'help',
					'resize', 'sort'
				],
				handlers : {
                    select : function(event, elfinderInstance) {
                        var selected = event.data.selected;						
						if (selected.length) {
							 console.log(elfinderInstance.file(selected[0]))
						}						
                    }
                },
				lang : 'en',
				//customData : {answer : 42},
				//ui : ['tree', 'toolbar'],
				ui : ['toolbar'],

			})



			// console.log(f1)
			// 

			 setTimeout(function() {
			 
			 	var searchVal = '<?php echo $searchText ?>';
			 	$('.elfinder-button-search :input').val(searchVal);		
			 	$('.elfinder-button-search :input').focus();

				//finder.search.exec(searchVal);
			//	$('.elfinder-button-search :input').val(searchVal).trigger( "keypress", [13] ); 

				
			 }, 1000)



		});
		
		

	</script>
</head>
<body>
	<div id="finder"></div>
	<br clear="all"/>
</body>
</html>
