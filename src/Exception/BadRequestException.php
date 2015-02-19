<?php

/**
 * @file
 * Contains \Drupal\restful\Exception\BadRequestException.
 */

namespace Drupal\restful\Exception;

class BadRequestException extends RestfulException {

  /**
   * Defines the HTTP error code.
   *
   * @var int
   */
  protected $code = 400;

  /**
   * Defines the problem instance.
   *
   * @var string
   */
  protected $instance = 'help/restful/problem-instances-bad-request';

}
