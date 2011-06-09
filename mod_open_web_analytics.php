<?php

// impediamo l'accesso diretto alla pagina
defined('_JEXEC') or die;
?>
<!-- Start Open Web Analytics Tracker -->
<script type="text/javascript">
//<![CDATA[
var owa_baseUrl = '<?php echo $params->get('baseUrl'); ?>';
var owa_cmds = owa_cmds || [];
owa_cmds.push(['setSiteId', '<?php echo $params->get('siteID'); ?>']);
owa_cmds.push(['trackPageView']);

<?php if($params->get('trackClicks')){ ?>
   owa_cmds.push(['trackClicks']);
<?php } ?>

<?php if($params->get('trackDomStream')){ ?>
   owa_cmds.push(['trackDomStream']);
<?php } ?>

(function() {
	var _owa = document.createElement('script'); _owa.type = 'text/javascript'; _owa.async = true;
	owa_baseUrl = ('https:' == document.location.protocol ? window.owa_baseSecUrl || owa_baseUrl.replace(/http:/, 'https:') : owa_baseUrl );
	_owa.src = owa_baseUrl + 'modules/base/js/owa.tracker-combined-min.js';
	var _owa_s = document.getElementsByTagName('script')[0]; _owa_s.parentNode.insertBefore(_owa, _owa_s);
}());
//]]>
</script>
<!-- End Open Web Analytics Code -->
