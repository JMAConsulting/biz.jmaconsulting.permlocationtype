<?php

require_once 'permlocationtype.civix.php';

/**
 * Implementation of hook_civicrm_config
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function permlocationtype_civicrm_config(&$config) {
  _permlocationtype_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function permlocationtype_civicrm_xmlMenu(&$files) {
  _permlocationtype_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function permlocationtype_civicrm_install() {
  _permlocationtype_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function permlocationtype_civicrm_uninstall() {
  _permlocationtype_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function permlocationtype_civicrm_enable() {
  _permlocationtype_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function permlocationtype_civicrm_disable() {
  _permlocationtype_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function permlocationtype_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _permlocationtype_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function permlocationtype_civicrm_managed(&$entities) {
  $entities[] = array(
    'module' => 'biz.jmaconsulting.permlocationtype',
    'name' => 'permlocationtype',
    'update' => 'never',
    'entity' => 'LocationType',
    'params' => array(
      'name' => 'LTGov',
      'display_name' => 'LTGov',
      'is_active' => 1,
      'version' => 3,
    ),
  );
  _permlocationtype_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function permlocationtype_civicrm_caseTypes(&$caseTypes) {
  _permlocationtype_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function permlocationtype_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _permlocationtype_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implementation of hook_civicrm_permission
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_permission
 */
function permlocationtype_civicrm_permission(&$permissions) {
  $prefix = ts('CiviCRM') . ': ';
  $permissions['access LtGov location type'] = array(
    $prefix . ts('access LtGov location type'),
    ts('Access LT. Gov location type'),
  );
}

/**
 * Function to return permissioned location type.
 *
 */
function getPermissionedLocationType() {
  $ltGov = civicrm_api3('LocationType', 'getsingle', array(
    'sequential' => 1,
    'return' => array("id"),
    'name' => "LtGov",
  ));
  return $ltGov['id'];
}

/**
 * Function to remove non-permissioned emails.
 *
 */
function removeEmails(&$emails) {
  $ltGov = getPermissionedLocationType();
  if (!empty($emails)) {
    foreach ($emails as $key => $email) {
      if ($email['location_type_id'] == $ltGov) {
        unset($emails[$key]);
      }
    }
  }
  return $emails;
}

/**
 * Implementation of hook_civicrm_pageRun
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_pageRun
 */
function permlocationtype_civicrm_pageRun(&$page) {
  if (CRM_Core_Permission::check('access LtGov location type') && get_class($page) == "CRM_Contact_Page_View_Summary") {
    $emails = CRM_Core_Smarty::singleton()->get_template_vars('email');
    removeEmails($emails);
    CRM_Core_Smarty::singleton()->assign('email', $emails);
  }
  if (!CRM_Core_Permission::check('access LtGov location type') && get_class($page) == "CRM_Admin_Page_LocationType") {
    $ltGov = getPermissionedLocationType();
    $rows = CRM_Core_Smarty::singleton()->get_template_vars('rows');
    if (CRM_Utils_Array::value($ltGov, $rows)) {
      unset($rows[$ltGov]);
      CRM_Core_Smarty::singleton()->assign('rows', $rows);
    }
  }
}

/**
 * Implementation of hook_civicrm_buildForm
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function permlocationtype_civicrm_buildForm($formName, &$form) {
  if (CRM_Core_Permission::check('access LtGov location type') && in_array($formName, array("CRM_Contact_Form_Inline_Email", "CRM_Contact_Form_Contact"))) {
    if (!empty($form->_values['email'])) {
      $ltGov = getPermissionedLocationType();
      foreach ($form->_values['email'] as $instance => $email) {
        if ($email['location_type_id'] == $ltGov) {
          $instances[] = $instance;
        }
      }
      $form->assign('hiddenEmail', json_encode($instances));
    }
    else {
      $ltGov = getPermissionedLocationType();
      $emails = civicrm_api3("Email", "get", array(
        "contact_id" => $form->_contactId,
        "location_type_id" => $ltGov,
        "return" => array("email"),
      ));
      if (count($emails) > 0) {
        foreach ($emails['values'] as $email) {
          $emailsToHide[] = $email['email'];
        }
      }
      $form->assign('emailsToHide', json_encode($emailsToHide));
    }
    CRM_Core_Region::instance('page-body')->add(array(
      'template' => 'CRM/LTGov.tpl',
    ));
  }
}

/**
 * Implementation of hook_civicrm_fieldOptions
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_pageRun
 */
function permlocationtype_civicrm_fieldOptions($entity, $field, &$options, $params) {
  if ($field == "location_type_id") {
    $ltGov = getPermissionedLocationType();
    if (!CRM_Core_Permission::check('access LtGov location type') && $entity == "Email") {
      unset($options[$ltGov]);
    }
    if ($entity == "Address") {
      unset($options[$ltGov]);
    }
  }
}
