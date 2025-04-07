<?php
require_once __DIR__ . '/../models/SiteDetails.php';
require_once __DIR__ .'/ControllerBootstrap.php';

$siteDetails = new SiteDetails();


switch ($data['page'] ?? '') {
    case 'home':
        $response = $siteDetails->getHomePageDetails();
        break;
    case 'about':
        $response = $siteDetails->getAboutPageDetails();
        break;
    case 'contact':
        $response = $siteDetails->getContactPageDetails();
        break;
    default:
        sendJsonResponse(['error' => 'Page Details Not Found'], 404);
        break;  
}

sendJsonResponse($response, !empty($response) ? 200 : 400);

?>
