<?php
/**
Copyright 2012-2020 Nick Korbel

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

class WebServices
{
	const AllAccessories = 'all_accessories';
	const AllAvailability = 'all_availability';
	const AllCustomAttributes = 'all_custom_attributes';
	const AllGroups = 'all_groups';
	const AllResources = 'all_resources';
	const AllReservations = 'all_reservations';
	const AllSchedules = 'all_schedules';
	const AllUsers = 'all_users';
	const ApproveReservation = 'approve_reservation';
	const CheckinReservation = 'checkin_reservation';
	const CheckoutReservation = 'checkout_reservation';
	const CreateCustomAttribute = 'create_custom_attribute';
	const CreateReservation = 'create_reservation';
	const CreateResource = 'create_resource';
	const CreateUser = 'create_user';
	const CreateGroup = 'create_group';
	const DeleteCustomAttribute = 'delete_custom_attribute';
	const DeleteReservation = 'delete_reservation';
	const DeleteResource = 'delete_resource';
	const DeleteUser = 'delete_user';
	const DeleteGroup = 'delete_group';
	const Login = 'login';
	const Logout = 'logout';
	const GetAccessory = 'get_accessory';
	const GetCustomAttribute = 'get_custom_attribute';
	const GetGroup = 'get_group';
	const GetReservation = 'get_reservation';
	const GetResource = 'get_resource';
	const GetResourceAvailability = 'get_resource_availability';
    const GetResourceGroups = 'get_resource_groups';
	const GetSchedule = 'get_schedule';
	const GetScheduleSlots = 'get_schedule_reservations';
	const GetUser = 'get_user';
	const GetUserByEmail = 'get_user_by_email';
	const UpdateCustomAttribute = 'update_custom_attribute';
	const UpdateReservation = 'update_reservation';
	const UpdateResource = 'update_resource';
	const UpdatePassword = 'update_password';
	const UpdateUser = 'update_user';
	const UpdateGroup = 'update_group';
	const UpdateGroupRoles = 'update_group_roles';
	const UpdateGroupPermissions = 'update_group_permissions';
	const UpdateGroupUsers = 'update_group_users';
	const GetStatuses = 'get_resource_statuses';
	const GetStatusReasons = 'get_resource_status_reasons';
	const GetAccount = 'get_user_account';
	const CreateAccount = 'create_user_account';
	const UpdateAccount = 'update_user_account';
	const UpdateAccountPassword = 'update_user_account_password';
}