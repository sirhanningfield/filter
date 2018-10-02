<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Product;

class FilterController extends Controller
{
	
    //
    public function filter(Request $request)
    {
        try {
            $productQuery = (new Product)->newQuery();
            $query = $this->buildQuery($request,$productQuery);
            return $this->getQueryResult($query);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }
    }

    private function buildQuery($request, $query)
    {  
        foreach ($request->all() as $param => $value) {
            $param = studly_case($param);
            if (method_exists ( $this , $param)) {
                $query = $this->{$param}($value, $query);
            }else{
                throw new Exception('filter method "'.$param.'" does not exist.' , 1);
                
            }
        }
        return $query;    
    }

    private function getQueryResult($query)
    {
        return $query->get();
    }

    // write a function for the filter
    private function name($value, $query)
    {
        return $query->where('name', 'LIKE', '%'.$value.'%');
        
    }

    private function category($value, $query)
    {
        return $query->where('category', $value);
        
    }

    private function price($value, $query)
    {
        return $query->where('price', $value);
        
    }

    private function isAvailable($value, $query)
    {
        return $query->where('available', $value);
    }


}
