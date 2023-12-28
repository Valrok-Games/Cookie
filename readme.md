# Valrok
This is a tool created for Valrok ApS projects

## Workflows
Master - ![Semantic-release](https://github.com/Valrok-Games/Cookie/actions/workflows/semantic-release.yml/badge.svg?branch=master)

## Contact
Contact: fred@valrokgames.com

# Cookie
A class that can create, set and delete a cookie.

## set
You can set a cookie without using the cookiemanager by calling "$cookie->set();"

## delete
You can delete a cookie without using the cookiemanager by calling "$cookie->delete();"

### CookieManager
- This class handles of creating, setting and deleting of cookie objects.
- Cookies should be created through this class, so it can manage em.

The CookieManager class has a static instance, which you can access by calling "CookieManager::instance()" then you can chain commands like so "CookieManager::instance()->set( $cookie );"

### get
You can get a cookie by calling "CookieManager::instance()->get( $cookie_name );"

### get_all_by
You can get all cookies matching a string by calling "CookieManager::instance()->get_all_by( $cookie_prefix );"
This allows you too target all cookies that matches a prefix, it returns an array.

### set
You can set a cookie by calling "CookieManager::instance()->set( $cookie );".

### delete
You can delete a cookie by calling "CookieManager::instance()->delete( $cookie );"