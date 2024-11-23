<?php

namespace Valrok\Cookie;

use Valrok\Cookie\Cookie;

/**
 * Manages, creates, deletes cookies
 */
class CookieManager {

	private static array $cookies = [];
	private static ?CookieManager $_instance = null;

	public static function instance(): self {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Checks if a cookie is set with the name
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function has( string $name ): bool {
		return isset( self::$cookies[ $name ] ) || isset( $_COOKIE[ $name ] );
	}

	/**
	 * gets all cookies that matches with the @param string[] searches
	 *
	 * @param string[] $searches
	 * @return Cookie[]
	 */
	public function get_all_by( string ...$searches ): array {
		$cookies = [];
		foreach ( $_COOKIE as $key => $value ) {
			/**
			 * Looping over all @var string[] $searches values
			 */
			foreach ( (array) $searches as $search ) {
				/**
				 * If search string is not inside $_COOKIE key skip
				 */
				if ( ! str_contains( $key, $search ) ) {
					continue;
				}

				$cookie = $this->get( $key );
				if ( ! isset( $cookie ) ) {
					continue;
				}

				$cookies[ $key ] = $cookie;
			}
		}

		return $cookies;
	}

	/**
	 * get a cookie by its name, will return null if no cookie with that name exists
	 *
	 * @param string $name
	 * @return ?Cookie
	 */
	public function get( string $name ): ?Cookie {
		$cookie = null;
		if ( $this->has( $name ) ) {
			$cookie = new Cookie( $name, $_COOKIE[ $name ] );
			/**
			 * Adds to list just in case it's in it
			 */
			$this->add_to_list( $cookie );
		}

		return $cookie;
	}

	/**
	 * Adds a cookie to the cookie array
	 * @return void
	 */
	private function add_to_list( Cookie $cookie ): void {
		self::$cookies[ $cookie->name ] = $cookie;
	}

	/**
	 * Removes the cookie from the cookie array
	 *
	 * @param Cookie $cookie
	 * @return void
	 */
	private function remove_from_list( Cookie $cookie ): void {
		unset( self::$cookies[ $cookie->name ] );
	}

	/**
	 * Sets a cookie and adds it to the cookie array
	 *
	 * @param Cookie $cookie
	 * @return self
	 */
	public function set( Cookie $cookie ): self {
		/**
		 * set cookie
		 */
		$cookie->set();
		/**
		 * Remove from cookie array
		 */
		$this->add_to_list( $cookie );
		return self::instance();
	}

	/**
	 * Deletes a cookie
	 * @param string $name
	 * @param array $option_args
	 * @return self
	 */
	public function delete( Cookie $cookie ): self {
		$cookie->delete();
		if ( $this->has( $cookie->name ) ) {
			/**
			 * Remove from cookie array
			 */
			$this->remove_from_list( $cookie );
		}

		return self::instance();
	}

}
