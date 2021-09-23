<?php

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/**
 * Redirect hashed link
 * @param string $hash
 */
$router->get('/r/{hash:\w+}', function (string $hash) use ($router) {
    /**
     * @var Link $link
     */
    $link = Link::query()->where('hash', $hash)->firstOrFail();

    return redirect($link->url);
});

/**
 * Redirect hashed link
 * @param string $hash
 * @return Response
 */
$router->get('/minify', function () use ($router) {
    return response()->json([
        'data' => Link::all(),
    ]);
});

/**
 * Add minify-link
 * @param Request $request
 * @return Response
 */
$router->post('/minify', function (Request $request) use ($router) {
    $this->validate($request, [
        'url' => 'required|url|max:2048'
    ]);

    $link = new Link($request->all());
    $link->url = $request->get('url');
    $link->hash = generateHash();

    return response()->json([
        'status' => $link->save(),
        'data' => $link,
    ]);
});

/**
 * Generate unique hash
 * @return string
 */
function generateHash(): string
{
    $hash = Str::random(10);

    if (Link::query()->where('hash', $hash)->exists()) {
        return generateHash();
    }
    return $hash;
}
