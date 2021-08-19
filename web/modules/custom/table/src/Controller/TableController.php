<?php

namespace Drupal\table\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for table routes.
 */
class TableController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
