<?php

/**
 * @file
 * Contains \Drupal\restful\Plugin\resource\Field\ResourceFieldCollectionInterface.
 */

namespace Drupal\restful\Plugin\resource\Field;

use Drupal\restful\Http\RequestInterface;
use Drupal\restful\Plugin\resource\DataInterpreter\DataInterpreterInterface;

interface ResourceFieldCollectionInterface extends \Iterator, \Countable {

  /**
   * Factory.
   *
   * Creates the collection and each one of the field resource fields in it
   * based on the configuration array.
   *
   * @param array $fields
   *   An array of field mappings.
   * @param RequestInterface $request
   *   The request.
   *
   * @return ResourceFieldCollectionInterface
   *   The newly created object.
   */
  public static function factory(array $fields = array(), RequestInterface $request = NULL);

  /**
   * Factory.
   *
   * Creates the collection based on the implementation of the static::getInfo
   * method.
   *
   * @return ResourceFieldCollectionInterface
   *   The newly created object.
   */
  public static function create();

  /**
   * Default get info implementation.
   *
   * This is the method the implementers need to overwrite in order to provide
   * their own field definitions.
   *
   * @return array
   *   The array with field mappings.
   */
  public static function getInfo();

  /**
   * Get an element of the collection by its key.
   *
   * @param string $key
   *   The key of the field.
   *
   * @return ResourceFieldInterface
   *   The requested field.
   */
  public function get($key);

  /**
   * Sets a field in the collection.
   *
   * @param string $key
   *   The key of the field.
   * @param ResourceFieldInterface $field
   *   The field to set.
   */
  public function set($key, ResourceFieldInterface $field);

  /**
   * Sets the data interpreter.
   *
   * @param DataInterpreterInterface $interpreter
   *   The interpreter.
   */
  public function setInterpreter($interpreter);

  /**
   * Gets the data interpreter.
   *
   * @return DataInterpreterInterface
   *   The interpreter.
   */
  public function getInterpreter();

  /**
   * Get the resource field that will return the ID.
   *
   * @return ResourceFieldInterface
   *   The field.
   */
  public function getIdField();

  /**
   * Set the resource field that will return the ID.
   *
   * @param ResourceFieldInterface $id_field
   *   The field to set.
   */
  public function setIdField($id_field);

  /**
   * Evaluate a parsed filter on a field collection.
   *
   * @param array $filter
   *   The parsed filter.
   *
   * @return bool
   *   TRUE if the collection matches the filter. FALSE otherwise.
   */
  public function evalFilter(array $filter);

}
