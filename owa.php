<?php
/**
 * @package Open Web Analytics tracking code for Joomla! 1.6
 * @author Marco Cosentino
 * @copyright (C) 2011 www.professioneit.com
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import Joomla! Plugin library file
jimport('joomla.plugin.plugin');

//The System plugin
class plgSystemOwa extends JPlugin
{
        /**
        * Constructor
        */
        public function __construct(& $subject, $params) {
                parent::__construct($subject, $params);
        }

        function onAfterRender()
        {
                $app = JFactory::getApplication();
                
                $owa_base_url = trim( $this->params->get('baseUrl', '') );
                $owa_site_id = trim( $this->params->get('siteID', '') );
                $owa_track_clicks = $this->params->get('trackClicks', false);
                $owa_track_domstream = $this->params->get('trackDomStream', false);
                
                $body = JResponse::getBody();
                
                $trk_clicks = $owa_track_clicks ? 'owa_cmds.push([\'trackClicks\']);' : '';
                $trk_domstream = $owa_track_domstream ? 'owa_cmds.push([\'trackDomStream\']);' : '';


                $trk_code = <<<EOT
<!-- Start Open Web Analytics Tracker -->
<script type="text/javascript">
//<![CDATA[
var owa_baseUrl = '{$owa_base_url}';
var owa_cmds = owa_cmds || [];
owa_cmds.push(['setSiteId', '{$owa_site_id}']);
owa_cmds.push(['trackPageView']);

{$trk_clicks}
{$trk_domstream}

(function() {
        var _owa = document.createElement('script'); _owa.type = 'text/javascript'; _owa.async = true;
        owa_baseUrl = ('https:' == document.location.protocol ? window.owa_baseSecUrl || owa_baseUrl.replace(/http:/, 'https:') : owa_baseUrl );
        _owa.src = owa_baseUrl + 'modules/base/js/owa.tracker-combined-min.js';
        var _owa_s = document.getElementsByTagName('script')[0]; _owa_s.parentNode.insertBefore(_owa, _owa_s);
}());
//]]>
</script>
<!-- End Open Web Analytics Code -->
EOT;

            if($owa_base_url !== '' && $owa_site_id !== '' && !$app->isAdmin() && strpos($_SERVER["PHP_SELF"], "index.php") !== false){
                $body = str_replace ("</body>", $trk_code."</body>", $body);
                JResponse::setBody($body);
            }
            return true;
        }
}

