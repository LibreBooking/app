{include file='globalheader.tpl'}
<h1>phpScheduleIt Help</h1>

DRAFT - INCOMPLETE AND SUBJECT TO CHANGE
<div id="help">
    <h2>Registration</h2>

    <p>
        Registration is required in order to use phpScheduleIt if you administrator has enabled it. After your account
        has been registered
        you will be able to log in and access any resources that you have permission to.
    </p>

    <h2>Booking</h2>

    <p>
        Under the Schedule menu item you will find the Booking item. This will show you the available, reserved and
        blocked slots on the schedule and allow you to book
        resources that you have permission to.
    </p>

    <h3>Express</h3>

    <p>
        On the Bookings page, find the resource, date and time you'd like to book. Clicking on the time slot will allow
        you change the details of the reservation. Clicking the
        Create button will check availability, book the reservation and send out any emails. You will be given a
        reference number to use for reservation follow-up.
    </p>

    <p>Any changes made to a reservation will not take effect until you save the reservation.</p>

    <p>Only Application Administrators can create reservations in the past.</p>

    <h3>Multiple Resources</h3>

    <p>You can book all resources that you have permission as part of a single reservation. To add more resources to
        your reservation, click the More Resources link, displayed next to the name of the primary resource you are
        reserving. You will then able to add more resources by selecting them and clicking the Done button.</p>

    <p>To remove additional resources from your reservation, click the More Resources link, deselect the resources you
        want to remove, and click the Done button.</p>

    <p>Additional resources will be subject to the same rules as primary resources. For example, this means that if you
        attempt to create a 2 hour reservation with Resource 1, which has a maximum length of 3 hours and with Resource
        2, which
        has a maximum length of 1 hour, your reservation will be denied.</p>

    <p>You can view the configuration details of a resource by hovering over the resource name.</p>

    <h3>Recurring Dates</h3>

    <p>A reservation can be configured to recur a number of different ways. For all repeat options the Until date is
        inclusive.</p>

    <p>The repeat options allow for flexible recurrence possibilities. For example: Repeat Daily every 2 days will
        create a reservation every other day for your specified time. Repeat Weekly, every 1 week on Monday, Wednesday,
        Friday will create a reservation on each of those days every week at your specified time. If you were creating a
        reservation on 2011-01-15, repeating Monthly, every 3 months on the day of month would create a reservation
        every third month on the 15th. Since 2011-01-15 is the third Saturday of January, the same example with the day
        of week selected would repeat every third month on the third Saturday of that month.</p>

    <h3>Additional Participants</h3>

    <p>You can either Add Participants or Invite Others when booking a reservation. Adding someone will include them on
        the reservation and will not send an invitation.
        The added user will receive an email. Inviting a user will send an invitation email and give the user an option
        to Accept or Decline the invitation. Accepting an
        invitation adds the user to the participants list. Declining an invitation removes the user from the invitees
        list.
    </p>

    <p>
        The total number of participants is limited by the resource's participant capacity.
    </p>

    <h3>Accessories</h3>

    <p>Accessories can be thought of as objects used during a reservation. Examples may be projectors or chairs. To add
        accessories to your reservation, click the Add link to the right of the Accessories title. From there you will
        be able to select a quantity for each of the available accessories. The quantity available during your
        reservation time will depend on how many accessories are already reserved.</p>

    <h3>Booking on behalf of others</h3>

    <p>Application Administrators and Group Administrators can book reservations on behalf of other users by clicking
        the Change link to the right of the user's name.</p>

    <p>Application Administrators and Group Administrators can also modify and delete reservations owned by other
        users.</p>

    <h2>Updating a Reservation</h2>

    <p>You can update any reservation that you have created or that was created on your behalf.</p>

    <h3>Updating Specific Instances From a Series</h3>

    <p>
        If a reservation is set up to repeat, then a series is created. After you make changes and Update the
        reservation, you will be asked which instances of the series you want to apply the changes to. You can
        apply your changes to the instance that you are viewing (Only This Instance) and no other instances will be
        changed.
        You can update All Instances to apply the change to every reservation instance that has not yet occurred. You
        can also apply the change only to Future Instances, which will update all reservation instances including and
        after the instance you are currently viewing.
    </p>

    <p>Only Application Administrators can update reservations in the past.</p>

    <h2>Deleting a Reservation</h2>

    <p>Deleting a reservation completely removes it from the schedule. It will no longer be visible anywhere in
        phpScheduleIt</p>

    <h3>Deleting Specific Instances From a Series</h3>

    <p>Similar to updating a reservation, when deleting you can select which instances you want to delete.</p>

    <p>Only Application Administrators can delete reservations in the past.</p>

    <h2>Adding a Reservation to Outlook &reg;</h2>

    <p>When viewing or updating a reservation you will see a button to Add to Outlook. If Outlook is installed on your
        computer then you should be asked to add the meeting. If it is not installed you will be prompted to download an
        .ics file. This is a standard calendar format. You can use this file to add the reservation to any application
        that supports the iCalendar file format.</p>

    <h2>Quotas</h2>

    <p>Administrators have the ability to configure quota rules based on a variety of criteria. If your reservation
        would violate any quota, you will be notified and the reservation will be denied.</p>

    <h2>Administration</h2>

    <p>If you are in an Application Administrator role then you will see the Application Management menu item. All
        administrative tasks can be found here.</p>

    <h3>Setting up Schedules</h3>

    <p>
        When installing phpScheduleIt a default schedule will be created with out of the box settings. From the
        Schedules menu option you can view and edit attributes of the current schedules.
    </p>

    <p>Each schedule must have a layout defined for it. This controls the availability of the resources on that
        schedule. Clicking the Change Layout link will bring up the layout editor. Here you can create and change the
        time slots that are available for reservation and blocked from reservation. There is no restriction on the slot
        times, but you must provide slot values for all 24 hours of the day, one per line. Also, the time format must be in 24 hour time.
        You can also provide a display label for any or all slots, if you wish.</p>

    <p>A slot without a label should be formatted like this: 10:25 - 16:50</p>
    <p>A slot with a label should be formatted like this: 10:25 - 16:50 Schedule Period 4</p>

    <p>Below the slot configuration windows is a slot creation wizard. This will set up available slots at the given
        interval between the start and end times.</p>

    <h3>Setting up Resources</h3>

    <h3>Setting up Accessories</h3>

    <h3>Setting up Quotas</h3>

    <h3>Setting up Announcements</h3>

    <h3>Setting up Groups</h3>

    <h3>Viewing and Managing Reservations</h3>

    <h3>Viewing and Managing Users</h3>


    <h2>Support</h2>

    <p><a href="http://php.brickhost.com/">Official Project Home</a></p>
    <p><a href="http:/php.brickhost.com/forums/">Support Forum</a></p>
    <p><a href="https://sourceforge.net/projects/phpscheduleit/">phpScheduleIt SourceForge Project Home</a></p>

    <h2>Credits</h2>

    <h3>Authors</h3>

    <h3>Translators</h3>

    <h3>Supporting Projects and Libraries</h3>

    <h2>License</h2>

    <p>phpScheduleIt free and open source, licenced under the GNU GENERAL PUBLIC LICENSE. Please see the included
        License file for more details.</p>

</div>

{include file='globalfooter.tpl'}