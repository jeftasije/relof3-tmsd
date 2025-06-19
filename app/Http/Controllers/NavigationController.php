<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Navigation;
use Illuminate\Support\Facades\DB;

class NavigationController extends Controller
{
    public function saveOrder(Request $request)
    {
        $items = $request->input('items');

        try {
            DB::transaction(function () use ($items) {
                foreach ($items as $item) {
                    $navigation = Navigation::findOrFail($item['id']);
                    $navigation->update([
                        'order' => $item['order']
                    ]);
                }
            });

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
