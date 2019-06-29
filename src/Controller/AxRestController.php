<?php

namespace Drupal\ax_siteinfo\Controller;

// Classes referenced in this class:
use Drupal\node\NodeInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller routines for AX api routes.
 */
class AxRestController extends ControllerBase {

  /**
   * Callback for  'page_json/{apikey}/{node_id}' API method.
   */
  public function get($apikey, NodeInterface $node) {
    // Empty response object.
    $response = [];
    // Peroare response.
    $response['data'] = [
      'type' => $node->get('type')->target_id,
      'id' => $node->get('nid')->value,
      'body' => [
        'title' => $node->get('title')->value,
        'content' => $node->get('body')->value,
      ],
    ];
    // Return response in form of json.
    return new JsonResponse($response);
  }

  /**
   * Allow access for valid api and of node type page.
   *
   * @param string $apikey
   *   Get API Key.
   * @param \Drupal\node\NodeInterface $node
   *   Get node object.
   *
   * @return bool
   *   Return true or false on the basis of criteria specified.
   */
  public function access($apikey, NodeInterface $node) {
    // Get site api key.
    $siteapikey = $this->config('system.site')->get('siteapikey');
    // Compare site api key and if node type is bundle.
    if (($apikey == $siteapikey) && ($node->bundle() == 'page')) {
      // Allow use to access the resoure.
      return AccessResult::allowed();
    }
    // Return 403 Access Denied page.
    return AccessResult::forbidden();
  }

}
