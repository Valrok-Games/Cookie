<?php

namespace Valrok\Cookie;

/**
 * Creates a cookie and can set & delete it
 */
class Cookie {
	public readonly string $name;
	public readonly string $value;
	private array $options;

	/**
	 * Sets a cookie
	 *
	 * @param string $name
	 * @param string $value
	 * @param array $options_args
	 * @return Cookie
	 */
	public function __construct( string $name, string $value, array $options_args = [] ) {
		$this->name   = $name;
		$this->value  = $value;
		$base_options = [
			'expires' => time() + 3600,
			'path'    => '/',
		];

		/**
		 * Setting or updating options array with arguments array
		 */
		$this->options = array_merge( $base_options, $options_args );
	}

	public function get_options(): array {
		return $this->options;
	}

	/**
	 * Sets a cookie
	 * @return void
	 */
	public function set(): void {
		setcookie( $this->name, $this->value, $this->options );
	}

	/**
	 * Deletes a cookie
	 *
	 * @param string $name
	 * @param array $option_args
	 * @return void
	 */
	public function delete(): void {
		/**
		 * Sets the expiring time in the past
		 */
		$this->options['expires']  = time() - 3600;
		$this->options['samesite'] = 'none';
		$this->options['secure']   = 'true';

		/**
		 * Setting value equal to a boolean value which should remove it
		 * documentation: https://www.php.net/manual/en/function.setcookie.php
		 */
		setcookie( $this->name, '1', $this->options );
	}

}
