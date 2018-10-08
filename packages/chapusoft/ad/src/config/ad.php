<?php

$local = array();
$production = array();

//BANNER LATERAL INDEX
$local['index.lateral'] = <<<EOD
<div style="display:block;width:300px;height:600px;background-color:#00FF00"></div>
EOD;
$production['index.lateral'] = <<<EOD
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:600px"
     data-ad-client="ca-pub-2093322466626616"
     data-ad-slot="2231303887"></ins>
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
EOD;

//DEPENDENCIAS
$localDependencies = "";
$productionDependencies =  <<<EOD
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
EOD;


return array(

    'local'  => ['slots' => $local,
                  'dependencies' => $localDependencies],

    'production' => ['slots' => $production,
                    'dependencies' => $productionDependencies],
);
