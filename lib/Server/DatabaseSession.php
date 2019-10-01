<?php
/**
 * Copyright 2019 Nick Korbel
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

require_once(ROOT_DIR . 'lib/Common/namespace.php');

class DatabaseSession implements SessionHandlerInterface
{
	public function __construct()
	{
		session_set_save_handler(
				array($this, "open"),
				array($this, "close"),
				array($this, "read"),
				array($this, "write"),
				array($this, "destroy"),
				array($this, "gc")
		);
		register_shutdown_function('session_write_close');
		@session_start();
	}

	public function open($savepath, $id)
	{
		$command = new AdHocCommand("SELECT `data` FROM sessions WHERE id = @id LIMIT 1");
		$command->AddParameter(new Parameter("@id", $id));
		$reader = ServiceLocator::GetDatabase()->Query($command);
		if ($reader->NumRows() == 1)
		{
			return true;
		}
		return false;
	}

	public function read($id)
	{
		$command = new AdHocCommand("SELECT `data` FROM sessions WHERE id = @id LIMIT 1");
		$command->AddParameter(new Parameter("@id", $id));
		$reader = ServiceLocator::GetDatabase()->Query($command);
		if ($row = $reader->GetRow())
		{
			return $row['data'];
		}
		else
		{
			return '';
		}
	}

	public function write($id, $data)
	{
		$access = time();

		$command = new AdHocCommand("REPLACE INTO sessions(id,access,`data`) VALUES (@id, @access, @data)");
		$command->AddParameter(new Parameter("@id", $id));
		$command->AddParameter(new Parameter("@access", $access));
		$command->AddParameter(new Parameter("@data", $data));

		try
		{
			ServiceLocator::GetDatabase()->Execute($command);
			return true;
		} catch (Exception $ex)
		{
			return false;
		}
	}

	public function destroy($id)
	{
		$command = new AdHocCommand("DELETE FROM sessions WHERE id = @id LIMIT 1");
		$command->AddParameter(new Parameter("@id", $id));
		try
		{
			ServiceLocator::GetDatabase()->Execute($command);
			return true;
		} catch (Exception $ex)
		{
			return false;
		}
	}

	public function close()
	{
		return true;
	}

	public function gc($max)
	{
		$old = time() - $max;

		$command = new AdHocCommand("DELETE FROM sessions WHERE access < @access LIMIT 1");
		$command->AddParameter(new Parameter("@access", $old));
		try
		{
			ServiceLocator::GetDatabase()->Execute($command);
			return true;
		} catch (Exception $ex)
		{
			return false;
		}
	}

	public function __destruct()
	{
		$this->close();
	}
}