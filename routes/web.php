<?php


use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect('/admin/dashboard');
});

Route::group(
    ['prefix' => 'admin', 'middleware' => Authenticate::class],
    function () {

       /** AUTH **/
        Route::get(
            'auth',
            [
                'as'   => 'auth',
                'uses' => 'AuthController@index',
            ]
        );

        /** DASHBOARD */
        Route::get(
            'dashboard',
            [
                'as'   => 'dashboard.index',
                'uses' => 'DashboardController@index',
            ]
        );
    }
);


Route::group(
    ['prefix' => 'core'],
    function () {

        Route::get(
            '/token',
            function (Request $request) {

                return response()->json(
                    [
                        'token' => session('token'),
                    ]
                );
            }
        );

        Route::post(
            '/token',
            function (Request $request) {

                session(['token' => $request->input('token')]);

                return response()->json(['token' => true]);
            }
        );
    }
);
