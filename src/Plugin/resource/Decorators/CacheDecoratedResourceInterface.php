<?php

/**
 * @file
 * Contains \Drupal\restful\Plugin\resource\Decorators\CacheDecoratedResourceInterface.
 */

namespace Drupal\restful\Plugin\resource\Decorators;


interface CacheDecoratedResourceInterface extends ResourceDecoratorInterface {


  /**
   * Getter for $cacheController.
   *
   * @return \DrupalCacheInterface
   *   The cache object.
   */
  public function getCacheController();

  /**
   * Clear all the cache entries for the resource.
   */
  public function invalidateResourceCache();

}
