<?php

$local = array();
$production = array();

//BANNER LATERAL INDEX
$local['index.lateral'] = <<<EOD
<div style="display:inline-block;width:100%;height:600px;background-color:#00FF00"></div>
EOD;

$production['index.lateral'] = <<<EOD
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2093322466626616"
     data-ad-slot="7909407482"
     data-ad-format="auto"></ins>
 <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
 <script>
 (adsbygoogle = window.adsbygoogle || []).push({});
 </script>
EOD;

//BANNER LATERAL INDEX
$local['index.lateral.9dollars'] = <<<EOD
<div style="display:inline-block;width:250px;height:250px;background-color:#FF0000"></div>
EOD;

$production['index.lateral.9dollars'] = "";
/**<<<EOD
<script>
var protocol = window.location.protocol;var host = window.location.hostname;var path = window.location.pathname;var params = encodeURIComponent(window.location.search);var referrer = encodeURIComponent(document.referrer);
if (protocol == "https:"){ document.write('<iframe src="https://secureads.bitbillions.com/adsize-9/?resource=1444938098.6049&own=12252&protocol='+protocol+'&host='+host+'&path='+path+'&params='+params+'&referrer='+referrer+'" width="250" height="265" frameborder="0" scrolling="no"></iframe>');} else { document.write('<iframe src="http://ads.bitbillions.com/adsize-9/?resource=1444938098.6049&own=12252&protocol='+protocol+'&host='+host+'&path='+path+'&params='+params+'&referrer='+referrer+'" width="250" height="265" frameborder="0" scrolling="no"></iframe>');}
</script>
EOD;
**/

//BANNER DEBAJO DEL JUEGO
$local['index.bottom.google'] = <<<EOD
<div style="display:inline-block;width:100%;height:60px;background-color:#00FF00"></div>
EOD;
$production['index.bottom.google'] = <<<EOD
<!-- responsive2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2093322466626616"
     data-ad-slot="5837781485"
     data-ad-format="auto"></ins>
     <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
     <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
     </script>
EOD;

$local['popup'] = <<<EOD
EOD;
$production['popup'] = "";
/**<<<EOD
<script type="text/javascript">
    var adfly_id = 11386787;
</script>
<script src="https://cdn.adf.ly/js/display.js"></script>
EOD;""
**/
//BANNER ENCIMA DEL JUEGO
$local['index.top'] = <<<EOD
<div style="display:inline-block;width:100%;height:60px;background-color:#00FF00"></div>
EOD;
$production['index.top'] = <<<EOD
<!-- responsive3 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2093322466626616"
     data-ad-slot="9849178687"
     data-ad-format="auto"></ins>
     <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
     <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
     </script>
EOD;

//ENLACE LATERAL INDEX
$local['index.lateral_link'] = <<<EOD
<div style="display:inline-block;width:200px;height:90px;background-color:#00FF00"></div>
EOD;
$production['index.lateral_link'] = <<<EOD
<ins class="adsbygoogle"
     style="display:inline-block;width:200px;height:90px"
     data-ad-client="ca-pub-2093322466626616"
     data-ad-slot="8247484687"></ins>
 <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
 <script>
 (adsbygoogle = window.adsbygoogle || []).push({});
 </script>
EOD;

$local['about.lateral2'] = <<<EOD
<div style="display:inline-block;width:100%;height:600px;background-color:#00FF00"></div>
EOD;
$production['about.lateral2'] = <<<EOD
<!-- responsive2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2093322466626616"
     data-ad-slot="5837781485"
     data-ad-format="auto"></ins>
 <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
 <script>
 (adsbygoogle = window.adsbygoogle || []).push({});
 </script>
EOD;



//BANNER
$local['index.bottom'] = "";
$production['index.bottom'] = "";


//DEPENDENCIAS
$localDependencies = "";
$productionDependencies =  <<<EOD

EOD;



return array(

    'local'  => ['slots' => $local,
                  'dependencies' => $localDependencies],

    'production' => ['slots' => $production,
                    'dependencies' => $productionDependencies],
);
