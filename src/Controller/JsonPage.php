<?php

namespace Drupal\site_info\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class JsonPage extends ControllerBase {

  public function getPageData(Request $request, $page_arg) {
  	$site_api_key = \Drupal::state()->get('siteapikey', 'No API Key yet');
	$node = Node::load($page_arg);
	if(is_object($node)){
		if($node->getType() == 'page'){
			if(!($site_api_key == 'No API Key yet')){
				$serializer = \Drupal::service('serializer');
				$data = $serializer->serialize($node, 'json', ['plugin_id' => 'entity']);
				return new JsonResponse($data);
			}
		}
	}
	throw new AccessDeniedHttpException();
  }
}
