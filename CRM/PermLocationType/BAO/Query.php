<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.7                                                |
 +--------------------------------------------------------------------+
 | Copyright JMAConsulting 2004-2017                                  |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
 */

/**
 *
 * @package CRM
 * @copyright JMAConsulting LLC (c) 2004-2017
 */
class CRM_PermLocationType_BAO_Query {

  /**
   * Build select for Case.
   *
   * @param CRM_Contact_BAO_Query $query
   */
  public static function select(&$query) {}

  /**
   * @param string $name
   * @param $mode
   * @param $side
   *
   * @return null|string
   */
  public static function from($name, $mode, $side) {}

  /**
   * Given a list of conditions in query generate the required where clause.
   *
   * @param $query
   */
  public static function where(&$query) {
    $ltGov = getPermissionedLocationType();
    if (CRM_Utils_Array::value('civicrm_email', $query->_tables)) {
      $query->_select['email'] = "IF(`civicrm_email`.location_type_id = {$ltGov}, '', `civicrm_email`.email) as `email`";
    }
    if (CRM_Utils_Array::value('LTGov-email', $query->_tables)) {
      $query->_select['LTGov-email'] = "IF(`LTGov-email`.location_type_id = {$ltGov}, '', `LTGov-email`.email) as `LTGov-email`";
    }
  }

  public static function getFields() {
    return array();
  }

  public static function setTableDependency(&$tables) {
  }
  
  public static function registerAdvancedSearchPane(&$panes) {
  }

  public static function getPanesMapper(&$panes) {
  }

  public static function buildAdvancedSearchPaneForm(&$form, $type) {
  }

  public static function alterSearchBuilderOptions(&$apiEntities, &$fieldOptions) {
  }

}
