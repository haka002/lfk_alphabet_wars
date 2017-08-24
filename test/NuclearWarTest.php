<?php

use AlphabetWars\NuclearWar;

/**
 * Created by PhpStorm.
 * User: haka
 * Date: 2017. 08. 24.
 * Time: 22:12
 */
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
	 * @expectedException \InvalidArgumentException
	 */
	public function testFightWithBadParameter()
	{
		$this->nuclearWar->fight('almafa@bn');
	}

	public function testFightWithGoodParameter()
	{
		$this->nuclearWar->fight('almafa');

		$this->assertTrue(true);
	}

	public function testBattlefieldWithoutBomb()
	{
		$battlefield = 'almasdlamsdlmsd[asldkas]sdfsf';

		$this->assertEquals($battlefield, $this->nuclearWar->fight($battlefield));
	}

	public function testBattlefieldWithBombButWithoutShelters()
	{
		$battlefield = 'almasdlamsdlmsdasldkas#sdfsf';

		$this->assertEquals('', $this->nuclearWar->fight($battlefield));
	}

	/**
	 * @param $expected
	 * @param $battlefield
	 *
	 * @dataProvider battlefieldProvider
	 */
	public function testBattlefieldWithBombAndWithShelters($expected, $battlefield)
	{
		$this->assertEquals($expected, $this->nuclearWar->fight($battlefield));
	}

	public function battlefieldProvider()
	{
		return [
			['abdefghijk', 'abde[fgh]ijk'],
			['fgh', 'ab#de[fgh]ijk'],
		];
	}
}
