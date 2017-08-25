<?php

namespace AlphabetWars;

use InvalidArgumentException;

class NuclearWar
{
	/**
	 * @param string $battlefield
	 *
	 * @return string The character which are not exploded.
	 */
	public function fight($battlefield)
	{
		if (!preg_match("/^[a-z\[\]#]+$/", $battlefield))
		{
			throw new InvalidArgumentException('The battlefield must contains minimum one char which could be only small letters and #, [, ] characters!');
		}

		// If there is not bomb
		if (strpos($battlefield, '#') === false)
		{
			return str_replace(array('[', ']'), '', $battlefield);
		}

		// If there is a bomb, but there is not any brackets
		if (strpos($battlefield, '[') === false)
		{
			return '';
		}

		$survivors = [];
		$position  = 0;

		while (
			$shelterCords = $this->searchShelter($battlefield, $position)
		) {
			$leftHashMarksCount  = $this->countHashMarkOnLeft($battlefield, $shelterCords[0]);
			$rightHashMarksCount = $this->countHashMarkOnRight($battlefield, $shelterCords[1]);

			if (
				$leftHashMarksCount >= 2
				|| $rightHashMarksCount >= 2
				||
				(
					$leftHashMarksCount == 1
					&& $rightHashMarksCount == 1
				)
			) {
				$position = $shelterCords[1];

				continue;
			}

			$survivors[] = substr($battlefield, $shelterCords[0] + 1, $shelterCords[1] - $shelterCords[0] - 1);
			$position    = $shelterCords[1];
		}

		return implode($survivors, '');
	}

	/**
	 * @param string $string
	 * @param int    $index  The shelter will search from the given index.
	 *
	 * @return array|null
	 */
	private function searchShelter($string, $index)
	{
		$cord1 = strpos($string, '[', $index);

		if ($cord1 === false)
		{
			return null;
		}

		$cord2 = strpos($string, ']', $cord1);

		return array($cord1, $cord2);
	}

	/**
	 * @param string $battlefield
	 * @param int    $leftIndex
	 *
	 * @return int
	 */
	private function countHashMarkOnLeft($battlefield, $leftIndex)
	{
		$bracketIndex  = (int)strrpos(substr($battlefield, 0, $leftIndex), ']');

		if ($bracketIndex === false)
		{
			return (int)substr_count($battlefield, '#', $bracketIndex);
		}

		return (int)substr_count($battlefield, '#', $bracketIndex, $leftIndex + 1 - $bracketIndex);
	}

	/**
	 * @param string $battlefield
	 * @param int $rightIndex
	 *
	 * @return int
	 */
	private function countHashMarkOnRight($battlefield, $rightIndex)
	{
		$bracketIndex  = strpos($battlefield, '[', $rightIndex + 1);

		if ($bracketIndex === false)
		{
			return (int)substr_count($battlefield, '#', $rightIndex + 1);
		}

		return (int)substr_count($battlefield, '#', $rightIndex + 1, $bracketIndex - $rightIndex + 1);
	}
}
