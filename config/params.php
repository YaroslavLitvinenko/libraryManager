<?php

$areaController = 'area';

$homeActionForAdmin = 'journal';
$homeActionForDirector = 'admin';
$homeActionForClient = 'personal-area';

return [
    'adminEmail' => 'admin@example.com',

    'areaController' => $areaController,
    'homePageDirector' => $areaController . '/' . $homeActionForDirector,
    'homePageAdmin' => $areaController . '/' . $homeActionForAdmin,
    'homePageClient' => $areaController . '/' . $homeActionForClient,
];
