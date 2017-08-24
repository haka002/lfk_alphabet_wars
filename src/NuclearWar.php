<?php

namespace AlphabetWars;

use InvalidArgumentException;

class NuclearWar
{
	/**
	 * @param string $battlefield
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

		// ha két különböző zárójel között van legalább kettő #
		// ha [ vagy ] mellett van ##
		$survivors = [];
		$position  = 0;

		while (
			$shelterCords = $this->searchShelter($battlefield, $position)
		) {
			if (
				$this->countHashMarkOnLeft($battlefield, $shelterCords[0]) == 2
				|| $this->countHashMarkOnRight($battlefield, $shelterCords[1]) == 2
				|| (
					$this->countHashMarkOnLeft($battlefield, $shelterCords[0]) == 1
					&& $this->countHashMarkOnRight($battlefield, $shelterCords[1]) == 1
				)
			) {
				continue;
			}

			$survivors[] = substr($battlefield, $shelterCords[0] + 1, $shelterCords[0] - $shelterCords[1]);

			$position = $shelterCords[1];
		}

		return implode($survivors, '');
	}

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

	private function countHashMarkOnLeft($battlefield, $leftIndex)
	{
		$bracketIndex  = strrpos(substr($battlefield, 0, $leftIndex + 1), ']');

		if ($bracketIndex === false)
		{
			return var_dump((int)substr_count($battlefield, '#', $bracketIndex));
		}

		return (int)substr_count($battlefield, '#', $bracketIndex, $leftIndex + 1 - $bracketIndex);
	}

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
