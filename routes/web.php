<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'penjualan'], function () use ($router) {
    $router->get('/', function () {
        return response()->json([
            [
                'id' => 1,
                'nomor' => 'SALE/00001',
                'customer' => 'Ucup',
            ],
            [
                'id' => 2,
                'nomor' => 'SALE/00002',
                'customer' => 'Udin',
            ],
            [
                'id' => 3,
                'nomor' => 'SALE/00003',
                'customer' => 'Wati',
            ],
        ]);
    });


    $router->get('/{id}', function ($id) {
        return response()->json(['data' => [
            'id' => $id,
            'nomor' => 'SALE/00001',
            'customer' => 'Ucup',
            'total' => 10000,
            'alamat' => 'Sidoarjo'
        ]]);
    });


    $router->post('/', function() {
        return response()->json([
            'message' => 'Berhasil',
            'id' => 4,
        ]);
    });


    $router->put('/{id}', function (Request $request, $id) {
        $nomor = $request->input('nomor');
        $customer = $request->input('customer');
        $total = $request->input('total');
        $alamat = $request->input('alamat');

        return response()->json(['data' => [
            'id' => $id,
            'nomor' => $nomor,
            'customer' => $customer,
            'total' => $total,
            'alamat' => $alamat
        ]]);
    });


    $router->delete('/{id}', function($id) {
        return response()->json(['message' => 'Berhasil delete id: '.$id]);
    });


    $router->get('/{id}/confirm', function(Request $request, $id) {
        $user = $request->user();
        if ($user == null) {
            return response()->json(['error' => 'Unauthorized'], 401, ['X-Header-One' => 'Header Value']);
        }
        return response()->json(['message' => 'Berhasil confirm id: '.$id, 'data' => $user]);
    });


    $router->get('/{id}/send-email', function(Request $request, $id) {
        $user = $request->user();
        Mail::raw('This is the email body.', function ($message) {
            $message->to('teslumen@yopmail.com')
                ->subject('Lumen email test');
        });

        return response()->json(['message' => 'Berhasil kirim email', 'data' => $user]);
    });
});