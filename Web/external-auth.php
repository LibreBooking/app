<?php
/**
 * Copyright 2015 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/Authentication/ExternalAuthLoginPage.php');
require_once(ROOT_DIR . 'Presenters/Authentication/ExternalAuthLoginPresenter.php');

$page = new ExternalAuthLoginPage();
$page->PageLoad();



/**
 * $url = 'https://accounts.google.com/o/oauth2/token';
 * $fields = array(
 * 'code' => $_GET['code'],
 * 'grant_type' => 'authorization_code',
 * 'client_id' => '531675809673-4m4s8htfvtj6a4sjrnubj3b2um9meurg.apps.googleusercontent.com',
 * 'client_secret' => 'FL8j_raF5ZKgNgXLv1TGNhOV',
 * 'redirect_uri' => 'http://localhost/development/Web/external-auth.php',
 * );
 *
 * $curl = curl_init();
 *
 * curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
 * curl_setopt($curl, CURLOPT_URL, $url);
 * curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
 * curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($fields));
 * curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 *
 * curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
 * curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
 *
 * curl_setopt($curl, CURLOPT_CAINFO, __DIR__ . "/../cacert.pem");
 * curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 * curl_setopt($curl, CURLOPT_HEADER, true);
 *
 * $response = curl_exec($curl);
 *
 * if ($response === false)
 * {
 * $error = curl_error($curl);
 * $code = curl_errno($curl);
 *
 * print 'ERROR ' .  $error . '<br/>' . $code;
 * }
 *
 * $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
 *
 * $responseSegments = explode("\r\n\r\n", $response, 2);
 * $responseHeaders = $responseSegments[0];
 * $responseBody = isset($responseSegments[1]) ? $responseSegments[1] : null;
 *
 * curl_close($curl);
 *
 * $access = json_decode($responseBody);
 *
 *
 *
 * var_dump($access);
 */