<?php
/**
 * Copyright 2017-2019 Nick Korbel
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

namespace Booked {
	require_once(ROOT_DIR . 'lib/Common/Resources.php');
	require_once(ROOT_DIR . 'lib/Common/Resources.php');

	use NumberFormatter;
	use Resources;

	class Currency
	{
		private $currencies = array();

		/**
		 * @var string
		 */
		private $currencyCode;

		/**
		 * @var CurrencyDefinition
		 */
		private $currency;

		/**
		 * @param string $currencyCode
		 */
		public function __construct($currencyCode)
		{
			$this->currencyCode = $currencyCode;
			$this->currencies = self::Currencies();

			$this->currency = $this->currencies[0];
			foreach ($this->currencies as $currency)
			{
				if ($currency->IsoCode() == $currencyCode)
				{
					$this->currency = $currency;
					break;
				}
			}
		}

		/**
		 * @return CurrencyDefinition[]
		 */
		public static function Currencies()
		{
			return array(
					new CurrencyDefinition('USD'),
					new CurrencyDefinition('AUD'),
					new CurrencyDefinition('BRL'),
					new CurrencyDefinition('CAD'),
					new CurrencyDefinition('CZK'),
					new CurrencyDefinition('DKK'),
					new CurrencyDefinition('EUR'),
					new CurrencyDefinition('HKD'),
					new CurrencyDefinition('HUF'),
					new CurrencyDefinition('ILS'),
					new CurrencyDefinition('JPY', true),
					new CurrencyDefinition('MYR'),
					new CurrencyDefinition('MXN'),
					new CurrencyDefinition('NOK'),
					new CurrencyDefinition('NZD'),
					new CurrencyDefinition('PHP'),
					new CurrencyDefinition('PLN'),
					new CurrencyDefinition('SGD'),
					new CurrencyDefinition('SEK'),
					new CurrencyDefinition('CHF'),
					new CurrencyDefinition('TWD'),
					new CurrencyDefinition('THB'),
			);
		}

		/**
		 * @param string $currencyCode
		 * @return Currency
		 */
		public static function Create($currencyCode)
		{
			return new Currency($currencyCode);
		}

		/**
		 * @param float $amount
		 * @return string
		 */
		public function Format($amount)
		{
			if (!class_exists('NumberFormatter'))
			{
				if ($this->currencyCode == 'USD')
				{
					return '$' . floatval($amount) . 'USD';
				}
				else
				{
					return 'We cannot format this currency. <a href="http://php.net/manual/en/book.intl.php">You must enable internationalization</a>.';
				}
			}
			else
			{
				$fmt = new NumberFormatter(Resources::GetInstance()->CurrentLanguage, NumberFormatter::CURRENCY);
				return $fmt->formatCurrency($amount, $this->currencyCode);
			}
		}

		/**
		 * @param float $amount
		 * @return float
		 */
		public function ToStripe($amount)
		{
			if ($this->IsZeroDecimal())
			{
				return $amount;
			}

			return $amount * 100;
		}

		/**
		 * @param float $amount
		 * @return float
		 */
		public function FromStripe($amount)
		{
			if ($this->IsZeroDecimal())
			{
				return $amount;
			}

			return $amount / 100;
		}

		public function IsZeroDecimal()
		{
			return $this->currency->IsZeroDecimal();
		}
	}

	class CurrencyDefinition
	{
		/**
		 * @var string
		 */
		private $isoCode;

		/**
		 * @var bool
		 */
		private $isZeroDecimal;

		/**
		 * @param string $isoCode
		 * @param bool $isZeroDecimal
		 */
		public function __construct($isoCode, $isZeroDecimal = false)
		{
			$this->isoCode = $isoCode;
			$this->isZeroDecimal = $isZeroDecimal;
		}

		public function __toString()
		{
			return $this->isoCode;
		}

		/**
		 * @return string
		 */
		public function IsoCode()
		{
			return $this->isoCode;
		}

		/**
		 * @return bool
		 */
		public function IsZeroDecimal()
		{
			return $this->isZeroDecimal;
		}
	}
}
