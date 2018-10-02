<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class FilterController extends Controller
{
	
    //
    public function filter(Request $request)
    {
    	$productQuery = (new Product)->newQuery();
        $query = $this->buildQuery($request,$productQuery);
        return $this->getQueryResult($query);
    }

    private function buildQuery($request, $query)
    {
        foreach ($request->all() as $param => $value) {
            if (method_exists ( $this , $param)) {
                $query = $this->{$param}($value, $query);
            }
        }
        return $query;
    }

    private function getQueryResult($query)
    {
        return $query->get();
    }

    // write a function for the filter
    public function name($value, $query)
    {
        return $query->where('name', 'LIKE', '%'.$value.'%');
        
    }

    public function category($value, $query)
    {
        return $query->where('category', $value);
        
    }

    public function price($value, $query)
    {
        return $query->where('price', $value);
        
    }

    public function available($value, $query)
    {
        return $query->where('available', $value);
    }


}
