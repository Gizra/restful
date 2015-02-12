<?php

/**
 * @file
 * Contains \Drupal\restful\Plugin\resource\Field\ResourceFieldEntityInterface
 */

namespace Drupal\restful\Plugin\resource\Field;

interface ResourceFieldEntityInterface extends ResourceFieldInterface {

  /**
   * Decorate the object.
   *
   * @param ResourceFieldInterface $decorated
   *   The decorated subject.
   */
  public function decorate(ResourceFieldInterface $decorated);

  /**
   * @return string
   */
  public function getSubProperty();

  /**
   * @param string $subProperty
   */
  public function setSubProperty($subProperty);

  /**
   * @return string
   */
  public function getFormatter();

  /**
   * @param string $formatter
   */
  public function setFormatter($formatter);

  /**
   * @return string
   */
  public function getWrapperMethod();

  /**
   * @param string $wrapperMethod
   */
  public function setWrapperMethod($wrapperMethod);

  /**
   * @return boolean
   */
  public function isWrapperMethodOnEntity();

  /**
   * @param boolean $wrapperMethodOnEntity
   */
  public function setWrapperMethodOnEntity($wrapperMethodOnEntity);

  /**
   * @return string
   */
  public function getColumn();

  /**
   * @param string $column
   */
  public function setColumn($column);

  /**
   * @return array
   */
  public function getImageStyles();

  /**
   * @param array $imageStyles
   */
  public function setImageStyles($imageStyles);

  /**
   * Get the image URLs based on the configured image styles.
   *
   * @param array $file_array
   *   The file array.
   * @param array $image_styles
   *   The list of image styles to use.
   *
   * @return array
   *   The input file array with an extra key for the image styles.
   */
  public function getImageUris(array $file_array, $image_styles);

  /**
   * Checks if a given string represents a Field API field.
   *
   * @param string $name
   *   The name of the field/property.
   *
   * @return bool
   *   TRUE if it's a field. FALSE otherwise.
   */
  public static function propertyIsField($name);
}
