<?php
/* This section can be removed if you would like to reuse the PHP example outside of this PHP sample application */
require_once("lib/config.php"); 
require_once("lib/common.php");

$configManager = new Config();

?>
<!doctype html>
    <head> 
        <title>pdf阅读器 - 上海市城市规划设计研究院</title>                
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width" />
        <style type="text/css" media="screen"> 
			html, body	{ height:100%; }
			body { margin:0; padding:0; overflow:auto; }   
			#flashContent { display:none; }
        </style> 
		
		<link rel="stylesheet" type="text/css" href="css/flexpaper.css" />
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.extensions.min.js"></script>
		<script type="text/javascript" src="js/flexpaper.js"></script>
		<script type="text/javascript" src="js/flexpaper_handlers.js"></script>
    </head> 
    <body>
			<div id="documentViewer" class="flexpaper_viewer"></div>
	        <?php
	        require("../config.php");
			require(DOYO_PATH."/sys.php");
			$aid = $_GET["id"];
			$docs = syDB('magzine_field')->find(array('aid'=>$aid),null,'majorpdf,supplementpdf');
			if($_GET["type"]=='supplement'){
				$doc = substr($docs["supplementpdf"],17,-4);
				$source = '../' . substr($docs["supplementpdf"],1);
				$dest = '../../upload/' . substr($docs["supplementpdf"],17);
			}else{
				$doc = substr($docs["majorpdf"],17,-4);
				$source = '../' . substr($docs["majorpdf"],1);
				$dest = '../../upload/' . substr($docs["majorpdf"],17);
			}
			
			if(!file_exists($dest)){
				copy($source, $dest);
			}
			$pdfFilePath = $configManager->getConfig('path.pdf'); 
			?>
	        <script type="text/javascript">   
		        function getDocumentUrl(document){
		        	var numPages 			= <?php echo getTotalPages($pdfFilePath . $doc . ".pdf") ?>;
					var url = "{services/view.php?doc={doc}&format={format}&page=[*,0],{numPages}}";
						url = url.replace("{doc}",document);
						url = url.replace("{numPages}",numPages);
						return url;	        
		        }
		        
				var searchServiceUrl	= escape('services/containstext.php?doc=<?php echo $doc ?>&page=[page]&searchterm=[searchterm]');
				$('#documentViewer').FlexPaperViewer(
				  { config : {
						 
						 DOC : escape(getDocumentUrl("<?php echo $doc ?>")),
						 Scale : 0.6, 
						 ZoomTransition : 'easeOut',
						 ZoomTime : 0.5, 
						 ZoomInterval : 0.1,
						 FitPageOnLoad : true,
						 FitWidthOnLoad : false, 
						 FullScreenAsMaxWindow : false,
						 ProgressiveLoading : false,
						 MinZoomSize : 0.2,
						 MaxZoomSize : 5,
						 SearchMatchAll : false,
  						 SearchServiceUrl : searchServiceUrl,
						 InitViewMode : '',
						 RenderingOrder : '<?php echo ($configManager->getConfig('renderingorder.primary') . ',' . $configManager->getConfig('renderingorder.secondary')) ?>',
						 
						 ViewModeToolsVisible : true,
						 ZoomToolsVisible : true,
						 NavToolsVisible : true,
						 CursorToolsVisible : true,
						 SearchToolsVisible : true,
  						 key : '<?php echo $configManager->getConfig('licensekey') ?>',
  						 
  						 DocSizeQueryService : 'services/swfsize.php?doc=<?php echo $doc ?>',

						 JSONDataType : 'jsonp',

						 WMode : 'transparent',
  						 localeChain: 'zh_CN'
						 }}
				);
	        </script>
   </body>
</html>