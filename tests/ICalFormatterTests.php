<?php
require_once('fakes/FakeReservation.php');
require_once('../lib/icalendar/ICalReservationFormatter.php');
require_once('PHPUnit.php');

class ICalFormatterTests extends PHPUnit_TestCase
{
	function ICalFormatterTests($name) {
		$this->PHPUnit_TestCase($name);
	}

	function testFormatSettingsIncludesProperAttributes() {
		$fake = new FakeReservation();

		$formatter = new ICalReservationFormatter();
		$formatter->setReservation($fake);
		$settings = $formatter->formatSettings();

		$id = $fake->id;

		$dtstart = sprintf(
			'%sT%s%s00Z',
			date('Ymd', $fake->start_date),
			Time::getHours($fake->start),
			Time::getMinutes($fake->start)
		);

		$dtend = sprintf(
			'%sT%s%s00Z',
			date('Ymd', $fake->end_date),
			Time::getHours($fake->end),
			Time::getMinutes($fake->end)
		);

		$created = sprintf('%sT%sZ', date('Ymd', $fake->created), date('His', $fake->created));
		$modified = sprintf('%sT%sZ', date('Ymd', $fake->modified), date('His', $fake->modified));

		$this->assertEquals("UID:$id\nDTSTART:$dtstart\nDTEND:$dtend\nCREATED:$created\nLAST-MODIFIED:$modified\n", $settings);
	}

	function testFormatOwnerIncludesProperAttributes() {
		$fake = new FakeReservation();

		$formatter = new ICalReservationFormatter();
		$formatter->setReservation($fake);
		$owner = $formatter->formatOwner();

		$this->assertEquals("ORGANIZER:MAILTO:test@email.com\n", $owner);
	}

	function testFormatParticipantsIncludesProperAttributes() {
		$fake = new FakeReservation();

		$formatter = new ICalReservationFormatter();
		$formatter->setReservation($fake);
		$participants = $formatter->formatParticipants();

		$this->assertEquals("ATTENDEE:MAILTO:fake1@email.com\nATTENDEE:MAILTO:fake2@email.com\n", $participants);
	}

	function testFormatSummaryIncludesProperAttributes() {
		$fake = new FakeReservation();

		$formatter = new ICalReservationFormatter();
		$formatter->setReservation($fake);
		$summary = $formatter->formatSummary();

		$this->assertEquals("SUMMARY:summary\n", $summary);
	}

	function testFormatReminderIncludesProperAttributes() {
		$fake = new FakeReservation();

		$formatter = new ICalReservationFormatter();
		$formatter->setReservation($fake);
		$reminder = $formatter->formatReminder();

		$this->assertEquals("BEGIN:VALARM\nACTION:EMAIL\nTRIGGER:-P{$fake->reminder_minutes_prior}M\nEND:VALARM\n", $reminder);
	}

	function testFormatResourcesncludesProperAttributes() {
		$fake = new FakeReservation();

		$formatter = new ICalReservationFormatter();
		$formatter->setReservation($fake);
		$resources = $formatter->formatResources();

		$this->assertEquals("RESOURCES:resource1,projector1\nLOCATION:location1\n", $resources);
	}
	
	function testSummaryIsEmptyStringIfNoSummary() {
		$fake = new FakeReservation();
		$fake->summary = '';

		$formatter = new ICalReservationFormatter();
		$formatter->setReservation($fake);
		$summary = $formatter->formatSummary();

		$this->assertEquals("", $summary);
		
		$fake->summary = null;

		$formatter = new ICalReservationFormatter();
		$formatter->setReservation($fake);
		$summary = $formatter->formatSummary();

		$this->assertEquals("", $summary);
	}
	
	function testAlarmIsEmptyStringIfNoReminder() {
		$fake = new FakeReservation();
		$fake->reminder_minutes_prior = 0;

		$formatter = new ICalReservationFormatter();
		$formatter->setReservation($fake);
		$reminder = $formatter->formatReminder();

		$this->assertEquals("", $reminder);
	}
	
	function testModifiedIsEmptyIfNoModification() {
		$fake = new FakeReservation();
		$fake->modified = null;
		
		$formatter = new ICalReservationFormatter();
		$formatter->setReservation($fake);
		$settings = $formatter->formatSettings();

		$id = $fake->id;

		$dtstart = sprintf(
			'%sT%s%s00Z',
			date('Ymd', $fake->start_date),
			Time::getHours($fake->start),
			Time::getMinutes($fake->start)
		);

		$dtend = sprintf(
			'%sT%s%s00Z',
			date('Ymd', $fake->end_date),
			Time::getHours($fake->end),
			Time::getMinutes($fake->end)
		);

		$created = sprintf('%sT%sZ', date('Ymd', $fake->created), date('His', $fake->created));

		$this->assertEquals("UID:$id\nDTSTART:$dtstart\nDTEND:$dtend\nCREATED:$created\n", $settings);
	
	}
}
?>