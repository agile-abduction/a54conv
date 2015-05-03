<?php

require('../vendor/autoload.php');

class A54convTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var A54conv $_Aconv
	 */
	private $_A54conv;

	public function setUp() {
		$this->_A54conv = new A54conv();
	}

	/**
	 *
	 * @covers A54conv::convert
	 */
	public function testConvert() {

		$subjects = [
			null,
			'',
			0,
			[],
		];
		foreach ($subjects as $eachSubject) {
			$this->assertNull($this->_A54conv->convert($eachSubject));
		}

		$subjects = [
			'asd',
			1,
			[1,2],
		];
		foreach ($subjects as $eachSubject) {
			$this->assertNotNull($this->_A54conv->convert($eachSubject), 'failed: ' . var_export($eachSubject, true));
		}

		// I have not found a problem!!!

		$this->markTestIncomplete();
	}

	/**
	 * @param string $subject
	 * @dataProvider adjustTextIndentProvider
	 * @covers A54conv::adjustTextIndent
	 */
	public function testAdjustTextIndent($subject) {

		$maxIndent = $this->_getmaxIndent($subject);

		for ($i=0; $i<=$maxIndent + 2; $i++) {
			$adjusted = $this->_A54conv->adjustTextIndent($subject, $i);
			$this->assertEquals($i, $this->_getminIndent($adjusted));
			$this->assertEquals($i, $this->_getmaxIndent($adjusted));
		}

	}

	public function adjustTextIndentProvider() {
		return [
			[
				'asdfdfd',
			],
			[
				<<<EOS
			%test_val = array(
		)
				;

EOS
			],
			[
				<<<EOS
	%test_val = array(
		)
	;

EOS
			],
		];
	}

	/**
	 * @param string $subject
	 * @dataProvider adjustLinIndentProvider
	 * @covers A54conv::adjustLineIndent
	 */
	public function testAdjustLineIndent($subject) {

		$maxIndent = $this->_getmaxIndent($subject);

		for ($i=0; $i<=$maxIndent; $i++) {

			$adjusted = $this->_A54conv->adjustLineIndent($subject, $i);
			$this->assertEquals($i, $this->_getmaxIndent($adjusted));
			$this->assertEquals($i, $this->_getminIndent($adjusted));

		}

	}

	public function adjustLinIndentProvider() {
		return [
			['asd'],
			['		asd'],
			['					asd'],
			['asd			 '],
			['		asd		'],
			['			asd	'],
			['					asd				'],
		];
	}

	private function _getminIndent($subject) {

		$lines = explode("\n", $subject);

		$indent = null;
		foreach ($lines as $eachLine) {
			if (empty($eachLine)) {
				continue;
			}
			if (preg_match('/^(\t*)/', $eachLine, $matches)) {
				$currentIndent = strlen($matches[1]);
			}
			else {
				$currentIndent = 0;
			}

			$indent = is_null($indent)
				? $currentIndent
				: min($indent, $currentIndent);
		}
		return 0 + $indent;
	}

	private function _getmaxIndent($subject) {

		$lines = explode("\n", $subject);

		$indent = 0;
		foreach ($lines as $eachLine) {
			if (empty($eachLine)) {
				continue;
			}
			if (preg_match('/^(\t*)/', $eachLine, $matches)) {
				$currentIndent = strlen($matches[1]);
			}
			else {
				$currentIndent = 0;
			}

			$indent = max($indent, $currentIndent);
		}
		return $indent;
	}

}
