<?php


namespace App\Services;


use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Redirect
{
    /**
     * @var Redirector|null
     */
    static $redirect;

    /**
     * @var Request|null
     */
    static $request;

    /**
     * @return Redirector|null
     */
    public static function run(): ?Redirector
    {
        return self::$redirect;
    }

    /**
     * @param Redirector $redirect
     */
    public static function setRedirect(Redirector $redirect)
    {
        self::$redirect = $redirect;
    }

    /**
     * @param Request $request
     */
    public static function setRequest(Request $request)
    {
        self::$request = $request;
    }

    /**
     * @param string $name
     * @param array $params
     * @return string
     */
    public static function toRoute(string $name, array $params = []): string
    {
        return self::$redirect->route($name, $params)->getTargetUrl();
    }

    public static function location(string $name, array $params = []): void
    {
        try {
            $redirectUri = self::toRoute($name, $params);

            if (self::$request->route()->getName() === $name
                && array_values(self::$request->route()->parametersWithoutNulls()) === $params) {
                $redirectUri = null;
            }
        } catch (RouteNotFoundException $e) {
            $redirectUri = $name;
            if (self::$request->path() === ltrim($redirectUri, '/')) {
                $redirectUri = null;
            }
        }

        header("Location: {$redirectUri}", 302);
    }
}