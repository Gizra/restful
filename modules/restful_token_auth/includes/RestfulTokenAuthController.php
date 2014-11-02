<?php

/**
 * @file
 * Contains \RestfulTokenAuthController
 */

class RestfulTokenAuthController extends \EntityAPIController {

  /**
   * Create a new access_token entity with a referenced refresh_token.
   *
   * @param int $uid
   *   The user ID.
   * @param int $expiration
   *   The timestamp when this token will expire
   *
   * @return \RestfulTokenAuth
   *   The created entity.
   */
  public function createAccessToken($uid) {
    $refresh_token = $this->createRefreshToken($uid);
    // Create a new access token.
    $values = array(
      'uid' => $uid,
      'type' => 'access_token',
      'created' => REQUEST_TIME,
      'name' => t('Access token for: @uid', array(
        '@uid' => $uid,
      )),
      'token' => drupal_random_key(),
      'expire' => $this->getExpireTime(),
      'refresh_token_reference' => array(LANGUAGE_NONE => array(array(
        'target_id' => $refresh_token->id,
      ))),
    );
    $access_token = $this->create($values);
    $this->save($access_token);

    return $access_token;
  }

  /**
   * Create a refresh token for the current user and delete all the existing
   * ones for that same user.
   *
   * @param int $uid
   *   The user ID.
   *
   * @return \RestfulTokenAuth
   *   The token entity.
   */
  private function createRefreshToken($uid) {
    // Check if there are other refresh tokens for the user.
    $query = new \EntityFieldQuery();
    $results = $query
      ->entityCondition('entity_type', 'restful_token_auth')
      ->entityCondition('bundle', 'refresh_token')
      ->propertyCondition('uid', $uid)
      ->execute();

    if (!empty($results['restful_token_auth'])) {
      // Delete the tokens.
      entity_delete_multiple('restful_token_auth', array_keys($results['restful_token_auth']));
    }

    // Create a new refresh token.
    $values = array(
      'uid' => $uid,
      'type' => 'refresh_token',
      'created' => REQUEST_TIME,
      'name' => t('Refresh token for: @uid', array(
        '@uid' => $uid,
      )),
      'token' => drupal_random_key(),
    );
    $refresh_token = entity_create('restful_token_auth', $values);
    entity_save('restful_token_auth', $refresh_token);
    return $refresh_token;
  }

  /**
   * Return the expiration time.
   *
   * @return int
   *   Timestamp with the expiration time.
   */
  protected function getExpireTime() {
    return strtotime('now + 1 week');
  }

}
