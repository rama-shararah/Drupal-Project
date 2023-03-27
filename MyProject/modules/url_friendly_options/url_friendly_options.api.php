<?php

/**
 * @file
 * Hooks for the url_friendly_options module.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Allows modules to bypass url-friendly validation for a particular field.
 *
 * Modules implementing this hook should return TRUE if the field being saved
 * should bypass URL-friendly validation.
 *
 * @param string $field_name
 *   The name of the field storage being saved.
 * @param string $entity_type_id
 *   The entity type that holds the field storage being saved.
 */
function hook_url_friendly_options_bypass_field_validation($field_name, $entity_type_id) {
  if ($field_name === 'field_foo_bar' && $entity_type_id === 'node') {
    return TRUE;
  }
  return FALSE;
}

/**
 * @} End of "addtogroup hooks".
 */
