<?php

/**
 * @file
 * Contains RestfulTestEntityTestsResource__1_1.
 */

class RestfulTestEntityTestsResource__1_1 extends RestfulTestEntityTestsResource {

  /**
   * Overrides RestfulTestEntityTestsResource::getPublicFields().
   */
  public function getPublicFields() {
    $public_fields = parent::getPublicFields();

    $public_fields['text_single'] = array(
      'property' => 'text_single',
      'sub_property' => 'value',
    );

    $public_fields['text_multiple'] = array(
      'property' => 'text_multiple',
      'sub_property' => 'value',
    );

    $public_fields['entity_reference_single'] = array(
      'property' => 'entity_reference_single',
      'wrapper_method' => 'getIdentifier',
    );

    $public_fields['entity_reference_multiple'] = array(
      'property' => 'entity_reference_multiple',
      'wrapper_method' => 'getIdentifier',
    );

    return $public_fields;
  }
}
