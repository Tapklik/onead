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

        /** REPORTS **/
        Route::get(
            'reports',
            [
                'as'   => 'reports.index',
                'uses' => 'ReportsController@index',
            ]
        );

        /** PROFILE **/
        Route::get(
            'profile',
            [
                'as'   => 'profile.index',
                'uses' => 'ProfileController@index',
            ]
        );

        Route::get(
            'settings',
            [
                'as'   => 'settings.index',
                'uses' => 'SettingsController@index',
            ]
        );

        Route::get(
            'billing',
            [
                'as'   => 'billing.index',
                'uses' => 'BillingController@index',
            ]
        );

        /** CAMPAIGNS */
        Route::group(
            ['prefix' => 'campaigns'],
            function () {

                Route::get(
                    '/',
                    [
                        'as'   => 'campaigns.index',
                        'uses' => 'CampaignsController@index',
                    ]
                );

                Route::get(
                    '/create',
                    [
                        'as'   => 'campaigns.create',
                        'uses' => 'CampaignsController@create',
                    ]
                );

                Route::get(
                    '/edit/{id}',
                    [
                        'as'   => 'campaigns.edit',
                        'uses' => 'CampaignsController@show',
                    ]
                );
   }
        );

        /** CREATIVES */
        Route::group(
            ['prefix' => 'creatives'],
            function () {

                Route::get(
                    '/',
                    [
                        'as'   => 'creatives.index',
                        'uses' => 'CreativesController@index',
                    ]
                );
            }
        );

        /** LOGOUT */
        Route::get(
            '/logout',
            function (Request $request) {

                $request->session()->flush();

                return redirect('/admin/auth');
            }
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

        Route::get('/health', [
            'as' => 'health',
            'uses' => 'HealthCheckController@index'
        ]);
    }
);
