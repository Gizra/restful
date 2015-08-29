<?php

/**
 * @file
 * Contains \Drupal\restful\Plugin\formatter\Formatter
 */

namespace Drupal\restful\Plugin\formatter;

use Drupal\Component\Plugin\PluginBase;
use Drupal\restful\Plugin\ConfigurablePluginTrait;
use Drupal\restful\Plugin\resource\ResourceInterface;

abstract class Formatter extends PluginBase implements FormatterInterface {

  use ConfigurablePluginTrait;

  /**
   * The resource handler containing more info about the request.
   *
   * @var ResourceInterface
   */
  protected $resource;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public function format(array $data) {
    return $this->render($this->prepare($data));
  }

  /**
   * {@inheritdoc}
   */
  public function getContentTypeHeader() {
    // Default to the most generic content type.
    return 'application/hal+json; charset=utf-8';
  }

  /**
   * {@inheritdoc}
   */
  public function getResource() {
    if (isset($this->resource)) {
      return $this->resource;
    }

    // Get the resource from the instance configuration.
    $instance_configuration = $this->getConfiguration();
    if (empty($instance_configuration['resource'])) {
      return NULL;
    }
    $this->resource = $instance_configuration['resource'] instanceof ResourceInterface ? $instance_configuration['resource'] : NULL;
    return $this->resource;
  }

  /**
   * {@inheritdoc}
   */
  public function setResource(ResourceInterface $resource) {
    $this->resource = $resource;
  }

  /**
   * Helper function to know if a variable is iterable or not.
   *
   * @param mixed $input
   *   The variable to test.
   *
   * @return bool
   *   TRUE if the variable is iterable.
   */
  protected static function isIterable($input) {
    return is_array($input) || $input instanceof \Traversable || $input instanceof \stdClass;
  }

  /**
   * Determines if the response is an error, and sets content type accordingly.
   *
   * @param int $status
   *   The HTTP status code.
   * @param string $content_type
   *   The content type
   *
   * @return bool
   *   TRUE if the status if of error, otherwise FALSE.
   */
  protected function isError($status, $content_type = 'application/problem+json; charset=utf-8') {
    if (!empty($status) && floor($status / 100) != 2) {
      $this->contentType = $content_type;
      return TRUE;
    }

    return FALSE;
  }

}
