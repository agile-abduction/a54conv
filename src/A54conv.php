<?php

/**
 * Class A54conv - array to php5.4 short format converter
 */
class A54conv {

	/**
	 * @var array[] set of pattern-replacement pairs to process input
	 */
	protected $_replacers = [
		// convert line breaks
		[
			'pattern' => '/\r\n/',
			'replacement' => "\n",
		],
		// to replace actual array(
		[
			'pattern' => '/array \(/',
			'replacement' => '[',
		],
		// to replace => array( occurances (now converted to => [ something), get rid of one newline
		[
			'pattern' => '/ =>\n([\t ]+)\[/',
			'replacement' => " => [",
			// I will implement spaces suport later
			//'replace' => '/ =>\n((    |\t)+)\[\n((    |\t)+)/',
		],
		// to replace closing brackets
		[
			'pattern' => "/\n[\t ]+\),/",
			'replacement' => "\n],",
		],
		// to replace closing bracket
		[
			'pattern' => "/\)(\n([\t ]+))?/",
			'replacement' => "]",
		],
	];

	protected $_indentRaisePattern = '/\[$/';
	protected $_indentLowerPattern = '/\](,|;)?$/';

	/**
	 * @param string|array $in
	 * @return null|string
	 */
	public function convert($in) {

		// make sure we have a non-empty string to begin with
		if (is_array($in) && !empty($in)) {
			$in = var_export($in, true);
		}
		if (empty($in)) {
			return null;
		}

		$replaced = $in;

		foreach ($this->_replacers as $eachReplacer) {
			$replaced = preg_replace($eachReplacer['pattern'], $eachReplacer['replacement'], $replaced);
		};

		return $this->adjustTextIndent($replaced);

	}

	/**
	 * I adjust indentation for a text, given it's in previously prepared format
	 * @param string $subject
	 * @param int $baseIndent
	 * @return string
	 */
	public function adjustTextIndent($subject, $baseIndent=0) {

		$lines = explode("\n", $subject);
		$lineCnt = count($lines);
		$indent = $baseIndent;
		for ($i=0; $i<$lineCnt; $i++) {

			$line = $lines[$i];

			if (preg_match($this->_indentLowerPattern, $line)) {
				$currentIndent = --$indent;
			}
			else if (preg_match($this->_indentRaisePattern, $line)) {
				$currentIndent = $indent++;
			}
			else {
				$currentIndent = $indent;
			}

			$lines[$i] = $this->adjustLineIndent($line, $currentIndent);

		}

		return implode("\n", $lines);

	}

	/**
	 * I adjust one string's leading indentation to given value
	 *
	 * @param $line
	 * @param $indent
	 * @param string $indentStr
	 * @return string
	 */
	public function adjustLineIndent($line, $indent, $indentStr = "\t") {
		return str_repeat($indentStr, $indent) . trim($line);
	}

}
