<?php
/**
  * Catroid: An on-device visual programming system for Android devices
  * Copyright (C) 2010-2013 The Catrobat Team
  * (<http://developer.catrobat.org/credits>)
  * 
  * This program is free software: you can redistribute it and/or modify
  * it under the terms of the GNU Affero General Public License as
  * published by the Free Software Foundation, either version 3 of the
  * License, or (at your option) any later version.
  * 
  * An additional term exception under section 7 of the GNU Affero
  * General Public License, version 3, is available at
  * http://developer.catrobat.org/license_additional_term
  * 
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  * GNU Affero General Public License for more details.
  * 
  * You should have received a copy of the GNU Affero General Public License
  * along with this program. If not, see <http://www.gnu.org/licenses/>.
  */

class CorePresenter_http extends CorePresenterCommon {
  private $statusCode;

  public function __construct(CoreModule $module) {
    parent::__construct($module);
    $data = $this->module->getData();

    $this->statusCode = STATUS_CODE_INTERNAL_SERVER_ERROR;
    if(isset($data['statusCode']) && is_int($data['statusCode'])) {
      $this->statusCode = $data['statusCode'];
    }
  }

  public function display() {
    $statusString = 'HTTP/1.0 ' . $this->statusCode;
    header($statusString, true, $this->statusCode);

    return true;
  }

  public function getStatusCode() {
    return $this->statusCode;
  }

  public function __destruct() {
    parent::__destruct();
  }
}
?>
