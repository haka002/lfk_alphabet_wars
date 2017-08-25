<?php

use AlphabetWars\NuclearWar;

class NuclearWarTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var NuclearWar
	 */
	private $nuclearWar;

	public function setUp()
	{
		parent::setUp();

		$this->nuclearWar = new NuclearWar();
	}

	/**
	 * @expectedException InvalidArgumentException
	 *
	 * @cover \AlphabetWars\Nuclear
	 */
	public function testFightWithBadParameter()
	{
		$this->nuclearWar->fight('almafa@bn');
	}

	/**
	 * @cover \AlphabetWars\Nuclear
	 */
	public function testBattlefieldWithoutBomb()
	{
		$battlefield                = 'almasdlamsdlmsd[asldkas]sdfsf';
		$battlefieldWithoutBrackets = 'almasdlamsdlmsdasldkassdfsf';

		$this->assertEquals($battlefieldWithoutBrackets, $this->nuclearWar->fight($battlefield));
	}

	/**
	 * @cover \AlphabetWars\Nuclear
	 */
	public function testBattlefieldWithBombButWithoutShelters()
	{
		$this->assertEquals('', $this->nuclearWar->fight('almasdlamsdlmsdasldkas#sdfsf'));
	}

	/**
	 * @param $expected
	 * @param $battlefield
	 *
	 * @dataProvider battlefieldProvider
	 *
	 * @cover \AlphabetWars\Nuclear
	 */
	public function testBattlefieldWithBombAndWithShelters($expected, $battlefield)
	{
		$this->assertEquals($expected, $this->nuclearWar->fight($battlefield));
	}

	/**
	 * @return array
	 */
	public function battlefieldProvider()
	{
		return [
			['almafa', 'almafa'],
			['abdefghijk', 'abde[fgh]ijk'],
			['fgh', 'ab#de[fgh]ijk'],
			['', 'ab#de[fgh]ij#k'],
			['', '##abde[fgh]ijk'],
			['mn', '##abde[fgh]ijk[mn]op'],
			['mn', '#ab#de[fgh]ijk[mn]op'],
			['mn', '#abde[fgh]i#jk[mn]op'],
			['ac', '[a]#[b]#[c]'],
			['d', '[a]#b#[c][d]'],
			['abc', '[a][b][c]'],
			['c', '##a[a]b[c]#']
		];
	}
}
