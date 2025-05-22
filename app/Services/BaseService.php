<?php 
namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Routing\ControllerMiddlewareOptions;

class BaseService extends Controller
{
    public function middleware($middleware, array $options = [])
    {
        foreach ((array) $middleware as $m) {
            $this->middleware[] = [
                'middleware' => $m,
                'options' => &$options,
            ];
        }

        return new ControllerMiddlewareOptions($options);
    }

    
}