<?php
/**
Copyright 2011-2016 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'tests/fakes/DBFakes.php');
require_once(ROOT_DIR . 'tests/fakes/DBRows.php');
require_once(ROOT_DIR . 'tests/fakes/FakeAuth.php');
require_once(ROOT_DIR . 'tests/fakes/FakePageBase.php');
require_once(ROOT_DIR . 'tests/fakes/FakePasswordEncryption.php');
require_once(ROOT_DIR . 'tests/fakes/FakeRegister.php');
require_once(ROOT_DIR . 'tests/fakes/FakeValidator.php');
require_once(ROOT_DIR . 'tests/fakes/FakeServer.php');
require_once(ROOT_DIR . 'tests/fakes/FakeSmarty.php');
require_once(ROOT_DIR . 'tests/fakes/FakeConfig.php');
require_once(ROOT_DIR . 'tests/fakes/FakeActiveDirectoryOptions.php');
require_once(ROOT_DIR . 'tests/fakes/FakeActiveDirectoryWrapper.php');
require_once(ROOT_DIR . 'tests/fakes/FakeResources.php');
require_once(ROOT_DIR . 'tests/fakes/FakeAnnouncements.php');
require_once(ROOT_DIR . 'tests/fakes/FakeSchedules.php');
require_once(ROOT_DIR . 'tests/fakes/FakeResourceAccess.php');
require_once(ROOT_DIR . 'tests/fakes/FakeReservationRepository.php');
require_once(ROOT_DIR . 'tests/fakes/FakeUserSession.php');
require_once(ROOT_DIR . 'tests/fakes/FakeResource.php');
require_once(ROOT_DIR . 'tests/fakes/FakeEmailService.php');
require_once(ROOT_DIR . 'tests/fakes/FakeUser.php');
require_once(ROOT_DIR . 'tests/fakes/FakeSchedule.php');
require_once(ROOT_DIR . 'tests/fakes/TestCustomAttribute.php');
require_once(ROOT_DIR . 'tests/fakes/TestDateRange.php');
require_once(ROOT_DIR . 'tests/fakes/TestReservation.php');
require_once(ROOT_DIR . 'tests/fakes/TestReservationSeries.php');
require_once(ROOT_DIR . 'tests/fakes/FakePluginManager.php');
require_once(ROOT_DIR . 'tests/fakes/FakeRegistrationPage.php');
require_once(ROOT_DIR . 'tests/fakes/FakeActivation.php');
require_once(ROOT_DIR . 'tests/fakes/FakePermissionService.php');
require_once(ROOT_DIR . 'tests/fakes/FakeReservationAttachment.php');
require_once(ROOT_DIR . 'tests/fakes/FakeUploadedFile.php');
require_once(ROOT_DIR . 'tests/fakes/FakeFileSystem.php');
require_once(ROOT_DIR . 'tests/fakes/FakeReport.php');
require_once(ROOT_DIR . 'tests/fakes/FakeSavedReport.php');
require_once(ROOT_DIR . 'tests/fakes/TestReservationItemView.php');
require_once(ROOT_DIR . 'tests/fakes/FakeWebAuthentication.php');
require_once(ROOT_DIR . 'tests/fakes/FakeRestServer.php');
require_once(ROOT_DIR . 'tests/fakes/FakePrivacyFilter.php');
require_once(ROOT_DIR . 'tests/fakes/FakeGroup.php');
require_once(ROOT_DIR . 'tests/fakes/FakeReservationSavePage.php');
require_once(ROOT_DIR . 'tests/fakes/ExistingReservationSeriesBuilder.php');
require_once(ROOT_DIR . 'tests/fakes/FakeAttributeList.php');
require_once(ROOT_DIR . 'tests/fakes/FakeResourceGroupTree.php');
require_once(ROOT_DIR . 'tests/fakes/FakeAttributeRepository.php');
require_once(ROOT_DIR . 'tests/fakes/FakeResourceService.php');
require_once(ROOT_DIR . 'tests/fakes/FakeReservationViewRepository.php');
require_once(ROOT_DIR . 'tests/fakes/FakeGroupRepository.php');
require_once(ROOT_DIR . 'tests/fakes/FakeAuthorizationService.php');
require_once(ROOT_DIR . 'tests/fakes/FakeAttributeService.php');
require_once(ROOT_DIR . 'tests/fakes/FakeUserRepository.php');
require_once(ROOT_DIR . 'tests/fakes/FakeAccessoryRepository.php');
require_once(ROOT_DIR . 'tests/fakes/TestResourceDto.php');
require_once(ROOT_DIR . 'tests/fakes/FakeExistingReservationPage.php');
require_once(ROOT_DIR . 'tests/fakes/FakeReservationCheckinPage.php');
require_once(ROOT_DIR . 'tests/fakes/FakeResourceRepository.php');
require_once(ROOT_DIR . 'tests/fakes/FakeReservationService.php');
require_once(ROOT_DIR . 'tests/fakes/FakeGuestUserService.php');
require_once(ROOT_DIR . 'tests/fakes/FakeReservationHandler.php');
require_once(ROOT_DIR . 'tests/fakes/FakeScheduleLayout.php');
require_once(ROOT_DIR . 'tests/fakes/FakeReservationWaitlistRepository.php');
require_once(ROOT_DIR . 'tests/fakes/FakeDailyLayout.php');
require_once(ROOT_DIR . 'tests/fakes/FakeScheduleService.php');