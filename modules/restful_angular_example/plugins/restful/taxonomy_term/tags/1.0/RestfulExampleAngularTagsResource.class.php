<?php

/**
 * @file
 * Contains \RestfulExampleAngularTagsResource.
 */

class RestfulExampleAngularTagsResource extends \RestfulEntityBase {

  /**
   * Overrides \RestfulEntityBase::getList().
   *
   * Allow passing the tags types in order to match them.
   */
  public function getList() {
    $request = $this->getRequest();
    return !isset($request['string']) ? parent::getList() : $this->getListByAutocomplete();
  }

  /**
   * Set properties of the entity based on the request, and save the entity.
   *
   * @param EntityMetadataWrapper $wrapper
   *   The wrapped entity object, passed by reference.
   * @param bool $null_missing_fields
   *   Determine if properties that are missing form the request array should
   *   be treated as NULL, or should be skipped. Defaults to FALSE, which will
   *   set the fields to NULL.
   *
   * @throws RestfulBadRequestException
   */
  protected function setPropertyValues(EntityMetadataWrapper $wrapper, $null_missing_fields = FALSE) {
    $term = $wrapper->value();
    if (!empty($term->tid)) {
      return;
    }

    $vocabulary = taxonomy_vocabulary_machine_name_load($term->vocabulary_machine_name);
    $term->vid = $vocabulary->vid;

    parent::setPropertyValues($wrapper, $null_missing_fields);
  }

  /**
   * Return the values of the types tags, with the ID.
   *
   * @return array
   *   Array with the found terms keys by the entity ID.
   *   ID. Otherwise, if the field allows auto-creating tags, the ID will be the
   *   term name, to indicate for client it is an unsaved term.
   *
   * @see taxonomy_autocomplete()
   */
  protected function getListByAutocomplete() {
    $request = $this->getRequest();
    if (empty($request['string'])) {
      // Empty string.
      return array();
    }

    $string = drupal_strtolower($request['string']);
    $options = $this->getPluginInfo('options');
    // $range = $options['autocomplete']['range'];
    $range = 10;

    $result = $this->getListByAutocompleteQueryResult($string, $range);

    $return = array();
    foreach ($result as $entity_id => $label) {
      $return[$entity_id] = check_plain($label);
    }

    return $return;
  }

  /**
   * Return the bundles that should be used for the autocomplete search.
   *
   * @return array
   *   Array with the vocabulary IDs.
   */
  protected function getListByAutocompleteBundles() {
    $vocabulary = taxonomy_vocabulary_machine_name_load($this->getBundle());
    return array($vocabulary->vid);
  }

  /**
   * Returns the result of a query for the auto complete.
   *
   * @param string $string
   *   The string to query.
   * @param int $range
   *   The range of the query.
   *
   * @return array
   *   Array keyed by the entity ID and the entity label as value.
   */
  protected function getListByAutocompleteQueryResult($string, $range) {
    $bundles = $this->getListByAutocompleteBundles();

    $query = db_select('taxonomy_term_data', 't');
    $query->addTag('translatable');
    $query->addTag('term_access');

    // Select rows that match by term name.
    return $query
      ->fields('t', array('tid', 'name'))
      ->condition('t.vid', $bundles, 'IN')
      ->condition('t.name', '%' . db_like($string) . '%', 'LIKE')
      ->range(0, $range)
      ->execute()
      ->fetchAllKeyed();
  }
}
