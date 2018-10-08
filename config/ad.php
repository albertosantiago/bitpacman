<?php
$local = array();
$production = array();

$local['index.lateral'] = <<<EOD
<iframe src="http://adsnet.wetdog.co" class="ads-lateral-banner"></iframe>
EOD;

$production['index.lateral'] = <<<EOD
<iframe src="http://adsnet.wetdog.co" class="ads-lateral-banner"></iframe>
EOD;

$local['index.top'] = <<<EOD
<iframe src="http://adsnet.wetdog.co" class="ads-top"></iframe>
EOD;
$production['index.top'] = <<<EOD
<iframe src="http://adsnet.wetdog.co" class="ads-top"></iframe>
EOD;

$local['index.lateral_link'] = <<<EOD
<iframe src="http://adsnet.wetdog.co" class="ads-lateral-banner"></iframe>
EOD;
$production['index.lateral_link'] = <<<EOD
<iframe src="http://adsnet.wetdog.co" class="ads-lateral-banner"></iframe>
EOD;

$local['about.lateral2'] = <<<EOD
<iframe src="http://adsnet.wetdog.co" class="ads-lateral-banner"></iframe>
EOD;
$production['about.lateral2'] = <<<EOD
<iframe src="http://adsnet.wetdog.co" class="ads-lateral-banner"></iframe>
EOD;

$local['index.bottom'] = <<<EOD
<iframe src="http://adsnet.wetdog.co" class="ads-bottom"></iframe>
EOD;
$production['index.bottom'] = <<<EOD
<iframe src="http://adsnet.wetdog.co" class="ads-bottom"></iframe>
EOD;


//DEPENDENCIAS
$localDependencies = "";
$productionDependencies =  <<<EOD
EOD;

return array(
    'local'  => [
        'slots' => $local,
        'dependencies' => $localDependencies
    ],
    'production' => [
        'slots' => $production,
        'dependencies' => $productionDependencies
    ]
);
